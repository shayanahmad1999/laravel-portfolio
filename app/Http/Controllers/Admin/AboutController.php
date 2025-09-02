<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    /**
     * Display the about page form.
     */
    public function index()
    {
        $about = About::first() ?? new About();
        return view('admin.about.index', compact('about'));
    }

    /**
     * Update the about page information.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'resume_link' => 'nullable|url|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'completed_projects' => 'nullable|integer|min:0',
            'companies_worked' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.about.index')
                ->withErrors($validator)
                ->withInput();
        }

        $about = About::first();
        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($about && $about->image) {
                Storage::delete($about->image);
            }

            $path = $request->file('image')->store('about', 'public');
            $data['image'] = $path;
        }

        if ($about) {
            $about->update($data);
        } else {
            About::create($data);
        }

        return redirect()->route('admin.about.index')
            ->with('success', 'About information updated successfully.');
    }
}