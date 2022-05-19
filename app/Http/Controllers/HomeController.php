<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected function Index(Request $request) {
        if($request->user()) {
            return view('home');
        }
        else {
            return redirect()->route('login');
        }
    }
    /* select web app user access */
    protected function AppAccess(Request $request, $urlPath, $accessLevel) {
        if ($request->user()) {
            session(['user_access' => $accessLevel]);
            session(['url_path' => $urlPath]);

            if ($urlPath == 'inventory') {
                return redirect()->route('inventory.dashboard.index');
            }
            elseif ($urlPath == 'online-exam') {
                return redirect()->route('online.dashboard.index');
            }
            else {
                return redirect()->route('menu.dashboard.index');
            }
        }
        else {
            return redirect()->route('login');
        }
    }
}
