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
        <div class="w-4/5 p-4 overflow-y-auto max-h-screen flex flex-row justify-center gap-10 items-center">
            <!-- Form for Adding New Payment Method -->
            <div class="bg-white shadow-xl rounded-xl px-8 pt-6 pb-8 mb-4 h-fit">
                <h2 class="text-3xl font-bold mb-6">Add New Payment Method</h2>
                <form action="{{ route('payment-methods.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Payment Method Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Payment Method Name">
                    </div>
                    <div class="mb-4">
                        <label for="no_direction" class="block text-gray-700 text-sm font-bold mb-2">No Direction</label>
                        <input type="number" id="no_direction" name="no_direction" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="No Direction">
                    </div>
                    <div class="mb-4">
                        <label for="admin_name" class="block text-gray-700 text-sm font-bold mb-2">Admin Name</label>
                        <input type="text" id="admin_name" name="admin_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Admin Name">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-[#008DDA] to-[#41C9E2] text-white font-semibold px-4 py-2 rounded-lg hover:scale-105 transition duration-200">Add Payment Method</button>
                </form>
            </div>

            <!-- List of Existing Payment Methods -->
            <div class="bg-white shadow-xl rounded-xl px-8 pt-6 pb-8 mb-4 max-h-screen">
                <h2 class="text-3xl font-bold mb-6">Existing Payment Methods</h2>
                @foreach($paymentMethods as $paymentMethod)
                    <div class="flex justify-between items-center border-b-2 border-gray-300 py-4">
                        <div>
                            <span class="text-lg font-semibold">{{ $paymentMethod->name }}</span>
                            <span class="text-gray-500"> - {{ $paymentMethod->no_direction }}</span>
                        </div>
                        <div>
                            <form action="{{ route('payment-methods.edit', $paymentMethod->id) }}" method="GET" class="inline">
                                @csrf
                                <button type="submit" class="bg-gradient-to-r from-[#008DDA] to-[#41C9E2] text-white font-semibold px-4 py-2 rounded-lg hover:scale-105 transition duration-200">Update</button>
                            </form>
                            <form action="{{ route('payment-methods.destroy', $paymentMethod->id) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-800 transition duration-200">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
