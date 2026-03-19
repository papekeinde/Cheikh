<section>
    <header>
        <h2 class="text-lg font-medium text-slate-950">
            {{ __('Mettre a jour le mot de passe') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Utilise un mot de passe long et unique pour mieux securiser ton compte.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" class="text-slate-700" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-[#F16529] focus:ring-[#F16529]" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" class="text-slate-700" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-[#F16529] focus:ring-[#F16529]" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmation du mot de passe')" class="text-slate-700" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-[#F16529] focus:ring-[#F16529]" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-full bg-[#F16529] text-slate-950 hover:bg-[#d65420] focus:ring-[#F16529] active:bg-[#d65420] dark:bg-[#F16529] dark:text-slate-950 dark:hover:bg-[#d65420]">{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
