<div 
    x-data="{
        toasts: [],
        add(type, title, message) {
            const id = Date.now();
            this.toasts.push({ id, type, title, message });
            
            // Auto dismiss setelah 4 detik
            setTimeout(() => {
                this.remove(id);
            }, 4000);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
        init() {
            // Tangkap Session Flash dari Laravel
            @if(session('success'))
                this.add('success', 'Berhasil', '{{ session('success') }}');
            @elseif(session('error'))
                this.add('error', 'Gagal', '{{ session('error') }}');
            @elseif(session('info'))
                this.add('info', 'Informasi', '{{ session('info') }}');
            @elseif($errors->any())
                this.add('error', 'Validasi Gagal', '{{ $errors->first() }}');
            @endif

            // Custom Event Listener untuk JS / AJAX
            window.addEventListener('toast', (e) => {
                this.add(e.detail.type || 'info', e.detail.title || 'Notifikasi', e.detail.message);
            });
        }
    }"
    class="fixed bottom-3 right-3 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none select-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div 
            x-transition:enter="transition ease-out duration-200 transform"
            x-transition:enter-start="translate-y-2 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="pointer-events-auto bg-white border border-slate-300 rounded shadow-lg overflow-hidden flex flex-col"
        >
            <div class="p-2.5 flex items-start gap-2.5">
                <div class="shrink-0 pt-0.5">
                    <template x-if="toast.type === 'success'">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                    </template>
                    <template x-if="toast.type === 'info'">
                        <i data-lucide="info" class="w-4 h-4 text-blue-600"></i>
                    </template>
                    <template x-if="toast.type === 'warning'">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-amber-600"></i>
                    </template>
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold text-slate-800 leading-none font-mono" x-text="toast.title"></p>
                    <p class="text-[11px] text-slate-600 mt-1 leading-snug font-sans" x-text="toast.message"></p>
                </div>

                <button 
                    @click="remove(toast.id)" 
                    class="text-slate-400 hover:text-slate-700 p-0.5 rounded transition-colors shrink-0"
                >
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </button>
            </div>

            <div class="h-0.5 bg-slate-100 w-full overflow-hidden">
                <div 
                    class="h-full animate-[toast-progress_4s_linear_forwards]"
                    :class="{
                        'bg-emerald-500': toast.type === 'success',
                        'bg-rose-500': toast.type === 'error',
                        'bg-blue-500': toast.type === 'info',
                        'bg-amber-500': toast.type === 'warning'
                    }"
                ></div>
            </div>
        </div>
    </template>
</div>

<style>
    @keyframes toast-progress {
        from { width: 100%; }
        to { width: 0%; }
    }
</style>