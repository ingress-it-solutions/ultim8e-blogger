<?php

namespace IngressITSolutions\Ultim8eBlogger;

use Illuminate\Support\ServiceProvider;
use IngressITSolutions\Ultim8eBlogger\Commands\NewPost;
use IngressITSolutions\Ultim8eBlogger\Models\Post;
use IngressITSolutions\Ultim8eBlogger\Providers\RouteServiceProvider;
use IngressITSolutions\Ultim8eBlogger\Repositories\PostRepository;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;

class Ultim8eBloggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/config/ultim8e-blogger.php' => config_path(
                        'ultim8e-blogger.php'
                    ),
                ],
                'config'
            );
            $this->publishes(
                [
                    __DIR__ . '/resources/views' => resource_path(
                        'views/vendor/ultim8e-blogger'
                    ),
                ],
                'views'
            );
        }
    }

    public function register()
    {
        $this->setup();
        $this->registerRepositories();
        $this->registerCommands();

        $this->app->register(RouteServiceProvider::class);
    }

    private function setup()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'ultim8e-blogger');

        $this->mergeConfigFrom(
            __DIR__ . '/config/ultim8e-blogger.php',
            'ultim8e-blogger'
        );

        // Add a disk to the filesystem
        $this->app['config']->set('filesystems.disks.ultim8e-blogger::posts', [
            'driver' => 'local',
            'root' => config('ultim8e-blogger.posts_path'),
        ]);

        // Overload sheets config to avoid local conflicts
        $this->app['config']->set('sheets.collections', [
            'posts' => [
                'disk' => 'ultim8e-blogger::posts',
                'sheet_class' => Post::class,
                'path_parser' => SlugWithDateParser::class,
                'content_parser' => MarkdownWithFrontMatterParser::class,
                'extension' => 'md',
            ],
        ]);
    }

    private function registerRepositories()
    {
        $this->app->singleton(PostRepository::class);
    }

    private function registerCommands()
    {
        $this->commands([NewPost::class]);
    }
}
