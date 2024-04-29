{{-- payment/payment.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('sidebar')

        <!-- Main Content -->
        <div class="w-4/5 p-4">
            @php
                $taxAmount = $totalAmount * 0.05;
                $totalAmountWithTax = $totalAmount + $taxAmount;
            @endphp

            <form action="{{ route('storeOrder') }}" method="POST">
                @csrf
                <!-- Payment details -->
                <div class="border-0 border-red-600 flex flex-row justify-around items-center mb-4">
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h2 class="text-2xl text-center underline font-extrabold mb-4 bg-gray-300 py-2">Payment Details</h2>
                        <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
                        <input type="hidden" name="tax_amount" value="{{ $taxAmount }}">
                        <input type="hidden" name="total_amount_with_tax" value="{{ $totalAmountWithTax }}">
                        <p><span class="font-semibold">Order ID:</span> {{ auth()->id() }}</p>
                        <p><span class="font-semibold">Payment Method:</span> Transfer</p>
                        <p><span class="font-semibold">Total Amount:</span> ${{ number_format($totalAmount, 2) }}</p>
                        <p><span class="font-semibold">Tax (5%):</span> ${{ number_format($taxAmount, 2) }}</p>
                        <p class="font-extrabold text-green-400"><span class="font-semibold text-black">Total Amount with Tax:</span> ${{ number_format($totalAmountWithTax, 2) }}</p>

                        <!-- Payment Option -->
                        <div class="bg-gray-200 p-4 shadow-md rounded-lg mt-4 min-w-1/2">
                            <h2 class="text-lg font-semibold mb-2">Payment Option</h2>
                            <div class="relative">
                                <select name="payment_method" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Payment Method</option>
                                    @foreach($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9 11l4-4 4 4m-4-4v14"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Confirm button -->
                    <div class="mt-4 flex flex-col gap-y-5 border-0 border-red-700 items-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Confirm Payment</button>
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">Cancel</button>
                    </div>
                </div>
            </form>


            <!-- Cart items -->
            <div class="bg-white p-4 shadow-md rounded-lg">
                <h2 class="text-lg font-semibold mb-2">Cart Items</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <!-- Table header -->
                        <thead>
                            <tr>
                                <th class="p-2 border-b">Name</th>
                                <th class="p-2 border-b">Quantity</th>
                                <th class="p-2 border-b">Price</th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody>
                            @foreach($cartItems as $cartItem)
                                <tr>
                                    <td class="p-2 border-b">{{ $cartItem->component->name }}</td>
                                    <td class="p-2 border-b">{{ $cartItem->quantity }}</td>
                                    <td class="p-2 border-b">${{ number_format($cartItem->quantity * $cartItem->component->price, 0, '.', ',') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
