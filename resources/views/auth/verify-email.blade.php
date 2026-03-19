<x-vitrineauth-layout title="Vérifier votre email">
    <div class="auth-header">
        <h1>Vérifier l'email</h1>
        <p>Confirmez votre adresse email pour continuer</p>
    </div>

    <div style="background: #e3f2fd; color: #1565c0; padding: 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; line-height: 1.6;">
        Un lien de vérification a été envoyé à votre adresse email. Vérifiez votre boîte de réception et suivez les instructions pour activer votre compte.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div style="background: #e8f5e9; color: #2e7d32; padding: 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; line-height: 1.6;">
            Un nouveau lien de vérification a été envoyé à l'adresse email fournie lors de votre inscription.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="auth-form">
        @csrf

        <div class="form-actions">
            <button type="submit" class="btn-primary-form">Renvoyer le lien</button>
        </div>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <div class="form-actions">
            <button type="submit" class="btn-outline-form">Se déconnecter</button>
        </div>
    </form>
</x-vitrineauth-layout>
