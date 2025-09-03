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
            'projects' => Project::where('user_id', auth()->id())->count(),
            'skills' => Skill::where('user_id', auth()->id())->count(),
            'categories' => Category::where('user_id', auth()->id())->count(),
        ];
        
        $recentProjects = Project::where('user_id', auth()->id())->latest()->take(5)->get();
        $recentSkills = Skill::where('user_id', auth()->id())->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentProjects', 'recentSkills'));
    }
}