{{-- comp-component.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SE TSMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>

    {{-- <div class="flex h-screen bg-gray-100"> --}}
    <div class="flex h-screen bg-[#F7EEDD]">
        <!-- Sidebar -->
        @include('sidebar')

        <!-- Main Content -->
        <div class="w-4/5 p-4 overflow-y-auto h-[screen-20]">
            <div class="flex justify-between mb-4">
                <input type="text" class="w-2/3 bg-[#ACE2E1]/60 rounded-md py-2 px-4" id="searchInput" placeholder="Search Item Here...">

                {{-- Add Item only for admin --}}
                @if(auth()->check() && auth()->user()->email === 'tsms@gmail.com' && auth()->user()->name === 'tsms')
                    <a href="{{ route('create_compComponent') }}" class="bg-gradient-to-r from-[#FF6500] via-[#FF8A08] to-[#FFC100] rounded-md py-2 px-4 font-bold text-white">Add Item</a>
                @endif
            </div>

            <table class="w-full bg-none rounded-md cursor-default">
                <thead>
                    <tr class="rounded-md">
                        <th class="border-4 rounded-md border-[#41C9E2] px-4 py-2">Picture</th>
                        <th class="border-4 rounded-md border-[#41C9E2] px-4 py-2">Name</th>
                        <th class="border-4 rounded-md border-[#41C9E2] px-4 py-2">Vendor</th>
                        <th class="border-4 rounded-md border-[#41C9E2] px-4 py-2">Description</th>
                        <th class="border-4 rounded-md border-[#41C9E2] px-4 py-2">Quantity</th>
                        <th class="border-4 rounded-md border-[#41C9E2] px-4 py-2">Category</th>
                        <th class="border-4 rounded-md border-[#41C9E2] px-4 py-2">Price</th>

                        @auth
                        <th class="border-4 rounded-md border-[#41C9E2] px-4 py-2">Action</th>
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($compComponents as $compComponent)
                        <tr class="compComponentRow">
                            <td class="border-4 border-[#41C9E2] px-4 py-2"><img class="w-16 h-16 object-cover m-auto" src="{{ Storage::url($compComponent->picture) }}" /></td>
                            <td class="border-4 border-[#41C9E2] px-4 py-2">{{ $compComponent->name }}</td>
                            <td class="border-4 border-[#41C9E2] px-4 py-2">{{ $compComponent->vendor }}</td>
                            <td class="border-4 border-[#41C9E2] px-4 py-2">{{ $compComponent->description }}</td>
                            <td class="border-4 border-[#41C9E2] px-4 py-2">{{ $compComponent->quantity }}</td>
                            <td class="border-4 border-[#41C9E2] px-4 py-2">{{ $compComponent->category }}</td>
                            <td class="border-4 border-[#41C9E2] px-4 py-2 w-[150px]">$ {{ $compComponent->price }}</td>

                            {{-- Action buttons --}}
                            @auth
                            <td class="border-0 border-[#41C9E2] px-4 py-2 flex flex-row items-center justify-center gap-x-2 min-h-full my-auto">
                                {{-- For admin: Edit and Delete buttons --}}
                                @if(auth()->check() && auth()->user()->email === 'tsms@gmail.com' && auth()->user()->name === 'tsms')
                                    <button class="bg-gradient-to-r from-[#008DDA] to-[#41C9E2] text-white font-semibold px-4 py-2 rounded-lg hover:scale-105 transition duration-200">
                                        <a href="{{ route('edit_compComponent', $compComponent) }}" class="text-white w-full">Edit</a>
                                    </button>

                                    <button onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this component?')) { document.getElementById('delete-form-{{ $compComponent->id }}').submit(); }" class="bg-red-500 text-white font-semibold px-4 py-2 rounded-lg hover:scale-105 transition duration-200 hover:bg-red-800">Delete</button>
                                    <form id="delete-form-{{ $compComponent->id }}" action="{{ route('delete_compComponent', $compComponent) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif

                                {{-- For non-admin: Add to cart button --}}
                                @unless(auth()->check() && auth()->user()->email === 'tsms@gmail.com' && auth()->user()->name === 'tsms')
                                <form action="{{ route('addItemToCart') }}" method="POST" class="border-0 w-full">
                                    @csrf
                                    <input type="hidden" name="component_id" value="{{ $compComponent->id }}">
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-1 py-2 rounded-md w-full mt-[10px]">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                                @endunless
                            </td>
                            @endauth
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.compComponentRow').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

    </script>

</body>
</html>
