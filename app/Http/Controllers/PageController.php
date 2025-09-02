<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', ['title' => 'Home']);
    }

    public function contact()
    {
        return view('pages.contact', ['title' => 'Contact']);
    }
}
