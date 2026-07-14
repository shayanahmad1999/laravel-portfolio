<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimelineEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineEntryController extends Controller
{
    public function index()
    {
        $entries = TimelineEntry::byUserId()->orderBy('sort_order')->orderByDesc('start_date')->paginate(10);
        return view('admin.timeline.index', compact('entries'));
    }

    public function create()
    {
        return view('admin.timeline.create', ['entry' => new TimelineEntry()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = Auth::id();
        $data['is_current'] = $request->boolean('is_current');
        $data['is_visible'] = $request->boolean('is_visible', true);

        TimelineEntry::create($data);

        return redirect()->route('admin.timeline.index')->with('success', 'Timeline entry created successfully.');
    }

    public function edit(TimelineEntry $timeline)
    {
        abort_unless($timeline->user_id === Auth::id(), 403);
        return view('admin.timeline.edit', ['entry' => $timeline]);
    }

    public function update(Request $request, TimelineEntry $timeline)
    {
        abort_unless($timeline->user_id === Auth::id(), 403);

        $data = $this->validated($request);
        $data['is_current'] = $request->boolean('is_current');
        $data['is_visible'] = $request->boolean('is_visible');

        $timeline->update($data);

        return redirect()->route('admin.timeline.index')->with('success', 'Timeline entry updated successfully.');
    }

    public function destroy(TimelineEntry $timeline)
    {
        abort_unless($timeline->user_id === Auth::id(), 403);
        $timeline->delete();

        return redirect()->route('admin.timeline.index')->with('success', 'Timeline entry deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'organization' => 'nullable|string|max:255',
            'entry_type' => 'required|string|in:experience,education,certificate,award',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string|max:2000',
            'is_visible' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);
    }
}

