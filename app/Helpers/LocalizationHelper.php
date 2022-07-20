<?php

namespace App\Helpers;

use App\Models\Language;
use App\Facades\Localization\LocalizationFacade;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Class LocalizationHelper
 *
 * @package App\Helpers
 */
final class LocalizationHelper
{
    /**
     * @param string|null $url
     * @param string|null $locale
     *
     * @return string
     * @author sihoullete
     */
    public static function localizeUrl(string $url = null, string $locale = null): string
    {
        $localizeUrl = '';
        if ($locale === null) {
            $locale = LocalizationFacade::getCurrentLanguage();
        }
        if (! LocalizationFacade::isSupportedLanguage($locale)) {
            throw new RuntimeException('Locale \'' . $locale . '\' is not in the list of supported locales.');
        }

        if (is_null($url)) {
            $url = request()->fullUrl();
        }

        $parseUrl = parse_url($url);
        if (isset($parseUrl['scheme'])) {
            $localizeUrl .= $parseUrl['scheme'] . '://';
        }
        if (isset($parseUrl['host'])) {
            $localizeUrl .= $parseUrl['host'];
        }
        if (isset($parseUrl['host'], $parseUrl['port'])) {
            $localizeUrl .= ':' . $parseUrl['port'];
        }

        $urlLocale = LocalizationFacade::getHideDefaultLang()
            && $locale === LocalizationFacade::getDefaultLanguage()
                ? '' : $locale;
        if (isset($parseUrl['path'])) {
            $path = ltrim($parseUrl['path'], '/');

            // Remove old lang locale
            $routePrefix = LocalizationFacade::getApiPrefix();
            $languages = LocalizationFacade::getSupportedLanguages();
            array_filter($languages, function ($lang) use ($routePrefix, &$path) {
                $pattern = !empty($routePrefix)
                    ? '/^\/?' . $lang . '\/?|\/?' . $routePrefix . '\/' . $lang . '\/?/'
                    : '/^\/?' . $lang . '\/?';
                $path = preg_replace($pattern, '', $path);
            });

            $localizeUrl .= !empty($urlLocale)
                ? '/' . $urlLocale . '/' . $path
                : '/' . $path;
        } else {
            $localizeUrl .= '/' . $urlLocale;
        }

        $localizeUrl = ltrim(rtrim($localizeUrl, '/'), '/');
        if (isset($parseUrl['query'])) {
            $localizeUrl .= '?' . $parseUrl['query'];
        }

        return url($localizeUrl);
    }

    /**
     * @return array
     * @author sihoullete
     */
    public static function i18nSwitchList(): array
    {
        $i18nSwitchList = [];
        $languages = Language::where('active', 1)
            ->where('locale', '!=', App::getLocale())
            ->get();
        if ($languages->count()) {
            $languages->each(function (Language $language) use (&$i18nSwitchList) {
                $i18nSwitchList[$language->locale] = [
                    'native' => Str::ucfirst($language->native),
                    'link' => self::localizeUrl(null, $language->locale)
                ];
            });
        }

        return $i18nSwitchList;
    }
}
