<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'user_books')
                    ->withPivot(['notes', 'user_rating', 'started_reading', 'finished_reading', 'current_page', 'tags'])
                    ->withTimestamps();
    }

    /**
     * Get user's shelves
     */
    public function shelves()
    {
        return $this->hasMany(UserShelf::class)->orderBy('order');
    }

    /**
     * Get user's system shelves
     */
    public function systemShelves()
    {
        return $this->shelves()->where('is_system', true);
    }

    /**
     * Get user's custom shelves
     */
    public function customShelves()
    {
        return $this->shelves()->where('is_system', false);
    }

    /**
     * Get shelf by slug
     */
    public function getShelfBySlug($slug)
    {
        return $this->shelves()->where('slug', $slug)->first();
    }

    public function getReadingStatsAttribute()
    {
        return [
            'readBooks' => $this->getShelfBySlug('read')?->books_count ?? 0,
            'readingBooks' => $this->getShelfBySlug('reading')?->books_count ?? 0,
            'favoriteBooks' => $this->getShelfBySlug('favorites')?->books_count ?? 0,
            'totalBooks' => $this->userBooks()->count(),
        ];
    }
}
