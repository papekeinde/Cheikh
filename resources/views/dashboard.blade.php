@extends('layouts.tailadmin')

@push('styles')
    <style>
        .stat-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96) 0%, #ffffff 100%);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 1.75rem;
            padding: 1.75rem;
            box-shadow: 0 28px 60px -42px rgba(15, 23, 42, 0.28);
        }
        .stat-card__label {
            color: #64748b;
            font-size: 0.95rem;
        }
        .stat-card__value {
            margin-top: 1rem;
            color: #0f172a;
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.25rem, 4vw, 3rem);
            line-height: 1;
        }
        .moderation-shell {
            background: linear-gradient(180deg, rgba(255, 247, 242, 0.9) 0%, rgba(255, 255, 255, 0.98) 18%, #ffffff 100%);
            border: 1px solid #fed7c3;
            border-radius: 2rem;
            box-shadow: 0 32px 80px -52px rgba(241, 101, 41, 0.35);
        }
        .section-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #f16529;
            color: #111827;
            padding: 0.9rem 1.35rem;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 18px 32px -24px rgba(241, 101, 41, 0.8);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }
        .section-action:hover {
            background: #d65420;
            transform: translateY(-1px);
            box-shadow: 0 22px 40px -24px rgba(241, 101, 41, 0.8);
        }
        .project-review-card {
            border: 1px solid #e2e8f0;
            border-radius: 1.75rem;
            background: #ffffff;
            box-shadow: 0 18px 40px -34px rgba(15, 23, 42, 0.3);
        }
        .soft-panel {
            border-radius: 1.25rem;
            background: #fff7f2;
            border: 1px solid #fed7c3;
            padding: 1rem 1.1rem;
        }
        .soft-input {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid #dbe3ee;
            background: #ffffff;
            padding: 0.9rem 1rem;
            color: #0f172a;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .soft-input:focus {
            outline: none;
            border-color: #f16529;
            box-shadow: 0 0 0 4px rgba(241, 101, 41, 0.12);
        }
        .progress-track {
            margin-top: 0.75rem;
            height: 0.8rem;
            overflow: hidden;
            border-radius: 999px;
            background: #e2e8f0;
        }
        .progress-track > span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #f16529 0%, #fb923c 100%);
        }
        .status-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.45rem 0.8rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .empty-state {
            border: 1px dashed #cbd5e1;
            border-radius: 1.5rem;
            padding: 2.5rem 1.5rem;
            text-align: center;
            color: #64748b;
            background: rgba(255, 255, 255, 0.72);
        }
        .message-card {
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            background: #ffffff;
            padding: 1rem 1.1rem;
        }

        /* Dark mode */
        html.dark .stat-card {
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.96) 0%, #1e293b 100%);
            border-color: #334155;
            box-shadow: 0 28px 60px -42px rgba(0, 0, 0, 0.5);
        }
        html.dark .stat-card__label { color: #94a3b8; }
        html.dark .stat-card__value { color: #f1f5f9; }
        html.dark .moderation-shell {
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.98) 18%, #1e293b 100%);
            border-color: #334155;
            box-shadow: 0 32px 80px -52px rgba(0, 0, 0, 0.5);
        }
        html.dark .project-review-card {
            border-color: #334155;
            background: #1e293b;
            box-shadow: 0 18px 40px -34px rgba(0, 0, 0, 0.5);
        }
        html.dark .soft-panel {
            background: #0f172a;
            border-color: #334155;
        }
        html.dark .soft-input {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }
        html.dark .soft-input:focus {
            border-color: #f16529;
            box-shadow: 0 0 0 4px rgba(241, 101, 41, 0.2);
        }
        html.dark .message-card {
            border-color: #334155;
            background: #1e293b;
        }
        html.dark .empty-state {
            border-color: #334155;
            background: rgba(30, 41, 59, 0.72);
            color: #94a3b8;
        }
        html.dark .section-action { color: #ffffff; }
        html.dark .chart-card {
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.96) 0%, #1e293b 100%);
            border-color: #334155;
        }
    </style>
@endpush

@section('title', auth()->user()->isAdmin() ? 'Pilotage projets' : 'Mon espace projet')

@section('content')
    <div class="space-y-8">
        <section class="grid gap-4 md:grid-cols-3 lg:grid-cols-3">
            @if(auth()->user()->isAdmin())
                <div class="stat-card">
                    <p class="stat-card__label">Visites aujourd'hui</p>
                    <p class="stat-card__value">{{ $todayVisits }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-card__label">Uniques aujourd'hui</p>
                    <p class="stat-card__value">{{ $todayUnique }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-card__label">Total visites</p>
                    <p class="stat-card__value">{{ $totalVisits }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-card__label">Visiteurs uniques</p>
                    <p class="stat-card__value">{{ $totalUnique }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-card__label">Projets en attente</p>
                    <p class="stat-card__value">{{ $pendingProjects->count() }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-card__label">Projets approuvés</p>
                    <p class="stat-card__value">{{ $approvedProjectsCount }}</p>
                </div>
            @else
                <div class="stat-card">
                    <p class="stat-card__label">Mes projets actifs</p>
                    <p class="stat-card__value">{{ $activeProjectsCount }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-card__label">Projets validés</p>
                    <p class="stat-card__value">{{ $approvedProjectsCount }}</p>
                </div>
                <div class="stat-card flex flex-col justify-between gap-4">
                    <div>
                        <p class="stat-card__label">Nouveau besoin</p>
                        <p class="mt-4 text-lg text-slate-900">Décris ton projet et suis son avancement.</p>
                    </div>
                    <a href="{{ route('dashboard.projects.create') }}" class="section-action">Soumettre un projet</a>
                </div>
            @endif
        </section>

        @if(auth()->user()->isAdmin())
            {{-- ═══ GRAPHIQUES ═══ --}}
            <section class="grid gap-6 lg:grid-cols-2">
                <div class="stat-card chart-card" style="border-radius:1.75rem;">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4" style="font-family:'Playfair Display',serif">Visites — 7 derniers jours</h3>
                    <div style="height:240px"><canvas id="visitsChart"></canvas></div>
                </div>
                <div class="stat-card chart-card" style="border-radius:1.75rem;">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4" style="font-family:'Playfair Display',serif">Distribution horaire</h3>
                    <div style="height:240px"><canvas id="hourlyChart"></canvas></div>
                </div>
            </section>

            {{-- ═══ LOCALISATIONS + PROFILS VISITEURS ═══ --}}
            <section class="grid gap-6 lg:grid-cols-2">
                {{-- Top localisations --}}
                <div class="moderation-shell p-6">
                    <h3 class="text-xl font-display text-slate-950 mb-4">Top localisations</h3>
                    @if($topLocations->count())
                        <div class="space-y-3">
                            @foreach($topLocations as $loc)
                                @php $pct = $topLocations->max('visit_count') > 0 ? ($loc->visit_count / $topLocations->max('visit_count')) * 100 : 0; @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm text-slate-700">{{ $loc->country }}{{ $loc->city ? ' — '.$loc->city : '' }}</span>
                                        <span class="text-sm font-bold" style="color:#f16529">{{ $loc->visit_count }}</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full rounded-full" style="width:{{ $pct }}%; background: linear-gradient(90deg, #f16529, #fb923c)"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400">Les données de localisation seront collectées avec les prochaines visites.</p>
                    @endif
                </div>

                {{-- Profils visiteurs --}}
                <div class="moderation-shell p-6">
                    <h3 class="text-xl font-display text-slate-950 mb-4">Profils visiteurs</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-left">
                                    <th class="pb-2 pr-3 font-semibold text-slate-600">Visiteur</th>
                                    <th class="pb-2 pr-3 font-semibold text-slate-600">Lieu</th>
                                    <th class="pb-2 pr-3 font-semibold text-slate-600">Visites</th>
                                    <th class="pb-2 pr-3 font-semibold text-slate-600">Première</th>
                                    <th class="pb-2 font-semibold text-slate-600">Dernière</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($visitors as $v)
                                    <tr class="border-b border-slate-100">
                                        <td class="py-2 pr-3 text-slate-500 font-mono text-xs">{{ Str::limit($v->ip_hash, 12) }}</td>
                                        <td class="py-2 pr-3 text-slate-700 whitespace-nowrap">
                                            @if($v->country)
                                                {{ $v->country }}{{ $v->city ? ' · '.$v->city : '' }}
                                            @else
                                                <span class="text-slate-400">—</span>
                                            @endif
                                        </td>
                                        <td class="py-2 pr-3 font-bold" style="color:#f16529">{{ $v->visit_count }}</td>
                                        <td class="py-2 pr-3 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($v->first_visit)->format('d/m H:i') }}</td>
                                        <td class="py-2 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($v->last_visit)->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-slate-400">Aucun visiteur.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            {{-- ═══ VISITES RÉCENTES ═══ --}}
            <section class="moderation-shell p-6 md:p-8">
                <div class="mb-6">
                    <h2 class="text-3xl font-display text-slate-950">Visites récentes</h2>
                    <p class="mt-2 text-sm text-slate-500">Les 30 dernières visites sur le portfolio.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-left">
                                <th class="pb-3 pr-4 font-semibold text-slate-600">Date</th>
                                <th class="pb-3 pr-4 font-semibold text-slate-600">Lieu</th>
                                <th class="pb-3 pr-4 font-semibold text-slate-600">Page</th>
                                <th class="pb-3 pr-4 font-semibold text-slate-600">Referrer</th>
                                <th class="pb-3 font-semibold text-slate-600">Navigateur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVisits as $visit)
                                <tr class="border-b border-slate-100">
                                    <td class="py-2.5 pr-4 whitespace-nowrap text-slate-700">{{ $visit->created_at->format('d/m H:i:s') }}</td>
                                    <td class="py-2.5 pr-4 text-slate-700 whitespace-nowrap">
                                        @if($visit->country)
                                            {{ $visit->country }}{{ $visit->city ? ' · '.$visit->city : '' }}
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="py-2.5 pr-4 text-slate-700">{{ $visit->path ?: '/' }}</td>
                                    <td class="py-2.5 pr-4 text-slate-500 max-w-[200px] truncate">{{ $visit->referer ?: '-' }}</td>
                                    <td class="py-2.5 text-slate-500 max-w-[250px] truncate">{{ Str::limit($visit->user_agent, 60) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">Aucune visite enregistrée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="moderation-shell p-6 md:p-8">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-3xl font-display text-slate-950">Messagerie</h2>
                        <p class="mt-2 max-w-2xl text-sm text-slate-500">Messages recus depuis le formulaire de contact. Aucun envoi Gmail requis.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($contactMessages as $message)
                        <article class="message-card">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-slate-900">{{ $message->name }} · {{ $message->email }}</p>
                                <p class="text-xs uppercase tracking-[0.12em] text-slate-500">{{ $message->created_at_display ?? '-' }}</p>
                            </div>
                            <p class="mt-2 text-sm font-medium text-slate-800">{{ $message->subject }}</p>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $message->message }}</p>
                        </article>
                    @empty
                        <div class="empty-state">
                            Aucun message recu pour le moment.
                        </div>
                    @endforelse
                </div>
            </section>

            <section id="moderation" class="moderation-shell p-6 md:p-8">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-3xl font-display text-slate-950">Validation et progression</h2>
                        <p class="mt-2 max-w-2xl text-sm text-slate-500">Tu peux approuver, rejeter et mettre a jour l'avancement des projets soumis depuis une interface plus claire et plus lisible.</p>
                    </div>
                    <a href="{{ route('dashboard.projects.create') }}" class="section-action">Ajouter un projet portfolio</a>
                </div>

                <div class="space-y-4">
                    @forelse($submittedProjects as $project)
                        <form method="POST" action="{{ route('dashboard.projects.review', $project) }}" class="project-review-card p-5 space-y-5">
                            @csrf
                            @method('PATCH')
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <h3 class="text-xl font-semibold text-slate-950">{{ $project->titre }}</h3>
                                        <span class="status-chip {{ $project->status === 'approved' ? 'bg-green-100 text-green-700' : ($project->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">{{ strtoupper($project->status) }}</span>
                                        <span class="status-chip bg-brand/10 text-brand">{{ $project->type }}</span>
                                    </div>
                                    <p class="mt-2 text-sm text-slate-500">Soumis par {{ $project->user->nom }} · {{ $project->user->email }}</p>
                                    <p class="mt-3 text-sm leading-6 text-slate-700">{{ $project->description }}</p>
                                </div>
                                <div class="w-full lg:w-72 soft-panel">
                                    <label class="text-xs uppercase tracking-[0.18em] text-slate-500">Progression</label>
                                    <div class="progress-track">
                                        <span style="width: {{ $project->progress }}%"></span>
                                    </div>
                                    <p class="mt-3 text-sm font-semibold text-slate-900">{{ $project->progress }}%</p>
                                </div>
                            </div>

                            <div class="grid gap-4 lg:grid-cols-3">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Statut</label>
                                    <select name="status" class="soft-input">
                                        @foreach(['pending' => 'En attente', 'approved' => 'Approuve', 'rejected' => 'Rejete'] as $value => $label)
                                            <option value="{{ $value }}" @selected($project->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Progression</label>
                                    <input type="number" name="progress" min="0" max="100" value="{{ $project->progress }}" class="soft-input">
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="section-action w-full">Mettre a jour</button>
                                </div>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Retour admin</label>
                                <textarea name="admin_feedback" rows="3" class="soft-input">{{ old('admin_feedback', $project->admin_feedback) }}</textarea>
                            </div>
                        </form>
                    @empty
                        <div class="empty-state">
                            Aucun projet soumis pour le moment.
                        </div>
                    @endforelse
                </div>
            </section>
        @else
            <section class="moderation-shell p-6 md:p-8">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-3xl font-display text-slate-950">Mes projets</h2>
                        <p class="mt-2 text-sm text-slate-500">Suis la progression de chaque demande validee ou en cours d'etude.</p>
                    </div>
                    <a href="{{ route('dashboard.projects.create') }}" class="section-action">Creer un projet</a>
                </div>

                <div class="space-y-4">
                    @forelse($myProjects as $project)
                        <article class="project-review-card p-5">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <h3 class="text-xl font-semibold text-slate-950">{{ $project->titre }}</h3>
                                        <span class="status-chip {{ $project->status === 'approved' ? 'bg-green-100 text-green-700' : ($project->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">{{ strtoupper($project->status) }}</span>
                                        <span class="status-chip bg-brand/10 text-brand">{{ $project->type }}</span>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-slate-700">{{ $project->description }}</p>
                                    @if($project->admin_feedback)
                                        <div class="mt-4 soft-panel text-sm text-slate-600">
                                            <strong>Retour admin :</strong> {{ $project->admin_feedback }}
                                        </div>
                                    @endif
                                </div>
                                <div class="w-full lg:w-72 soft-panel">
                                    <label class="text-xs uppercase tracking-[0.18em] text-slate-500">Progression</label>
                                    <div class="progress-track">
                                        <span style="width: {{ $project->progress }}%"></span>
                                    </div>
                                    <p class="mt-3 text-sm font-semibold text-slate-900">{{ $project->progress }}%</p>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state">
                            Aucun projet soumis pour l'instant.
                        </div>
                    @endforelse
                </div>
            </section>
        @endif
    </div>

@if(auth()->user()->isAdmin())
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const brandColor = '#F16529';
    const brandLight = 'rgba(241, 101, 41, 0.15)';
    const blueColor = '#3b82f6';
    const blueLight = 'rgba(59, 130, 246, 0.15)';
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(148,163,184,0.12)' : 'rgba(0,0,0,0.06)';
    const tickColor = isDark ? '#94a3b8' : '#64748b';

    Chart.defaults.color = tickColor;
    Chart.defaults.borderColor = gridColor;

    // Visits line chart
    const visitsData = @json($last7Days);
    new Chart(document.getElementById('visitsChart'), {
        type: 'line',
        data: {
            labels: visitsData.map(d => d.label),
            datasets: [
                {
                    label: 'Total',
                    data: visitsData.map(d => d.total),
                    borderColor: brandColor,
                    backgroundColor: brandLight,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: brandColor,
                    borderWidth: 2,
                },
                {
                    label: 'Uniques',
                    data: visitsData.map(d => d.unique),
                    borderColor: blueColor,
                    backgroundColor: blueLight,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: blueColor,
                    borderWidth: 2,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 12 } } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Hourly bar chart
    const hourlyData = @json($hourlyData);
    new Chart(document.getElementById('hourlyChart'), {
        type: 'bar',
        data: {
            labels: Array.from({length: 24}, (_, i) => i + 'h'),
            datasets: [{
                label: 'Visites',
                data: hourlyData,
                backgroundColor: brandLight,
                borderColor: brandColor,
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endpush
@endif

@endsection
