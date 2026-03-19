<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-slate-950">
            {{ __('Supprimer le compte') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Cette action est irreversible. Toutes les donnees liees a ton compte seront supprimees definitivement.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-full bg-red-600 hover:bg-red-500"
    >{{ __('Supprimer le compte') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-slate-950">
                {{ __('Es-tu sur de vouloir supprimer ton compte ?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Entre ton mot de passe pour confirmer la suppression definitive de ton compte.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 rounded-2xl border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-red-500 focus:ring-red-500"
                    placeholder="{{ __('Mot de passe') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Supprimer le compte') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
