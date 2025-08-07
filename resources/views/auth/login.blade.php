{{-- Konten yang Anda berikan, dibungkus oleh x-guest-layout --}}
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-center text-green-600 font-medium" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        {{-- Email Address --}}
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#1B3C53] mb-2" />
            <x-text-input id="email"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 custom-input-focus"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-[#1B3C53] mb-2" />
            <x-text-input id="password"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 custom-input-focus"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-700">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-blue-500 transition-colors duration-200"
                    href="{{ route('password.request') }}">
                    {{ __('Lupa Kata Sandi Anda?') }}
                </a>
            @endif
        </div>

        {{-- Login Button --}}
        <div class="flex justify-center">
            <x-primary-button
                class="w-full justify-center py-3 text-lg font-semibold bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-blue-500 transition-all duration-300 shadow-md">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>