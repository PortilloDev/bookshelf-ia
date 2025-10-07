<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'synonyms',
        'description',
        'icon'
    ];

    /**
     * Get the books that belong to this category
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_category')
                    ->withTimestamps();
    }

    /**
     * Get count of books in this category
     */
    public function getBooksCountAttribute()
    {
        return $this->books()->count();
    }
}
