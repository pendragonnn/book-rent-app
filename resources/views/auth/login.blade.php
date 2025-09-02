<x-guest-layout>
    <x-auth-session-status class="mb-4 text-center text-[#2F1E12] font-medium" :status="session('status')" />
    {{-- Define the title for the browser tab --}}
    <x-slot:title>
        {{ __('Login') }} - {{ config('app.name') }}
    </x-slot>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        {{-- Email Address --}}
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#442C1D] mb-2" />
            <x-text-input id="email"
                class="block w-full rounded-md border-[#D4C3B2] shadow-sm focus:border-[#C88A21] focus:ring-[#C88A21] custom-input-focus"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-[#442C1D] mb-2" />
            <x-text-input id="password"
                class="block w-full rounded-md border-[#D4C3B2] shadow-sm focus:border-[#C88A21] focus:ring-[#C88A21] custom-input-focus"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-[#D4C3B2] text-[#442C1D] shadow-sm focus:ring-[#C88A21]" name="remember">
                <span class="ms-2 text-sm text-[#6B5A4B]">{{ __('Remember Me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-[#C88A21] hover:text-[#9E6C36] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-[#C88A21] transition-colors duration-200"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        {{-- Login Button --}}
        <div class="flex justify-center">
            <x-primary-button
                class="w-full justify-center py-3 text-lg font-semibold bg-[#442C1D] hover:bg-[#6B5A4B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-[#C88A21] transition-all duration-300 shadow-md">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>