<?php

namespace App\DTOs\Upload;

use Illuminate\Http\UploadedFile;

readonly class UploadDocumentDTO
{
    public function __construct(
        public int $bookId,
        public UploadedFile $file
    ) {}

    public static function fromArray(
        array $data
    ): self {
        return new self(
            bookId: $data['book_id'],
            file: $data['file']
        );
    }
}