<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserShelf extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'icon',
        'color',
        'is_system',
        'order'
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shelf) {
            if (empty($shelf->slug)) {
                $shelf->slug = Str::slug($shelf->name);
            }
        });
    }

    /**
     * Get the user that owns the shelf
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the books in this shelf
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'user_shelf_items')
                    ->withPivot(['user_id', 'position', 'added_at'])
                    ->withTimestamps()
                    ->orderBy('user_shelf_items.position');
    }

    /**
     * Get the shelf items
     */
    public function items()
    {
        return $this->hasMany(UserShelfItem::class, 'shelf_id');
    }

    /**
     * Get count of books in this shelf
     */
    public function getBooksCountAttribute()
    {
        return $this->items()->count();
    }
}
