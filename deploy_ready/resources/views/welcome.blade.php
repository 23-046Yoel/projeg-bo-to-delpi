<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BoTo Delphi - Premium Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,900&family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
            background-image: radial-gradient(circle at 80% 10%, rgba(212,175,55,0.08) 0%, transparent 50%),
                              radial-gradient(circle at 10% 90%, rgba(15,23,42,0.05) 0%, transparent 50%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem; /* Reduced from 1.5rem */
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        .page-wrapper {
            width: 100%;
            max-width: 420px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.5rem; /* Added internal padding */
        }

        /* Logo area */
        .logo-area {
            margin-bottom: 2rem;
            display: flex;
            justify-content: center;
            transition: transform 0.6s ease;
        }
        .logo-area:hover { transform: translateY(-6px); }

        /* Card */
        .card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 32px 80px -12px rgba(15,23,42,0.12);
            border-radius: 1.75rem;
            width: 100%;
            overflow: hidden;
        }

        .card-accent {
            height: 4px;
            background: linear-gradient(90deg, #B8860B, #D4AF37, #B8860B);
        }

        .card-body {
            padding: 2rem 1.5rem;
        }

        @media (min-width: 480px) {
            .card-body { padding: 2.5rem 2rem; }
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 900;
            font-size: 1.75rem;
            color: #0F172A;
            text-align: center;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .card-subtitle {
            text-align: center;
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 1.75rem;
        }

        /* Logged-in state */
        .user-greeting {
            text-align: center;
            padding: 1rem 0;
        }
        .user-greeting p {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        .user-greeting strong {
            color: #0F172A;
            font-weight: 900;
            font-size: 1.1rem;
        }

        /* CTA Button */
        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            width: 100%;
            padding: 0.9rem 1.25rem;
            border-radius: 0.875rem;
            font-weight: 900;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(135deg, #0F172A 0%, #1e293b 100%);
            box-shadow: 0 12px 30px -6px rgba(15,23,42,0.3);
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            -webkit-tap-highlight-color: transparent;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 36px -6px rgba(15,23,42,0.35);
        }
        .btn-primary:active {
            transform: scale(0.98);
        }
        .btn-primary svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* Arrow SVG in dashboard button */
        .btn-primary .arrow-svg {
            width: 14px;
            height: 14px;
        }

        /* Footer */
        .page-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.6rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.4em;
            color: #94a3b8;
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- Logo -->
        <div class="logo-area">
            <a href="/" style="text-decoration:none;">
                <x-application-logo style="width:80px;height:auto;" />
            </a>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-accent"></div>
            <div class="card-body">
                <h1 class="card-title">Selamat Datang</h1>

                @if (Route::has('login'))
                    @auth
                        <div class="user-greeting">
                            <p>Anda sudah masuk sebagai</p>
                            <p><strong>{{ Auth::user()->name }}</strong></p>
                        </div>
                        <div style="margin-top:1.5rem;">
                            <a href="{{ url('/dashboard') }}" class="btn-primary">
                                Buka Portal Dashboard
                                <svg class="arrow-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    @else
                        <p class="card-subtitle">
                            Silakan masuk menggunakan akun WhatsApp terdaftar Anda untuk mengakses sistem manajemen MBG.
                        </p>
                        <a href="{{ route('login.wa') }}" class="btn-primary">
                            <svg fill="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.445 0 .081 5.363.079 11.97c0 2.112.551 4.171 1.597 6.011L0 24l6.193-1.623c1.787.974 3.8 1.488 5.854 1.489h.005c6.605 0 11.97-5.363 11.972-11.971 0-3.202-1.246-6.212-3.507-8.473"/>
                            </svg>
                            Masuk Lewat WhatsApp
                        </a>
                    @endauth
                @endif
            </div>
        </div>

        <p class="page-footer">&copy; 2026 BOTO DELPHI. ALL RIGHTS RESERVED.</p>
    </div>
</body>
</html>
