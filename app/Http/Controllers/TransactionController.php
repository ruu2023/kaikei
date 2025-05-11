<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        $transaction->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}
