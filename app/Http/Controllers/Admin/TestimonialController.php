<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::byUserId()->orderBy('sort_order')->latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create', ['testimonial' => new Testimonial()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        unset($data['remove_avatar']);
        $data['user_id'] = Auth::id();
        $data['is_visible'] = $request->boolean('is_visible', true);
        $data['avatar'] = $this->storeAvatar($request);

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        abort_unless($testimonial->user_id === Auth::id(), 403);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        abort_unless($testimonial->user_id === Auth::id(), 403);

        $data = $this->validated($request);
        unset($data['remove_avatar']);
        $data['is_visible'] = $request->boolean('is_visible');

        if ($request->boolean('remove_avatar')) {
            $this->deleteAvatar($testimonial);
            $data['avatar'] = null;
        }

        if ($request->hasFile('avatar')) {
            $this->deleteAvatar($testimonial);
            $data['avatar'] = $this->storeAvatar($request);
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        abort_unless($testimonial->user_id === Auth::id(), 403);
        $this->deleteAvatar($testimonial);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_name' => 'required|string|max:255',
            'client_role' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:2000',
            'is_visible' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'remove_avatar' => 'nullable|boolean',
        ]);
    }

    private function storeAvatar(Request $request): ?string
    {
        if (!$request->hasFile('avatar')) {
            return null;
        }

        $avatar = $request->file('avatar');
        $fileName = time() . '_' . Str::slug($request->client_name) . '.' . $avatar->getClientOriginalExtension();

        return $avatar->storeAs('testimonials', $fileName, 'public');
    }

    private function deleteAvatar(Testimonial $testimonial): void
    {
        if ($testimonial->avatar) {
            Storage::disk('public')->delete($testimonial->avatar);
        }
    }
}

