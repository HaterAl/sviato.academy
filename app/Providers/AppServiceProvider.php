<?php

namespace App\Providers;

use App\Services\Seo;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Change 'public' path to 'static'
        $this->app->bind('path.public', fn() => base_path('static'));

        $this->app->singleton('seo', function ($app) {
            return new Seo($app->request);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Vite::macro('image', fn ($asset) => $this->asset("resources/images/{$asset}"));
    }
}
