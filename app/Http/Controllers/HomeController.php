<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
 */
final class HomeController extends Controller
{
    /**
     * @return Renderable
     *
     * @author sihoullete
     */
    public function index()
    {
        return view('home');
    }
}
