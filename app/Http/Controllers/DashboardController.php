<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBook;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Calculate reading stats from shelves
        $stats = [
            'totalBooks' => $user->userBooks()->count(),
            'readBooks' => $user->getShelfBySlug('read')?->items()->count() ?? 0,
            'readingBooks' => $user->getShelfBySlug('reading')?->items()->count() ?? 0,
            'favoriteBooks' => $user->getShelfBySlug('favorites')?->items()->count() ?? 0
        ];

        // Get recent books (last 5 added)
        $recentBookIds = \App\Models\UserShelfItem::where('user_id', $user->id)
            ->orderBy('added_at', 'desc')
            ->limit(5)
            ->pluck('book_id')
            ->unique();
        
        $recentBooks = $user->userBooks()
            ->with('book')
            ->whereIn('book_id', $recentBookIds)
            ->get()
            ->map(function($userBook) use ($user) {
                $book = $userBook->book;
                
                // Get shelves for this book
                $shelfItems = \App\Models\UserShelfItem::where('user_id', $user->id)
                    ->where('book_id', $book->id)
                    ->with('shelf')
                    ->get();
                
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'authors' => $book->authors ?? [],
                    'cover_url' => $book->cover_url,
                    'shelves' => $shelfItems->pluck('shelf')->filter()->map(function($shelf) {
                        return [
                            'name' => $shelf->name,
                            'icon' => $shelf->icon,
                            'color' => $shelf->color,
                            'is_system' => $shelf->is_system
                        ];
                    })->toArray()
                ];
            })->toArray();

        return view('pages.dashboard', compact('user', 'stats', 'recentBooks'));
    }
}
