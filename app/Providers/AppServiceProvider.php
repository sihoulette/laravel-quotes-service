<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Localization\LocalizationService;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LocalizationService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $this->app->make(LocalizationService::class);
        $this->app->bind('localization', LocalizationService::class);
    }
}
