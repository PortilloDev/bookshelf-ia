<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBook extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'notes', 'tags', 'user_rating',
        'started_reading', 'finished_reading', 'current_page'
    ];

    protected $casts = [
        'started_reading' => 'date',
        'finished_reading' => 'date',
        'tags' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the shelves this book is in
     */
    public function shelves()
    {
        return $this->hasMany(UserShelfItem::class, 'book_id', 'book_id')
                    ->where('user_id', $this->user_id);
    }

    /**
     * Helper: Get all shelf names this book is in
     */
    public function getShelfNamesAttribute()
    {
        return $this->shelves()
                    ->with('shelf')
                    ->get()
                    ->pluck('shelf.name')
                    ->toArray();
    }
}
