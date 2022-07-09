<?php

namespace App\Twig;

use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Route;

/**
 * Class Functions
 *
 * @package App\Twig
 */
class Functions extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     *
     * @author sihoullete
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('routeHas', [$this, 'routeHas']),
            new TwigFunction('i18nSwitchList', [$this, 'i18nSwitchList']),
        ];
    }

    /**
     * Check if a route with the given name exists.
     *
     * @param array|string $name
     * @return bool
     *
     * @author sihoullete
     */
    public static function routeHas(array|string $name): bool
    {
        return Route::has($name);
    }

    /**
     * Switch app language list
     *
     * @return array
     *
     * @author sihoullete
     */
    public static function i18nSwitchList(): array
    {
        $i18nSwitchList = [];
        foreach (LaravelLocalization::getSupportedLocales() as $locale => $item) {
            if ($locale !== LaravelLocalization::getCurrentLocale()) {
                $i18nSwitchList[$locale] = [
                    'native' => Str::ucfirst($item['native']),
                    'link' => LaravelLocalization::getLocalizedURL($locale, null, [], false)
                ];
            }
        }

        return $i18nSwitchList;
    }
}
