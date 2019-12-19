<?php

use Barryvdh\Snappy\ServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;

class SnappyTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            Infoexam\Snappy\SnappyServiceProvider::class,
        ];
    }

    public function test_service_provider_loaded()
    {
        $this->assertArrayHasKey(
            ServiceProvider::class,
            $this->app->getLoadedProviders()
        );
    }

    /**
     * @requires OS Linux
     */
    public function test_config()
    {
        $config = $this->app['config']['snappy'];

        $type = PHP_INT_SIZE === 4 ? 'i386' : 'amd64';

        $this->assertSame(
            base_path(
                sprintf(
                    'vendor/h4cc/wkhtmltopdf-%s/bin/wkhtmltopdf-%s',
                    $type,
                    $type
                )
            ),
            $config['pdf']['binary']
        );

        $this->assertSame(
            base_path(
                sprintf(
                    'vendor/h4cc/wkhtmltoimage-%s/bin/wkhtmltoimage-%s',
                    $type,
                    $type
                )
            ),
            $config['image']['binary']
        );
    }
}
