<?php

namespace App\Http\Controllers\Api;

use Throwable;

use App\Models\Book;
use App\Models\BookVersion;

use App\Services\VersionService;

use App\DTOs\Version\CreateVersionDTO;

use App\Http\Requests\Version\CreateVersionRequest;

class VersionController extends BaseApiController
{
    public function __construct(
        protected VersionService $versionService
    ) {}

    /**
     * Create Version Snapshot
     */
    public function store(
        CreateVersionRequest $request
    )
    {
        try {

            $version = $this->versionService
                ->create(
                    CreateVersionDTO::fromArray(
                        $request->validated()
                    )
                );

            return $this->success(
                $version,
                'Version created successfully',
                201
            );

        } catch (Throwable $e) {

            return $this->error(
                config('app.debug')
                    ? $e->getMessage()
                    : 'Failed to create version',
                null,
                500
            );
        }
    }

    /**
     * List Book Versions
     */
    public function index(
        Book $book
    )
    {
        try {

            $versions = $this->versionService
                ->getVersions(
                    $book
                );

            return $this->success(
                $versions,
                'Versions fetched successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                config('app.debug')
                    ? $e->getMessage()
                    : 'Failed to fetch versions',
                null,
                500
            );
        }
    }

    /**
     * Show Single Version
     */
    public function show(
        Book $book,
        BookVersion $version
    )
    {
        try {

            $version = $this->versionService
                ->show(
                    $book,
                    $version
                );

            return $this->success(
                $version,
                'Version fetched successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                config('app.debug')
                    ? $e->getMessage()
                    : 'Version not found',
                null,
                404
            );
        }
    }

    /**
     * Rollback Version
     */
    public function rollback(
        Book $book,
        BookVersion $version
    )
    {
        try {

            $book = $this->versionService
                ->rollback(
                    $version
                );

            return $this->success(
                $book,
                'Version rollback successful'
            );

        } catch (Throwable $e) {

            return $this->error(
                config('app.debug')
                    ? $e->getMessage()
                    : 'Rollback failed',
                null,
                500
            );
        }
    }
}