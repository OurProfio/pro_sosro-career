<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Selamat Datang') - Sosro Career</title>
    <link rel="icon" href="{{ asset('assets/images/logo sosro.webp') }}">

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @include('guest.layouts.components.style')
</head>

<body>

    <div class="mx-auto w-screen max-w-[1900px]">
        @include('guest.layouts.navbar')
        <main class="">
            @yield('content')
        </main>
        @include('guest.layouts.footer')
        {{-- @include('guest.layouts.notification') --}}
    </div>

    @include('guest.layouts.components.notification')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>

</html>
