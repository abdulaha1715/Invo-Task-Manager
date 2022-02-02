<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            <a href="{{ route('task.create') }}"class="border border-emerald-400 px-3 py-1">Add New</a>
        </div>
    </x-slot>

    @if (Session('success'))
        <div id="status_message" class="py-2 bg-emerald-200 text-emerald-700 text-center">
            <p>{{ Session('success') }}</p>
        </div>
    @endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-8">Id</th>
                                <th class="border py-2">Name</th>
                                <th class="border py-2">Client</th>
                                <th class="border py-2">Price</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                                function getImageUrl($image) {
                                    if(str_starts_with($image, 'http')) {
                                        return $image;
                                    }
                                    return asset('storage/uploads') . '/' . $image;
                                }
                            @endphp --}}

                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="border py-2 w-8 text-center">
                                        {{ $task->id }}
                                    </td>
                                    {{-- <td class="border py-2 w-32 text-center">
                                        <img src="{{ getImageUrl($client->avatar) }}" width="80" class="mx-auto rounded" alt="">
                                    </td> --}}
                                    <td class="border py-2 text-center">
                                        {{ $task->name }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $task->client->name }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $task->price }}
                                    </td>
                                    {{-- <td class="border py-2 text-center">
                                        {{ $client->email }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $client->phone }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $client->country }}
                                    </td> --}}
                                    <td class="border py-2 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('task.edit', $task->id) }}" class="text-white bg-emerald-800 px-3 py-1 mr-2">Edit</a>
                                            <form action="{{ route('task.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Do you want to delete?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white bg-red-800 px-3 py-1">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>