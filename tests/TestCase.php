<?php

namespace IngressITSolutions\Ultim8eBlogger\Tests;

use IngressITSolutions\Ultim8eBlogger\Ultim8eBloggerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Sheets\SheetsServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            Ultim8eBloggerServiceProvider::class,
            SheetsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }

    public function tearDown(): void
    {
        // Unset config
        $file = base_path() . '/config/ultim8e-blogger.php';
        if (file_exists($file)) {
            unlink($file);
        }

        parent::tearDown();
    }
}
