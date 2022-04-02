<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User') }}
            </h2>
            <a href="{{ route('users.create') }}"class="border border-emerald-400 px-3 py-1">Add New</a>
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
                                <th class="border py-2 w-12">Id</th>
                                <th class="border py-2">thumbnail</th>
                                <th class="border py-2">Name</th>
                                <th class="border py-2 w-20">email</th>
                                <th class="border py-2 w-32">company</th>
                                <th class="border py-2 w-32">phone</th>
                                <th class="border py-2 w-32">country</th>
                                <th class="border py-2 w-32">Role</th>
                                <th class="border py-2 w-32">Verified</th>
                                <th class="border py-2 min-w-max px-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                function getImageUrl($image) {
                                    if(str_starts_with($image, 'http')) {
                                        return $image;
                                    }
                                    return asset('storage/uploads') . '/' . $image;
                                }
                            @endphp

                            @forelse ($users as $user)
                                <tr>
                                    <td class="border py-2 w-8 text-center">
                                        {{ $user->id }}
                                    </td>
                                    <td class="border py-2 text-center text-sm">
                                        <img src="{{ getImageUrl($user->thumbnail) }}" width="80" class="mx-auto rounded" alt="">
                                    </td>
                                    <td class="border py-2 text-center text-sm capitalize">
                                        {{ $user->name }}
                                    </td>
                                    <td class="border py-2 text-center text-sm capitalize">
                                        {{ $user->email }}
                                    </td>
                                    <td class="border py-2 text-center text-sm capitalize">
                                        {{ $user->company }}
                                    </td>
                                    <td class="border py-2 text-center text-sm capitalize">
                                        {{ $user->phone }}
                                    </td>
                                    <td class="border py-2 text-center text-sm capitalize">
                                        {{ $user->country }}
                                    </td>
                                    <td class="border py-2 text-center text-sm capitalize">
                                        {{ $user->role }}
                                    </td>
                                    <td class="border py-2 text-center text-sm capitalize">{{ $user->hasVerifiedEmail() ? 'Yes' : 'No' }}</td>
                                    <td class="border py-2 px-3 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="border-2 bg-purple-500 text-white hover:bg-transparent hover:text-black transition-all duration-300 px-3 py-1 mr-2">Edit</a>

                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Do you really want to delete?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="border-2 bg-red-500 text-white hover:bg-transparent hover:text-black transition-all duration-300 px-3 py-1 mr-2">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border py-6 text-center text-xl">No Client Found!</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
