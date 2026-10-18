<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Temporary placeholder for menu pages that are not rebuilt yet,
 * so navigation works end-to-end while modules are ported one by one.
 */
class PendingPageController extends Controller
{
    public function __invoke(Request $request): View
    {
        $module = $request->segment(1);

        return view('pending', [
            'module' => array_key_exists($module, config('menu')) ? $module : null,
        ]);
    }
}
