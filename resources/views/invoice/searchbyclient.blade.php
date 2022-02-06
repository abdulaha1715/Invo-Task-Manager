<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                    {{ $client->name }}
                    {{ __('Tasks List') }}
                </h2>
                <p class="text-xl">{{ $client->email }}</p>
                <p class="text-xl">{{ $client->phone }}</p>
                <p class="text-xl">{{ $client->country }}</p>
            </div>

            <a href="{{ route('client.index') }}"class="border border-emerald-400 px-3 py-1">Back</a>
        </div>
    </x-slot>

   @include('layouts.messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-8">Id</th>
                                <th class="border py-2">Name</th>
                                <th class="border py-2">Price</th>
                                <th class="border py-2">Status</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ( $client->tasks as $task)
                                <tr>
                                    <td class="border py-2 w-8 text-center">
                                        {{ $task->id }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $task->name }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $task->price }}
                                    </td>
                                    <td class="border py-2 text-center capitalize">
                                        {{ $task->status }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('task.edit', $task->id) }}" class="text-white bg-emerald-800 px-3 py-1 mr-2">Edit</a>

                                            <a href="{{ route('task.show', $task->slug) }}" class="text-white bg-blue-800 px-3 py-1 mr-2">View</a>

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
                        {{-- {{ $tasks->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
