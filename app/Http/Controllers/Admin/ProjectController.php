<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('category')
            ->byUserId()
            ->latest()
            ->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::byUserId()->get();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => Auth::id()]);

        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|max:255',
            'body'            => 'required|string',
            'image'           => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'project_files'   => 'nullable|array',
            'project_files.*' => 'file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip|max:10240',
            'category_id'     => 'required|exists:categories,id',
            'tags'            => 'nullable',
            'repo_url'        => 'nullable|url',
            'live_url'        => 'nullable|url',
            'is_featured'     => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.projects.create')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['title', 'body', 'category_id', 'tags', 'repo_url', 'live_url', 'user_id']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['excerpt'] = Str::limit(strip_tags($request->body), 160);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('projects', $imageName, 'public');
            $data['thumbnail'] = 'projects/' . $imageName;
        }

        $data['project_files'] = $this->storeProjectFiles($request);
        $data['tags'] = $this->normalizeTags($data['tags'] ?? null);

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $categories = Category::byUserId()->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'title'                  => 'required|string|max:255',
            'body'                   => 'required|string',
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'project_files'          => 'nullable|array',
            'project_files.*'        => 'file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip|max:10240',
            'remove_project_files'   => 'nullable|array',
            'remove_project_files.*' => 'integer',
            'category_id'            => 'required|exists:categories,id',
            'tags'                   => 'nullable',
            'repo_url'               => 'nullable|url',
            'live_url'               => 'nullable|url',
            'is_featured'            => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.projects.edit', $project->id)
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['title', 'body', 'category_id', 'tags', 'repo_url', 'live_url']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['excerpt'] = Str::limit(strip_tags($request->body), 160);

        if ($request->hasFile('image')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('projects', $imageName, 'public');
            $data['thumbnail'] = 'projects/' . $imageName;
        }

        $existingFiles = $this->removeSelectedProjectFiles(
            $project->project_files ?? [],
            $request->input('remove_project_files', [])
        );

        $data['project_files'] = array_values(array_merge($existingFiles, $this->storeProjectFiles($request)));
        $data['tags'] = $this->normalizeTags($data['tags'] ?? $project->tags);

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->project_files ?? [] as $file) {
            if (!empty($file['path'])) {
                Storage::disk('public')->delete($file['path']);
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    private function storeProjectFiles(Request $request): array
    {
        if (!$request->hasFile('project_files')) {
            return [];
        }

        $storedFiles = [];

        foreach ($request->file('project_files') as $file) {
            $fileName = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('projects/files', $fileName, 'public');

            $storedFiles[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ];
        }

        return $storedFiles;
    }

    private function removeSelectedProjectFiles(array $files, array $indexesToRemove): array
    {
        $indexesToRemove = array_map('intval', $indexesToRemove);

        foreach ($indexesToRemove as $index) {
            if (isset($files[$index]['path'])) {
                Storage::disk('public')->delete($files[$index]['path']);
                unset($files[$index]);
            }
        }

        return array_values($files);
    }

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
            return [];
        }

        return array_values(array_filter($parts, fn($t) => $t !== '' && $t !== null));
    }
}

