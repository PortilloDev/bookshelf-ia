<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryEmbedding extends Model
{
    protected $fillable = [
        'hash','query_norm','provider','model','dim','vector_literal','expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
