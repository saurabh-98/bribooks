<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'title',
        'sort_order'
    ];

    /**
     * Book relationship
     */
    public function book()
    {
        return $this->belongsTo(
            Book::class
        );
    }

    /**
     * Pages relationship
     */
    public function pages()
    {
        return $this->hasMany(
            Page::class
        );
    }
}