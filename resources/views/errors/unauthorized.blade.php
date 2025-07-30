<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akses Ditolak') }}
        </h2>
    </x-slot>

    <div class="py-12 text-center">
        <h1 class="text-2xl font-bold text-red-600 mb-4">Anda tidak boleh mengakses halaman ini</h1>
        <p class="text-gray-600">Silakan kembali ke halaman sebelumnya</p>
    </div>
</x-app-layout>
