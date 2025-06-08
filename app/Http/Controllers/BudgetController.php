<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        // 現在の月の予算一覧
        $budgets = Budget::where('user_id', Auth::id())
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->with('category')
            ->get();
        
        // 支出カテゴリ一覧（予算設定用）
        $expenseCategories = Category::where('default_type', 'expense')->get();
        
        return view('budgets.index', compact('budgets', 'expenseCategories', 'currentYear', 'currentMonth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|integer|min:1',
            'year' => 'required|integer|min:2020|max:2030',
            'month' => 'required|integer|min:1|max:12',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        // 既存の予算があれば更新、なければ作成
        Budget::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'category_id' => $validated['category_id'],
                'year' => $validated['year'],
                'month' => $validated['month'],
            ],
            ['amount' => $validated['amount']]
        );
        
        return back()->with('success', '予算を設定しました。');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
        ]);
        
        $budget->update($validated);
        
        return back()->with('success', '予算を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        
        $budget->delete();
        
        return back()->with('success', '予算を削除しました。');
    }

    /**
     * Get budget data for specific month (AJAX)
     */
    public function getBudgetData(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);
        
        $budgets = Budget::where('user_id', Auth::id())
            ->where('year', $year)
            ->where('month', $month)
            ->with('category')
            ->get();
        
        $budgetData = $budgets->map(function ($budget) {
            return [
                'id' => $budget->id,
                'category_name' => $budget->category->name,
                'amount' => $budget->amount,
                'actual_spent' => $budget->actual_spent,
                'remaining_amount' => $budget->remaining_amount,
                'progress_percentage' => $budget->progress_percentage,
                'warning_level' => $budget->warning_level,
                'is_over_budget' => $budget->is_over_budget,
            ];
        });
        
        return response()->json($budgetData);
    }
}
