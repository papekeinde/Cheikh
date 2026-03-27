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
                            // Coordonnées projection équirectangulaire: x=(lon+180)/360*1000, y=(90-lat)/180*500
                            $countryCoords = [
                                'France' => [506, 122], 'FR' => [506, 122],
                                'Senegal' => [452, 209], 'SN' => [452, 209],
                                'United States' => [228, 142], 'US' => [228, 142], 'USA' => [228, 142], 'États-Unis' => [228, 142],
                                'Canada' => [206, 94], 'CA' => [206, 94],
                                'United Kingdom' => [497, 103], 'GB' => [497, 103], 'UK' => [497, 103], 'Royaume-Uni' => [497, 103],
                                'Germany' => [525, 108], 'DE' => [525, 108], 'Allemagne' => [525, 108],
                                'Spain' => [489, 139], 'ES' => [489, 139], 'Espagne' => [489, 139],
                                'Italy' => [533, 133], 'IT' => [533, 133], 'Italie' => [533, 133],
                                'Belgium' => [511, 109], 'BE' => [511, 109], 'Belgique' => [511, 109],
                                'Switzerland' => [522, 119], 'CH' => [522, 119], 'Suisse' => [522, 119],
                                'Netherlands' => [514, 106], 'NL' => [514, 106], 'Pays-Bas' => [514, 106],
                                'Portugal' => [478, 142], 'PT' => [478, 142],
                                'Morocco' => [483, 161], 'MA' => [483, 161], 'Maroc' => [483, 161],
                                'Tunisia' => [525, 156], 'TN' => [525, 156], 'Tunisie' => [525, 156],
                                'Algeria' => [506, 172], 'DZ' => [506, 172], 'Algérie' => [506, 172],
                                'Mali' => [489, 203], 'ML' => [489, 203],
                                'Guinea' => [469, 219], 'GN' => [469, 219], 'Guinée' => [469, 219],
                                'Ivory Coast' => [485, 229], 'CI' => [485, 229], "Côte d'Ivoire" => [485, 229],
                                'Cameroon' => [533, 233], 'CM' => [533, 233], 'Cameroun' => [533, 233],
                                'Nigeria' => [522, 225], 'NG' => [522, 225],
                                'Ghana' => [497, 228], 'GH' => [497, 228],
                                'Congo' => [544, 262], 'CD' => [544, 262], 'CG' => [544, 251],
                                'South Africa' => [569, 333], 'ZA' => [569, 333], 'Afrique du Sud' => [569, 333],
                                'Egypt' => [583, 178], 'EG' => [583, 178], 'Égypte' => [583, 178],
                                'Kenya' => [603, 253], 'KE' => [603, 253],
                                'Ethiopia' => [608, 225], 'ET' => [608, 225], 'Éthiopie' => [608, 225],
                                'India' => [717, 192], 'IN' => [717, 192], 'Inde' => [717, 192],
                                'China' => [789, 153], 'CN' => [789, 153], 'Chine' => [789, 153],
                                'Japan' => [883, 150], 'JP' => [883, 150], 'Japon' => [883, 150],
                                'South Korea' => [856, 150], 'KR' => [856, 150], 'Corée du Sud' => [856, 150],
                                'Russia' => [778, 78], 'RU' => [778, 78], 'Russie' => [778, 78],
                                'Turkey' => [597, 142], 'TR' => [597, 142], 'Turquie' => [597, 142],
                                'Brazil' => [358, 289], 'BR' => [358, 289], 'Brésil' => [358, 289],
                                'Mexico' => [217, 186], 'MX' => [217, 186], 'Mexique' => [217, 186],
                                'Argentina' => [325, 356], 'AR' => [325, 356], 'Argentine' => [325, 356],
                                'Colombia' => [300, 239], 'CO' => [300, 239], 'Colombie' => [300, 239],
                                'Australia' => [869, 319], 'AU' => [869, 319], 'Australie' => [869, 319],
                                'Indonesia' => [833, 264], 'ID' => [833, 264], 'Indonésie' => [833, 264],
                                'Saudi Arabia' => [625, 183], 'SA' => [625, 183], 'Arabie Saoudite' => [625, 183],
                                'UAE' => [650, 183], 'AE' => [650, 183], 'Émirats arabes unis' => [650, 183],
                                'Poland' => [553, 106], 'PL' => [553, 106], 'Pologne' => [553, 106],
                                'Sweden' => [547, 78], 'SE' => [547, 78], 'Suède' => [547, 78],
                                'Norway' => [528, 78], 'NO' => [528, 78], 'Norvège' => [528, 78],
                                'Ireland' => [478, 103], 'IE' => [478, 103], 'Irlande' => [478, 103],
                                'Austria' => [539, 119], 'AT' => [539, 119], 'Autriche' => [539, 119],
                                'Romania' => [569, 122], 'RO' => [569, 122], 'Roumanie' => [569, 122],
                                'Ukraine' => [589, 114], 'UA' => [589, 114],
                                'Pakistan' => [692, 167], 'PK' => [692, 167],
                                'Bangladesh' => [750, 183], 'BD' => [750, 183],
                                'Vietnam' => [800, 206], 'VN' => [800, 206],
                                'Thailand' => [781, 207], 'TH' => [781, 207], 'Thaïlande' => [781, 207],
                                'Philippines' => [839, 217], 'PH' => [839, 217],
                                'Malaysia' => [803, 239], 'MY' => [803, 239], 'Malaisie' => [803, 239],
                                'Singapore' => [789, 246], 'SG' => [789, 246], 'Singapour' => [789, 246],
                                'Mauritania' => [467, 194], 'MR' => [467, 194], 'Mauritanie' => [467, 194],
                                'Gambia' => [454, 213], 'GM' => [454, 213], 'Gambie' => [454, 213],
                                'Burkina Faso' => [496, 217], 'BF' => [496, 217],
                                'Niger' => [522, 201], 'NE' => [522, 201],
                                'Togo' => [503, 228], 'TG' => [503, 228],
                                'Benin' => [506, 224], 'BJ' => [506, 224], 'Bénin' => [506, 224],
                                'Gabon' => [532, 252], 'GA' => [532, 252],
                                'Tanzania' => [597, 268], 'TZ' => [597, 268], 'Tanzanie' => [597, 268],
                            ];

                            $maxCount = $topLocations->max('visit_count') ?: 1;
                        @endphp

                        {{-- Continents — projection équirectangulaire simplifiée --}}
                        {{-- Greenland --}}
                        <path class="map-land" d="M363,42 Q370,28 385,22 Q400,20 412,28 Q418,38 416,52 Q412,62 403,67 Q392,65 380,58 Q368,50 363,42 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- North America (avec Golfe du Mexique et Floride) --}}
                        <path class="map-land" d="M33,69 Q55,88 75,92 L110,96 Q130,98 150,105 L153,117 Q156,130 160,144 Q170,152 178,158 L194,186 Q205,191 215,197 L228,206 Q240,202 250,197 L261,192 Q255,187 249,183 L238,178 Q237,174 237,170 Q243,168 250,168 L267,170 Q272,176 275,182 Q278,172 280,164 L289,153 Q292,146 295,139 L308,133 Q322,128 335,125 L353,119 Q348,111 342,103 Q330,88 319,74 Q315,62 311,50 Q273,43 236,42 Q194,44 153,47 Q97,48 42,50 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- South America --}}
                        <path class="map-land" d="M275,250 Q280,240 289,228 L300,222 Q310,219 325,228 L355,242 Q380,252 400,261 L408,272 Q403,280 397,289 L386,306 Q380,314 372,325 L358,339 Q348,347 336,356 L322,367 Q316,380 313,392 L311,406 Q300,392 292,378 Q289,361 288,344 L286,322 Q283,303 280,286 Q278,272 275,258 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- Europe --}}
                        <path class="map-land" d="M478,83 Q486,78 494,83 Q500,86 503,92 L506,100 Q508,106 514,108 L528,103 Q539,100 550,97 L564,100 Q575,106 581,117 Q583,128 578,136 L567,144 Q556,150 542,150 L528,144 Q519,147 508,150 L494,153 Q483,150 475,142 Q469,133 472,122 L478,111 Q481,103 483,97 Q480,92 478,86 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- Scandinavia --}}
                        <path class="map-land" d="M508,56 Q517,48 528,50 Q539,50 547,56 L556,64 Q561,72 561,81 L556,86 Q547,83 536,78 L522,75 Q514,72 511,67 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- British Isles --}}
                        <path class="map-land" d="M492,86 Q497,81 500,83 Q503,88 503,94 Q500,100 497,103 Q493,100 491,97 Q490,92 492,86 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        <path class="map-land" d="M481,92 Q484,89 486,92 Q488,97 486,100 Q483,103 481,100 Q479,97 481,92 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- Africa --}}
                        <path class="map-land" d="M483,155 Q500,150 519,152 Q542,155 561,161 L581,170 Q594,178 603,192 L614,211 Q625,219 636,225 Q640,235 636,247 L625,261 Q619,272 614,283 L603,308 Q597,322 589,333 Q581,340 572,344 L556,347 Q542,344 531,336 L525,322 Q522,308 522,292 L519,272 Q514,258 506,247 L497,239 Q486,236 475,231 L464,222 Q456,214 453,206 Q455,198 458,192 L467,175 Q475,164 483,155 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- Middle East --}}
                        <path class="map-land" d="M589,150 Q600,145 614,150 L628,161 Q639,172 642,186 L639,200 Q633,214 622,222 L608,225 Q597,222 589,214 L583,200 Q581,186 583,172 Q586,161 589,150 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- Russia / North Asia --}}
                        <path class="map-land" d="M583,58 Q617,45 661,42 Q706,39 756,44 L808,53 Q847,61 881,72 L914,86 Q933,97 942,114 Q944,131 933,144 L917,156 Q897,164 872,167 L842,169 Q814,167 786,164 L756,158 Q728,153 700,147 L672,142 Q644,136 619,128 L597,119 Q583,108 578,94 Q575,81 578,72 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- East/South Asia --}}
                        <path class="map-land" d="M633,142 Q653,136 675,142 L700,153 Q722,164 742,178 L758,194 Q772,211 781,228 L786,247 Q786,258 781,267 L769,275 Q756,278 742,272 L725,264 Q711,253 697,242 L683,228 Q669,214 658,197 L647,178 Q639,164 636,150 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- India --}}
                        <path class="map-land" d="M697,169 Q711,161 725,169 L733,181 Q739,197 736,214 L728,233 Q719,247 708,250 L697,247 Q689,239 686,225 L683,208 Q683,192 689,178 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- Japan --}}
                        <path class="map-land" d="M881,125 Q886,119 892,122 L894,131 Q892,142 889,150 L883,158 Q878,156 875,150 L875,139 Q878,131 881,125 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- Southeast Asia Islands --}}
                        <path class="map-land" d="M803,250 Q819,244 836,250 L850,258 Q861,269 858,283 L850,297 Q839,306 825,308 L808,306 Q797,297 794,283 L794,267 Q797,256 803,250 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- Australia --}}
                        <path class="map-land" d="M836,297 Q856,289 878,292 L900,300 Q914,311 919,328 L919,347 Q914,364 900,375 L881,381 Q864,383 847,378 L833,369 Q822,356 822,339 L825,319 Q828,306 836,297 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />
                        {{-- New Zealand --}}
                        <path class="map-land" d="M942,361 Q947,356 953,358 Q956,364 953,372 L947,378 Q942,375 939,369 Z" fill="#e4dbc8" stroke="#d4c9b0" stroke-width="0.5" filter="url(#landShadow)" />

                        {{-- Data circles + labels --}}
                        @foreach($topLocations as $loc)
                            @php
                                $coords = $countryCoords[$loc->country] ?? null;
                            @endphp
                            @continue(!$coords)
                            @php
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
