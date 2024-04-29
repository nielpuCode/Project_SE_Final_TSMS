<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
</head>
<body class="bg-[#F7EEDD] font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('sidebar')

        <!-- Main Content -->
        <div class="w-4/5 p-4 overflow-y-auto h-full bg-[#F7EEDD]">
            <h2 class="text-3xl font-bold mb-6">Order History</h2>
            <input type="text" class="w-2/3 bg-gray-200 rounded-md py-2 px-4 mb-4" id="searchInput" placeholder="Search Order">

            <div class="w-full flex flex-row gap-3 justify-center border-0 border-red-600 max-h flex-wrap cursor-default">
                @foreach($orders as $order)
                    <div class="shadow-md rounded-lg p-6 mb-4 order-item w-[600px] bg-white">
                        <div class="flex justify-between mb-4">
                            <div class="text-lg font-semibold">Order Name:</div>
                            <div class="text-lg font-semibold tracking-widest" style="background: linear-gradient(to right, #9900ff, #fd1d1d, #fcb045); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                {{ $order->order_name }}
                            </div>

                        </div>
                        <div class="flex justify-between mb-4">
                            <div class="text-lg font-semibold">Payed At:</div>
                            <div class="text-lg">{{ $order->created_at->format('d/m/Y') }}</div>
                        </div>
                        <div class="flex justify-between mb-4">
                            <div class="text-lg font-semibold">Total Price:</div>
                            <div class="text-lg font-bold text-green-600">$ {{ $order->total_amount_with_tax}}</div>
                        </div>
                        <div class="flex justify-between">
                            <div class="text-lg font-semibold">Payment Method:</div>
                            @if($order->payment_method === 'bca')
                                <div class="text-lg">BCA</div>
                            @elseif($order->payment_method === 'gopay')
                                <div class="text-lg">GoPay</div>
                            @elseif($order->payment_method === 'dana')
                                <div class="text-lg">Dana</div>
                            @elseif($order->payment_method === 'ovo')
                                <div class="text-lg">OVO</div>
                            @else
                            <div class="flex justify-between">
                                @php
                                    $paymentMethod = \App\Models\PaymentMethod::where('id', $order->payment_method)->first();
                                @endphp
                                @if($paymentMethod)
                                    <div class="text-lg">{{ $paymentMethod->name }}</div>
                                @else
                                    <div class="text-lg">N/A</div> <!-- Or any other default value -->
                                @endif
                            </div>

                            @endif
                        </div>


                        @if(auth()->user()->name === 'tsms' && auth()->user()->email === 'tsms@gmail.com')
                            <div class="flex justify-between mt-5">
                                <form action="{{ route('deleteOrder', $order->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">Complete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>

        </div>
    </div>
    <script>
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function () {
            const searchText = searchInput.value.toLowerCase();
            const orderItems = document.getElementsByClassName('order-item');
            for (let item of orderItems) {
                const orderName = item.querySelector('.text-lg:nth-child(2)').textContent.toLowerCase();
                if (orderName.includes(searchText)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>
