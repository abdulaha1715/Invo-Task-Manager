<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Client') }}
            </h2>
            <a href="{{ route('client.index') }}"class="border border-emerald-400 px-3 py-1">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('client.update', $client->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex mt-6">
                            <div class="flex-1 mr-4">
                                <label for="name" class="formLabel">Name</label>
                                <input type="text" name="name" class="formInput" value="{{ $client->name }}">

                                @error('name')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex-1 mr-4">
                                <label for="username" class="formLabel">Username</label>
                                <input type="text" name="username" class="formInput" value="{{ $client->username }}">

                                @error('username')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex mt-6">
                            <div class="flex-1 mr-4">
                                <label for="email" class="formLabel">Email</label>
                                <input type="email" name="email" class="formInput" value="{{ $client->email }}">

                                @error('email')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex-1 mr-4">
                                <label for="phone" class="formLabel">Phone</label>
                                <input type="tel" name="phone" class="formInput" value="{{ $client->phone }}">

                                @error('phone')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex mt-6 justify-between">
                            <div class="flex-1">
                                <label for="country" class="formLabel">Country</label>
                                <input type="text" name="country" class="formInput" value="{{ $client->country }}">

                                @error('country')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex-1 mx-5">
                                <label for="status" class="formLabel">Status</label>
                                <select name="status" id="status" class="formInput">
                                    <option value="none" {{ $client->status == 'none' ? 'selected' : '' }}>Select Status</option>
                                    <option value="active" {{ $client->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $client->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>

                                @error('status')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex-1">
                                <label for="avatar" class="formLabel">Avatar</label>
                                <label for="avatar" class="formLabel border-2 rounded-md border-dashed border-emerald-700 py-4 text-center">Click
                                    to upload image</label>
                                <input type="file" name="avatar" id="avatar" class="formInput hidden">

                                @error('avatar')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror

                                @php
                                    function getImageUrl($image) {
                                        if(str_starts_with($image, 'http')) {
                                            return $image;
                                        }
                                        return asset('storage/uploads') . '/' . $image;
                                    }
                                @endphp

                                <div class="w-full">
                                    <img src="{{ getImageUrl($client->avatar) }}" alt="" class="rounded w-28 h-28">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-8 py-2 text-base uppercase bg-emerald-600 hover:bg-emerald-700 text-white rounded-md transition-all">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
