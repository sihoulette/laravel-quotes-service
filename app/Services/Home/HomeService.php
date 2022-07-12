<?php

namespace App\Services\Home;

use App\Models\Post;
use App\Models\PostSocial;
use App\Services\Social\SocialService;
use Illuminate\Pagination\LengthAwarePaginator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;

/**
 * Class HomeService
 *
 * @package App\Services\Home
 */
final class HomeService
{
    /**
     * @param array $data
     *
     * @return LengthAwarePaginator
     *
     * @author sihoullete
     */
    public function index(array $data = []): LengthAwarePaginator
    {
        $posts = Post::where('language_locale', LaravelLocalization::getCurrentLocale())
            ->with(['user'])
            ->orderByDesc('id')
            ->paginate(5);
        $posts->each(static function ($item) {
            $socials = SocialService::getSupportedSocials();
            foreach ($socials as $alias => $social) {
                $postSocial = PostSocial::where('post_id', $item->id)
                    ->where('social_alias', $social['alias'])
                    ->first();
                $socials[$alias]['share_count'] = $postSocial instanceof PostSocial
                    ? $postSocial->share_count : 0;
                $socials[$alias]['share_url'] = Route::has('share.' . $alias)
                    ? route('share.' . $alias) : null;
            }
            $item->setAttribute('socials', $socials);
            return $item;
        });

        return $posts;
    }
}
