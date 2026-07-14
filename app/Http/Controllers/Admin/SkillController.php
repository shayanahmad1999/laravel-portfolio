<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::byUserId()
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
        $request->merge(['user_id' => Auth::id()]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.skills.create')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'level', 'user_id']);
        $data['logo'] = $this->storeLogo($request);

        Skill::create($data);

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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_logo' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.skills.edit', $skill->id)
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'level']);

        if ($request->boolean('remove_logo')) {
            $this->deleteLogo($skill);
            $data['logo'] = null;
        }

        if ($request->hasFile('logo')) {
            $this->deleteLogo($skill);
            $data['logo'] = $this->storeLogo($request);
        }

        $skill->update($data);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        $this->deleteLogo($skill);
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully.');
    }

    private function storeLogo(Request $request): ?string
    {
        if (!$request->hasFile('logo')) {
            return null;
        }

        $logo = $request->file('logo');
        $fileName = time() . '_' . Str::slug($request->name) . '.' . $logo->getClientOriginalExtension();
        $logo->storeAs('skills', $fileName, 'public');

        return 'skills/' . $fileName;
    }

    private function deleteLogo(Skill $skill): void
    {
        if ($skill->logo) {
            Storage::disk('public')->delete($skill->logo);
        }
    }
}
