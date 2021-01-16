<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Please update your password') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('change.password') }}" enctype="multipart/form-data">
        @csrf

            <div>
                <x-label for="new_password" :value="__('New Password')" />

                <x-input id="new_password" class="block mt-1 w-full" type="password" name="new_password" :value="old('new_password')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Change Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
