@extends('guest.layouts.index')

@section('title', 'Daftar')

@section('content')
    <div class="flex flex-col items-center justify-center px-4 py-8 min-h-full">
        <div
            class="w-full sm:max-w-lg bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl p-8 md:p-10 border border-gray-100">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Buat <span class="text-red-600">Akun Baru</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Mulai langkah karier Anda bersama PT Sinar Sosro Gunung Slamat.</p>
            </div>

            <form method="POST" action="{{ route('guest.register.post') }}" onsubmit="return disableButton(this)"
                class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block font-semibold text-gray-700 text-sm mb-1">Alamat Email</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input id="email"
                            class="block w-full pl-11 pr-4 py-3 bg-gray-50 border @error('email') border-red-500 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-lg text-sm focus:ring-4 focus:ring-red-50 focus:border-red-500 focus:bg-white transition-all outline-none"
                            type="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@email.com" @error('email') aria-invalid="true" @enderror aria-describedby="msg_email" />
                    </div>
                    @error('email')
                        <x-input-error id="msg_email" :message="$message" />
                    @else
                        <span id="msg_email" class="text-xs text-slate-500 mt-1.5 block transition-colors">Gunakan alamat email resmi yang aktif (contoh: nama@domain.com).</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="password" class="block font-semibold text-gray-700 text-sm mb-1">Password</label>
                        <input id="password" type="password" name="password"
                            class="block w-full bg-gray-50 border @error('password') border-red-500 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-red-50 focus:border-red-500 focus:bg-white transition-all outline-none pr-11"
                            required placeholder="••••••••" @error('password') aria-invalid="true" @enderror aria-describedby="msg_password" />
                        @error('password')
                            <x-input-error id="msg_password" :message="$message" />
                        @else
                            <span id="msg_password" class="text-xs text-slate-500 mt-1.5 block transition-colors">Minimal 8 karakter.</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block font-semibold text-gray-700 text-sm mb-1">Konfirmasi
                            Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="block w-full bg-gray-50 border @error('password_confirmation') border-red-500 ring-2 ring-red-100 @else border-gray-200 @enderror rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-red-50 focus:border-red-500 focus:bg-white transition-all outline-none pr-11"
                            required placeholder="••••••••" @error('password_confirmation') aria-invalid="true" @enderror aria-describedby="msg_password_confirmation" />
                        @error('password_confirmation')
                            <x-input-error id="msg_password_confirmation" :message="$message" />
                        @else
                            <span id="msg_password_confirmation" class="text-xs text-slate-500 mt-1.5 block transition-colors">Ulangi password di atas.</span>
                        @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed disabled:active:scale-100 cursor-pointer flex justify-center items-center">
                        <span id="btn-text">Daftarkan Akun</span>
                        <svg id="btn-icon" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="flex flex-col items-center space-y-3 mt-2 border-t border-gray-100">
                <p class="text-sm text-gray-500">
                    Sudah terdaftar?
                    <a href="{{ route('guest.login') }}"
                        class="text-red-600 hover:text-red-700 hover:underline font-bold ml-1 cursor-pointer">
                        Masuk di sini
                    </a>
                </p>
            </div>

            <p class="text-center text-xs text-gray-400 mt-5">
                PT Sinar Sosro Gunung Slamat. Seluruh data Anda terjaga kerahasiaannya.
            </p>
        </div>
    </div>

    <script>
        function disableButton(form) {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                const btnText = document.getElementById('btn-text');
                if (btnText) btnText.textContent = 'Memproses...';
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const msgEmail = document.getElementById('msg_email');
            const passInput = document.getElementById('password');
            const msgPass = document.getElementById('msg_password');
            const confirmInput = document.getElementById('password_confirmation');
            const msgConfirm = document.getElementById('msg_password_confirmation');

            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            let emailTouched = false;
            let passTouched = false;
            let confirmTouched = false;

            const iconOk = '<svg class="w-3.5 h-3.5 shrink-0 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>';
            const iconErr = '<svg class="w-3.5 h-3.5 shrink-0 mt-0.5 text-red-600" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>';

            function setRegisterStatus(input, msgEl, state, text) {
                input.classList.remove('border-gray-200', 'border-red-500', 'ring-2', 'ring-red-100', 'border-emerald-500');
                if (state === 'valid') {
                    input.classList.add('border-emerald-500');
                    input.removeAttribute('aria-invalid');
                    msgEl.className = 'text-xs text-emerald-700 font-medium mt-1.5 flex items-start gap-1.5 leading-snug';
                    msgEl.innerHTML = `${iconOk}<span>${text}</span>`;
                } else if (state === 'error') {
                    input.classList.add('border-red-500', 'ring-2', 'ring-red-100');
                    input.setAttribute('aria-invalid', 'true');
                    msgEl.className = 'text-xs text-red-600 font-medium mt-1.5 flex items-start gap-1.5 leading-snug';
                    msgEl.innerHTML = `${iconErr}<span>${text}</span>`;
                } else {
                    input.classList.add('border-gray-200');
                    input.removeAttribute('aria-invalid');
                    msgEl.className = 'text-xs text-slate-500 mt-1.5 block transition-colors';
                    msgEl.textContent = text;
                }
            }

            function validateEmail(showError) {
                if (!emailInput || !msgEmail) return;
                const val = emailInput.value.trim();
                if (val.length === 0) {
                    setRegisterStatus(emailInput, msgEmail, 'neutral', 'Gunakan alamat email resmi yang aktif (contoh: nama@domain.com).');
                } else if (emailRegex.test(val)) {
                    setRegisterStatus(emailInput, msgEmail, 'valid', 'Format email valid.');
                } else if (showError) {
                    setRegisterStatus(emailInput, msgEmail, 'error', 'Format email tidak valid. Gunakan format seperti nama@domain.com.');
                } else {
                    setRegisterStatus(emailInput, msgEmail, 'neutral', 'Sedang mengetik email (contoh: nama@domain.com).');
                }
            }

            function validatePassword(showError) {
                if (!passInput || !msgPass) return;
                const val = passInput.value;
                if (val.length === 0) {
                    setRegisterStatus(passInput, msgPass, 'neutral', 'Minimal 8 karakter.');
                } else if (val.length >= 8) {
                    setRegisterStatus(passInput, msgPass, 'valid', `Panjang password memenuhi syarat (${val.length} karakter).`);
                } else if (showError) {
                    setRegisterStatus(passInput, msgPass, 'error', `Password masih kurang ${8 - val.length} karakter lagi (${val.length}/8).`);
                } else {
                    setRegisterStatus(passInput, msgPass, 'neutral', `Minimal 8 karakter (${val.length}/8 karakter).`);
                }
                if (confirmInput && confirmInput.value.length > 0) {
                    validateConfirm(confirmTouched);
                }
            }

            function validateConfirm(showError) {
                if (!confirmInput || !msgConfirm) return;
                const pass = passInput ? passInput.value : '';
                const conf = confirmInput.value;
                if (conf.length === 0) {
                    setRegisterStatus(confirmInput, msgConfirm, 'neutral', 'Ulangi password di atas.');
                } else if (conf === pass) {
                    setRegisterStatus(confirmInput, msgConfirm, 'valid', 'Password cocok.');
                } else if (showError) {
                    setRegisterStatus(confirmInput, msgConfirm, 'error', 'Konfirmasi password tidak cocok dengan password.');
                } else {
                    setRegisterStatus(confirmInput, msgConfirm, 'neutral', 'Pastikan sama persis dengan password di atas.');
                }
            }

            if (emailInput) {
                emailInput.addEventListener('input', () => validateEmail(emailTouched));
                emailInput.addEventListener('blur', () => {
                    if (emailInput.value.trim().length > 0) {
                        emailTouched = true;
                        validateEmail(true);
                    }
                });
            }
            if (passInput) {
                passInput.addEventListener('input', () => validatePassword(passTouched));
                passInput.addEventListener('blur', () => {
                    if (passInput.value.length > 0) {
                        passTouched = true;
                        validatePassword(true);
                    }
                });
            }
            if (confirmInput) {
                confirmInput.addEventListener('input', () => validateConfirm(confirmTouched));
                confirmInput.addEventListener('blur', () => {
                    if (confirmInput.value.length > 0) {
                        confirmTouched = true;
                        validateConfirm(true);
                    }
                });
            }
        });
    </script>
@endsection
