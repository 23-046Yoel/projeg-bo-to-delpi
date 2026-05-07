<x-guest-layout>
    <div id="login-container">
        <div class="login-tabs" style="display: flex; margin-bottom: 2rem; border-radius: 12px; background: #F3F4F6; padding: 0.5rem;">
            <button type="button" onclick="switchTab('wa')" id="tab-wa" style="flex: 1; padding: 0.75rem; border-radius: 8px; font-weight: bold; font-size: 0.875rem; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); color: #10B981; border: none; cursor: pointer; transition: all 0.3s;">WhatsApp</button>
            <button type="button" onclick="switchTab('email')" id="tab-email" style="flex: 1; padding: 0.75rem; border-radius: 8px; font-weight: bold; font-size: 0.875rem; background: transparent; color: #6B7280; border: none; cursor: pointer; transition: all 0.3s;">Email</button>
        </div>

        {{-- Session Status & Errors --}}
        @if (session('status'))
            <div style="color: #10B981; font-size: 0.875rem; margin-bottom: 1rem; text-align: center; font-weight: bold;">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div style="color: #EF4444; font-size: 0.875rem; margin-bottom: 1rem; text-align: center; background: #FEF2F2; padding: 0.5rem; border-radius: 8px; border: 1px solid #FCA5A5;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- WhatsApp Form --}}
        <div id="form-wa">
            <div class="card-header">
                <h1 class="card-title">Portal Akses</h1>
                <p class="card-subtitle">Gunakan nomor WhatsApp terdaftar</p>
            </div>

            <label class="field-label">Masukkan Nomor WhatsApp</label>
            <div class="input-wrapper">
                <span class="input-prefix">+62</span>
                <input type="text" id="phone" placeholder="812-3456-7890" autocomplete="tel">
            </div>

            <button onclick="sendOtp()" id="btn-send" class="btn-premium">
                <span>Kirim Kode OTP</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>

        {{-- Email Form --}}
        <div id="form-email" style="display: none;">
            <div class="card-header">
                <h1 class="card-title">Portal Admin</h1>
                <p class="card-subtitle">Masuk menggunakan Email & Password</p>
            </div>

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label class="field-label" style="display: block; margin-bottom: 0.5rem;">Email Resmi</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #F3F4F6; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.3s;" placeholder="admin@example.com">
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label class="field-label" style="display: block; margin-bottom: 0.5rem;">Kata Sandi (Password)</label>
                    <input type="password" name="password" required style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #F3F4F6; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.3s;" placeholder="••••••••">
                </div>
                <button type="submit" class="btn-premium" style="background: #1B2631; color: white; width: 100%; padding: 0.875rem; border-radius: 12px; font-weight: bold; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>
        </div>

        {{-- STEP 2: Verifikasi OTP --}}
        <div id="step-otp" style="display:none;">
            <div class="card-header" style="text-align: center;">
                <h1 class="card-title">Verifikasi OTP</h1>
                <p class="card-subtitle">Kode 6-digit telah dikirimkan ke:</p>
                <div id="display-phone" class="phone-display" style="font-size: 1.1rem; color: #1B2631;">+62 8xxx</div>
            </div>

            <div class="otp-grid">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-input" data-index="{{ $i }}" placeholder="-">
                @endfor
            </div>

            <button onclick="verifyOtp()" id="btn-verify" class="btn-premium">
                <span>Lanjutkan &amp; Masuk</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
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

        // Tab Switching Logic
        function switchTab(tab) {
            const waForm = document.getElementById('form-wa');
            const emailForm = document.getElementById('form-email');
            const tabWa = document.getElementById('tab-wa');
            const tabEmail = document.getElementById('tab-email');
            const stepOtp = document.getElementById('step-otp');

            // Hide OTP step if open
            if(stepOtp) stepOtp.style.display = 'none';

            if(tab === 'wa') {
                waForm.style.display = 'block';
                emailForm.style.display = 'none';
                
                // Active Styling
                tabWa.style.background = 'white';
                tabWa.style.color = '#10B981';
                tabWa.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
                
                // Inactive Styling
                tabEmail.style.background = 'transparent';
                tabEmail.style.color = '#6B7280';
                tabEmail.style.boxShadow = 'none';
            } else {
                waForm.style.display = 'none';
                emailForm.style.display = 'block';
                
                // Active Styling
                tabEmail.style.background = 'white';
                tabEmail.style.color = '#1B2631';
                tabEmail.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
                
                // Inactive Styling
                tabWa.style.background = 'transparent';
                tabWa.style.color = '#6B7280';
                tabWa.style.boxShadow = 'none';
            }
        }

        // Handle OTP input behavior
        document.addEventListener('DOMContentLoaded', () => {
            @if ($errors->any())
                switchTab('email');
            @endif

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