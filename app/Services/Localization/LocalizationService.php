<?php

namespace App\Services\Localization;

use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Entities\Localization\LocalizationEntity;

/**
 * Class LocalizationService
 *
 * @package App\Services\Localization
 */
final class LocalizationService implements LocalizationServiceContract
{
    /**
     * @var LocalizationEntity $entity
     */
    private static LocalizationEntity $entity;

    /**
     * LocalizationService constructor.
     *
     * @param LocalizationEntity $entity
     */
    public function __construct(LocalizationEntity $entity)
    {
        self::$entity = $entity;
        if ($this->canLoadLanguages()) {
            $this->loadSupportedLanguages();
            $this->loadDefaultLanguage();
        }
    }

    /**
     * @return bool
     * @author sihoullete
     */
    public function canLoadLanguages(): bool
    {
        try {
            $aliveConnect = true;
            DB::connection()->getPdo();
        } catch (\Exception) {
            $aliveConnect = false;
        }

        return $aliveConnect && Schema::hasTable('languages');
    }

    /**
     * @return void
     * @author sihoullete
     */
    public function loadSupportedLanguages(): void
    {
        $languages = Language::where('active', 1)
            ->orderBy('position')
            ->get();
        if ($languages->count()) {
            $supportedLocales = $languages->map(function ($lang) {
                return $lang->locale;
            })->toArray();
            self::$entity->setSupportedLanguages($supportedLocales);
        } else {
            $defaultLanguages = config('app.supported_locales', []);
            self::$entity->setSupportedLanguages($defaultLanguages);
        }
    }

    /**
     * @return void
     * @author sihoullete
     */
    public function loadDefaultLanguage(): void
    {
        $defaultLanguage = config('app.locale') ?: config('app.fallback_locale');
        $language = Language::where('active', 1)
            ->where('default', 1)
            ->first();
        if ($language instanceof Language) {
            $defaultLanguage = $language->locale;
        }

        self::$entity->setDefaultLanguage($defaultLanguage);
        self::$entity->setCurrentLanguage($defaultLanguage);

        $this->loadCurrentLanguage();
    }

    /**
     * @return void
     * @author sihoullete
     */
    public function loadCurrentLanguage(): void
    {
        $segments = request()->segments();
        if (count($segments)) {
            $currentLang = $segments[0];
            if ($currentLang === self::$entity->getApiPrefix()) {
                $currentLang = $segments[1] ?? self::$entity->getDefaultLanguage();
            }
            self::$entity->setCurrentLanguage($currentLang);
        }

        app()->setLocale(self::$entity->getCurrentLanguage());
    }

    /**
     * @param string $language
     *
     * @return string
     * @author sihoullete
     */
    public static function langPrefix(string $language = ''): string
    {
        if (!is_null($language)) {
            self::$entity->setCurrentLanguage($language);
            app()->setLocale(self::$entity->getCurrentLanguage());
        }

        // Set current lang prefix
        $langPrefix = self::$entity->getCurrentLanguage();
        if (self::$entity->getHideDefaultLang()) {
            $segments = request()->segments();
            // Check can remove prefix in segments
            $canRmPrefix = count($segments) === 0;
            if (!$canRmPrefix) {
                $urlLang = self::$entity->getApiPrefix() === $segments[0]
                    ? $segments[1] ?? '' : $segments[0] ?? '';

                $canRmPrefix = !self::$entity->isSupportedLanguage($urlLang);
            }

            // Remove prefix if can
            $langPrefix = $canRmPrefix ? '' : $langPrefix;
        }

        return $langPrefix;
    }

    /**
     * @return string
     * @author sihoullete
     */
    public static function getApiPrefix(): string
    {
        return self::$entity->getApiPrefix();
    }

    /**
     * @return string
     * @author sihoullete
     */
    public static function getHideDefaultLang(): string
    {
        return self::$entity->getHideDefaultLang();
    }

    /**
     * @return string
     * @author sihoullete
     */
    public static function getDefaultLanguage(): string
    {
        return self::$entity->getDefaultLanguage();
    }

    /**
     * @return string
     * @author sihoullete
     */
    public static function getCurrentLanguage(): string
    {
        return self::$entity->getCurrentLanguage();
    }

    /**
     * @return array
     * @author sihoullete
     */
    public static function getSupportedLanguages(): array
    {
        return self::$entity->getSupportedLanguages();
    }

    /**
     * @param string $language
     *
     * @return bool
     * @author sihoullete
     */
    public static function isSupportedLanguage(string $language = ''): bool
    {
        return self::$entity->isSupportedLanguage($language);
    }

    /**
     * @param string $language
     *
     * @return bool
     * @author sihoullete
     */
    public static function isDefaultLanguage(string $language = ''): bool
    {
        return self::$entity->isDefaultLanguage($language);
    }
}
