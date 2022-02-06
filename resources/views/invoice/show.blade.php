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
                        <div class="flex justify-between">
                            <div>
                                <h1 class="text-4xl font-bold">Task Name : {{ $task->name }}</h1>
                                <h3 class="text-2xl font-bold my-2">Price :{{ $task->price }}</h3>
                                <h3 class="text-2xl font-bold">Client Name: {{ $task->client->name }}</h3>
                            </div>
                            <div class="items-center">
                                <div class="capitalize font-bold bg-amber-300 hover:bg-amber-400 transition-all text-white text-lg w-48 px-6 py-3 text-center mt-2 rounded-md inline-block">
                                    <p>{{ $task->status }}</p>
                                </div>

                                @if ($task->status == 'pending')
                                    <div class="">
                                        <form action="{{ route('markAsComplete', $task) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button class="capitalize font-bold bg-violet-400 hover:bg-violet-600 transition-all text-white text-base w-48 px-6 py-3 text-center mt-2 rounded-md inline-block cursor-pointer">Mark as Complate</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <h2 class="text-3xl font-bold mt-5 mb-3">Description</h2>

                        <div class="border my-4 p-5 text-lg prose max-w-none">
                            {!! $task->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
