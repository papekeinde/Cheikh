<x-vitrineauth-layout title="Réinitialiser le mot de passe">
    <div class="auth-header">
        <h1>Mot de passe oublié</h1>
        <p>Entrez votre email pour réinitialiser votre mot de passe</p>
    </div>

    @if (session('status'))
        <div style="background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="vous@exemple.com">
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary-form">Envoyer le lien</button>
        </div>

        <div class="form-link">
            Vous vous êtes souvenu de votre mot de passe? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </form>
</x-vitrineauth-layout>
