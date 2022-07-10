<?php

namespace App\Services\Home;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class HomeService
 *
 * @package App\Services\Home
 */
class HomeService
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
        return Post::where('language_locale', LaravelLocalization::getCurrentLocale())
            ->with(['user'])
            ->orderByDesc('id')
            ->paginate(5);
    }
}
