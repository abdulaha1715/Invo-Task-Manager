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
                                <th class="border py-2 w-40">Priority</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($tasks as $task)
                                <tr>
                                    <td class="border py-2 w-8 text-center">
                                        {{ $task->id }}
                                    </td>
                                    <td class="border py-2 text-left px-2 relative">
                                        <a href="{{ route('task.show', $task->slug) }}" class="text-base font-bold hover:text-emerald-600">{{ $task->name }}</a>

                                        @php
                                            $startdate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->setTimezone('Asia/Dhaka');
                                            $enddate = $task->end_date;

                                            // Time Left Calculation
                                            if ($enddate > $startdate) {
                                                $days = $startdate->diffInDays($enddate);
                                                $hours = $startdate->copy()->addDays($days)->diffInHours($enddate);
                                                $minutes = $startdate->copy()->addDays($days)->addHours($hours)->diffInMinutes($enddate);
                                            } else {
                                                $days = 0;
                                                $hours = 0;
                                                $minutes = 0;
                                            }

                                            // Bar Color And Percent
                                            if($task->end_date > Carbon\carbon::now() && $task->status != 'complete') {
                                                if ($days == 1) {
                                                    $persen = 95;
                                                    $color = 'bg-red-700';
                                                }elseif ($days < 3) {
                                                    $persen = 75;
                                                    $color = 'bg-red-600';
                                                }elseif ($days < 5) {
                                                    $persen = 60;
                                                    $color = 'bg-red-400';
                                                }elseif ($days < 6) {
                                                    $persen = 40;
                                                    $color = 'bg-red-300';
                                                } else {
                                                    $persen = 100;
                                                    $color = 'bg-green-300';
                                                }
                                            } else {
                                                $persen = 100;
                                                $color = 'bg-red-500';
                                            }

                                        @endphp

                                        @if ($task->status == 'pending')
                                        <div class="counter-class border-t py-1 mt-2 flex justify-end space-x-2 task-{{ $task->id }}"
                                            data-date="{{ $task->end_date }}">
                                            @if ($enddate > $startdate && $task->status == 'pending')
                                                <p>{{ $days != 0 ? $days . ' Days,' : '' }} {{ $days != 0 && $hours != 0 ? $hours . ' Hours' : '' }} {{ $minutes . ' Minutes' }}</p>
                                            @else
                                                <div class="text-sm">
                                                    {{ $task->status == 'pending' ? 'Time Over Due!' : '' }}</div>
                                            @endif

                                        </div>
                                        @endif

                                        @if ($task->status == 'complete')
                                            <div class="absolute h-1 w-full z-10 bg-green-600 left-0 bottom-0"></div>
                                        @else
                                            <div class="absolute h-1 z-10 left-0 bottom-0 {{ $color }}"
                                                style="width: {{ $persen }}%;"></div>
                                        @endif

                                        <div class="absolute h-1 w-full bg-slate-400 left-0 bottom-0"></div>
                                    </td>
                                    <td class="border py-2 text-center">
                                        <a class="hover:text-emerald-500 text-sm" href="{{ route('invoice.index') }}?client_id={{ $task->client->id }}">{{ $task->client->name }}</a>
                                    </td>
                                    <td class="border py-2 text-center text-sm">
                                        {{ $task->price }}
                                    </td>
                                    <td class="border py-2 px-2 text-center capitalize text-sm">
                                        {{ $task->status }}

                                        @if ($task->status == 'pending')
                                            <form action="{{ route('markAsComplete', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-white w-full bg-green-500 px-3 py-1">Complete</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="border py-2 text-center text-sm capitalize">
                                        {{ $task->priority }}
                                    </td>
                                    <td class="border py-2 px-2 text-center">
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

                            @empty
                                <tr>
                                    <td colspan="7" class="border py-6 text-center text-xl">No Tasks Found!</td>
                                </tr>
                            @endforelse

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
