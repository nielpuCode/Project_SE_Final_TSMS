{{-- account/edit-account.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SE TSMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        @include('sidebar')

        <div class="max-w-md w-full max-h-screen bg-white p-8 rounded-lg shadow-lg m-auto overflow-y-auto">
            <h1 class="text-2xl font-semibold mb-6 text-center">Update Account</h1>
            <form action="{{ route('account.update') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Address</label>
                    <input type="text" id="address" name="address" value="{{ auth()->user()->address }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ auth()->user()->phone_number }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4 relative">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" placeholder="Leave blank to keep the current password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" value="{{ auth()->user()->password }}">
                    <input type="checkbox" id="togglePassword" class="absolute right-0 top-1/2 transform -translate-y-1/2 cursor-pointer" onchange="togglePasswordVisibility()">
                </div>

                <script>
                    function togglePasswordVisibility() {
                        const passwordInput = document.getElementById('password');
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                        } else {
                            passwordInput.type = 'password';
                        }
                    }
                </script>
                <div class="mb-4">
                    <button type="submit" class="w-full my-2 bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Update</button>
                </div>
            </form>
            <form action="{{ route('account.delete') }}" method="POST" onsubmit="return confirmDeleteAccount()">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full my-2 bg-red-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-800 transition duration-200">Delete Account</button>
            </form>

            <script>
                function confirmDeleteAccount() {
                    if (confirm('Are you sure you want to delete your account? This action cannot be undone. Please confirm again.')) {
                        return confirm('Are you really sure? This action cannot be undone.');
                    }
                    return false;
                }
            </script>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full my-2 bg-red-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-800 transition duration-200">Logout</button>
            </form>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.user-account') }}" class="block text-center mt-4 text-blue-500 hover:text-blue-600">Manage User Accounts</a>
            @endif
        </div>

    </div>
</body>
</html>
