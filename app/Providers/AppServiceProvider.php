<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\View\Components\{
    Slider,
    WebHeader,
    ZeroState
};
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
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
        date_default_timezone_set('Africa/Lagos');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        # components
        Blade::components([
            'web-header' => WebHeader::class,
            'slider' => Slider::class,
            'zero-state' => ZeroState::class
        ]);

        // View::share([
        //     'siteSetting' => SiteSetting::first()
        // ]);
    }
}