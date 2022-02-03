<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Task') }}
            </h2>
            <a href="{{ route('task.index') }}"class="border border-emerald-400 px-3 py-1">Back</a>
        </div>
    </x-slot>

   @include('layouts.messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="">
                        <h1 class="text-4xl font-bold">Task Name : {{ $task->name }}</h1>
                        <h3 class="text-2xl font-bold my-2">Price :{{ $task->price }}</h3>
                        <h3 class="text-2xl font-bold">Client Name: {{ $task->client->name }}</h3>

                        <h2 class="text-3xl font-bold mt-5 mb-3">Description</h2>

                        <div class="border my-4 p-5 text-lg">
                            {!! $task->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
