<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'book_id',
        'file_name',
        'file_path',
        'status'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}