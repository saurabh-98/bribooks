<?php

namespace App\Repositories;

use App\Models\Upload;
use App\Repositories\Contracts\UploadRepositoryInterface;

class UploadRepository implements UploadRepositoryInterface
{
    public function create(
        array $data
    ): Upload {

        return Upload::create(
            $data
        );
    }

    public function findById(
        int $id
    ): ?Upload {

        return Upload::find($id);
    }

    public function getBookUploads(
        int $bookId
    )
    {
        return Upload::where(
            'book_id',
            $bookId
        )
        ->latest()
        ->get();
    }

    public function delete(
        Upload $upload
    ): bool {

        return $upload->delete();
    }
}