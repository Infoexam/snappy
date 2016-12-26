<?php

class SnappyTest extends Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            Infoexam\Snappy\SnappyServiceProvider::class,
        ];
    }

    public function test_service_provider_loaded()
    {
        $this->assertArrayHasKey(Barryvdh\Snappy\ServiceProvider::class, $this->app->getLoadedProviders());
    }

    /**
     * @requires OS Linux
     */
    public function test_config()
    {
        $config = $this->app['config']['snappy'];

        if (PHP_INT_SIZE === 4) {
            $this->assertSame(base_path('vendor/h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386'), $config['pdf']['binary']);
            $this->assertSame(base_path('vendor/h4cc/wkhtmltoimage-i386/bin/wkhtmltoimage-i386'), $config['image']['binary']);
        } else {
            $this->assertSame(base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'), $config['pdf']['binary']);
            $this->assertSame(base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'), $config['image']['binary']);
        }
    }
}
