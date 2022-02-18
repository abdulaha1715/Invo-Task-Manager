<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            <a href="{{ route('task.create') }}"class="border border-emerald-400 px-3 py-1">Add New</a>
        </div>
    </x-slot>

   @include('layouts.messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 py-10 px-10 bg-white overflow-hidden shadow-sm sm:rounded-lg {{ request('client_id') || request('price')  || request('status')  || request('fromDate')  || request('endDate') ? '' : 'hidden' }}" id="task_filter">
                <h2 class="font-bold mb-6 text-center">Filter Tasks </h2>
                <form action="{{ route('task.index') }}" method="GET">

                    <div class="flex mt-6 justify-between items-end mb-10">
                        <div class="flex-1 mr-4">

                            @error('client_id')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror

                            <label for="client_id" class="formLabel">Client Name</label>

                            <select name="client_id" id="client_id" class="formInput">
                                <option value="">Select Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id || request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="flex-1 mr-4">

                            @error('status')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror

                            <label for="status" class="formLabel">Select Status</label>

                            <select name="status" id="status" class="formInput">
                                <option value="">Select Status</option>
                                <option value="pending" {{ old('status') == 'pending' || request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="complete" {{ old('status') == 'complete' || request('status') == 'complete' ? 'selected' : '' }}>Complete</option>
                            </select>
                        </div>

                        <div class="flex-1 mr-4">

                            @error('fromDate')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror

                            <label for="fromDate" class="formLabel">Start Date</label>
                            <input type="date" id="fromDate" name="fromDate" class="formInput" value="{{ request('fromDate') }}" max="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="flex-1 mr-4">

                            @error('endDate')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror

                            <label for="endDate" class="formLabel">End Date</label>
                            <input type="date" id="endDate" name="endDate" class="formInput" value="{{ request('endDate') !='' ? request('endDate') : ''}}" max="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="flex-1 mr-4">

                            @error('endDate')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror

                            <label for="price" class="formLabel">Max Price</label>
                            <input type="number" id="price" name="price" class="formInput" value="{{ request('price') }}">
                        </div>


                        <div class="flex-1 mr-4">
                            <button type="submit" class="px-8 py-3 font-bold text-base uppercase bg-emerald-600 hover:bg-emerald-700 text-white rounded-md transition-all">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="text-right">
                        <button type="submit" id="task_filter_trigger" class="px-4 py-3 text-white bg-green-400 mb-10">{{ request('client_id') || request('price')  || request('status')  || request('fromDate')  || request('endDate') ? 'Close Filter' : 'Filter' }}</button>
                    </div>

                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-12">Id</th>
                                <th class="border py-2">Name</th>
                                <th class="border py-2">Client</th>
                                <th class="border py-2 w-20">Price</th>
                                <th class="border py-2 w-40">Status</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="border py-2 w-8 text-center">
                                        {{ $task->id }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        <a href="{{ route('task.show', $task->slug) }}" class="text-base font-bold hover:text-emerald-600">{{ $task->name }}</a>
                                    </td>
                                    <td class="border py-2 text-center">
                                        <a class="text-emerald-500 hover:underline text-sm" href="{{ route('searchTaskByClient',$task->client) }}">{{ $task->client->name }}</a>
                                    </td>
                                    <td class="border py-2 text-center text-sm">
                                        {{ $task->price }}
                                    </td>
                                    <td class="border py-2 text-center capitalize text-sm">
                                        {{ $task->status }}
                                    </td>
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
