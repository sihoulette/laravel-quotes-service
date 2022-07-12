<?php

namespace App\Services\Social;

use App\Models\Social;
use App\Services\AbstractService;

/**
 * Class SocialService
 *
 * @package App\Services\Social
 */
final class SocialService extends AbstractService implements SocialServiceContract
{
    /**
     * @return array
     * @author sihoullete
     */
    public static function getSupportedSocials(): array
    {
        $supportedSocials = [];
        $socials = Social::where('active', 1)
            ->orderBy('position')
            ->get();
        if ($socials->count()) {
            $socials->map(function ($social) use (&$supportedSocials) {
                if (isset(self::SUPPORT_NETWORKS[$social->alias])) {
                    $supportedSocials[$social->alias]['alias'] = $social->alias;
                    $supportedSocials[$social->alias]['name'] = $social->name;
                    $supportedSocials[$social->alias]['fa_brand'] = $social->fa_brand;
                }
            });
        }

        return $supportedSocials;
    }
}
