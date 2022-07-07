<?php

namespace App\Services\Language;

use RuntimeException;
use App\Models\Language;
use Illuminate\Support\Arr;

/**
 * Class LanguageService
 *
 * @package App\Services\Language
 */
final class LanguageService implements LanguageServiceContract
{
    /**
     * @param array $locales
     * @return array
     * @author sihoullete
     */
    public static function makeSupportedLocales(array $locales = self::DEFAULT_LOCALES): array
    {
        $supportLocales = [];
        if (Arr::has(self::SUPPORT_LOCALES, $locales)) {
            foreach ($locales as $local) {
                if (isset(self::SUPPORT_LOCALES[$local])) {
                    $supportLocales[$local] = self::SUPPORT_LOCALES[$local];
                } else {
                    throw new RuntimeException('Oops, not supported locale: ' . $local);
                }
            }
        } else {
            $notSupport = Arr::where($locales, function ($value) {
                return !isset(self::SUPPORT_LOCALES[$value]);
            });
            $notSupport = implode(', ', $notSupport);
            throw new RuntimeException('Oops, not supported locales: ' . $notSupport);
        }

        return $supportLocales;
    }

    /**
     * @return array
     * @author sihoullete
     */
    public static function getSupportedLocales(): array
    {
        $supportedLocales = [];
        $languages = Language::where('active', 1)
            ->orderBy('position')
            ->get();
        if ($languages->count()) {
            $locales = $languages->map(function ($lang) {
                return $lang->locale;
            })->toArray();
            $supportedLocales = self::makeSupportedLocales($locales);
            $languages->map(function ($lang) use (&$supportedLocales) {
                $supportedLocales[$lang->locale]['name'] = $lang->name;
                $supportedLocales[$lang->locale]['regional'] = $lang->regional;
            });
        }

        return $supportedLocales;
    }

    /**
     * @return string|null
     * @author sihoullete
     */
    public static function getDefaultLocale(): ?string
    {
        $language = Language::where('active', 1)
            ->where('default', 1)
            ->first();

        return $language instanceof Language
            ? $language->locale : null;
    }
}
