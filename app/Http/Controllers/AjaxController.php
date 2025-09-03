<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Models\{Project, Category, Skill};
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function projects(Request $req)
    {
        $userId = $this->resolveUserId($req);
        
        $q = Project::query()->with('category')
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->latest();

        if ($req->filled('category')) {
            $q->whereHas('category', fn($w) => $w->where('name', $req->category));
        }
        if ($req->filled('search')) {
            $q->where('title', 'like', '%' . $req->search . '%');
        }

        return response()->json(
            $q->paginate(9)->through(function ($p) {
                return [
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'thumbnail' => $p->thumbnail,
                    'category' => optional($p->category)->name,
                    'excerpt' => $p->excerpt,
                    'repo_url' => $p->repo_url,
                    'live_url' => $p->live_url,
                    'tags' => $p->tags,
                ];
            })
        );
    }

    public function skills(Request $req)
    {
        $userId = $this->resolveUserId($req);
        
        $query = Skill::query();
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return response()->json($query
            ->orderBy('level', 'desc')
            ->get(['name', 'level']));
    }

    public function contact(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email',
            'message' => 'required|string|max:4000',
        ]);
        Mail::to(config('mail.from.address'))->send(new ContactMail($data));
        return response()->json(['ok' => true, 'msg' => 'Thanks, your message was sent.']);
    }
    
    /**
     * Resolve which user's portfolio to show
     */
    private function resolveUserId($request)
    {
        // Check if a specific user is requested
        if ($request->has('user_id')) {
            return $request->get('user_id');
        }
        
        // If user is authenticated, show their portfolio
        if (Auth::check()) {
            return Auth::id();
        }
        
        // If no user is authenticated, check if there's a demo user
        $demoUser = \App\Models\User::first();
        return $demoUser ? $demoUser->id : null;
    }
}
