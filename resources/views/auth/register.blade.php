<x-vitrineauth-layout title="Créer un compte">
    <div class="auth-header">
        <h1>Inscription</h1>
        <p>Rejoignez notre communauté</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Nom -->
        <div class="form-group">
            <label for="nom">Nom complet</label>
            <input id="nom" type="text" name="nom" value="{{ old('nom') }}" required autofocus autocomplete="name" placeholder="Votre nom complet">
            @error('nom')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="vous@exemple.com">
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            @error('password_confirmation')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary-form">S'inscrire</button>
        </div>

        <div class="form-link">
            Vous avez déjà un compte? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </form>
</x-vitrineauth-layout>
