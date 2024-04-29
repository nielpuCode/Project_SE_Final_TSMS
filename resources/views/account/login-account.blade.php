<!-- account/login-account.blade.php -->
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
<div class="flex h-screen bg-[#F7EEDD]">
    <!-- Sidebar -->
    @include('sidebar')

    <script>
        // Check for error message in URL
        @if(session('error'))
            alert("{{ session('error') }}");
        @endif
    </script>

    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg m-auto">
        <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">Login to Your Account</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold mb-2 text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold mb-2 text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-6">
                <button type="submit" class="w-full bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Login</button>
            </div>
        </form>
        {{-- <div class="text-center">
            <span class="text-gray-600">Forgot your password?</span>
            <!-- account/login-account.blade.php -->
            ...
            <form action="{{ route('password.forgot') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold mb-2 text-gray-700">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-6">
                    <button type="submit" class="w-full bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Reset Password</button>
                </div>
            </form>
        </div> --}}

        <div class="text-center mt-4">
            <span class="text-gray-600">Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register here</a>
        </div>
    </div>
</div>
</body>
</html>
