<?php

namespace Infoexam\Snappy;

use Barryvdh\Snappy\Facades\SnappyImage;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Barryvdh\Snappy\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class SnappyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (PHP_OS !== 'Linux') {
            return;
        }

        $bit = PHP_INT_SIZE === 4 ? 'i386' : 'amd64';

        $path = base_path('vendor/h4cc/wkhtmlto%s-%s/bin/wkhtmlto%s-%s');

        foreach (['pdf', 'image'] as $type) {
            $this->app['config']->set(
                sprintf('snappy.%s.binary', $type),
                sprintf($path, $type, $bit, $type, $bit)
            );
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(BaseServiceProvider::class);

        $loader = AliasLoader::getInstance();

        $loader->alias('SnappyPdf', SnappyPdf::class);

        $loader->alias('SnappyImage', SnappyImage::class);
    }
}
