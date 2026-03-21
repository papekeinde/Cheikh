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
        html.dark #worldMapSvg {
            background: linear-gradient(180deg, #1a2535 0%, #1e2d3d 50%, #172030 100%);
        }
        html.dark #worldMapSvg .map-land {
            fill: #2d3a48;
            stroke: #3d4d5e;
        }
        html.dark #mapTooltip {
            background: rgba(28,28,30,0.95) !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
        }
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

            {{-- ═══ CARTE DU MONDE — VISITEURS ═══ --}}
            <section class="moderation-shell p-6 md:p-8">
                <div class="mb-6">
                    <h2 class="text-3xl font-display text-slate-950" style="font-family:'Playfair Display',serif">Visiteurs dans le monde</h2>
                    <p class="mt-2 text-sm text-slate-500">Carte des pays d'où proviennent vos visiteurs.</p>
                </div>

                <div class="relative" id="worldMapContainer">
                    {{-- Tooltip Apple Maps style --}}
                    <div id="mapTooltip" class="absolute pointer-events-none z-50 hidden" style="transform:translate(-50%,-130%)">
                        <div style="background:rgba(255,255,255,0.95);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-radius:14px;padding:10px 14px;box-shadow:0 2px 20px rgba(0,0,0,0.15),0 0 0 0.5px rgba(0,0,0,0.08);font-size:13px;line-height:1.4;color:#1d1d1f;font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Inter',sans-serif;min-width:120px;text-align:center">
                            <div id="mapTooltipContent"></div>
                        </div>
                        <div style="width:0;height:0;border-left:8px solid transparent;border-right:8px solid transparent;border-top:8px solid rgba(255,255,255,0.95);margin:0 auto"></div>
                    </div>

                    <svg id="worldMapSvg" viewBox="0 0 1000 500" class="w-full h-auto" style="max-height:440px;border-radius:1.5rem;background:linear-gradient(180deg,#c3ddf0 0%,#a8cce4 30%,#92bfdb 60%,#b0d0e8 100%);overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08),inset 0 1px 0 rgba(255,255,255,0.3)">
                        <defs>
                            <filter id="pinShadow" x="-50%" y="-50%" width="200%" height="200%">
                                <feDropShadow dx="0" dy="1" stdDeviation="2" flood-color="rgba(0,0,0,0.25)" />
                            </filter>
                            <filter id="landShadow" x="-2%" y="-2%" width="104%" height="104%">
                                <feDropShadow dx="0" dy="1" stdDeviation="1.5" flood-color="rgba(0,0,0,0.06)" />
                            </filter>
                            <radialGradient id="oceanShine" cx="40%" cy="30%" r="60%">
                                <stop offset="0%" stop-color="rgba(255,255,255,0.08)" />
                                <stop offset="100%" stop-color="rgba(255,255,255,0)" />
                            </radialGradient>
                        </defs>
                        <rect width="1000" height="500" fill="url(#oceanShine)" />

                        {{-- Cercles par pays --}}
                        @php
                            // Mapping simplifié pays → coordonnées approximatives sur la carte SVG 1000x500
                            $countryCoords = [
                                'France' => [480, 175], 'FR' => [480, 175],
                                'Senegal' => [410, 260], 'SN' => [410, 260],
                                'United States' => [220, 185], 'US' => [220, 185], 'USA' => [220, 185], 'États-Unis' => [220, 185],
                                'Canada' => [230, 140], 'CA' => [230, 140],
                                'United Kingdom' => [460, 155], 'GB' => [460, 155], 'UK' => [460, 155], 'Royaume-Uni' => [460, 155],
                                'Germany' => [505, 165], 'DE' => [505, 165], 'Allemagne' => [505, 165],
                                'Spain' => [465, 195], 'ES' => [465, 195], 'Espagne' => [465, 195],
                                'Italy' => [510, 190], 'IT' => [510, 190], 'Italie' => [510, 190],
                                'Belgium' => [485, 165], 'BE' => [485, 165], 'Belgique' => [485, 165],
                                'Switzerland' => [495, 178], 'CH' => [495, 178], 'Suisse' => [495, 178],
                                'Netherlands' => [487, 158], 'NL' => [487, 158], 'Pays-Bas' => [487, 158],
                                'Portugal' => [450, 195], 'PT' => [450, 195],
                                'Morocco' => [450, 225], 'MA' => [450, 225], 'Maroc' => [450, 225],
                                'Tunisia' => [505, 218], 'TN' => [505, 218], 'Tunisie' => [505, 218],
                                'Algeria' => [480, 225], 'DZ' => [480, 225], 'Algérie' => [480, 225],
                                'Mali' => [455, 265], 'ML' => [455, 265],
                                'Guinea' => [420, 270], 'GN' => [420, 270], 'Guinée' => [420, 270],
                                'Ivory Coast' => [440, 280], 'CI' => [440, 280], "Côte d'Ivoire" => [440, 280],
                                'Cameroon' => [505, 285], 'CM' => [505, 285], 'Cameroun' => [505, 285],
                                'Nigeria' => [490, 280], 'NG' => [490, 280],
                                'Ghana' => [460, 280], 'GH' => [460, 280],
                                'Congo' => [520, 310], 'CD' => [530, 310], 'CG' => [520, 305],
                                'South Africa' => [535, 385], 'ZA' => [535, 385], 'Afrique du Sud' => [535, 385],
                                'Egypt' => [545, 225], 'EG' => [545, 225], 'Égypte' => [545, 225],
                                'Kenya' => [565, 305], 'KE' => [565, 305],
                                'Ethiopia' => [570, 280], 'ET' => [570, 280], 'Éthiopie' => [570, 280],
                                'India' => [680, 245], 'IN' => [680, 245], 'Inde' => [680, 245],
                                'China' => [750, 210], 'CN' => [750, 210], 'Chine' => [750, 210],
                                'Japan' => [830, 195], 'JP' => [830, 195], 'Japon' => [830, 195],
                                'South Korea' => [810, 200], 'KR' => [810, 200], 'Corée du Sud' => [810, 200],
                                'Russia' => [650, 130], 'RU' => [650, 130], 'Russie' => [650, 130],
                                'Turkey' => [555, 195], 'TR' => [555, 195], 'Turquie' => [555, 195],
                                'Brazil' => [310, 340], 'BR' => [310, 340], 'Brésil' => [310, 340],
                                'Mexico' => [180, 245], 'MX' => [180, 245], 'Mexique' => [180, 245],
                                'Argentina' => [285, 395], 'AR' => [285, 395], 'Argentine' => [285, 395],
                                'Colombia' => [260, 290], 'CO' => [260, 290], 'Colombie' => [260, 290],
                                'Australia' => [825, 385], 'AU' => [825, 385], 'Australie' => [825, 385],
                                'Indonesia' => [785, 310], 'ID' => [785, 310], 'Indonésie' => [785, 310],
                                'Saudi Arabia' => [580, 240], 'SA' => [580, 240], 'Arabie Saoudite' => [580, 240],
                                'UAE' => [610, 245], 'AE' => [610, 245], 'Émirats arabes unis' => [610, 245],
                                'Poland' => [520, 160], 'PL' => [520, 160], 'Pologne' => [520, 160],
                                'Sweden' => [510, 130], 'SE' => [510, 130], 'Suède' => [510, 130],
                                'Norway' => [500, 120], 'NO' => [500, 120], 'Norvège' => [500, 120],
                                'Ireland' => [445, 155], 'IE' => [445, 155], 'Irlande' => [445, 155],
                                'Austria' => [510, 175], 'AT' => [510, 175], 'Autriche' => [510, 175],
                                'Romania' => [535, 178], 'RO' => [535, 178], 'Roumanie' => [535, 178],
                                'Ukraine' => [550, 165], 'UA' => [550, 165],
                                'Pakistan' => [650, 235], 'PK' => [650, 235],
                                'Bangladesh' => [700, 248], 'BD' => [700, 248],
                                'Vietnam' => [760, 260], 'VN' => [760, 260],
                                'Thailand' => [745, 260], 'TH' => [745, 260], 'Thaïlande' => [745, 260],
                                'Philippines' => [810, 265], 'PH' => [810, 265],
                                'Malaysia' => [770, 290], 'MY' => [770, 290], 'Malaisie' => [770, 290],
                                'Singapore' => [775, 300], 'SG' => [775, 300], 'Singapour' => [775, 300],
                                'Mauritania' => [425, 245], 'MR' => [425, 245], 'Mauritanie' => [425, 245],
                                'Gambia' => [410, 258], 'GM' => [410, 258], 'Gambie' => [410, 258],
                                'Burkina Faso' => [454, 272], 'BF' => [454, 272],
                                'Niger' => [475, 260], 'NE' => [475, 260],
                                'Togo' => [465, 280], 'TG' => [465, 280],
                                'Benin' => [475, 280], 'BJ' => [475, 280], 'Bénin' => [475, 280],
                                'Gabon' => [510, 305], 'GA' => [510, 305],
                                'Tanzania' => [560, 320], 'TZ' => [560, 320], 'Tanzanie' => [560, 320],
                            ];

                            $maxCount = $topLocations->max('visit_count') ?: 1;
                        @endphp

                        {{-- Continents — Apple Maps style (beige/sand fill, soft edges) --}}
                        {{-- Greenland --}}
                        <path class="map-land" d="M310,55 Q330,40 360,42 Q385,44 395,58 Q400,72 390,85 Q375,95 355,92 Q330,88 315,78 Q305,68 310,55 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- North America --}}
                        <path class="map-land" d="M85,110 Q100,85 140,72 Q175,62 210,68 Q245,72 270,82 Q290,75 305,85 Q310,100 300,115 L290,135 Q285,145 278,155 Q270,168 258,180 Q245,195 230,210 Q222,220 218,232 Q215,245 205,255 Q195,262 183,268 Q170,270 160,260 Q148,248 140,235 Q130,218 118,200 Q105,180 95,160 Q82,138 80,120 Q82,112 85,110 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- Central America --}}
                        <path class="map-land" d="M165,258 Q175,252 185,260 Q192,268 200,275 Q195,282 188,288 Q178,290 172,285 Q165,278 162,270 Q163,262 165,258 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- South America --}}
                        <path class="map-land" d="M230,282 Q250,272 275,275 Q300,278 318,290 Q332,302 340,318 Q345,335 342,355 Q338,375 328,392 Q315,410 300,422 Q285,432 272,428 Q258,420 250,405 Q242,388 238,368 Q235,348 233,328 Q230,308 228,295 Q229,286 230,282 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- Europe --}}
                        <path class="map-land" d="M440,108 Q455,98 472,100 Q488,102 502,108 Q518,105 530,110 Q545,115 555,125 Q562,135 558,148 Q555,160 548,172 Q540,185 530,195 Q520,202 508,205 Q495,208 482,205 Q468,200 458,192 Q448,182 442,170 Q436,156 434,142 Q433,128 436,118 Q438,112 440,108 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- British Isles --}}
                        <path class="map-land" d="M445,130 Q450,122 458,120 Q465,122 468,128 Q470,136 466,142 Q460,146 454,145 Q448,142 446,136 Q445,132 445,130 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- Africa --}}
                        <path class="map-land" d="M430,215 Q450,208 472,212 Q495,210 515,215 Q535,218 552,225 Q568,232 578,245 Q585,260 582,278 Q578,298 570,318 Q560,340 548,358 Q535,375 520,388 Q505,398 490,400 Q475,398 462,390 Q450,378 442,362 Q435,345 430,325 Q425,302 422,280 Q420,258 422,240 Q425,225 430,215 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- Middle East --}}
                        <path class="map-land" d="M558,200 Q572,195 585,198 Q598,200 610,208 Q618,215 622,225 Q620,238 612,248 Q600,255 588,252 Q575,248 565,238 Q558,228 555,218 Q555,208 558,200 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- Russia / North Asia --}}
                        <path class="map-land" d="M555,68 Q590,58 630,60 Q670,58 710,62 Q748,65 780,72 Q810,78 835,88 Q855,98 860,112 Q858,128 848,142 Q835,155 818,162 Q800,168 780,170 Q752,168 730,162 Q706,158 685,152 Q665,148 648,142 Q630,138 615,132 Q598,128 585,120 Q572,112 562,102 Q555,92 553,82 Q554,74 555,68 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- South/East Asia --}}
                        <path class="map-land" d="M625,165 Q645,158 668,162 Q690,168 710,178 Q730,185 748,195 Q765,205 775,218 Q782,232 778,248 Q772,262 760,272 Q745,278 728,275 Q710,270 695,260 Q678,252 665,240 Q652,228 642,215 Q635,200 630,188 Q626,175 625,165 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- India --}}
                        <path class="map-land" d="M645,232 Q658,225 672,228 Q685,232 695,242 Q700,255 698,268 Q692,280 682,288 Q670,292 658,288 Q648,280 642,268 Q638,254 640,242 Q642,235 645,232 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- Japan --}}
                        <path class="map-land" d="M822,168 Q830,162 838,165 Q842,172 840,182 Q836,192 830,198 Q824,200 820,195 Q816,188 818,178 Q820,172 822,168 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- Southeast Asia Islands --}}
                        <path class="map-land" d="M758,280 Q772,275 788,278 Q802,282 812,292 Q818,302 815,315 Q808,325 798,328 Q785,330 772,325 Q762,318 756,308 Q752,296 754,285 Q755,280 758,280 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- Australia --}}
                        <path class="map-land" d="M780,348 Q805,338 832,342 Q858,348 878,362 Q890,375 888,392 Q882,408 868,418 Q850,425 830,422 Q808,418 790,408 Q775,396 770,382 Q768,368 772,355 Q775,350 780,348 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />
                        {{-- New Zealand --}}
                        <path class="map-land" d="M905,400 Q912,395 918,398 Q920,405 916,412 Q910,416 904,414 Q900,408 902,402 Q904,400 905,400 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.8" filter="url(#landShadow)" />

                        {{-- Data circles + labels --}}
                        @foreach($topLocations as $loc)
                            @php
                                $coords = $countryCoords[$loc->country] ?? null;
                                if (!$coords) continue;
                                $ratio = $loc->visit_count / $maxCount;
                                $r = 8 + ($ratio * 22);
                                $opacity = 0.35 + ($ratio * 0.55);
                            @endphp
                            <g class="map-point" data-country="{{ $loc->country }}" data-city="{{ $loc->city }}" data-count="{{ $loc->visit_count }}" style="cursor:pointer">
                                {{-- Soft pulse --}}
                                <circle cx="{{ $coords[0] }}" cy="{{ $coords[1] }}" r="{{ $r }}" fill="#f16529" fill-opacity="0.12">
                                    <animate attributeName="r" values="{{ $r }};{{ $r + 14 }};{{ $r }}" dur="3.5s" repeatCount="indefinite" />
                                    <animate attributeName="fill-opacity" values="0.12;0;0.12" dur="3.5s" repeatCount="indefinite" />
                                </circle>
                                {{-- Pin shadow --}}
                                <circle cx="{{ $coords[0] }}" cy="{{ $coords[1] + 1 }}" r="{{ max($r * 0.72, 6) }}" fill="rgba(0,0,0,0.18)" filter="url(#pinShadow)" />
                                {{-- White outer ring --}}
                                <circle cx="{{ $coords[0] }}" cy="{{ $coords[1] }}" r="{{ max($r * 0.72, 6) }}" fill="#ffffff" />
                                {{-- Inner accent fill --}}
                                <circle cx="{{ $coords[0] }}" cy="{{ $coords[1] }}" r="{{ max($r * 0.52, 4) }}" fill="#f16529" />
                                {{-- Count label (only for larger points) --}}
                                @if($r > 16)
                                    <text x="{{ $coords[0] }}" y="{{ $coords[1] - $r - 6 }}" text-anchor="middle" fill="#1d1d1f" font-size="10" font-weight="700" font-family="-apple-system,BlinkMacSystemFont,'SF Pro Text','Inter',sans-serif">{{ $loc->visit_count }}</text>
                                @endif
                            </g>
                        @endforeach
                    </svg>

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

    // World map tooltip — Apple Maps style
    const mapContainer = document.getElementById('worldMapContainer');
    const tooltip = document.getElementById('mapTooltip');
    const tooltipContent = document.getElementById('mapTooltipContent');
    if (mapContainer && tooltip && tooltipContent) {
        document.querySelectorAll('.map-point').forEach(g => {
            g.addEventListener('mouseenter', e => {
                const country = g.dataset.country;
                const city = g.dataset.city;
                const count = g.dataset.count;
                tooltipContent.innerHTML = '<div style="font-weight:600;font-size:13px">' + (city ? city + ', ' : '') + country + '</div><div style="color:#86868b;font-size:11px;margin-top:2px">' + count + ' visite' + (count > 1 ? 's' : '') + '</div>';
                tooltip.classList.remove('hidden');
            });
            g.addEventListener('mousemove', e => {
                const rect = mapContainer.getBoundingClientRect();
                tooltip.style.left = (e.clientX - rect.left) + 'px';
                tooltip.style.top = (e.clientY - rect.top) + 'px';
            });
            g.addEventListener('mouseleave', () => {
                tooltip.classList.add('hidden');
            });
        });
    }
</script>
@endpush
@endif

@endsection
