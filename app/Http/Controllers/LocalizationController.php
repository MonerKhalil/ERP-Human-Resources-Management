<?php

namespace App\Http\Controllers;

use App\HelpersClasses\MyApp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * @param $Lang
     * @return RedirectResponse
     * @author moner khalil
     */
    public function SwitchLang($Lang): RedirectResponse
    {
        $locale = MyApp::Classes()->getLangLocale($Lang);
        App::setLocale($locale);
        Session::put(MyApp::Classes()->localeSessionKey,$locale);
        return redirect()->back();
    }
}
