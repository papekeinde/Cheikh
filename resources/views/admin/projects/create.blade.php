@extends('layouts.tailadmin')

@section('title', 'Soumettre un projet')

@push('styles')
    <style>
        .project-form-shell {
            border: 1px solid #fed7c3;
            border-radius: 2rem;
            background: linear-gradient(180deg, rgba(255, 247, 242, 0.92) 0%, #ffffff 18%, #ffffff 100%);
            box-shadow: 0 32px 80px -52px rgba(241, 101, 41, 0.3);
        }
        .project-field {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid #dbe3ee;
            background: #ffffff;
            padding: 0.95rem 1rem;
            color: #0f172a;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }
        .project-field:focus {
            outline: none;
            border-color: #f16529;
            box-shadow: 0 0 0 4px rgba(241, 101, 41, 0.12);
        }
        .project-field::placeholder {
            color: #94a3b8;
        }
        .project-label {
            margin-bottom: 0.55rem;
            display: block;
            font-size: 0.92rem;
            font-weight: 600;
            color: #334155;
        }
        .project-secondary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 1px solid #dbe3ee;
            background: #ffffff;
            padding: 0.9rem 1.25rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: #334155;
            text-decoration: none;
            transition: border-color 0.2s ease, background 0.2s ease, color 0.2s ease;
        }
        .project-secondary-btn:hover {
            border-color: #f16529;
            background: #fff7f2;
            color: #f16529;
        }
        .project-primary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 1px solid #f16529;
            background: #f16529;
            padding: 0.9rem 1.25rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
            transition: background 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }
        .project-primary-btn:hover {
            background: #d65420;
            border-color: #d65420;
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div>
            <h1 class="text-4xl font-display text-slate-950">Soumettre un projet</h1>
            <p class="mt-2 text-sm text-slate-500">Renseigne ton besoin. L'administrateur pourra le valider puis mettre a jour son avancement depuis le dashboard.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.projects.store') }}" class="project-form-shell p-6 md:p-8 space-y-6">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="project-label">Titre du projet</label>
                    <input type="text" name="titre" value="{{ old('titre') }}" required class="project-field">
                </div>
                <div>
                    <label class="project-label">Type</label>
                    <input type="text" name="type" value="{{ old('type') }}" placeholder="Web, Desktop, API..." required class="project-field">
                </div>
            </div>

            <div>
                <label class="project-label">Description</label>
                <textarea name="description" rows="6" required class="project-field">{{ old('description') }}</textarea>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="project-label">Complexite estimee (1-100)</label>
                    <input type="number" name="complexite" min="1" max="100" value="{{ old('complexite', 50) }}" required class="project-field">
                </div>
                <div>
                    <label class="project-label">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Laravel, Vue, API..." class="project-field">
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="project-label">Lien du projet</label>
                    <input type="url" name="lien" value="{{ old('lien') }}" class="project-field">
                </div>
                <div>
                    <label class="project-label">Lien GitHub</label>
                    <input type="url" name="github" value="{{ old('github') }}" class="project-field">
                </div>
            </div>

            <div>
                <label class="project-label">Image ou chemin visuel</label>
                <input type="text" name="image" value="{{ old('image') }}" placeholder="images/projets/mon-projet.png ou URL" class="project-field">
            </div>

            @if($errors->any())
                <div class="rounded-2xl bg-red-50 px-4 py-3 text-sm text-red-700 border border-red-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('dashboard') }}" class="project-secondary-btn">Retour</a>
                <button type="submit" class="project-primary-btn">Envoyer le projet</button>
            </div>
        </form>
    </div>
@endsection
