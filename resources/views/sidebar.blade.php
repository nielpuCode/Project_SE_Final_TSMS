{{-- welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SE TSMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Sidebar -->
<div class="w-1/5 bg-gradient-to-r from-[#008DDA] via-[#41C9E2] to-[#ACE2E1] p-4">
    <ul>
        <li class="py-2">
            <button class="w-full bg-white/50 hover:bg-[#0E46A3] font-bold text-black hover:text-white rounded-md py-2 px-4">
                <a href="{{ route('showCompComponents') }}">Home</a>
            </button>
        </li>

        @auth
        <li class="py-2">
            <button class="w-full bg-white/50 hover:bg-[#0E46A3] font-bold text-black hover:text-white rounded-md py-2 px-4">
                <a href="{{ route('showCart') }}">Cart</a>
            </button>
        </li>

        <li class="py-2">
            <button class="w-full bg-white/50 hover:bg-[#0E46A3] font-bold text-black hover:text-white rounded-md py-2 px-4">
                <a href="{{ route('showOrders') }}">Order</a>
            </button>
        </li>

        <li class="py-2">
            @if(auth()->check() && auth()->user()->email === 'tsms@gmail.com' && auth()->user()->name === 'tsms')
                <!-- Admin button -->
                <button class="w-full bg-white/50 hover:bg-[#0E46A3] font-bold text-black hover:text-white rounded-md py-2 px-4">
                    <a href="{{ route('payment-methods.index') }}">Payment</a>
                </button>
            @else
                <!-- Normal user button -->
                <button class="w-full bg-white/50 hover:bg-[#0E46A3] font-bold text-black hover:text-white rounded-md py-2 px-4">
                    <a href="{{ route('showCart') }}">Payment</a>
                </button>
            @endif
        </li>

        @endauth

        @guest
        <li class="py-2">
            <button class="w-full bg-white/50 hover:bg-[#0E46A3] font-bold text-black hover:text-white rounded-md py-2 px-4 text-center"><a href="{{ route('login') }}">Login?</a></button>
        </li>
        @else
        <li class="py-2">
            <button class="w-full bg-white/50 hover:bg-[#0E46A3] font-bold text-black hover:text-white rounded-md py-2 px-4 font-extrabold text-yellow-700"><a href="{{ route('account.edit') }}">{{ Auth::user()->name }}</a></button>
        </li>
        @endguest
    </ul>
</div>




</body>
</html>
