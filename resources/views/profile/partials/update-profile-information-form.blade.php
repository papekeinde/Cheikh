<section>
    <header>
        <h2 class="text-lg font-medium text-slate-950">
            {{ __('Informations du profil') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Mets a jour les informations de ton compte et ton adresse email.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nom" :value="__('Nom')" class="text-slate-700" />
            <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-[#F16529] focus:ring-[#F16529]" :value="old('nom', $user->nom)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nom')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-[#F16529] focus:ring-[#F16529]" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-700">
                        {{ __('Ton adresse email n\'est pas encore verifiee.') }}

                        <button form="send-verification" class="underline text-sm text-[#F16529] hover:text-[#d65420] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F16529]">
                            {{ __('Clique ici pour renvoyer l\'email de verification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Un nouveau lien de verification a ete envoye a ton adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-full bg-[#F16529] text-slate-950 hover:bg-[#d65420] focus:ring-[#F16529] active:bg-[#d65420] dark:bg-[#F16529] dark:text-slate-950 dark:hover:bg-[#d65420]">{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-500"
                >{{ __('Enregistre.') }}</p>
            @endif
        </div>
    </form>
</section>
