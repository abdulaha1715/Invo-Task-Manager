<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="">
        <div class="container mx-auto py-10">
            <div class="grid grid-cols-4 gap-5">

                <x-card text="Clients" :route="route('client.index')" :count="count($user->clients)" class="bg-gradient-to-tr from-teal-200 to-yellow-500 rounded-md"></x-card>

                <x-card text="Pending Tasks" route="{{ route('task.index') }}?status=pending" :count="count($pending_tasks)" class="bg-gradient-to-tl from-teal-200 to-yellow-500 rounded-md"></x-card>

                <x-card text="Completed Tasks" route="{{ route('task.index') }}?status=complete" :count="count($user->tasks) - count($pending_tasks)" class="bg-gradient-to-tr from-teal-200 to-yellow-500 rounded-md"></x-card>

                <x-card text="Due Invoice" route="{{ route('invoice.index') }}?status=unpaid" :count="count($unpaid_invoices)" class="bg-gradient-to-tl from-teal-200 to-yellow-500 rounded-md"></x-card>

            </div>
        </div>
    </div>

    <div class="">
        <div class="container mx-auto">
            <div class="flex space-x-10">
                <div class="prose max-w-none">
                    <h3>Todo:</h3>

                    <ul class="bg-slate-300 px-10 py-4 inline-block">
                        @forelse ($pending_tasks->slice(0,8) as $pending_task)
                            <li><a href="{{ route('task.show', $pending_task->slug) }}">{{ $pending_task->name }}</a></li>
                        @empty
                            <li>No Pending Tasks Found!</li>
                        @endforelse
                    </ul>
                </div>
                <div class="prose max-w-none">
                    <h3>Payment History:</h3>

                    <ul class="bg-amber-400 px-5 py-4">
                        @forelse ($paid_invoices->slice(0,8) as $paid_invoice)
                            <li class="flex justify-between space-x-10 items-center">
                                <span class="text-sm">{{ $paid_invoice->client->updated_at->format('d M, Y') }}</span>
                                <span>{{ $paid_invoice->client->name }}</span>
                                <span>${{ $paid_invoice->amount }}</span>
                            </li>
                        @empty
                            <li>No Paid Invoice Found!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
