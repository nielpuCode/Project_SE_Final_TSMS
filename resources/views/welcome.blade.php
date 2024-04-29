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
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        @include('sidebar')

        <div class="w-4/5 p-4">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3xVsuCUsbiy2ctnBC0CFWEjHzfbOsCiwpDtDQbLs-tQ&s" class="w-[40%] mx-auto" />


            <h1 class="font-extrabold text-5xl text-center my-8">Ahihihihihihi Ahihihihihih Ahihihihihihi</h1>
        </div>


    </div>


</body>
</html>
