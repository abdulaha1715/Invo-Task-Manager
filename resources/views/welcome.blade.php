<x-guest-layout>
    <div class="flex justify-between items-center flex-col h-screen relative">

        <div class="text-center flex-1 absolute top-2/4 -translate-y-2/4">
            <div class="flex items-center space-x-3 mb-2">
                <img src="{{ asset('img/invo-mate.png') }}" class="w-20" alt="">
            <h2 class="font-bold text-6xl">INVO</h2>
            </div>
            <h3 class="text-xl">freelancer invoice helper</h3>
           <div class="flex space-x-3">
            <a href="{{ route('login') }}"
            class="border border-orange-400 px-5 py-1 mt-3 hover:bg-orange-400 transition-all duration-300 hover:text-white inline-block">Login</a>
            <a href="{{ route('register') }}"
            class="border border-orange-400 px-5 py-1 mt-3 hover:bg-orange-400 transition-all duration-300 hover:text-white inline-block">Register</a>
           </div>
        </div>

    </div>
</x-guest-layout>
