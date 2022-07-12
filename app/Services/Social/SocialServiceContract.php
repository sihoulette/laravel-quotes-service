<?php

namespace App\Services\Social;

/**
 * Interface SocialServiceContract
 *
 * @package App\Services\Social
 */
interface SocialServiceContract
{
    /**
     * List of all support social networks
     */
    public const SUPPORT_NETWORKS = [
        'telegram' => [
            'alias' => 'telegram',
            'name' => 'Telegram',
            'fa_brand' => 'fa-brands fa-telegram',
        ],
        'e-mail' => [
            'alias' => 'e-mail',
            'name' => 'E-mail',
            'fa_brand' => 'fa-solid fa-at',

        ],
        'viber' => [
            'alias' => 'viber',
            'name' => 'Viber',
            'fa_brand' => 'fa-brands fa-viber',
        ]
    ];

    /**
     * List of supported social networks
     *
     * @return array
     * @author sihoullete
     */
    public static function getSupportedSocials(): array;
}
