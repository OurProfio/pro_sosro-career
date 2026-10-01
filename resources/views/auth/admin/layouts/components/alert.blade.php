@if (session('info') || $errors->any())
    @php
        // Menentukan status pesan (apakah error atau info biasa)
        $isError = $errors->any();
        $message = $isError ? $errors->first() : session('info');
    @endphp

    <div id="alert-1"
        class="fixed bottom-4 right-4 z-50 flex items-center p-4 text-sm rounded-xl border shadow-lg transition-all duration-300 {{ $isError ? 'bg-rose-50 border-rose-200 text-rose-800' : 'bg-blue-50 border-blue-200 text-blue-800' }}"
        role="alert">

        <!-- Ikon Alert -->
        @if ($isError)
            <!-- Ikon Warning/Error -->
            <svg class="w-5 h-5 shrink-0 text-rose-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
        @else
            <!-- Ikon Info Bawaan Anda -->
            <svg class="w-5 h-5 shrink-0 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
        @endif

        <!-- Isi Pesan -->
        <div class="ms-3 text-sm font-medium pr-2">
            {{ $message }}
        </div>

        <!-- Tombol Close (Atribut Flowbite: data-dismiss-target) -->
        <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 p-1.5 inline-flex items-center justify-center h-8 w-8 rounded-lg hover:cursor-pointer transition-colors {{ $isError ? 'bg-rose-50 text-rose-500 hover:bg-rose-100' : 'bg-blue-50 text-blue-500 hover:bg-blue-100' }}"
            data-dismiss-target="#alert-1" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 17.94 6M18 18 6.06 6" />
            </svg>
        </button>
    </div>

    <!-- Script Vanilla JS: Auto-dismiss (Otomatis hilang setelah 5 detik) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const alertElement = document.getElementById('alert-1');
            if (alertElement) {
                setTimeout(() => {
                    const closeBtn = alertElement.querySelector('[data-dismiss-target]');
                    if (closeBtn) {
                        closeBtn.click();
                    } else {
                        alertElement.remove();
                    }
                }, 5000);
            }
        });
    </script>
@endif
