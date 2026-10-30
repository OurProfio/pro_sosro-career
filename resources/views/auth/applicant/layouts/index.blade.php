<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Selamat Datang') - Sosro Career</title>
    <link rel="icon" href="{{ asset('assets/images/logo sosro.webp') }}">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- Sortable --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    @include('auth.applicant.layouts.components.style')

    @if (request()->routeIs('biodata.*'))
        <style>
            /* Otomatis teks huruf kapital (uppercase) untuk input teks formulir biodata */
            input[type="text"]:not([data-no-uppercase]):not([name="email"]):not([name="instagram"]):not([name="linkedin"]):not([name*="phone"]):not([name*="nik"]):not([name*="postal"]):not([name*="code"]):not([name*="date"]):not([name*="gpa"]):not([name*="year"]),
            textarea:not([data-no-uppercase]) {
                text-transform: uppercase;
            }
        </style>
    @endif
</head>

<body>

    <div class="min-h-screen flex flex-col">
        @include('auth.applicant.layouts.navbar')
        <main class="flex-1">
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

        @if (request()->routeIs('biodata.*'))
            document.addEventListener('input', function(e) {
                const el = e.target;
                if (!el || !['INPUT', 'TEXTAREA'].includes(el.tagName)) return;
                if (el.tagName === 'INPUT' && el.type !== 'text') return;
                if (el.dataset.noUppercase !== undefined) return;
                const name = (el.name || '').toLowerCase();
                if (
                    name.includes('email') ||
                    name.includes('instagram') ||
                    name.includes('linkedin') ||
                    name.includes('phone') ||
                    name.includes('nik') ||
                    name.includes('postal') ||
                    name.includes('code') ||
                    name.includes('date') ||
                    name.includes('gpa') ||
                    name.includes('year')
                ) {
                    return;
                }
                const start = el.selectionStart;
                const end = el.selectionEnd;
                const upper = el.value.toUpperCase();
                if (el.value !== upper) {
                    el.value = upper;
                    if (start !== null && end !== null) {
                        el.setSelectionRange(start, end);
                    }
                }
            });
        @endif
    </script>
</body>

</html>
