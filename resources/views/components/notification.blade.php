@props([
    'requiredWarningTitle' => 'Lengkapi Biodata',
    'requiredWarningMessage' => 'Silakan lengkapi biodata Anda terlebih dahulu sebelum melamar pekerjaan.',
])

@php
    $initialToasts = [];

    if (session('success') || session('status')) {
        $initialToasts[] = [
            'type' => 'success',
            'title' => 'Berhasil',
            'message' => (string) (session('success') ?? session('status')),
        ];
    }

    if (session('error')) {
        $initialToasts[] = [
            'type' => 'error',
            'title' => 'Terjadi Kesalahan',
            'message' => (string) session('error'),
        ];
    }

    if (session('warning') || request('required')) {
        $initialToasts[] = [
            'type' => 'warning',
            'title' => session('warning') ? 'Perhatian' : $requiredWarningTitle,
            'message' => (string) (session('warning') ?? $requiredWarningMessage),
        ];
    }

    if (session('info')) {
        $initialToasts[] = [
            'type' => 'info',
            'title' => 'Informasi',
            'message' => (string) session('info'),
        ];
    }

    if ($errors->any()) {
        $initialToasts[] = [
            'type' => 'error',
            'title' => 'Validasi Gagal',
            'message' => (string) $errors->first(),
        ];
    }

    $toastThemes = [
        'success' => [
            'role' => 'status',
            'border' => 'border-slate-200 border-l-emerald-600',
            'iconBg' => 'bg-emerald-50 text-emerald-700',
            'bar' => 'bg-emerald-500',
            'duration' => 4500,
        ],
        'error' => [
            'role' => 'alert',
            'border' => 'border-red-200 border-l-red-600',
            'iconBg' => 'bg-red-50 text-red-700',
            'bar' => 'bg-red-600',
            'duration' => 0,
        ],
        'warning' => [
            'role' => 'alert',
            'border' => 'border-amber-200 border-l-amber-500',
            'iconBg' => 'bg-amber-50 text-amber-700',
            'bar' => 'bg-amber-500',
            'duration' => 6500,
        ],
        'info' => [
            'role' => 'status',
            'border' => 'border-slate-200 border-l-blue-600',
            'iconBg' => 'bg-blue-50 text-blue-700',
            'bar' => 'bg-blue-600',
            'duration' => 4500,
        ],
    ];
@endphp

<div id="global-toast-container" aria-live="polite"
    class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 max-w-sm w-[calc(100%-2.5rem)] pointer-events-none font-sans">
    @foreach ($initialToasts as $toast)
        @php
            $theme = $toastThemes[$toast['type']] ?? $toastThemes['info'];
        @endphp
        <div data-hci-toast data-duration="{{ $theme['duration'] }}" role="{{ $theme['role'] }}"
            class="pointer-events-auto bg-white rounded-xl border border-l-4 {{ $theme['border'] }} shadow-xl overflow-hidden transition-all duration-200">
            <div class="p-4 flex items-start gap-3">
                <div class="shrink-0 w-8 h-8 rounded-lg {{ $theme['iconBg'] }} flex items-center justify-center">
                    @if ($toast['type'] === 'success')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    @elseif ($toast['type'] === 'error')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    @elseif ($toast['type'] === 'warning')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900">{{ $toast['title'] }}</p>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $toast['message'] }}</p>
                </div>
                <button type="button" aria-label="Tutup notifikasi"
                    class="hci-close-btn shrink-0 w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @if ($theme['duration'] > 0)
                <div class="h-1 bg-slate-100 w-full overflow-hidden">
                    <div class="hci-progress h-full {{ $theme['bar'] }}" style="width: 100%; transition: width {{ $theme['duration'] }}ms linear;"></div>
                </div>
            @endif
        </div>
    @endforeach
</div>

<script>
    (function () {
        if (window.__hciToastInitialized) {
            return;
        }
        window.__hciToastInitialized = true;

        function bindToastBehavior(toast, duration) {
            const dismiss = () => {
                if (toast.dataset.closing === '1') return;
                toast.dataset.closing = '1';
                toast.classList.add('opacity-0', '-translate-y-1');
                setTimeout(() => toast.remove(), 200);
            };

            const closeBtn = toast.querySelector('.hci-close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', dismiss);
            }

            if (duration > 0) {
                let remaining = duration;
                let startTime = Date.now();
                let timer = setTimeout(dismiss, remaining);
                const bar = toast.querySelector('.hci-progress');

                requestAnimationFrame(() => {
                    if (bar) bar.style.width = '0%';
                });

                toast.addEventListener('mouseenter', () => {
                    clearTimeout(timer);
                    remaining = Math.max(0, remaining - (Date.now() - startTime));
                    if (bar) {
                        const pct = (remaining / duration) * 100;
                        bar.style.transition = 'none';
                        bar.style.width = pct + '%';
                    }
                });

                toast.addEventListener('mouseleave', () => {
                    startTime = Date.now();
                    const nextDuration = Math.max(500, remaining);
                    timer = setTimeout(dismiss, nextDuration);
                    if (bar) {
                        bar.style.transition = `width ${nextDuration}ms linear`;
                        requestAnimationFrame(() => {
                            bar.style.width = '0%';
                        });
                    }
                });
            }

            return dismiss;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text ?? '';
            return div.innerHTML;
        }

        window.showToast = function (type, title, message, options = {}) {
            const container = document.getElementById('global-toast-container');
            if (!container) return;

            const themes = {
                success: {
                    role: 'status',
                    border: 'border-slate-200 border-l-emerald-600',
                    iconBg: 'bg-emerald-50 text-emerald-700',
                    bar: 'bg-emerald-500',
                    actionText: 'text-emerald-700 hover:text-emerald-800',
                    duration: 4500,
                    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>',
                },
                error: {
                    role: 'alert',
                    border: 'border-red-200 border-l-red-600',
                    iconBg: 'bg-red-50 text-red-700',
                    bar: 'bg-red-600',
                    actionText: 'text-red-700 hover:text-red-800',
                    duration: 0,
                    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>',
                },
                warning: {
                    role: 'alert',
                    border: 'border-amber-200 border-l-amber-500',
                    iconBg: 'bg-amber-50 text-amber-700',
                    bar: 'bg-amber-500',
                    actionText: 'text-amber-800 hover:text-amber-900',
                    duration: 6500,
                    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                },
                info: {
                    role: 'status',
                    border: 'border-slate-200 border-l-blue-600',
                    iconBg: 'bg-blue-50 text-blue-700',
                    bar: 'bg-blue-600',
                    actionText: 'text-blue-700 hover:text-blue-800',
                    duration: 4500,
                    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                },
            };

            const theme = themes[type] || themes.info;
            const duration = typeof options.duration === 'number' ? options.duration : theme.duration;

            const toast = document.createElement('div');
            toast.setAttribute('role', theme.role);
            toast.className = `pointer-events-auto bg-white rounded-xl border border-l-4 ${theme.border} shadow-xl overflow-hidden transition-all duration-200 opacity-0 translate-y-2`;

            const actionHtml = options.actionLabel
                ? `<div class="mt-2"><button type="button" class="hci-action-btn text-xs font-bold ${theme.actionText} underline underline-offset-2 cursor-pointer">${escapeHtml(options.actionLabel)}</button></div>`
                : '';

            const progressHtml = duration > 0
                ? `<div class="h-1 bg-slate-100 w-full overflow-hidden"><div class="hci-progress h-full ${theme.bar}" style="width: 100%; transition: width ${duration}ms linear;"></div></div>`
                : '';

            toast.innerHTML = `
                <div class="p-4 flex items-start gap-3">
                    <div class="shrink-0 w-8 h-8 rounded-lg ${theme.iconBg} flex items-center justify-center">
                        ${theme.icon}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900">${escapeHtml(title)}</p>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">${escapeHtml(message)}</p>
                        ${actionHtml}
                    </div>
                    <button type="button" aria-label="Tutup notifikasi" class="hci-close-btn shrink-0 w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                ${progressHtml}
            `;

            container.prepend(toast);
            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-2');
            });

            const dismiss = bindToastBehavior(toast, duration);
            const actionBtn = toast.querySelector('.hci-action-btn');
            if (actionBtn) {
                actionBtn.addEventListener('click', () => {
                    if (typeof options.onAction === 'function') {
                        options.onAction();
                    }
                    dismiss();
                });
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#global-toast-container [data-hci-toast]').forEach((toast) => {
                const duration = parseInt(toast.dataset.duration || '0', 10);
                bindToastBehavior(toast, Number.isNaN(duration) ? 0 : duration);
            });
        });
    })();
</script>
