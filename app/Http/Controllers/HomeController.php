<?php

namespace App\Http\Controllers;

use App\Helpers\LocalizationHelper;
use Illuminate\Http\Request;
use App\Services\Home\HomeService;
use Illuminate\Contracts\Support\Renderable;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
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
     * @return Renderable
     *
     * @author sihoullete
     */
    public function index(Request $request)
    {
        $data['items'] = $this->service->index($request->all());

        return view('home', $data);
    }
}
