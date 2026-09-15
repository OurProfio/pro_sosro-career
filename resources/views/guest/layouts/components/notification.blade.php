<div id="toast-container" class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-2.5 max-w-sm w-full pointer-events-none select-none font-sans"></div>

<style>
    @keyframes toastShrink {
        from { width: 100%; }
        to { width: 0%; }
    }

    @keyframes toastSlideIn {
        from {
            transform: translateY(1rem) scale(0.95);
            opacity: 0;
        }
        to {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes toastFadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.95);
        }
    }

    .toast-card {
        animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .toast-card.closing {
        animation: toastFadeOut 0.2s ease-in forwards;
    }

    .toast-progress-bar {
        animation: toastShrink 4s linear forwards;
    }
</style>

<script>
    function showToast(type, title, message) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const config = {
            success: {
                bgIcon: 'bg-emerald-50 text-emerald-600',
                progressBar: 'bg-emerald-500',
                icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            },
            error: {
                bgIcon: 'bg-red-50 text-red-600',
                progressBar: 'bg-red-600',
                icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>'
            },
            info: {
                bgIcon: 'bg-blue-50 text-blue-600',
                progressBar: 'bg-blue-600',
                icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            },
            warning: {
                bgIcon: 'bg-amber-50 text-amber-600',
                progressBar: 'bg-amber-500',
                icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            }
        };

        const theme = config[type] || config.info;

        const toastEl = document.createElement('div');
        toastEl.className = 'toast-card pointer-events-auto bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden flex flex-col w-full';

        toastEl.innerHTML = `
            <div class="p-3.5 flex items-start gap-3">
                <div class="shrink-0 p-2 rounded-full mt-0.5 ${theme.bgIcon}">
                    ${theme.icon}
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <p class="text-xs font-bold text-gray-800 tracking-tight">${title}</p>
                    <p class="text-xs text-gray-500 mt-0.5 leading-snug font-medium">${message}</p>
                </div>
                <button type="button" class="toast-close-btn text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition shrink-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="h-1 bg-gray-100 w-full overflow-hidden">
                <div class="h-full toast-progress-bar ${theme.progressBar}"></div>
            </div>
        `;

        const removeToast = () => {
            if (toastEl.classList.contains('closing')) return;
            toastEl.classList.add('closing');
            toastEl.addEventListener('animationend', () => {
                toastEl.remove();
            });
        };

        toastEl.querySelector('.toast-close-btn').addEventListener('click', removeToast);
        const timer = setTimeout(removeToast, 4000);
        container.appendChild(toastEl);
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success') || session('status'))
            showToast('success', 'Berhasil!', @json(session('success') ?? session('status')));
        @elseif(session('error'))
            showToast('error', 'Terjadi Kesalahan!', @json(session('error')));
        @elseif(session('info'))
            showToast('info', 'Informasi', @json(session('info')));
        @elseif(session('warning'))
            showToast('warning', 'Peringatan!', @json(session('warning')));
        @elseif($errors->any())
            showToast('error', 'Validasi Gagal!', @json($errors->first()));
        @endif
    });
</script>