<x-guest-layout>
    <div id="login-container">
        {{-- STEP 1: Input nomor HP --}}
        <div id="step-phone">
            <div class="card-header">
                <h1 class="card-title">Portal Akses</h1>
                <p class="card-subtitle">Gunakan nomor WhatsApp Anda</p>
            </div>

            <label class="field-label">Nomor WhatsApp</label>
            <div class="input-wrapper">
                <span class="input-prefix">+62</span>
                <input type="text" id="phone" placeholder="8123456789" autocomplete="tel">
            </div>

            <button onclick="sendOtp()" id="btn-send" class="btn-premium">
                <span>Kirim Kode OTP</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>

        {{-- STEP 2: Verifikasi OTP --}}
        <div id="step-otp" style="display:none;">
            <div class="card-header">
                <h1 class="card-title">Verifikasi OTP</h1>
                <p class="card-subtitle">Kode telah dikirimkan ke:</p>
                <span id="display-phone" class="phone-display">+62 8xxx</span>
            </div>

            <div class="otp-grid">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-input" data-index="{{ $i }}"
                        placeholder="&bull;">
                @endfor
            </div>

            <button onclick="verifyOtp()" id="btn-verify" class="btn-premium">
                <span>Verifikasi &amp; Masuk</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </button>

            <div class="text-center">
                <button onclick="backToPhone()" class="btn-text-link">Bukan Nomor Anda? Ganti</button>
            </div>
        </div>

        <div id="message" class="msg-box"></div>
    </div>

    <script>
        let currentPhone = '';

        // Handle OTP input behavior
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.otp-input');

            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;
                    // Allow only numbers
                    if (!/^\d$/.test(value)) {
                        e.target.value = '';
                        return;
                    }

                    if (value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    // Auto-verify if last digit
                    const otp = Array.from(inputs).map(i => i.value).join('');
                    if (otp.length === 6) verifyOtp();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].value = '';
                    }
                });

                // Clear on click for better UX
                input.addEventListener('click', () => {
                    input.select();
                });
            });
        });

        async function sendOtp() {
            const phoneCell = document.getElementById('phone');
            const phone = phoneCell.value.trim();
            const btn = document.getElementById('btn-send');
            const msg = document.getElementById('message');

            if (!phone) { showMsg('Masukkan nomor WhatsApp!', 'error'); return; }

            btn.disabled = true;
            btn.innerHTML = '<span>Mengirim...</span>';
            msg.className = 'msg-box';

            try {
                const res = await fetch('{{ route("login.wa.send") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ phone })
                });
                const data = await res.json();

                if (data.success) {
                    currentPhone = phone;
                    document.getElementById('display-phone').textContent = '+62 ' + phone;
                    document.getElementById('step-phone').style.display = 'none';
                    document.getElementById('step-otp').style.display = 'block';

                    // Auto-focus first OTP input
                    setTimeout(() => {
                        document.querySelector('.otp-input').focus();
                    }, 100);

                    showMsg(data.message, 'success');
                } else {
                    showMsg(data.message || 'Gagal mengirim OTP.', 'error');
                }
            } catch (e) {
                showMsg('Koneksi terputus atau server sedang sibuk. Mohon coba lagi.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<span>Kirim Kode OTP</span><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>';
            }
        }

        async function verifyOtp() {
            const inputs = document.querySelectorAll('.otp-input');
            const otp = Array.from(inputs).map(i => i.value).join('');
            const btn = document.getElementById('btn-verify');
            const msg = document.getElementById('message');

            if (otp.length < 6) return; // Silent return if not enough digits

            btn.disabled = true;
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<span>Memverifikasi...</span>';
            msg.className = 'msg-box';

            try {
                const res = await fetch('{{ route("login.wa.verify") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ phone: currentPhone, otp })
                });
                const data = await res.json();

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    showMsg(data.message, 'error');
                    // Focus back to first input and clear all on error
                    inputs.forEach(i => i.value = '');
                    inputs[0].focus();
                }
            } catch (e) {
                showMsg('Gagal verifikasi. Periksa koneksi internet Anda.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
        }

        function backToPhone() {
            document.getElementById('step-phone').style.display = 'block';
            document.getElementById('step-otp').style.display = 'none';
            document.getElementById('message').className = 'msg-box';
        }

        function showMsg(text, type) {
            const msg = document.getElementById('message');
            msg.textContent = text;
            msg.className = 'msg-box ' + type;
        }
    </script>
</x-guest-layout>