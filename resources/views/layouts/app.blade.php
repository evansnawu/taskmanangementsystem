<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.8"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>


    </div>

    @if (session('status'))
        <script>
            let mess = "{{ session('status') }}"
            Swal.fire({
                position: "top-right",
                icon: "success",
                title: mess,
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    @endif


    @if (session('error'))
        <script>
            let mess = "{{ session('error') }}"
            Swal.fire({
                position: "center",
                icon: "error",
                html: '<p> <strong>' + mess + '</strong></p>',
                showConfirmButton: true,
            });
        </script>
    @endif

</body>

</html>
