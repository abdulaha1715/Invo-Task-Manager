<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Invoice') }}
            </h2>
            <a href="{{ route('invoice.index') }}"class="border border-emerald-400 px-3 py-1">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('invoice.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="flex mt-6 justify-between items-end">
                            <div class="flex-1 mr-4">
                                <label for="client_id" class="formLabel">Client Name</label>

                                <select name="client_id" id="client_id" class="formInput">
                                    <option value="none">Select Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                    @endforeach

                                </select>

                                @error('client_id')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 mr-4">
                                <label for="status" class="formLabel">Select Status</label>

                                <select name="status" id="status" class="formInput">
                                    <option value="none">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="complete">Complete</option>
                                </select>

                                @error('status')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 mr-4">
                                <label for="fromdate" class="formLabel">Start Date</label>
                                <input type="date" id="fromdate" name="price" class="formInput" value="">

                                @error('status')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 mr-4">
                                <label for="todate" class="formLabel">To Date</label>
                                <input type="date" id="todate" name="price" class="formInput" value="{{ now()->format('Y-m-d') }}">

                                @error('status')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 mr-4">
                                <button type="submit" class="px-8 py-3 text-base uppercase bg-emerald-600 hover:bg-emerald-700 text-white rounded-md transition-all">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
