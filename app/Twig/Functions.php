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
            new TwigFunction('routeHas', [Route::class, 'has']),
            new TwigFunction('i18nSwitchList', [$this, 'i18nSwitchList']),
            new TwigFunction('localizeURL', [LaravelLocalization::class, 'localizeURL']),
        ];
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
