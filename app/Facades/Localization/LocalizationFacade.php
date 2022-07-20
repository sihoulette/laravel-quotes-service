<?php

namespace App\Facades\Localization;

use Illuminate\Support\Facades\Facade;

/**
 * Class LocalizationFacade
 *
 * @package App\Facades\Localization
 *
 * @method static string langPrefix(string $language = '')
 *
 * @method static string getApiPrefix()
 * @method static string getHideDefaultLang()
 * @method static string getDefaultLanguage()
 * @method static string getCurrentLanguage()
 * @method static array getSupportedLanguages()
 *
 * @method static bool isSupportedLanguage(string $language = '')
 * @method static bool isDefaultLanguage(string $language = '')
 */
class LocalizationFacade extends Facade
{
    /**
     * @return string
     * @author sihoullete
     */
    protected static function getFacadeAccessor(): string
    {
        return 'localization';
    }
}
