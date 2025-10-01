<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookRaw extends Model
{
    use HasUuids;

    protected $table = 'book_raw';

    protected $fillable = [
        'source','external_id','payload_json','checksum','status','fetched_at',
    ];

    protected $casts = [
        'payload_json' => 'array',
        'fetched_at' => 'datetime',
    ];
}
