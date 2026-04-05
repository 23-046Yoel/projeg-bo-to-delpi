<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div style="display: flex !important; flex-direction: column !important; gap: 2rem !important; align-items: center !important; text-align: center !important; padding: 1rem 0 !important;">
        <div style="margin-bottom: 1rem !important;">
            <p style="font-size: 14px !important; color: #475569 !important; font-weight: 600 !important; line-height: 1.6 !important;">
                Untuk keamanan dan kemudahan, silakan masuk menggunakan akun WhatsApp Anda.
            </p>
        </div>

        <a href="{{ route('login.wa') }}" class="btn-premium" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; gap: 0.75rem !important; width: 100% !important; padding: 1.25rem !important; text-decoration: none !important; font-size: 16px !important; letter-spacing: 0.1em !important;">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" width="24" height="24" style="width: 24px !important; height: 24px !important;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.445 0 .081 5.363.079 11.97c0 2.112.551 4.171 1.597 6.011L0 24l6.193-1.623c1.787.974 3.8 1.488 5.854 1.489h.005c6.605 0 11.97-5.363 11.972-11.971 0-3.202-1.246-6.212-3.507-8.473"/></svg>
            MASUK DENGAN WHATSAPP
        </a>

        <div style="margin-top: 2rem !important; border-top: 1px solid #f1f5f9 !important; padding-top: 1.5rem !important; width: 100% !important;">
            <p style="font-size: 10px !important; color: #94a3b8 !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.2em !important;">
                Sistem Manajemen Premium
            </p>
        </div>
    </div>
</x-guest-layout>
