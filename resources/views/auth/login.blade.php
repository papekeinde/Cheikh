<x-vitrineauth-layout title="Se connecter">
    <div class="auth-header">
        <h1>Connexion</h1>
        <p>Accédez à votre espace personnel</p>
    </div>

    @if (session('status'))
        <div style="background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="vous@exemple.com">
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <div class="checkbox-group">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Se souvenir de moi</label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary-form">Se connecter</button>
        </div>

        <div class="form-link">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Mot de passe oublié?</a>
            @endif
            <br>
            Pas encore inscrit? <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </form>
</x-vitrineauth-layout>
