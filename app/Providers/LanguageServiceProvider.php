<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Language\LanguageService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class LanguageServiceProvider
 *
 * @package App\Providers
 */
final class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $dynamicLocales = LanguageService::getSupportedLocales();
        if (!empty($dynamicLocales)) {
            app('config')
                ->set('app.locale', LanguageService::getDefaultLocale());
            LaravelLocalization::setSupportedLocales($dynamicLocales);
        }
    }
}
