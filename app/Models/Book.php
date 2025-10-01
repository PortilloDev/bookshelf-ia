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
        'categories', 'rating', 'cover_url', 'preview_url', 'info_url'
    ];

    protected $casts = [
        'authors' => 'array',
        'categories' => 'array',
        'published_date' => 'date',
        'rating' => 'decimal:2',
    ];

    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }

    // Helpers opcionales
    public function getAuthorsListAttribute(): string
    {
        return implode(', ', $this->authors ?? []);
    }
}
