<?php

namespace Tannhatcms\ImageResizes;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ImageResizesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'imageresizes');
    }

    public function boot()
    {
        try {
            foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
                require_once $filename;
            }
        } catch (\Exception $e) {
            //throw $e;
        }         
    }

}
