<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::byUserId()->orderBy('sort_order')->latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create', ['service' => new Service()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = Auth::id();
        $data['features'] = $this->normalizeFeatures($data['features'] ?? null);
        $data['is_visible'] = $request->boolean('is_visible', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        abort_unless($service->user_id === Auth::id(), 403);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        abort_unless($service->user_id === Auth::id(), 403);

        $data = $this->validated($request);
        $data['features'] = $this->normalizeFeatures($data['features'] ?? null);
        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        abort_unless($service->user_id === Auth::id(), 403);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:80',
            'accent_color' => 'required|string|in:indigo,purple,blue,emerald,rose,amber',
            'description' => 'required|string|max:1000',
            'features' => 'nullable|string|max:2000',
            'is_visible' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);
    }

    private function normalizeFeatures(?string $features): array
    {
        if (!$features) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $features))
            ->map(fn($feature) => trim($feature))
            ->filter()
            ->values()
            ->all();
    }
}
