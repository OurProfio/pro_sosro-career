<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Selamat Datang') - Sosro Career</title>
    <link rel="icon" href="{{ asset('assets/images/logo sosro.webp') }}">

    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @include('guest.layouts.components.style')
</head>

<body>
    <div class="min-h-screen flex flex-col max-w-[1900px] mx-auto">
        @include('guest.layouts.navbar')
        <main class="flex-1">
            @yield('content')
        </main>
        @include('guest.layouts.footer')
        {{-- @include('guest.layouts.notification') --}}
    </div>

    <x-notification required-warning-title="Perlu Masuk Akun"
        required-warning-message="Silakan masuk (login) terlebih dahulu untuk dapat melamar lowongan pekerjaan." />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>

</html>
