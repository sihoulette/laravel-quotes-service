<?php

namespace App\Entities\Localization;

/**
 * Interface LocalizationEntityContract
 *
 * @package App\Entities\Localization
 */
interface LocalizationEntityContract
{
    /**
     * Default app language
     */
    public const DEFAULT_LANGUAGE = 'ru';

    /**
     * List of default support languages
     */
    public const SUPPORT_LANGUAGES = ['ru', 'en'];

    /**
     * List of all available languages
     */
    public const AVAILABLE_LANGUAGES = [
        'uk' => ['name' => 'Ukrainian', 'native' => 'Українська', 'regional' => 'uk_UA'],
        'en' => ['name' => 'English', 'native' => 'English', 'regional' => 'en_GB'],
        'ru' => ['name' => 'Russian', 'native' => 'Русский', 'regional' => 'ru_RU'],
    ];

    /**
     * @param array $languages
     *
     * @return $this
     * @author sihoullete
     */
    public function setSupportedLanguages(array $languages): self;

    /**
     * @return array
     * @author sihoullete
     */
    public function getSupportedLanguages(): array;

    /**
     * @param string $language
     *
     * @return $this
     * @author sihoullete
     */
    public function setDefaultLanguage(string $language): self;

    /**
     * @return string
     * @author sihoullete
     */
    public function getDefaultLanguage(): string;

    /**
     * @param string $language
     *
     * @return $this
     * @author sihoullete
     */
    public function setCurrentLanguage(string $language): self;

    /**
     * @return string
     * @author sihoullete
     */
    public function getCurrentLanguage(): string;

    /**
     * @param string $prefix
     *
     * @return $this
     * @author sihoullete
     */
    public function setApiPrefix(string $prefix): self;

    /**
     * @return string
     * @author sihoullete
     */
    public function getApiPrefix(): string;

    /**
     * @param bool $hide
     *
     * @return $this
     * @author sihoullete
     */
    public function setHideDefaultLang(bool $hide = true): self;


    /**
     * @return string
     * @author sihoullete
     */
    public function getHideDefaultLang(): string;

    /**
     * @param string $language
     *
     * @return bool
     * @author sihoullete
     */
    public function isSupportedLanguage(string $language): bool;

    /**
     * @param string $language
     *
     * @return bool
     * @author sihoullete
     */
    public function isDefaultLanguage(string $language): bool;
}
