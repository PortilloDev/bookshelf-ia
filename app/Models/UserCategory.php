<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'color',
        'icon'
    ];

    /**
     * Get the user that owns the category
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user books that have this category
     */
    public function userBooks()
    {
        return $this->belongsToMany(UserBook::class, 'user_book_categories');
    }
}
