<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $messagesPath = storage_path('app/contact_messages.json');
        $contactMessages = collect();

        if (File::exists($messagesPath)) {
            $decoded = json_decode(File::get($messagesPath), true);

            if (is_array($decoded)) {
                $contactMessages = collect($decoded)
                    ->take(20)
                    ->map(function (array $message) {
                        $message['created_at_display'] = !empty($message['created_at'])
                            ? date('d/m/Y H:i', strtotime($message['created_at']))
                            : '-';

                        return (object) $message;
                    });
            }
        }

        if ($user->isAdmin()) {
            return view('dashboard', [
                'submittedProjects' => Projet::with('user')->latest()->get(),
                'pendingProjects' => Projet::with('user')->pending()->latest()->get(),
                'approvedProjectsCount' => Projet::approved()->count(),
                'usersCount' =>
                    \App\Models\User::count(),
                'contactMessages' => $contactMessages,
            ]);
        }

        return view('dashboard', [
            'myProjects' => $user->projets()->latest()->get(),
            'activeProjectsCount' => $user->projets()->whereIn('status', ['pending', 'approved'])->count(),
            'approvedProjectsCount' => $user->projets()->approved()->count(),
        ]);
    }
}
