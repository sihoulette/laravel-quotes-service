<?php

namespace App\Twig;

use Route;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Helpers\LocalizationHelper;

/**
 * Class Functions
 *
 * @package App\Twig
 */
final class Functions extends AbstractExtension
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
            new TwigFunction('localizeUrl', [LocalizationHelper::class, 'localizeUrl']),
            new TwigFunction('i18nSwitchList', [LocalizationHelper::class, 'i18nSwitchList']),
        ];
    }
}
