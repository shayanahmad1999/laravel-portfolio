<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\{Project, Skill};
use App\Support\PortfolioContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AjaxController extends Controller
{
    public function projects(Request $req)
    {
        $user = PortfolioContext::resolveUser($req);
        $userId = $user?->id;
        
        $q = Project::query()->with('category')
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->latest();

        if ($req->filled('category')) {
            $q->whereHas('category', fn($w) => $w->where('name', $req->category));
        }
        if ($req->filled('search')) {
            $q->where('title', 'like', '%' . $req->search . '%');
        }
        if ($req->boolean('featured')) {
            $q->where('is_featured', true);
        }

        return response()->json(
            $q->paginate(9)->through(function ($p) {
                return [
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'thumbnail' => $p->thumbnail,
                    'project_files' => $p->project_files ?? [],
                    'is_featured' => $p->is_featured,
                    'category' => optional($p->category)->name,
                    'excerpt' => $p->excerpt,
                    'body' => $p->body,
                    'repo_url' => $p->repo_url,
                    'live_url' => $p->live_url,
                    'tags' => $p->tags,
                ];
            })
        );
    }

    public function skills(Request $req)
    {
        $user = PortfolioContext::resolveUser($req);
        $userId = $user?->id;
        
        return response()->json(Skill::query()
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->orderBy('level', 'desc')
            ->get(['name', 'logo', 'level']));
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email',
            'message' => 'required|string|max:4000',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        $user = PortfolioContext::resolveUser($request);
        $settings = PortfolioContext::settings($user);
        $recipient = $settings->contact_email ?: config('mail.from.address');

        Mail::to($recipient)->send(new ContactMail($data));

        return response()->json(['ok' => true, 'msg' => 'Thanks, your message was sent.']);
    }
}

