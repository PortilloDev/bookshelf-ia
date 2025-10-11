<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserBook extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'slug', 'notes', 'tags', 'user_rating',
        'started_reading', 'finished_reading', 'current_page'
    ];

    protected $casts = [
        'started_reading' => 'date',
        'finished_reading' => 'date',
        'tags' => 'array',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($userBook) {
            if (empty($userBook->slug)) {
                $userBook->slug = $userBook->generateUniqueSlug();
            }
        });
    }

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

    /**
     * Generate a unique slug for this user book
     */
    public function generateUniqueSlug(): string
    {
        $baseSlug = Str::slug($this->user->name . '-' . $this->book->title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Find user book by slug
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }
}
