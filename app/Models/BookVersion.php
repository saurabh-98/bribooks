<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'version',
        'snapshot',
        'created_by',
    ];

    protected $casts = [
        'snapshot' => 'array',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}