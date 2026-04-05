<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - CyberPanel Theme</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            :root {
                --cp-navy: #1B2631;
                --cp-navy-light: #212F3D;
                --cp-green: #27AE60;
                --cp-green-hover: #219150;
                --cp-bg: #F4F7F9;
                --cp-text: #2C3E50;
                --cp-border: #D5DBDB;
                --cp-shadow: rgba(0, 0, 0, 0.08);
            }

            body {
                font-family: 'Inter', sans-serif;
                background: var(--cp-bg);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: var(--cp-text);
                padding: 1.5rem;
                -webkit-font-smoothing: antialiased;
            }

            .page-wrapper {
                width: 100%;
                max-width: 420px;
                display: flex;
                flex-direction: column;
                animation: fadeIn 0.5s ease-out;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Simple Header */
            .panel-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .panel-logo {
                background: var(--cp-green);
                width: 64px;
                height: 64px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
                color: white;
                box-shadow: 0 8px 16px rgba(39, 174, 96, 0.2);
            }

            .panel-logo svg {
                width: 36px;
                height: 36px;
            }

            .panel-title {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 800;
                font-size: 1.5rem;
                color: var(--cp-navy);
                letter-spacing: -0.02em;
            }

            /* CyberPanel Style Card */
            .card {
                background: white;
                border-radius: 8px;
                border: 1px solid var(--cp-border);
                box-shadow: 0 10px 30px var(--cp-shadow);
                width: 100%;
                overflow: hidden;
            }

            .card-header-accent {
                height: 4px;
                background: var(--cp-green);
            }

            .card-content {
                padding: 2.5rem 2rem;
            }

            /* Forms - Technical & Clean */
            .field-label {
                display: block;
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--cp-navy-light);
                margin-bottom: 0.5rem;
            }

            .input-wrapper {
                position: relative;
                margin-bottom: 1.5rem;
            }

            input[type="text"], input[type="password"], input[type="email"] {
                width: 100%;
                background: #FFFFFF;
                border: 1px solid var(--cp-border);
                border-radius: 6px;
                padding: 0.875rem 1rem 0.875rem 4.5rem;
                font-family: 'Inter', sans-serif;
                font-size: 1.1rem;
                color: #000000;
                font-weight: 500;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s;
            }

            input[type="text"]:focus {
                border-color: var(--cp-green);
                box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
            }

            .input-prefix {
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                font-weight: 800;
                color: var(--cp-green);
                font-size: 1.1rem;
                border-right: 2px solid var(--cp-border);
                padding-right: 0.75rem;
                line-height: 1.2;
                display: flex;
                align-items: center;
                height: 1.5rem;
            }

            /* OTP Boxes - Technical */
            .otp-grid {
                display: flex;
                justify-content: center;
                gap: 0.5rem;
                margin-bottom: 2rem;
                flex-wrap: nowrap;
            }

            input[type="text"].otp-input {
                width: 48px !important;
                height: 54px !important;
                padding: 0 !important;
                background: white;
                border: 1.5px solid var(--cp-border);
                border-radius: 8px;
                text-align: center;
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--cp-navy);
                outline: none;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }

            input[type="text"].otp-input:focus {
                border-color: var(--cp-green);
                box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
                transform: translateY(-2px);
            }

            /* CyberPanel Primary Button */
            .btn-premium {
                height: 3.5rem;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                background: var(--cp-green);
                color: white !important;
                font-weight: 700;
                font-size: 1rem;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
                text-decoration: none;
            }

            .btn-premium svg {
                width: 1.25rem;
                height: 1.25rem;
                flex-shrink: 0;
                stroke-width: 3;
            }

            .btn-premium:hover {
                background: var(--cp-green-hover);
                box-shadow: 0 8px 24px rgba(39, 174, 96, 0.3);
                transform: translateY(-1px);
            }

            .btn-premium:active {
                transform: scale(0.98);
            }

            .btn-text-link {
                color: var(--cp-green);
                font-size: 0.85rem;
                font-weight: 700;
                background: none;
                border: none;
                cursor: pointer;
                margin-top: 1.5rem;
                text-decoration: none;
                transition: all 0.2s;
                opacity: 0.8;
            }

            .btn-text-link:hover { 
                opacity: 1;
                text-decoration: underline;
                text-underline-offset: 4px;
            }

            /* Feedback */
            .msg-box {
                margin-top: 1.5rem;
                padding: 1rem;
                border-radius: 6px;
                font-size: 0.85rem;
                font-weight: 500;
                text-align: left;
                display: none;
                border-left: 4px solid transparent;
            }
            .msg-box.success { background: #E8F8F5; color: #145A32; display: block; border-left-color: #27AE60; }
            .msg-box.error { background: #FDEDEC; color: #78281F; display: block; border-left-color: #CB4335; }

            .phone-display {
                font-weight: 700;
                color: var(--cp-navy);
                margin: 0.5rem 0 1rem 0;
                display: block;
            }

            /* Footer - Minimal */
            .page-footer {
                margin-top: 2rem;
                font-size: 0.75rem;
                color: #AAB7B8;
                text-align: center;
            }

            @media (max-width: 480px) {
                .card-content { padding: 2rem 1.5rem; }
                .otp-input { width: 42px; height: 42px; font-size: 1.25rem; }
            }

            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body>
        <div class="page-wrapper">
            <header class="panel-header">
                <div class="panel-logo">
                    <x-application-logo />
                </div>
                <h1 class="panel-title">CyberPanel Control</h1>
            </header>

            <div class="card">
                <div class="card-header-accent"></div>
                <div class="card-content">
                    {{ $slot }}
                </div>
            </div>

            <p class="page-footer">&copy; 2026 Admin Management Portal &bull; v1.0</p>
        </div>
    </body>
</html>