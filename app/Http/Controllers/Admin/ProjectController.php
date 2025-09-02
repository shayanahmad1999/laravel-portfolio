<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('category')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'image'        => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id'  => 'required|exists:categories,id',
            'tags'         => 'nullable', // can be string "a,b" or array ["a","b"]
            'github'       => 'nullable|url',
            'demo'         => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.projects.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Build data safely (whitelist fields)
        $data = $request->only(['title', 'description', 'category_id', 'tags', 'github', 'demo']);

        // Image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/projects', $imageName);
            $data['image'] = 'projects/' . $imageName;
        }

        // Normalize tags to an ARRAY
        $data['tags'] = $this->normalizeTags($data['tags'] ?? null);

        Project::create($data); // slug is auto-generated in the model

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $categories = Category::all();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id'  => 'required|exists:categories,id',
            'tags'         => 'nullable', // can be string or array
            'github'       => 'nullable|url',
            'demo'         => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.projects.edit', $project->id)
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['title', 'description', 'category_id', 'tags', 'github', 'demo']);

        // Image upload (replace old)
        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::delete('public/' . $project->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/projects', $imageName);
            $data['image'] = 'projects/' . $imageName;
        }

        // Normalize tags to an ARRAY
        $data['tags'] = $this->normalizeTags($data['tags'] ?? $project->tags);

        // Keep existing slug unless you want to reset it when title changes.
        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        // Delete project image
        if ($project->image) {
            Storage::delete('public/' . $project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    /**
     * Accepts:
     * - null                -> []
     * - "a,b,c"             -> ["a","b","c"]
     * - ["a", "b", "c"]     -> ["a","b","c"]
     * - trims, removes empties, lowercases/normalizes if you like
     */
    private function normalizeTags($tags): array
    {
        if (is_null($tags) || $tags === '') {
            return [];
        }

        if (is_string($tags)) {
            $parts = array_map('trim', explode(',', $tags));
        } elseif (is_array($tags)) {
            $parts = array_map(fn($t) => is_string($t) ? trim($t) : $t, $tags);
        } else {
            // unexpected type: cast to empty
            return [];
        }

        // remove empty values and duplicates (case-insensitive unique optional)
        $parts = array_values(array_filter($parts, fn($t) => $t !== '' && $t !== null));

        return $parts;
    }
}
