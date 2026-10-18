<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $modules = collect(config('menu'))->filter(fn ($m, $key) => $request->user()->canModule($key));

        return view('welcome', ['modules' => $modules]);
    }
}
