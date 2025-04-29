<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function transaction()
    {
        return view('pages.transaction');
    }

    public function analytics()
    {
        return view('pages.analytics');
    }

    public function settings()
    {
        return view('pages.settings');
    }
}
