<x-app-layout>
    <x-slot name="header">

    </x-slot>


    @php
        function getImageUrl($image) {
            if(str_starts_with($image, 'http')) {
                return $image;
            }
            return asset('storage/uploads') . '/' . $image;
        }
    @endphp

    <div class="py-10">
        <div class="max-w-5xl mx-auto">
            <div class="">
                <div class="py-36 relative bg-black bg-opacity-50 bg-blend-overlay bg-cover bg-no-repeat bg-center mb-10"
                    style="background-image: url('https://picsum.photos/1024/400')">

                    <div class="absolute bottom-5 left-5 flex space-x-5">
                        <div class=" w-28 h-28 bg-center bg-cover rounded-full "
                            style="background-image: url({{ getImageUrl($client->avatar) }})"></div>
                        <div class="">
                            <h1 class="text-white mt-5 text-lg">{{ $client->name }} <span class="text-xs">({{
                                    $client->username }})</span></h1>
                            <h2 class="text-white">{{ $client->country }}</h2>
                        </div>
                    </div>
                </div>

                <h2 class="text-white font-bold text-2xl">Summery</h2>

                <div class="">

                    <div class="grid grid-cols-4 gap-5 mt-6">
                        <x-card text="Total Tasks" route="{{ route('task.index') }}" :count="count($client->tasks)" class="bg-amber-300" />

                        <x-card text="Pending Tasks" route="{{ route('task.index') }}" :count="count($pending_tasks)" class="bg-amber-300" />

                        <x-card text="Total Invoice" route="{{ route('invoice.index') }}" :count="count($client->invoices)" class="bg-amber-300" />

                        <x-card text="Paid Invoice" route="{{ route('invoice.index') }}" :count="count($paid_invoices)" class="bg-amber-300" />

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
