<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'categories' => Category::count(),
        ];
        
        $recentProjects = Project::latest()->take(5)->get();
        $recentSkills = Skill::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentProjects', 'recentSkills'));
    }
}