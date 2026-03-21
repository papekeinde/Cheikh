<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardProjectController extends Controller
{
    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string', 'max:100'],
            'complexite' => ['required', 'integer', 'min:1', 'max:100'],
            'tags' => ['nullable', 'string'],
            'lien' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();

        Projet::create([
            'user_id' => $user->id,
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'complexite' => $validated['complexite'],
            'tags' => collect(explode(',', $validated['tags'] ?? ''))
                ->map(fn ($tag) => trim($tag))
                ->filter()
                ->values()
                ->all(),
            'lien' => $validated['lien'] ?? null,
            'github' => $validated['github'] ?? null,
            'image' => $validated['image'] ?? null,
            'ordre' => 999,
            'status' => $user->isAdmin() ? 'approved' : 'pending',
            'progress' => $user->isAdmin() ? 100 : 5,
            'approved_at' => $user->isAdmin() ? now() : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Projet soumis avec succes.');
    }

    public function review(Request $request, Projet $projet): RedirectResponse
    {
        abort_unless($request->user()->isAdmin(), 403);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
            'progress' => ['required', 'integer', 'min:0', 'max:100'],
            'admin_feedback' => ['nullable', 'string'],
        ]);

        $projet->update([
            'status' => $validated['status'],
            'progress' => $validated['progress'],
            'admin_feedback' => $validated['admin_feedback'] ?? null,
            'approved_at' => $validated['status'] === 'approved' ? now() : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Projet mis a jour.');
    }
}
