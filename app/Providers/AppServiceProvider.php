<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Models\Book;

use App\Policies\BookPolicy;

use App\Repositories\UserRepository;
use App\Repositories\BookRepository;
use App\Repositories\ChapterRepository;
use App\Repositories\PageRepository;
use App\Repositories\VersionRepository;
use App\Repositories\UploadRepository;
use App\Repositories\DashboardRepository;
use App\Repositories\WorkflowRepository;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\ChapterRepositoryInterface;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Repositories\Contracts\VersionRepositoryInterface;
use App\Repositories\Contracts\UploadRepositoryInterface;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use App\Repositories\Contracts\WorkflowRepositoryInterface;

use App\Events\BookCreated;
use App\Events\BookUpdated;

use App\Events\ChapterCreated;
use App\Events\ChapterUpdated;
use App\Events\ChapterDeleted;

use App\Events\PageCreated;
use App\Events\PageUpdated;
use App\Events\PageDeleted;

use App\Listeners\CreateBookVersionListener;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Repository Bindings
        |--------------------------------------------------------------------------
        */

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            BookRepositoryInterface::class,
            BookRepository::class
        );

        $this->app->bind(
            ChapterRepositoryInterface::class,
            ChapterRepository::class
        );

        $this->app->bind(
            PageRepositoryInterface::class,
            PageRepository::class
        );

        $this->app->bind(
            UploadRepositoryInterface::class,
            UploadRepository::class
        );

        $this->app->bind(
            VersionRepositoryInterface::class,
            VersionRepository::class
        );

        $this->app->bind(
            DashboardRepositoryInterface::class,
            DashboardRepository::class
        );

        $this->app->bind(
            WorkflowRepositoryInterface::class,
            WorkflowRepository::class
        );
    }

    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Policies
        |--------------------------------------------------------------------------
        */

        Gate::policy(
            Book::class,
            BookPolicy::class
        );

        /*
        |--------------------------------------------------------------------------
        | Event Listeners
        |--------------------------------------------------------------------------
        */

       $events = [

            BookCreated::class,
            BookUpdated::class,

            ChapterCreated::class,
            ChapterUpdated::class,
            ChapterDeleted::class,

            PageCreated::class,
            PageUpdated::class,
            PageDeleted::class,

            BookSubmitted::class,
            BookApproved::class,
            BookRejected::class,
            BookPublished::class,
        ];

        foreach ($events as $event) {

            Event::listen(
                $event,
                CreateBookVersionListener::class
            );
        }
    }
}