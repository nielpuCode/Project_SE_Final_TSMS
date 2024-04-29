<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SE TSMS - Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        @include('sidebar')

        <!-- Main Content -->
        <div class="w-4/5 p-4 relative">
            <h1 class="text-2xl font-bold mb-8">Cart</h1>
            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-200 px-4 py-2">Picture</th>
                        <th class="border border-gray-200 px-4 py-2">Name</th>
                        <th class="border border-gray-200 px-4 py-2">Vendor</th>
                        <th class="border border-gray-200 px-4 py-2">Amount</th>
                        <th class="border border-gray-200 px-4 py-2">Price</th>
                        <th class="border border-gray-200 px-4 py-2">Total</th>

                        @auth
                            <th class="border border-gray-200 px-4 py-2">Action</th>
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @auth

                    @foreach($cartItems as $cartItem)
                        <tr>
                            <td class="border border-gray-200 px-4 py-2"><img class="w-16 h-16 object-cover m-auto" src="{{ Storage::url($cartItem->component->picture) }}" /></td>
                            <td class="border border-gray-200 px-4 py-2">{{ $cartItem->component->name }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $cartItem->component->vendor }}</td>
                            <td class="border border-gray-200 px-4 py-2 w-[100px]">
                                <!-- Form to save quantity changes -->
                                <form action="{{ route('cart.update', $cartItem->id) }}" method="POST" class="flex flex-col w-[100%] justify-center items-center mx-auto">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $cartItem->quantity }}" class="border-2 border-gray-600 rounded-lg my-2 mx-auto text-center">

                                    <div class="border-0 border-green-700 w-[50%] mx-auto">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 rounded-lg mx-auto w-[100%] font-extrabold text-white">Save</button>
                                    </div>
                                </form>
                            </td>
                            <td class="border border-gray-200 px-4 py-2">{{ $cartItem->component->price }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $cartItem->quantity * $cartItem->component->price }}</td>

                            @auth
                                <td class="border border-gray-200 px-4 py-2">
                                    <!-- Form to remove item from cart -->
                                    <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST" class="border-0 border-green-700 flex flex-row justify-center w-full rounded-lg">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold p-2 px-5 rounded-lg">Remove</button>
                                    </form>
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                    @endauth

                </tbody>
            </table>

            <div class="border-0 border-orange-700 w-[80%] flex flex-col justify-center absolute bottom-10">
                <div class="border-0 border-orange-700 w-[80%] flex flex-col justify-center absolute bottom-10">
                    <form action="{{ route('toPayment') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 font-bold text-white w-[20%] rounded-lg text-2xl py-2 px-4 mx-auto">Pay!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
