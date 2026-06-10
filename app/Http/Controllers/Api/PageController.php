<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Page;
use App\Models\Chapter;
use App\Services\PageService;
use App\DTOs\Page\StorePageDTO;
use App\DTOs\Page\UpdatePageDTO;
use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;

class PageController extends BaseApiController
{
    public function __construct(
        protected PageService $pageService
    ) {}

    /**
     * Display pages
     */
    public function index()
    {
        try {

            return $this->success(
                $this->pageService->getMyPages(),
                'Pages fetched successfully'
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
     * Store page
     */

   
    public function store(
        StorePageRequest $request,
        Chapter $chapter
    )
    {
        try {

            $page = $this->pageService->create(

                StorePageDTO::fromArray(
                    $request->validated(),
                    $chapter->id
                )

            );

            return $this->success(
                $page,
                'Page created successfully',
                201
            );

        } catch (\Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }

    /**
     * Show page
     */
    public function show(
        Page $page
    ) {
        return $this->success(
            $this->pageService->show(
                $page
            ),
            'Page fetched successfully'
        );
    }

    /**
     * Update page
     */
    public function update(
        UpdatePageRequest $request,
        Page $page
    ) {
        try {

            $page = $this->pageService->update(
                $page,
                UpdatePageDTO::fromArray(
                    $request->validated()
                )
            );

            return $this->success(
                $page,
                'Page updated successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }

    /**
     * Delete page
     */
    public function destroy(
        Page $page
    ) {
        try {

            $this->pageService->delete(
                $page
            );

            return $this->success(
                null,
                'Page deleted successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }
}