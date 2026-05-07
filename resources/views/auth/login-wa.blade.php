<x-guest-layout>
    <div id="login-container">
        <div class="card-header" style="text-align: center; margin-bottom: 2rem;">
            <div style="background: #1B2631; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 10px 20px rgba(27, 38, 49, 0.2);">
                <svg style="width: 30px; height: 30px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="card-title" style="font-size: 1.75rem; color: #1B2631; font-weight: 800; letter-spacing: -0.5px;">Portal Administrator</h1>
            <p class="card-subtitle" style="color: #64748B; font-size: 0.95rem; margin-top: 0.5rem;">Silakan masuk untuk mengelola sistem Bo To Delphi</p>
        </div>

        {{-- Session Status & Errors --}}
        @if (session('status'))
            <div style="color: #10B981; font-size: 0.875rem; margin-bottom: 1.5rem; text-align: center; font-weight: 600; background: #ECFDF5; padding: 0.75rem; border-radius: 12px; border: 1px solid #A7F3D0;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="color: #EF4444; font-size: 0.875rem; margin-bottom: 1.5rem; text-align: center; background: #FEF2F2; padding: 0.75rem; border-radius: 12px; border: 1px solid #FCA5A5;">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div style="margin-bottom: 1.25rem;">
                <label class="field-label" style="display: block; margin-bottom: 0.5rem; color: #334155; font-weight: 600; font-size: 0.875rem;">Alamat Email Resmi</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%;); color: #94A3B8;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        style="width: 100%; padding: 0.875rem 1rem 0.875rem 3rem; border: 2px solid #E2E8F0; border-radius: 14px; font-size: 1rem; outline: none; transition: all 0.3s; color: #1E293B;" 
                        placeholder="nama@email.com">
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <label class="field-label" style="color: #334155; font-weight: 600; font-size: 0.875rem;">Kata Sandi</label>
                    <a href="{{ route('password.request') }}" style="font-size: 0.75rem; color: #3B82F6; font-weight: 600; text-decoration: none;">Lupa Sandi?</a>
                </div>
                <div style="position: relative;">
                    <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%;); color: #94A3B8;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </span>
                    <input type="password" name="password" required 
                        style="width: 100%; padding: 0.875rem 1rem 0.875rem 3rem; border: 2px solid #E2E8F0; border-radius: 14px; font-size: 1rem; outline: none; transition: all 0.3s; color: #1E293B;" 
                        placeholder="••••••••">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="remember" style="width: 1.125rem; height: 1.125rem; border-radius: 4px; border: 2px solid #E2E8F0; cursor: pointer;">
                    <span style="margin-left: 0.5rem; font-size: 0.875rem; color: #64748B;">Ingat saya di perangkat ini</span>
                </label>
            </div>

            <button type="submit" class="btn-premium" style="background: #1B2631; color: white; width: 100%; padding: 1rem; border-radius: 14px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.75rem; transition: transform 0.2s, background 0.3s; font-size: 1rem; box-shadow: 0 4px 12px rgba(27, 38, 49, 0.15);">
                <span>MASUK SEKARANG</span>
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>

        <div style="margin-top: 2rem; text-align: center; border-top: 1px solid #F1F5F9; padding-top: 1.5rem;">
            <p style="color: #94A3B8; font-size: 0.8rem;">&copy; 2026 Admin Management Portal • v2.0 Premium</p>
        </div>
    </div>

    <style>
        input:focus {
            border-color: #1B2631 !important;
            box-shadow: 0 0 0 4px rgba(27, 38, 49, 0.05);
        }
        .btn-premium:hover {
            background: #2C3E50 !important;
            transform: translateY(-1px);
        }
        .btn-premium:active {
            transform: translateY(0);
        }
    </style>
</x-guest-layout>