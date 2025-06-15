<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::user()->id;
        $currentMonth = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();

        // 今月の収支計算
        $currentMonthIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('date', $currentMonth->year)
            ->whereMonth('date', $currentMonth->month)
            ->sum('amount');

        $currentMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('date', $currentMonth->year)
            ->whereMonth('date', $currentMonth->month)
            ->sum('amount');

        $currentMonthBalance = $currentMonthIncome - $currentMonthExpense;

        // 前月の収支計算
        $previousMonthIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('date', $previousMonth->year)
            ->whereMonth('date', $previousMonth->month)
            ->sum('amount');

        $previousMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('date', $previousMonth->year)
            ->whereMonth('date', $previousMonth->month)
            ->sum('amount');

        $previousMonthBalance = $previousMonthIncome - $previousMonthExpense;

        // 前月比計算
        $incomeChange = $previousMonthIncome > 0
            ? (($currentMonthIncome - $previousMonthIncome) / $previousMonthIncome) * 100
            : 0;
        $expenseChange = $previousMonthExpense > 0
            ? (($currentMonthExpense - $previousMonthExpense) / $previousMonthExpense) * 100
            : 0;
        $balanceChange = $previousMonthBalance != 0
            ? (($currentMonthBalance - $previousMonthBalance) / abs($previousMonthBalance)) * 100
            : 0;

        // 最近の取引（最新5件）
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with(['category', 'paymentMethod', 'client'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // チャートデータ（過去6ヶ月）
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $income = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');
            $expense = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');

            $chartData[] = [
                'month' => $month->format('Y-m'),
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense
            ];
        }

        // 現在月の予算データ
        $budgets = Budget::where('user_id', $userId)
            ->where('year', $currentMonth->year)
            ->where('month', $currentMonth->month)
            ->with('category')
            ->get();

        return view('pages.dashboard', compact(
            'currentMonthIncome',
            'currentMonthExpense',
            'currentMonthBalance',
            'incomeChange',
            'expenseChange',
            'balanceChange',
            'recentTransactions',
            'chartData',
            'budgets'
        ));
    }

    public function transaction(Request $request)
    {
        $category = Category::all();
        $paymentMethod = PaymentMethod::all();
        $type = $request->query("type");
        return view('pages.transaction', compact('category', 'paymentMethod', 'type'));
    }

    public function analytics()
    {
        $user = Auth::user();

        // フィルター条件の取得
        $type = request('type', 'all');
        $category_id = request('category_id');
        $start_date = request('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end_date = request('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // 取引データのクエリ構築
        $query = Transaction::where('user_id', $user->id)
            ->with(['category', 'paymentMethod', 'client'])
            ->whereBetween('date', [$start_date, $end_date]);

        // フィルター適用
        if ($type !== 'all') {
            $query->where('type', $type);
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // ページネーション対応
        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // 期間の収支サマリー
        $periodIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('date', [$start_date, $end_date])
            ->sum('amount');

        $periodExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$start_date, $end_date])
            ->sum('amount');

        $periodBalance = $periodIncome - $periodExpense;

        // 科目別集計
        $categoryStats = Transaction::where('user_id', $user->id)
            ->whereBetween('date', [$start_date, $end_date])
            ->selectRaw('category_id, type, SUM(amount) as total')
            ->groupBy('category_id', 'type')
            ->with('category')
            ->get()
            ->groupBy('category.name');

        // 月別推移データ（指定期間内）
        $startMonth = Carbon::parse($start_date)->startOfMonth();
        $endMonth = Carbon::parse($end_date)->endOfMonth();
        $monthlyData = [];

        $current = $startMonth->copy();
        while ($current <= $endMonth) {
            $income = Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereYear('date', $current->year)
                ->whereMonth('date', $current->month)
                ->sum('amount');

            $expense = Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereYear('date', $current->year)
                ->whereMonth('date', $current->month)
                ->sum('amount');

            $monthlyData[] = [
                'month' => $current->format('Y-m'),
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense
            ];

            $current->addMonth();
        }

        // カテゴリー一覧（フィルター用）
        $categories = Category::all();
        $paymentMethod = PaymentMethod::all();
        // dd($transactions->first()->paymentMethod->name);

        return view('pages.analytics', compact(
            'transactions',
            'periodIncome',
            'periodExpense',
            'periodBalance',
            'categoryStats',
            'monthlyData',
            'categories',
            'paymentMethod',
            'type',
            'category_id',
            'start_date',
            'end_date'
        ));
    }

    public function settings(Request $request)
    {
        $category = Category::all();
        $paymentMethods = PaymentMethod::where('user_id', Auth::id())->get();
        $page = $request->query("page");
        return view('pages.settings', compact('category', 'page', 'paymentMethods'));
    }
}
