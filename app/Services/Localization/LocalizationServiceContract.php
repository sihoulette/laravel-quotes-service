<?php

namespace App\Services\Localization;

/**
 * Interface LocalizationServiceContract
 *
 * @package App\Services\Localization
 */
interface LocalizationServiceContract
{
    /**
     * @return bool
     * @author sihoullete
     */
    public function canLoadLanguages(): bool;

    /**
     * @return void
     * @author sihoullete
     */
    public function loadSupportedLanguages(): void;

    /**
     * @return void
     * @author sihoullete
     */
    public function loadDefaultLanguage(): void;

    /**
     * @return void
     * @author sihoullete
     */
    public function loadCurrentLanguage(): void;

    /**
     * @param string $language
     *
     * @return string
     * @author sihoullete
     */
    public static function langPrefix(string $language = ''): string;

    /**
     * @return string|null
     * @author sihoullete
     */
    public static function getApiPrefix(): ?string;

    /**
     * @return string
     * @author sihoullete
     */
    public static function getHideDefaultLang(): string;

    /**
     * @return string
     * @author sihoullete
     */
    public static function getDefaultLanguage(): string;

    /**
     * @return string
     * @author sihoullete
     */
    public static function getCurrentLanguage(): string;

    /**
     * @return array
     * @author sihoullete
     */
    public static function getSupportedLanguages(): array;

    /**
     * @param string $language
     *
     * @return bool
     * @author sihoullete
     */
    public static function isSupportedLanguage(string $language = ''): bool;

    /**
     * @param string $language
     *
     * @return bool
     * @author sihoullete
     */
    public static function isDefaultLanguage(string $language = ''): bool;
}
