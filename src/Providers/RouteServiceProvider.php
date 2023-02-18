<?php

namespace IngressITSolutions\Ultim8eBlogger\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use IngressITSolutions\Ultim8eBlogger\Models\Post;
use IngressITSolutions\Ultim8eBlogger\Repositories\PostRepository;
use Spatie\Sheets\Sheets;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::bind('post', function ($slug, $route) {
            return $this->app->make(PostRepository::class)->find($slug);
        });

        parent::boot();
    }

    public function map(): void
    {
        if (config('ultim8e-blogger.register_routes')) {
            Route::middleware('web')->group(__DIR__ . '/../Http/routes.php');
        }
    }
}
