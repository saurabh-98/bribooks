<?php

namespace App\Services;

use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

use App\DTOs\Upload\UploadDocumentDTO;

use App\Repositories\Contracts\UploadRepositoryInterface;

class UploadService
{
    public function __construct(
        protected UploadRepositoryInterface $uploadRepository,
        protected DocumentConversionService $documentConversionService,
        protected VersionService $versionService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Upload Document
    |--------------------------------------------------------------------------
    */

    public function upload(
        UploadDocumentDTO $dto
    ): Upload {

        return DB::transaction(function () use ($dto) {

            $path = $dto->file->store(
                'manuscripts',
                'public'
            );

            $upload = $this->uploadRepository
                ->create([
                    'book_id'   => $dto->bookId,
                    'file_name' => $dto->file
                        ->getClientOriginalName(),
                    'file_path' => $path,
                    'status'    => 'processing',
                ]);

            $this->documentConversionService
                ->convert(
                    $dto->bookId,
                    storage_path(
                        'app/public/' . $path
                    )
                );

            $upload->update([
                'status' => 'completed',
            ]);

            $book = $upload->book;

            $this->versionService
                ->createSnapshot(
                    $book
                );

            return $upload->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Get Uploads By Book
    |--------------------------------------------------------------------------
    */

    public function getBookUploads(
        int $bookId
    ): Collection {

        return Upload::query()
            ->where(
                'book_id',
                $bookId
            )
            ->latest()
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Get Single Upload
    |--------------------------------------------------------------------------
    */

    public function getUpload(
        Upload $upload
    ): Upload {

        return $upload->load(
            'book'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Upload
    |--------------------------------------------------------------------------
    */

    public function deleteUpload(
        Upload $upload
    ): bool {

        return DB::transaction(function () use ($upload) {

            if (
                $upload->file_path &&
                Storage::disk('public')
                    ->exists(
                        $upload->file_path
                    )
            ) {
                Storage::disk('public')
                    ->delete(
                        $upload->file_path
                    );
            }

            return (bool) $upload->delete();
        });
    }
}