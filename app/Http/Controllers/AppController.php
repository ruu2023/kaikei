<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PaymentMethod;

class AppController extends Controller
{
    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function transaction()
    {
        $category = Category::all();
        $paymentMethod = PaymentMethod::all();
        return view('pages.transaction', compact('category', 'paymentMethod'));
    }

    public function analytics()
    {
        return view('pages.analytics');
    }

    public function settings()
    {
        $category = Category::all();
        return view('pages.settings', compact('category'));
    }
}
