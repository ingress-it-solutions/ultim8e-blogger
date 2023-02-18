<?php

namespace IngressITSolutions\Ultim8eBlogger\Tests;

use Illuminate\Support\Facades\Artisan;
use IngressITSolutions\Ultim8eBlogger\Tests\TestCase;

class InstallTest extends TestCase
{
    /** @test */
    public function it_can_be_installed()
    {
        Artisan::call('vendor:publish', [
            '--provider' =>
                'IngressITSolutions\Ultim8eBlogger\Ultim8eBloggerServiceProvider',
        ]);

        $output = Artisan::output();

        if ((int) app()->version()[0] >= 9) {
            $this->assertStringContainsString('DONE', $output);
        } else {
            $this->assertStringContainsString('Copied File', $output);
            $this->assertStringContainsString('Copied Directory', $output);
        }

        $this->assertFileExists(config_path('ultim8e-blogger.php'));
        $this->assertDirectoryExists(
            resource_path('views/vendor/ultim8e-blogger')
        );
    }

    /**
     * @test
     */
    public function it_has_correct_config()
    {
        $this->assertIsArray(config('ultim8e-blogger'));
        $this->assertEquals(
            base_path('posts'),
            config('ultim8e-blogger.posts_path')
        );
        $this->assertEquals('page', config('ultim8e-blogger.page_indicator'));
    }

    /**
     * @test
     */
    public function it_has_editable_config()
    {
        $this->app['config']->set(
            'ultim8e-blogger.posts_path',
            resource_path('posts')
        );

        $this->assertEquals(
            resource_path('posts'),
            config('ultim8e-blogger.posts_path')
        );
    }
}
