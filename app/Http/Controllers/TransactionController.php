<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class TransactionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->with(['category', 'paymentMethod', 'client'])->latest()->get();
        return response()->json($transactions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log::debug('store start', $request->all()); // デバッグ用
        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|integer|min:0',
            'type' => 'required|in:income,expense',
            'memo' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'client_id' => 'nullable|exists:clients,id',
            'client_name' => 'nullable|string|max:255',
        ]);
        // Log::debug('validate ok', $validated); // デバッグ用
        $validated['user_id'] = Auth::id();

        $transaction = Transaction::create($validated);

        // return response()->json($transaction, 201);
        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        $transaction->load(['category', 'paymentMethod', 'client']);

        return response()->json($transaction);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->load(['category', 'paymentMethod', 'client']);

        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|integer|min:0',
            'type' => 'required|in:income,expense',
            'memo' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'client_id' => 'nullable|exists:clients,id',
            'client_name' => 'nullable|string|max:255',
        ]);

        $transaction->update($validated);

        return back()->with('success', '取引を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        $transaction->delete();

        return back()->with('success', '取引を削除しました。');
    }

    /**
     * Export transactions as CSV
     */
    public function exportCsv(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $transactions = Transaction::where('user_id', Auth::id())
            ->with(['category', 'paymentMethod', 'client'])
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $filename = '仕訳帳_' . $start_date . '_' . $end_date . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');

            // BOMを追加（Excelでの文字化け対策）
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // ヘッダー行
            fputcsv($file, [
                '日付',
                '借方科目',
                '借方金額',
                '貸方科目',
                '貸方金額',
                '摘要',
                '支払方法',
                '取引先'
            ]);

            foreach ($transactions as $transaction) {
                if ($transaction->type === 'income') {
                    // 収入の場合：現金（借方）/ 売上（貸方）
                    fputcsv($file, [
                        $transaction->date,
                        $transaction->paymentMethod ? $transaction->paymentMethod->name : '現金',
                        $transaction->amount,
                        $transaction->category->name,
                        '',
                        $transaction->memo ?: '',
                        $transaction->paymentMethod ? $transaction->paymentMethod->name : '現金',
                        $transaction->client ? $transaction->client->name : ($transaction->client_name ?: '')
                    ]);
                } else {
                    // 支出の場合：経費（借方）/ 現金（貸方）
                    fputcsv($file, [
                        $transaction->date,
                        $transaction->category->name,
                        $transaction->amount,
                        $transaction->paymentMethod ? $transaction->paymentMethod->name : '現金',
                        '',
                        $transaction->memo ?: '',
                        $transaction->paymentMethod ? $transaction->paymentMethod->name : '現金',
                        $transaction->client ? $transaction->client->name : ($transaction->client_name ?: '')
                    ]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
