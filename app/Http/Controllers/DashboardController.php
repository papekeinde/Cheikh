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
            try {
            $todayStart = now()->startOfDay();

            $todayVisits = Visit::where('created_at', '>=', $todayStart)->count();
            $todayUnique = Visit::where('created_at', '>=', $todayStart)->distinct('ip_hash')->count('ip_hash');
            $totalVisits = Visit::count();
            $totalUnique = Visit::distinct('ip_hash')->count('ip_hash');
            $recentVisits = Visit::latest()->take(30)->get();

            // === Périodes : jour, semaine, mois, année ===
            $weekStart = now()->startOfWeek();
            $monthStart = now()->startOfMonth();
            $yearStart = now()->startOfYear();

            $weekVisits = Visit::where('created_at', '>=', $weekStart)->count();
            $weekUnique = Visit::where('created_at', '>=', $weekStart)->distinct('ip_hash')->count('ip_hash');
            $monthVisits = Visit::where('created_at', '>=', $monthStart)->count();
            $monthUnique = Visit::where('created_at', '>=', $monthStart)->distinct('ip_hash')->count('ip_hash');
            $yearVisits = Visit::where('created_at', '>=', $yearStart)->count();
            $yearUnique = Visit::where('created_at', '>=', $yearStart)->distinct('ip_hash')->count('ip_hash');

            // Chart: last 7 days
            $last7Days = collect(range(6, 0))->map(function ($daysAgo) {
                $date = now()->subDays($daysAgo);
                return [
                    'label' => $date->format('d/m'),
                    'total' => Visit::whereDate('created_at', $date->toDateString())->count(),
                    'unique' => Visit::whereDate('created_at', $date->toDateString())->distinct('ip_hash')->count('ip_hash'),
                ];
            });

            // Chart: last 4 weeks
            $last4Weeks = collect(range(3, 0))->map(function ($weeksAgo) {
                $start = now()->subWeeks($weeksAgo)->startOfWeek();
                $end = now()->subWeeks($weeksAgo)->endOfWeek();
                return [
                    'label' => $start->format('d/m') . '-' . $end->format('d/m'),
                    'total' => Visit::whereBetween('created_at', [$start, $end])->count(),
                    'unique' => Visit::whereBetween('created_at', [$start, $end])->distinct('ip_hash')->count('ip_hash'),
                ];
            });

            // Chart: last 12 months
            $last12Months = collect(range(11, 0))->map(function ($monthsAgo) {
                $date = now()->subMonths($monthsAgo);
                $start = $date->copy()->startOfMonth();
                $end = $date->copy()->endOfMonth();
                return [
                    'label' => $date->translatedFormat('M'),
                    'total' => Visit::whereBetween('created_at', [$start, $end])->count(),
                    'unique' => Visit::whereBetween('created_at', [$start, $end])->distinct('ip_hash')->count('ip_hash'),
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

            $pendingProjects = Projet::with('user')->pending()->latest()->get();
            $submittedProjects = Projet::with('user')->latest()->get();

            return view('admin.dashboard', [
                'pendingProjects' => $pendingProjects,
                'submittedProjects' => $submittedProjects,
                'approvedProjectsCount' => Projet::approved()->count(),
                'usersCount' => \App\Models\User::count(),
                'contactMessages' => $contactMessages,
                'todayVisits' => $todayVisits,
                'todayUnique' => $todayUnique,
                'weekVisits' => $weekVisits,
                'weekUnique' => $weekUnique,
                'monthVisits' => $monthVisits,
                'monthUnique' => $monthUnique,
                'yearVisits' => $yearVisits,
                'yearUnique' => $yearUnique,
                'totalVisits' => $totalVisits,
                'totalUnique' => $totalUnique,
                'recentVisits' => $recentVisits,
                'last7Days' => $last7Days,
                'last4Weeks' => $last4Weeks,
                'last12Months' => $last12Months,
                'hourlyData' => $hourlyData,
                'topLocations' => $topLocations,
                'visitors' => $visitors,
            ]);
            } catch (\Throwable $e) {
                return view('admin.dashboard', [
                    'pendingProjects' => collect(),
                    'submittedProjects' => collect(),
                    'approvedProjectsCount' => 0,
                    'usersCount' => 0,
                    'contactMessages' => $contactMessages,
                    'todayVisits' => 0, 'todayUnique' => 0,
                    'weekVisits' => 0, 'weekUnique' => 0,
                    'monthVisits' => 0, 'monthUnique' => 0,
                    'yearVisits' => 0, 'yearUnique' => 0,
                    'totalVisits' => 0, 'totalUnique' => 0,
                    'recentVisits' => collect(),
                    'last7Days' => collect(),
                    'last4Weeks' => collect(),
                    'last12Months' => collect(),
                    'hourlyData' => array_fill(0, 24, 0),
                    'topLocations' => collect(),
                    'visitors' => collect(),
                ]);
            }
        }

        return view('admin.dashboard', [
            'myProjects' => $user->projets()->latest()->get(),
            'activeProjectsCount' => $user->projets()->whereIn('status', ['pending', 'approved'])->count(),
            'approvedProjectsCount' => $user->projets()->approved()->count(),
        ]);
    }
}
