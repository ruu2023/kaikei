<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataExportController extends Controller
{
    public function fetchData(Request $request) {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $transactions = Transaction::with('category', 'paymentMethod')->where('user_id', Auth::id())->whereBetween('date', [$startDate, $endDate])->get()->toArray();
        Log::debug(($transactions));
        return response()->json($transactions,201);
    }
}
