<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TopicRepositoryInterface;
use App\Repositories\TopicRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;

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

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
