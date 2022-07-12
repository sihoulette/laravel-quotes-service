<?php

namespace App\Services\Post;

use App\Services\AbstractService;

/**
 * Class PostSocialService
 *
 * @package App\Services\Post
 */
final class PostSocialService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return array
     *
     * @author sihoullete
     */
    public function telegram(array $data = []): array
    {
        $result['success'] = true;

        return $result;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @author sihoullete
     */
    public function viber(array $data = []): array
    {
        $result['success'] = true;

        return $result;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @author sihoullete
     */
    public function email(array $data = []): array
    {
        $result['success'] = true;

        return $result;
    }
}
