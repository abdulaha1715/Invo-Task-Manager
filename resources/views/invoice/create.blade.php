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

                    <form action="{{ route('invoice.create') }}" method="GET" enctype="multipart/form-data">
                        @csrf

                        <div class="flex mt-6 justify-between items-end">
                            <div class="flex-1 mr-4">

                                @error('client_id')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror

                                <label for="client_id" class="formLabel">Client Name</label>

                                <select name="client_id" id="client_id" class="formInput">
                                    <option value="none">Select Client</option>
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
                                    <option value="none">Select Status</option>
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
                                <input type="date" id="endDate" name="endDate" class="formInput" value="{{ request('endDate') !='' ? request('endDate') : now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="flex-1 mr-4">
                                <button type="submit" class="px-8 py-3 text-base uppercase bg-emerald-600 hover:bg-emerald-700 text-white rounded-md transition-all">Search</button>
                            </div>
                        </div>
                    </form>

                    @if ($tasks)
                    <div class="mt-10">
                        <form action="{{ route('invoice') }}" method="GET" id="tasksInvoiceForm">
                        @csrf
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th class="border py-2 w-1/6">Select</th>
                                        <th class="border py-2 w-1/6">Id</th>
                                        <th class="border py-2 w-1/6">Name</th>
                                        <th class="border py-2 w-1/4">Client</th>
                                        <th class="border py-2 w-1/5">Status</th>
                                    </tr>
                                </thead>
                                <tbody>


                                        @foreach ($tasks as $task)
                                            <tr>
                                                <td class="border py-2 text-center">
                                                    <input type="checkbox" name="invoices_ids[]" value="{{ $task->id }}" checked >
                                                </td>
                                                <td class="border py-2 text-center">
                                                    {{ $task->id }}
                                                </td>
                                                <td class="border py-2 text-center">
                                                    {{ $task->name }}
                                                </td>
                                                <td class="border py-2 text-center">
                                                    {{ $task->client->name }}
                                                </td>
                                                <td class="border py-2 text-center capitalize">
                                                    {{ $task->status }}
                                                </td>
                                            </tr>
                                        @endforeach

                                </tbody>
                            </table>
                            <div class="mt-6 flex justify-between ">
                                <div class="flex space-x-3">
                                    <div class="">
                                        <label for="discount">Discount </label>
                                        <input type="number" name="discount" id="discount" placeholder="Tyoe discount">
                                    </div>

                                    <div class="">
                                        <select name="discount_type" id="discount_type">
                                            <option value="%">%</option>
                                            <option value="$">$</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <div class="flex mt-5 mb-6 justify-center space-x-5">
                                        <button type="submit" form="tasksInvoiceForm" name="preview" value="yes" class="px-3 py-2 bg-teal-500 text-white">Preview</button>

                                        <button type="submit" form="tasksInvoiceForm" name="generate" value="yes" class="px-3 py-2 bg-blue-500 text-white">Generate PDF</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
