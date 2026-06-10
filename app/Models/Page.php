<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'chapter_id',
        'title',
        'content',
        'page_no'
    ];

    public function chapter()
    {
        return $this->belongsTo(
            Chapter::class
        );
    }
}