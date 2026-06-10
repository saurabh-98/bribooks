<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Book;
use App\Models\Upload;
use App\Services\UploadService;
use App\DTOs\Upload\UploadDocumentDTO;
use App\Http\Requests\Upload\StoreUploadRequest;

class UploadController extends BaseApiController
{
    public function __construct(
        protected UploadService $uploadService
    ) {}

    /**
     * Upload document
     */
    public function store(
        StoreUploadRequest $request,
        Book $book
    )
    {
        try {

            $upload = $this->uploadService
                ->upload(
                    new UploadDocumentDTO(
                        file: $request->file('file'),
                        bookId: $book->id
                    )
                );

            return $this->success(
                $upload,
                'File uploaded successfully',
                201
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * List uploads of a book
     */
    public function index(
        Book $book
    )
    {
        try {

            return $this->success(
                $this->uploadService->getBookUploads(
                    $book->id
                ),
                'Uploads fetched successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Show single upload
     */
    public function show(
        Upload $upload
    )
    {
        try {

            return $this->success(
                $this->uploadService->getUpload(
                    $upload
                ),
                'Upload fetched successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                404
            );
        }
    }

    /**
     * Delete upload
     */
    public function destroy(
        Upload $upload
    )
    {
        try {

            $this->uploadService->deleteUpload(
                $upload
            );

            return $this->success(
                null,
                'Upload deleted successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                500
            );
        }
    }
}