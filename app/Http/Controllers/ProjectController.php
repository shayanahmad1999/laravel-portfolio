<?php

namespace App\Http\Controllers;

use App\Models\Category;

class ProjectController extends Controller
{
    public function page()
    {
        $categories = Category::orderBy('name')->get();
        return view('pages.projects', ['title' => 'Projects', 'categories' => $categories]);
    }
}
