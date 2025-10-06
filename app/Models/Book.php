<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Book extends Model
{
    use HasUuids;

    protected $fillable = [
        'external_id', 'source', 'title', 'authors', 'description', 
        'isbn', 'publisher', 'published_date', 'page_count', 'language',
        'categories', 'tags', 'rating', 'cover_url', 'preview_url', 'info_url'
    ];

    protected $casts = [
        'authors' => 'array',
        'categories' => 'array',
        'tags' => 'array',
        'published_date' => 'date',
        'rating' => 'decimal:2',
    ];

    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }

    /**
     * Get the global categories for this book
     */
    public function bookCategories()
    {
        return $this->belongsToMany(Category::class, 'book_category')
                    ->withTimestamps();
    }

    /**
     * Get users who have this book in their shelves
     */
    public function usersInShelves()
    {
        return $this->belongsToMany(User::class, 'user_shelf_items')
                    ->withPivot(['shelf_id', 'position', 'added_at'])
                    ->withTimestamps();
    }

    // Helpers opcionales
    public function getAuthorsListAttribute(): string
    {
        return implode(', ', $this->authors ?? []);
    }
}
