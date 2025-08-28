<x-guest-layout>
    <x-slot:title>
        {{ __('Register') }} - {{ config('app.name') }}
    </x-slot>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-[#442C1D] mb-2" />
            <x-text-input id="name"
                class="block w-full rounded-md border-[#D4C3B2] shadow-sm focus:border-[#C88A21] focus:ring-[#C88A21] custom-input-focus"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-[#442C1D] mb-2" />
            <x-text-input id="email"
                class="block w-full rounded-md border-[#D4C3B2] shadow-sm focus:border-[#C88A21] focus:ring-[#C88A21] custom-input-focus"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-[#442C1D] mb-2" />
            <x-text-input id="password"
                class="block w-full rounded-md border-[#D4C3B2] shadow-sm focus:border-[#C88A21] focus:ring-[#C88A21] custom-input-focus"
                type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-[#442C1D] mb-2" />
            <x-text-input id="password_confirmation"
                class="block w-full rounded-md border-[#D4C3B2] shadow-sm focus:border-[#C88A21] focus:ring-[#C88A21] custom-input-focus"
                type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div class="flex items-center justify-center mt-6">
            <x-primary-button
                class="w-full justify-center py-3 text-lg font-semibold bg-[#442C1D] hover:bg-[#6B5A4B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-[#C88A21] transition-all duration-300 shadow-md">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>