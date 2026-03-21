<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Visit;
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
            $todayStart = now()->startOfDay();

            $todayVisits = Visit::where('created_at', '>=', $todayStart)->count();
            $todayUnique = Visit::where('created_at', '>=', $todayStart)->distinct('ip_hash')->count('ip_hash');
            $totalVisits = Visit::count();
            $totalUnique = Visit::distinct('ip_hash')->count('ip_hash');
            $recentVisits = Visit::latest()->take(30)->get();

            // Last 7 days chart data
            $last7Days = collect(range(6, 0))->map(function ($daysAgo) {
                $date = now()->subDays($daysAgo);
                return [
                    'label' => $date->format('d/m'),
                    'total' => Visit::whereDate('created_at', $date->toDateString())->count(),
                    'unique' => Visit::whereDate('created_at', $date->toDateString())->distinct('ip_hash')->count('ip_hash'),
                ];
            });

            // Hourly distribution (database-agnostic)
            $allVisitsHours = Visit::pluck('created_at');
            $hourlyRaw = $allVisitsHours->groupBy(fn($dt) => (int) $dt->format('H'))
                ->map(fn($g) => $g->count())
                ->toArray();
            $hourlyData = [];
            for ($h = 0; $h < 24; $h++) {
                $hourlyData[] = $hourlyRaw[$h] ?? 0;
            }

            // Top locations
            $topLocations = Visit::selectRaw("country, city, COUNT(*) as visit_count")
                ->whereNotNull('country')
                ->where('country', '!=', 'Local')
                ->groupBy('country', 'city')
                ->orderByDesc('visit_count')
                ->limit(10)
                ->get();

            // Unique visitor profiles
            $visitors = Visit::selectRaw("ip_hash, COUNT(*) as visit_count, MIN(created_at) as first_visit, MAX(created_at) as last_visit, MAX(country) as country, MAX(city) as city, MAX(region) as region")
                ->groupBy('ip_hash')
                ->orderByDesc('visit_count')
                ->limit(20)
                ->get();

            return view('admin.dashboard', [
                'pendingProjects' => Projet::with('user')->pending()->latest()->get(),
                'approvedProjectsCount' => Projet::approved()->count(),
                'usersCount' => \App\Models\User::count(),
                'contactMessages' => $contactMessages,
                'todayVisits' => $todayVisits,
                'todayUnique' => $todayUnique,
                'totalVisits' => $totalVisits,
                'totalUnique' => $totalUnique,
                'recentVisits' => $recentVisits,
                'last7Days' => $last7Days,
                'hourlyData' => $hourlyData,
                'topLocations' => $topLocations,
                'visitors' => $visitors,
            ]);
        }

        return view('admin.dashboard', [
            'myProjects' => $user->projets()->latest()->get(),
            'activeProjectsCount' => $user->projets()->whereIn('status', ['pending', 'approved'])->count(),
            'approvedProjectsCount' => $user->projets()->approved()->count(),
        ]);
    }
}
