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
    {{-- Sortable --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    @include('auth.applicant.layouts.components.style')
</head>

<body>

    <div class="mx-auto min-w-screen">
        @include('auth.applicant.layouts.navbar')
        <main>
            @yield('content')
        </main>
        @include('auth.applicant.layouts.footer')
        {{-- @include('guest.layouts.notification') --}}
    </div>

    @include('auth.applicant.layouts.components.notification')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>

</html>
