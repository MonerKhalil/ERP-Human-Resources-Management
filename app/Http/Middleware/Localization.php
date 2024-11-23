<?php

namespace App\Http\Middleware;

use App\HelpersClasses\MyApp;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (is_null(Session::get(MyApp::Classes()->localeSessionKey))){
            Session::put(MyApp::Classes()->localeSessionKey,MyApp::Classes()->defaultLang);
        }
        App::setLocale(Session::get(MyApp::Classes()->localeSessionKey));
        return $next($request);
    }
}
