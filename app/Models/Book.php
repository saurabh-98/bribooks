<?php

namespace App\Models;

use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'description',
        'status',
        'published_at'
    ];

    protected function casts(): array
    {
        return [
            'status' => BookStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(
            User::class,
            'author_id'
        );
    }

    public function chapters()
    {
        return $this->hasMany(
            Chapter::class
        );
    }

    public function versions()
    {
        return $this->hasMany(
            BookVersion::class
        );
    }

    public function uploads()
    {
        return $this->hasMany(
            Upload::class
        );
    }

    public function moderationLogs()
    {
        return $this->hasMany(
            ModerationLog::class
        );
    }

    public function isPublished(): bool
    {
        return $this->status === BookStatus::PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status === BookStatus::DRAFT;
    }

    public function isSubmitted(): bool
    {
        return $this->status === BookStatus::SUBMITTED;
    }

    public function isApproved(): bool
    {
        return $this->status === BookStatus::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === BookStatus::REJECTED;
    }

    public function isUnderReview(): bool
    {
        return $this->status === BookStatus::UNDER_REVIEW;
    }
}