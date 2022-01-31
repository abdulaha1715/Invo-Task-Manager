<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Clients') }}
            </h2>
            <a href="{{ route('client.create') }}"class="border border-emerald-400 px-3 py-1">Add New</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-8">Id</th>
                                <th class="border py-2 w-32">Avatar</th>
                                <th class="border py-2">Name</th>
                                <th class="border py-2">Username</th>
                                <th class="border py-2">Phone</th>
                                <th class="border py-2">Email</th>
                                <th class="border py-2">Country</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="border py-2 w-8 text-center">
                                        {{ $client->id }}
                                    </td>
                                    <td class="border py-2 w-32 text-center">
                                        <img src="{{ $client->avatar }}" width="80" class="mx-auto rounded" alt="">
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $client->name }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $client->username }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $client->phone }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $client->email }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $client->country }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        <a href="#" class="text-white bg-emerald-800 px-3 py-1">Edit</a>
                                        <a href="#" class="text-white bg-red-800 px-3 py-1">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
