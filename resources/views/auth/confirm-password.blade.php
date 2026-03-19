<x-vitrineauth-layout title="Confirmer le mot de passe">
    <div class="auth-header">
        <h1>Confirmer votre identité</h1>
        <p>Entrez votre mot de passe pour sécuriser cette action</p>
    </div>

    <div style="background: #fff3e0; color: #e65100; padding: 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; line-height: 1.6;">
        C'est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <!-- Password -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary-form">Confirmer</button>
        </div>
    </form>
</x-vitrineauth-layout>
