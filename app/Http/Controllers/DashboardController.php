<?php

namespace App\Http\Controllers;

// Ei controller dashboard er summary data show kore (total team, player, match etc)
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
}