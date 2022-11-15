<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="Toko online kebutuhan sehari-hari di purbalingga. SmegaMart belanja ditempat online juga ada">
    <meta name="keywords"
        content="Online shop, smega mart, smk n 1 purbalingga, belanja di tempat, toko terlengkap, toko kebutuhan sehari-hari, toko sepatu, toko makanan">
    <meta name="author" content="SMK N 1 Purbalingga">
    {{-- <meta http-equiv="refresh" content="30"> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | Kasir Web WSB</title>
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;600;700&family=Poppins:wght@200;300;400;500;600;700;900&display=swap"
        rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <header class="bg-white">
        @include('layouts.partials.header.header-top')
        @include('layouts.partials.header.header-mid')
        @if (!request()->is('/'))
            @include('layouts.partials.header.header-bottom')
            @include('layouts.partials.breadcrumb')
        @endif
    </header>

    <div class="mx-3 py-3 lg:py-8">
        @yield('content')
    </div>

    {{-- partner --}}

    <footer class="bg-slate-200">
        @include('layouts.partials.footer.footer-bottom')
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/flowbite.js') }}"></script>
    <script defer src="{{ asset('assets/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/header-mid.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>

    <script>
        $(document).ready(function() {
            window.setTimeout(function() {
                $("#alert-border-3").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 1000);
        });
    </script>

</body>

</html>
