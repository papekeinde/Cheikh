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
        /* Leaflet map Apple style */
        #leafletMap {
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.3);
            z-index: 1;
        }
        #leafletMap .leaflet-tile-pane { border-radius: 1.5rem; }
        .leaflet-popup-content-wrapper {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15), 0 0 0 0.5px rgba(0,0,0,0.08) !important;
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Text', 'Inter', sans-serif !important;
            padding: 0 !important;
        }
        .leaflet-popup-content { margin: 10px 14px !important; font-size: 13px !important; line-height: 1.4 !important; color: #1d1d1f !important; }
        .leaflet-popup-tip { background: rgba(255,255,255,0.95) !important; }
        .leaflet-popup-close-button { display: none !important; }
        .leaflet-control-zoom { border: none !important; box-shadow: 0 2px 12px rgba(0,0,0,0.1) !important; border-radius: 12px !important; overflow: hidden; }
        .leaflet-control-zoom a { background: rgba(255,255,255,0.9) !important; backdrop-filter: blur(12px) !important; color: #1d1d1f !important; border: none !important; width: 36px !important; height: 36px !important; line-height: 36px !important; font-size: 18px !important; }
        .leaflet-control-zoom a:hover { background: rgba(255,255,255,1) !important; }
        .leaflet-control-attribution { display: none !important; }
        html.dark .leaflet-popup-content-wrapper { background: rgba(28,28,30,0.95) !important; }
        html.dark .leaflet-popup-content { color: #f1f5f9 !important; }
        html.dark .leaflet-popup-tip { background: rgba(28,28,30,0.95) !important; }
        html.dark .leaflet-control-zoom a { background: rgba(30,41,59,0.9) !important; color: #f1f5f9 !important; }
        html.dark .map-legend-chip {
            background: rgba(241,101,41,0.15) !important;
            color: #fb923c !important;
        }
        /* Period tabs */
        .period-tab {
            padding: 0.5rem 1.15rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #64748b;
            background: rgba(241,245,249,0.8);
            border: 1px solid transparent;
            transition: all 0.2s ease;
            cursor: pointer;
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Text', 'Inter', sans-serif;
        }
        .period-tab:hover {
            color: #0f172a;
            background: rgba(241,245,249,1);
        }
        .period-tab--active {
            background: #f16529 !important;
            color: #fff !important;
            box-shadow: 0 4px 14px -4px rgba(241,101,41,0.5);
        }
        html.dark .period-tab {
            color: #94a3b8;
            background: rgba(30,41,59,0.8);
        }
        html.dark .period-tab:hover {
            color: #f1f5f9;
            background: rgba(51,65,85,0.8);
        }
        html.dark .period-tab--active {
            background: #f16529 !important;
            color: #fff !important;
        }
    </style>
@endpush

@section('title', auth()->user()->isAdmin() ? 'Pilotage projets' : 'Mon espace projet')

@section('content')
    <div class="space-y-8">
        <section>
            @if(auth()->user()->isAdmin())
                {{-- Period tabs --}}
                <div class="flex flex-wrap gap-2 mb-5" x-data="{ period: 'day' }" id="periodTabs">
                    <button @click="period='day'; $dispatch('period-change', {period:'day'})" :class="period==='day' ? 'period-tab--active' : ''" class="period-tab">Aujourd'hui</button>
                    <button @click="period='week'; $dispatch('period-change', {period:'week'})" :class="period==='week' ? 'period-tab--active' : ''" class="period-tab">Semaine</button>
                    <button @click="period='month'; $dispatch('period-change', {period:'month'})" :class="period==='month' ? 'period-tab--active' : ''" class="period-tab">Mois</button>
                    <button @click="period='year'; $dispatch('period-change', {period:'year'})" :class="period==='year' ? 'period-tab--active' : ''" class="period-tab">Année</button>
                </div>

                <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-4"
                     x-data="{
                         period: 'day',
                         stats: {
                             day:   { visits: {{ $todayVisits }}, unique: {{ $todayUnique }}, label: 'Aujourd\'hui' },
                             week:  { visits: {{ $weekVisits }},  unique: {{ $weekUnique }},  label: 'Cette semaine' },
                             month: { visits: {{ $monthVisits }}, unique: {{ $monthUnique }}, label: 'Ce mois' },
                             year:  { visits: {{ $yearVisits }},  unique: {{ $yearUnique }},  label: 'Cette année' }
                         }
                     }"
                     @period-change.window="period = $event.detail.period">
                    <div class="stat-card">
                        <p class="stat-card__label">Visites <span x-text="stats[period].label" class="lowercase"></span></p>
                        <p class="stat-card__value" x-text="stats[period].visits"></p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-card__label">Uniques <span x-text="stats[period].label" class="lowercase"></span></p>
                        <p class="stat-card__value" x-text="stats[period].unique"></p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-card__label">Total toutes visites</p>
                        <p class="stat-card__value">{{ $totalVisits }}</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-card__label">Visiteurs uniques (total)</p>
                        <p class="stat-card__value">{{ $totalUnique }}</p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2 mt-4">
                    <div class="stat-card">
                        <p class="stat-card__label">Projets en attente</p>
                        <p class="stat-card__value">{{ $pendingProjects->count() }}</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-card__label">Projets approuvés</p>
                        <p class="stat-card__value">{{ $approvedProjectsCount }}</p>
                    </div>
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
                <div class="stat-card chart-card" style="border-radius:1.75rem;"
                     x-data="{ chartPeriod: 'day' }"
                     @period-change.window="chartPeriod = $event.detail.period; window.updateVisitsChart && window.updateVisitsChart($event.detail.period)">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800" style="font-family:'Playfair Display',serif"
                            x-text="chartPeriod==='day' ? 'Visites — 7 derniers jours' : chartPeriod==='week' ? 'Visites — 4 dernières semaines' : chartPeriod==='month' ? 'Visites — 12 derniers mois' : 'Visites — 12 derniers mois'"></h3>
                    </div>
                    <div style="height:240px"><canvas id="visitsChart"></canvas></div>
                </div>
                <div class="stat-card chart-card" style="border-radius:1.75rem;">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4" style="font-family:'Playfair Display',serif">Distribution horaire</h3>
                    <div style="height:240px"><canvas id="hourlyChart"></canvas></div>
                </div>
            </section>

            {{-- ═══ CARTE DU MONDE — LEAFLET ═══ --}}
            <section class="moderation-shell p-6 md:p-8">
                <div class="mb-6">
                    <h2 class="text-3xl font-display text-slate-950" style="font-family:'Playfair Display',serif">Visiteurs dans le monde</h2>
                    <p class="mt-2 text-sm text-slate-500">Carte des pays d'où proviennent vos visiteurs.</p>
                </div>

                <div id="leafletMap" style="height:440px;"></div>

                {{-- Légende Apple Maps style --}}
                @if($topLocations->count())
                    <div class="mt-5 flex flex-wrap gap-2.5 justify-center">
                        @foreach($topLocations->take(6) as $loc)
                            <span class="map-legend-chip inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl text-xs font-semibold" style="background:rgba(255,255,255,0.85);color:#1d1d1f;backdrop-filter:blur(12px);box-shadow:0 1px 4px rgba(0,0,0,0.06),0 0 0 0.5px rgba(0,0,0,0.04);font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Inter',sans-serif">
                                <span style="width:8px;height:8px;border-radius:50%;background:#f16529;box-shadow:0 0 0 2px #fff,0 0 0 3px rgba(241,101,41,0.3)"></span>
                                {{ $loc->country }}{{ $loc->city ? ' · '.$loc->city : '' }}
                                <span style="color:#86868b;font-weight:500">{{ $loc->visit_count }}</span>
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5 text-center text-sm" style="color:#86868b;font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Inter',sans-serif">Les données géographiques apparaîtront avec les prochaines visites.</div>
                @endif
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
                                    <p class="mt-2 text-sm text-slate-500">Soumis par {{ $project->user?->nom ?? 'Utilisateur supprimé' }} · {{ $project->user?->email ?? '-' }}</p>
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

    // Visits line chart — switchable by period
    const chartDataSets = {
        day: @json($last7Days),
        week: @json($last4Weeks),
        month: @json($last12Months),
        year: @json($last12Months)
    };

    let visitsChartInstance = new Chart(document.getElementById('visitsChart'), {
        type: 'line',
        data: {
            labels: chartDataSets.day.map(d => d.label),
            datasets: [
                {
                    label: 'Total',
                    data: chartDataSets.day.map(d => d.total),
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
                    data: chartDataSets.day.map(d => d.unique),
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

    window.updateVisitsChart = function(period) {
        const data = chartDataSets[period] || chartDataSets.day;
        visitsChartInstance.data.labels = data.map(d => d.label);
        visitsChartInstance.data.datasets[0].data = data.map(d => d.total);
        visitsChartInstance.data.datasets[1].data = data.map(d => d.unique);
        visitsChartInstance.update();
    };

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

    // Leaflet world map — Apple Maps style
    const mapEl = document.getElementById('leafletMap');
    if (mapEl) {
        const map = L.map('leafletMap', {
            center: [20, 10],
            zoom: 2,
            minZoom: 2,
            maxZoom: 8,
            zoomControl: true,
            scrollWheelZoom: true,
            attributionControl: false,
            worldCopyJump: true
        });

        // Light tile layer (Apple Maps-like)
        const isDark = document.documentElement.classList.contains('dark');
        const lightTiles = 'https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png';
        const darkTiles = 'https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}{r}.png';
        L.tileLayer(isDark ? darkTiles : lightTiles, { subdomains: 'abcd', maxZoom: 19 }).addTo(map);

        // Country → lat/lon lookup
        const countryCoords = {
            'France': [46.6, 2.3], 'FR': [46.6, 2.3],
            'Senegal': [14.5, -14.5], 'SN': [14.5, -14.5],
            'United States': [39.8, -98.5], 'US': [39.8, -98.5], 'USA': [39.8, -98.5], 'États-Unis': [39.8, -98.5],
            'Canada': [56.1, -106.3], 'CA': [56.1, -106.3],
            'United Kingdom': [55.4, -3.4], 'GB': [55.4, -3.4], 'UK': [55.4, -3.4], 'Royaume-Uni': [55.4, -3.4],
            'Germany': [51.2, 10.5], 'DE': [51.2, 10.5], 'Allemagne': [51.2, 10.5],
            'Spain': [40.5, -3.7], 'ES': [40.5, -3.7], 'Espagne': [40.5, -3.7],
            'Italy': [41.9, 12.6], 'IT': [41.9, 12.6], 'Italie': [41.9, 12.6],
            'Belgium': [50.8, 4.4], 'BE': [50.8, 4.4], 'Belgique': [50.8, 4.4],
            'Switzerland': [46.8, 8.2], 'CH': [46.8, 8.2], 'Suisse': [46.8, 8.2],
            'Netherlands': [52.1, 5.3], 'NL': [52.1, 5.3], 'Pays-Bas': [52.1, 5.3],
            'Portugal': [39.4, -8.2], 'PT': [39.4, -8.2],
            'Morocco': [31.8, -7.1], 'MA': [31.8, -7.1], 'Maroc': [31.8, -7.1],
            'Tunisia': [33.9, 9.5], 'TN': [33.9, 9.5], 'Tunisie': [33.9, 9.5],
            'Algeria': [28.0, 1.7], 'DZ': [28.0, 1.7], 'Algérie': [28.0, 1.7],
            'Mali': [17.6, -4.0], 'ML': [17.6, -4.0],
            'Guinea': [9.9, -11.4], 'GN': [9.9, -11.4], 'Guinée': [9.9, -11.4],
            'Ivory Coast': [7.5, -5.5], 'CI': [7.5, -5.5], "Côte d'Ivoire": [7.5, -5.5],
            'Cameroon': [7.4, 12.4], 'CM': [7.4, 12.4], 'Cameroun': [7.4, 12.4],
            'Nigeria': [9.1, 8.7], 'NG': [9.1, 8.7],
            'Ghana': [7.9, -1.0], 'GH': [7.9, -1.0],
            'Congo': [4.0, 21.8], 'CD': [-4.0, 21.8], 'CG': [-0.2, 15.8],
            'South Africa': [-30.6, 22.9], 'ZA': [-30.6, 22.9], 'Afrique du Sud': [-30.6, 22.9],
            'Egypt': [26.8, 30.8], 'EG': [26.8, 30.8], 'Égypte': [26.8, 30.8],
            'Kenya': [-0.02, 37.9], 'KE': [-0.02, 37.9],
            'Ethiopia': [9.1, 40.5], 'ET': [9.1, 40.5], 'Éthiopie': [9.1, 40.5],
            'India': [20.6, 79.0], 'IN': [20.6, 79.0], 'Inde': [20.6, 79.0],
            'China': [35.9, 104.2], 'CN': [35.9, 104.2], 'Chine': [35.9, 104.2],
            'Japan': [36.2, 138.3], 'JP': [36.2, 138.3], 'Japon': [36.2, 138.3],
            'South Korea': [35.9, 127.8], 'KR': [35.9, 127.8], 'Corée du Sud': [35.9, 127.8],
            'Russia': [61.5, 105.3], 'RU': [61.5, 105.3], 'Russie': [61.5, 105.3],
            'Turkey': [38.9, 35.2], 'TR': [38.9, 35.2], 'Turquie': [38.9, 35.2],
            'Brazil': [-14.2, -51.9], 'BR': [-14.2, -51.9], 'Brésil': [-14.2, -51.9],
            'Mexico': [23.6, -102.6], 'MX': [23.6, -102.6], 'Mexique': [23.6, -102.6],
            'Argentina': [-38.4, -63.6], 'AR': [-38.4, -63.6], 'Argentine': [-38.4, -63.6],
            'Colombia': [4.6, -74.3], 'CO': [4.6, -74.3], 'Colombie': [4.6, -74.3],
            'Australia': [-25.3, 133.8], 'AU': [-25.3, 133.8], 'Australie': [-25.3, 133.8],
            'Indonesia': [-0.8, 113.9], 'ID': [-0.8, 113.9], 'Indonésie': [-0.8, 113.9],
            'Saudi Arabia': [23.9, 45.1], 'SA': [23.9, 45.1], 'Arabie Saoudite': [23.9, 45.1],
            'UAE': [23.4, 53.8], 'AE': [23.4, 53.8], 'Émirats arabes unis': [23.4, 53.8],
            'Poland': [51.9, 19.1], 'PL': [51.9, 19.1], 'Pologne': [51.9, 19.1],
            'Sweden': [60.1, 18.6], 'SE': [60.1, 18.6], 'Suède': [60.1, 18.6],
            'Norway': [60.5, 8.5], 'NO': [60.5, 8.5], 'Norvège': [60.5, 8.5],
            'Ireland': [53.1, -7.7], 'IE': [53.1, -7.7], 'Irlande': [53.1, -7.7],
            'Austria': [47.5, 14.6], 'AT': [47.5, 14.6], 'Autriche': [47.5, 14.6],
            'Romania': [45.9, 25.0], 'RO': [45.9, 25.0], 'Roumanie': [45.9, 25.0],
            'Ukraine': [48.4, 31.2], 'UA': [48.4, 31.2],
            'Pakistan': [30.4, 69.3], 'PK': [30.4, 69.3],
            'Bangladesh': [23.7, 90.4], 'BD': [23.7, 90.4],
            'Vietnam': [14.1, 108.3], 'VN': [14.1, 108.3],
            'Thailand': [15.9, 100.9], 'TH': [15.9, 100.9], 'Thaïlande': [15.9, 100.9],
            'Philippines': [12.9, 121.8], 'PH': [12.9, 121.8],
            'Malaysia': [4.2, 101.9], 'MY': [4.2, 101.9], 'Malaisie': [4.2, 101.9],
            'Singapore': [1.4, 103.8], 'SG': [1.4, 103.8], 'Singapour': [1.4, 103.8],
            'Mauritania': [21.0, -10.9], 'MR': [21.0, -10.9], 'Mauritanie': [21.0, -10.9],
            'Gambia': [13.4, -16.6], 'GM': [13.4, -16.6], 'Gambie': [13.4, -16.6],
            'Burkina Faso': [12.4, -1.6], 'BF': [12.4, -1.6],
            'Niger': [17.6, 8.1], 'NE': [17.6, 8.1],
            'Togo': [8.6, 1.2], 'TG': [8.6, 1.2],
            'Benin': [9.3, 2.3], 'BJ': [9.3, 2.3], 'Bénin': [9.3, 2.3],
            'Gabon': [-0.8, 11.6], 'GA': [-0.8, 11.6],
            'Tanzania': [-6.4, 34.9], 'TZ': [-6.4, 34.9], 'Tanzanie': [-6.4, 34.9]
        };

        const locations = @json($topLocations);
        const maxCount = Math.max(...locations.map(l => l.visit_count), 1);

        locations.forEach(loc => {
            const coords = countryCoords[loc.country];
            if (!coords) return;
            const ratio = loc.visit_count / maxCount;
            const radius = 8 + (ratio * 22);

            // Outer pulse circle
            L.circleMarker(coords, {
                radius: radius + 8,
                fillColor: '#f16529',
                fillOpacity: 0.12,
                stroke: false,
                className: 'leaflet-pulse'
            }).addTo(map);

            // White outer ring + orange inner
            const marker = L.circleMarker(coords, {
                radius: Math.max(radius * 0.7, 6),
                fillColor: '#ffffff',
                fillOpacity: 1,
                color: '#ffffff',
                weight: 0,
            }).addTo(map);

            L.circleMarker(coords, {
                radius: Math.max(radius * 0.5, 4),
                fillColor: '#f16529',
                fillOpacity: 1,
                stroke: false,
            }).addTo(map).bindPopup(
                '<div style="text-align:center">' +
                '<div style="font-weight:600;font-size:13px">' + (loc.city ? loc.city + ', ' : '') + loc.country + '</div>' +
                '<div style="color:#86868b;font-size:11px;margin-top:2px">' + loc.visit_count + ' visite' + (loc.visit_count > 1 ? 's' : '') + '</div>' +
                '</div>',
                { closeButton: false, offset: [0, -4] }
            );
        });

        // Fit bounds if locations exist
        if (locations.length > 0) {
            const validCoords = locations.map(l => countryCoords[l.country]).filter(Boolean);
            if (validCoords.length > 0) {
                map.fitBounds(validCoords, { padding: [40, 40], maxZoom: 5 });
            }
        }

        // Pulse animation via CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes leafletPulse {
                0% { transform: scale(1); opacity: 0.12; }
                50% { transform: scale(1.6); opacity: 0; }
                100% { transform: scale(1); opacity: 0.12; }
            }
            .leaflet-pulse { animation: leafletPulse 3.5s ease-in-out infinite; transform-origin: center; }
            @keyframes myLocPulse {
                0% { transform: scale(1); opacity: 0.25; }
                50% { transform: scale(2.2); opacity: 0; }
                100% { transform: scale(1); opacity: 0.25; }
            }
            .my-loc-pulse { animation: myLocPulse 2.5s ease-in-out infinite; transform-origin: center; }
        `;
        document.head.appendChild(style);

        // Show user's current position (blue dot like Apple Maps)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                const myLatLng = [pos.coords.latitude, pos.coords.longitude];

                // Blue pulse ring
                L.circleMarker(myLatLng, {
                    radius: 20,
                    fillColor: '#007AFF',
                    fillOpacity: 0.2,
                    stroke: false,
                    className: 'my-loc-pulse'
                }).addTo(map);

                // White border ring
                L.circleMarker(myLatLng, {
                    radius: 9,
                    fillColor: '#ffffff',
                    fillOpacity: 1,
                    color: '#ffffff',
                    weight: 3,
                    opacity: 1
                }).addTo(map);

                // Blue inner dot
                L.circleMarker(myLatLng, {
                    radius: 7,
                    fillColor: '#007AFF',
                    fillOpacity: 1,
                    stroke: false,
                }).addTo(map).bindPopup(
                    '<div style="text-align:center">' +
                    '<div style="font-weight:600;font-size:13px">📍 Ma position</div>' +
                    '</div>',
                    { closeButton: false, offset: [0, -4] }
                );
            }, function(err) {
                console.log('Geolocation error:', err.message);
            }, { enableHighAccuracy: true, timeout: 10000 });
        }
    }
</script>
@endpush
@endif

@endsection
