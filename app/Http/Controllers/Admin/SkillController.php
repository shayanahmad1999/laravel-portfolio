<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::where('user_id', auth()->id())
            ->orderBy('level', 'desc')
            ->paginate(10);
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        // Add user_id to the request data
        $request->merge(['user_id' => auth()->id()]);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.skills.create')
                ->withErrors($validator)
                ->withInput();
        }

        Skill::create($request->only(['name', 'level', 'user_id']));

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill created successfully.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.skills.edit', $skill->id)
                ->withErrors($validator)
                ->withInput();
        }

        $skill->update($request->all());

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully.');
    }
}