<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Home\HomeService;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers\Api
 */
final class HomeController extends Controller
{
    /**
     * @var HomeService $service
     */
    public HomeService $service;

    /**
     * @param HomeService $service
     */
    public function __construct(HomeService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return HomeResource
     * @author sihoullete
     */
    public function index(Request $request)
    {
        $posts = $this->service->index($request->all());

        return new HomeResource($posts);
    }
}
