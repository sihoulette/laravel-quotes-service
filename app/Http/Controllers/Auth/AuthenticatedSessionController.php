<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Helpers\LocalizationHelper;

/**
 * Class AuthenticatedSessionController
 *
 * @package App\Http\Controllers\Auth
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     *
     * @return RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended(LocalizationHelper::localizeUrl(RouteServiceProvider::HOME));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(LocalizationHelper::localizeUrl(RouteServiceProvider::HOME));
    }
}
