<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TopicRepositoryInterface;
use App\Repositories\TopicRepository;

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
    }
}
