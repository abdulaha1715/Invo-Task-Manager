<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice Preview') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white border-t">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('invoice.pdf')
        </div>
    </div>
</x-app-layout>
