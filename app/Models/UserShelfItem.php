<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserShelfItem extends Model
{
    protected $fillable = [
        'user_id',
        'shelf_id',
        'book_id',
        'position',
        'added_at'
    ];

    protected $casts = [
        'added_at' => 'datetime',
        'position' => 'integer'
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shelf
     */
    public function shelf()
    {
        return $this->belongsTo(UserShelf::class, 'shelf_id');
    }

    /**
     * Get the book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
