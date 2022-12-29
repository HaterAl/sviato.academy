<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function home(): View
    {
        return view('main.home.home');
    }
}
