<?php

namespace App\Repositories\Contracts;

use App\Models\Upload;

interface UploadRepositoryInterface
{
    public function create(
        array $data
    ): Upload;

    public function findById(
        int $id
    ): ?Upload;

    public function getBookUploads(
        int $bookId
    );

    public function delete(
        Upload $upload
    ): bool;
}