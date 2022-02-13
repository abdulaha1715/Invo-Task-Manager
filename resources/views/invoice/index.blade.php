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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-1/6">Id</th>
                                <th class="border py-2 w-1/4">Client</th>
                                <th class="border py-2 w-1/5">Status</th>
                                <th class="border py-2 w-1/6">Download</th>
                                <th class="border py-2 w-1/3">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($invoices as $invoice)
                                <tr>
                                    <td class="border py-2 text-center">
                                        {{ $invoice->invoice_id }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        {{ $invoice->client->name }}
                                    </td>
                                    <td class="border py-2 text-center capitalize">
                                        {{ $invoice->status }}
                                    </td>
                                    <td class="border py-2 text-center">
                                        <a href="{{ asset('storage/invoices/' . $invoice->download_url)  }}" target="_blank" class="text-white bg-sky-300 hover:bg-sky-400 transition-all px-3 py-1 mr-2" rel="noopener noreferrer">Download PDF</a>
                                    </td>
                                    <td class="border py-2 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if ($invoice->status == 'unpaid')
                                                <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" onsubmit="return confirm('Did you get Paid?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-white bg-green-500 px-3 py-1">Paid</button>
                                                </form>
                                            @endif

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
                                    <td colspan="5" class="border py-6 text-center text-xl">No Invoice Found!</td>
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
