<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocaleController extends Controller
{
    public function __invoke(Request $request)
{
    $locale = $request->input('locale');

    if (in_array($locale, ['en', 'kh'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    // dd(app()->setLocale($locale));


    return redirect()->back();
}

}
