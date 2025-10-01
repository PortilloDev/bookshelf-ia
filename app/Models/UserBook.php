<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBook extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'status', 'notes', 'user_rating',
        'started_reading', 'finished_reading', 'current_page'
    ];

    protected $casts = [
        'started_reading' => 'date',
        'finished_reading' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
