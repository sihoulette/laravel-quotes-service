<?php

namespace App\Entities\Localization;

/**
 * Class LocalizationEntity
 *
 * @package App\Entities
 */
final class LocalizationEntity implements LocalizationEntityContract
{
    /**
     * @var string $defaultLanguage
     */
    private string $defaultLanguage = 'en';

    /**
     * @var string $currentLanguage
     */
    private string $currentLanguage = 'en';

    /**
     * @var array $supportedLanguages
     */
    private array $supportedLanguages = [];

    /**
     * @var bool $hideDefaultLang
     */
    private bool $hideDefaultLang = true;

    /**
     * @var string $apiPrefix
     */
    private string $apiPrefix = 'api';

    /**
     * @param string $defaultLanguage
     * @param array  $supportedLanguages
     */
    public function __construct(
        string $defaultLanguage = self::DEFAULT_LANGUAGE,
        array  $supportedLanguages = self::SUPPORT_LANGUAGES,
    )
    {
        $this->setSupportedLanguages($supportedLanguages)
            ->setDefaultLanguage($defaultLanguage)
            ->setCurrentLanguage($defaultLanguage);
    }

    /**
     * @param array $languages
     *
     * @return $this
     * @author sihoullete
     */
    public function setSupportedLanguages(array $languages): self
    {
        if (!empty(array_filter($languages))) {
            $this->supportedLanguages = $languages;
        }

        return $this;
    }

    /**
     * @return array
     * @author sihoullete
     */
    public function getSupportedLanguages(): array
    {
        return $this->supportedLanguages;
    }

    /**
     * @param string $language
     *
     * @return $this
     * @author sihoullete
     */
    public function setDefaultLanguage(string $language): self
    {
        $this->defaultLanguage = $language;
        if (!in_array($language, $this->supportedLanguages)) {
            $this->supportedLanguages[] = $language;
        }

        return $this;
    }

    /**
     * @return string
     * @author sihoullete
     */
    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }

    /**
     * @param string $language
     *
     * @return $this
     * @author sihoullete
     */
    public function setCurrentLanguage(string $language): self
    {
        if ($this->isSupportedLanguage($language)) {
            $this->currentLanguage = $language;
        }

        return $this;
    }

    /**
     * @return string
     * @author sihoullete
     */
    public function getCurrentLanguage(): string
    {
        return $this->currentLanguage;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     * @author sihoullete
     */
    public function setApiPrefix(string $prefix): self
    {
        $this->apiPrefix = $prefix;

        return $this;
    }

    /**
     * @return string
     * @author sihoullete
     */
    public function getApiPrefix(): string
    {
        return $this->apiPrefix;
    }

    /**
     * @param bool $hide
     *
     * @return $this
     * @author sihoullete
     */
    public function setHideDefaultLang(bool $hide = true): self
    {
        $this->hideDefaultLang = $hide;

        return $this;
    }

    /**
     * @return string
     * @author sihoullete
     */
    public function getHideDefaultLang(): string
    {
        return $this->hideDefaultLang;
    }

    /**
     * @param string $language
     *
     * @return bool
     * @author sihoullete
     */
    public function isSupportedLanguage(string $language): bool
    {
        return in_array($language, $this->supportedLanguages);
    }

    /**
     * @param string $language
     *
     * @return bool
     * @author sihoullete
     */
    public function isDefaultLanguage(string $language): bool
    {
        return $language === $this->defaultLanguage;
    }
}
