<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice') }}
            </h2>
            <a href="{{ route('invoice.create') }}"class="border border-emerald-400 px-3 py-1">Add New</a>
        </div>
    </x-slot>

   @include('layouts.messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 py-10 px-10 bg-white overflow-hidden shadow-sm sm:rounded-lg {{ request('client_id') || request('status')  || request('emailSend') ? '' : 'hidden' }}" id="task_filter">
                <h2 class="font-bold mb-6 text-center">Filter Invoices </h2>
                <form action="{{ route('invoice.index') }}" method="GET">

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
                                <option value="paid" {{ old('status') == 'paid' || request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ old('status') == 'unpaid' || request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                        </div>

                        <div class="flex-1 mr-4">

                            @error('fromDate')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror

                            <label for="emailSend" class="formLabel">Email Send</label>

                            <select name="emailSend" id="emailSend" class="formInput">
                                <option value="">Select Status</option>
                                <option value="yes" {{ old('emailSend') == 'yes' || request('emailSend') == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('emailSend') == 'no' || request('emailSend') == 'no' ? 'selected' : '' }}>No</option>
                            </select>
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
                        <button type="submit" id="task_filter_trigger" class="px-4 py-3 text-white bg-green-400 mb-10">{{ request('client_id') || request('status')  || request('emailSend') ? 'Close Filter' : 'Filter' }}</button>
                    </div>

                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-1/6">Id</th>
                                <th class="border py-2 w-1/4">Client</th>
                                <th class="border py-2 w-1/6">Status</th>
                                <th class="border py-2 w-1/6">Email Send</th>
                                <th class="border py-2 px-2">Preview</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($invoices as $invoice)
                                <tr>
                                    <td class="border py-2 text-center">
                                        <a href="{{ asset('storage/invoices/' . $invoice->download_url)  }}" target="_blank" class="hover:text-sky-400" >{{ $invoice->invoice_id }}</a>
                                    </td>
                                    <td class="border py-2 text-center">
                                        <a class="hover:text-emerald-500 " href="{{ route('task.index') }}?client_id={{ $invoice->client->id }}">{{ $invoice->client->name }}</a>
                                    </td>
                                    <td class="border py-2 px-2 text-center capitalize">
                                        {{ $invoice->status }}

                                        <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" onsubmit="return confirm('Did you want to continue?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-white w-full capitalize bg-green-500 px-3 py-1">{{ $invoice->status == 'unpaid' ? 'paid' : 'unpaid' }}</button>
                                        </form>
                                    </td>
                                    <td class="border py-2 px-2 text-center capitalize">
                                        {{ $invoice->email_sent }}
                                        @if ($invoice->email_sent == 'no')
                                            <a href="{{ route('invoice.sendemail', $invoice) }}" class="text-white block w-full bg-emerald-500 px-3 py-1">Send Email</a>
                                        @endif
                                    </td>
                                    <td class="border py-2 text-center">
                                        <a href="{{ asset('storage/invoices/' . $invoice->download_url)  }}" target="_blank" class="text-white bg-sky-300 hover:bg-sky-400 transition-all px-3 py-1 mx-2" rel="noopener noreferrer">View</a>
                                    </td>
                                    <td class="border py-2 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Do you want to delete?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white bg-red-800 px-3 py-1">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border py-6 text-center text-xl">No Invoice Found!</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{ $invoices->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
