<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // TODO: Implement reading stats
        $stats = [
            'totalBooks' => 0,
            'readBooks' => 0,
            'readingBooks' => 0,
            'favoriteBooks' => 0
        ];

        // TODO: Implement recent books
        $recentBooks = [];

        return view('pages.dashboard', compact('user', 'stats', 'recentBooks'));
    }
}
