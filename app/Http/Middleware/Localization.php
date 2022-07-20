<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Facades\Localization\LocalizationFacade;

/**
 * Class Localization
 *
 * @package App\Http\Middleware
 */
class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @author sihoullete
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $segments = $request->segments();
        if (count($segments) && LocalizationFacade::getHideDefaultLang()) {
            $langSegment = $segments[0];
            if ($langSegment === LocalizationFacade::getApiPrefix()) {
                $langSegment = $segments[1] ?? null;
            }

            # Redirect without default lang segment
            if ($langSegment === LocalizationFacade::getDefaultLanguage()) {
                foreach ($segments as $key => $segment) {
                    if ($segment === $langSegment) {
                        unset($segments[$key]);
                        break;
                    }
                }

                return redirect('/' . implode('/', $segments));
            }
        }
        $request->setLocale(LocalizationFacade::getCurrentLanguage());

        return $next($request);
    }
}
