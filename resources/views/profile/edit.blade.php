@extends('layouts.tailadmin')

@section('title', 'Mon profil')

@push('styles')
    <style>
        .profile-grid {
            display: grid;
            gap: 1.5rem;
        }
        .profile-card {
            padding: 1.75rem;
            border-radius: 2rem;
            border: 1px solid #fed7c3;
            background: linear-gradient(180deg, rgba(255, 247, 242, 0.88) 0%, #ffffff 22%, #ffffff 100%);
            box-shadow: 0 28px 72px -52px rgba(241, 101, 41, 0.34);
        }
        .profile-card__inner {
            max-width: 42rem;
        }
    </style>
@endpush

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div>
            <h1 class="text-4xl font-display text-slate-950">Mon profil</h1>
            <p class="mt-2 text-sm text-slate-500">Mets a jour tes informations, ton mot de passe et les reglages sensibles de ton compte.</p>
        </div>

        <div class="profile-grid">
            <div class="profile-card">
                <div class="profile-card__inner">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card__inner">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card__inner">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
