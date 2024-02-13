<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TopicRepositoryInterface;
use App\Repositories\TopicRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(TopicRepositoryInterface::class, TopicRepository::class);

        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }
}
