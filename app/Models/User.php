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
                    ->withPivot(['status', 'notes', 'user_rating', 'started_reading', 'finished_reading', 'current_page'])
                    ->withTimestamps();
    }

    public function getReadingStatsAttribute()
    {
        $userBooks = $this->userBooks();
        
        return [
            'readBooks' => $userBooks->where('status', 'read')->count(),
            'readingBooks' => $userBooks->where('status', 'reading')->count(),
            'favoriteBooks' => $userBooks->where('status', 'favorites')->count(),
        ];
    }
}
