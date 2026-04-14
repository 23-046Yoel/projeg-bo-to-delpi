<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Menu MBG | Alad Elphi</title>
    <meta name="description" content="Lihat jadwal menu harian Program Makan Bergizi Gratis (MBG) dari Yayasan Alad Elphi & Badan Gizi Nasional.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f5f7fa; color: #1a2540; }

        /* NAV */
        .nav { background: #0f1e40; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .nav-brand { color: #f0c040; font-weight: 900; font-size: 18px; letter-spacing: 1px; text-decoration: none; }
        .nav-links a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-left: 24px; transition: color .2s; }
        .nav-links a:hover { color: #f0c040; }

        /* HERO */
        .hero { background: linear-gradient(135deg, #0f1e40 0%, #1a3a6a 100%); padding: 60px 32px 40px; text-align: center; }
        .hero-tag { display: inline-block; background: rgba(240,192,64,0.15); border: 1px solid #f0c040; color: #f0c040; font-size: 10px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; padding: 6px 16px; border-radius: 999px; margin-bottom: 16px; }
        .hero h1 { color: #fff; font-size: clamp(24px, 5vw, 42px); font-weight: 900; line-height: 1.2; margin-bottom: 12px; }
        .hero p { color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 500; max-width: 480px; margin: 0 auto 32px; }

        /* FILTER */
        .filter-bar { background: #fff; border-bottom: 1px solid #eee; padding: 16px 32px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .filter-bar label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #0f1e40; }
        .filter-bar select { padding: 10px 16px; border: 2px solid #eee; border-radius: 12px; font-size: 13px; font-weight: 600; color: #1a2540; font-family: inherit; outline: none; cursor: pointer; transition: border-color .2s; }
        .filter-bar select:focus { border-color: #f0c040; }
        .filter-bar button { padding: 10px 20px; background: #0f1e40; color: #f0c040; border: none; border-radius: 12px; font-size: 11px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: all .2s; }
        .filter-bar button:hover { background: #1a3a6a; transform: translateY(-1px); }

        /* MAIN */
        .main { max-width: 1100px; margin: 0 auto; padding: 32px 16px 80px; }

        /* DATE GROUP */
        .date-group { margin-bottom: 32px; }
        .date-header { display: flex; align-items: center; gap: 16px; margin-bottom: 16px; }
        .date-badge { background: #0f1e40; color: #f0c040; padding: 8px 20px; border-radius: 999px; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; white-space: nowrap; }
        .date-badge.today { background: #f0c040; color: #0f1e40; }
        .date-line { flex: 1; height: 1px; background: #e5e7eb; }
        .today-badge { background: #22c55e; color: #fff; font-size: 9px; font-weight: 900; padding: 3px 10px; border-radius: 999px; letter-spacing: 1px; text-transform: uppercase; }

        /* MENU CARDS GRID */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
        .menu-card { background: #fff; border-radius: 20px; padding: 24px; border: 1px solid #f0f0f0; box-shadow: 0 4px 20px rgba(0,0,0,0.04); transition: all .3s; }
        .menu-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(15,30,64,0.10); border-color: #f0c040; }

        .card-dapur { font-size: 10px; font-weight: 800; color: #f0c040; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px; }
        .card-title { font-size: 15px; font-weight: 800; color: #0f1e40; margin-bottom: 16px; }

        .menu-items { display: flex; flex-direction: column; gap: 8px; }
        .menu-item { display: flex; align-items: flex-start; gap: 10px; }
        .item-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
        .dot-karbo { background: #f59e0b; }
        .dot-protein { background: #ef4444; }
        .dot-nabati { background: #8b5cf6; }
        .dot-sayur { background: #22c55e; }
        .dot-buah { background: #06b6d4; }
        .dot-pelengkap { background: #ec4899; }
        .item-label { font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; }
        .item-value { font-size: 13px; font-weight: 600; color: #1a2540; }

        /* EMPTY */
        .empty-state { text-align: center; padding: 80px 20px; }
        .empty-state svg { width: 60px; height: 60px; color: #d1d5db; margin: 0 auto 16px; display: block; }
        .empty-state p { color: #9ca3af; font-weight: 600; font-size: 14px; }

        /* BACK LINK */
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 12px; font-weight: 700; margin-bottom: 16px; transition: color .2s; }
        .back-link:hover { color: #f0c040; }

        /* FOOTER */
        .footer { background: #0f1e40; color: rgba(255,255,255,0.4); text-align: center; padding: 24px; font-size: 11px; font-weight: 600; letter-spacing: 1px; }

        @media(max-width: 640px) {
            .nav { padding: 12px 16px; }
            .hero { padding: 40px 16px 30px; }
            .filter-bar { padding: 12px 16px; }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="/" class="nav-brand">🌾 ALAD ELPHI</a>
        <div class="nav-links">
            <a href="/">Beranda</a>
            <a href="/jadwal-menu" style="color:#f0c040">Jadwal Menu</a>
            <a href="/dapur">Profil Dapur</a>
            <a href="/complaints/create">Pengaduan</a>
        </div>
    </nav>

    <div class="hero">
        <a href="/" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Beranda
        </a>
        <div class="hero-tag">Program MBG</div>
        <h1>Jadwal Menu Harian 🍱</h1>
        <p>Menu bergizi yang disiapkan oleh dapur-dapur SPPG Alad Elphi setiap harinya untuk anak-anak generasi bangsa.</p>
    </div>

    <div class="filter-bar">
        <form method="GET" action="/jadwal-menu" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <label>Filter Dapur:</label>
            <select name="sppg_id" onchange="this.form.submit()">
                <option value="">-- Semua Dapur --</option>
                @foreach($sppgs as $sppg)
                    <option value="{{ $sppg->id }}" {{ request('sppg_id') == $sppg->id ? 'selected' : '' }}>
                        {{ $sppg->name }}
                    </option>
                @endforeach
            </select>
            @if(request('sppg_id'))
                <a href="/jadwal-menu" style="font-size:11px;font-weight:800;color:#ef4444;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Reset</a>
            @endif
        </form>
    </div>

    <main class="main">
        @if($menus->isEmpty())
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p>Belum ada jadwal menu yang dipublikasikan untuk dapur ini.</p>
            </div>
        @else
            @foreach($menus as $date => $dayMenus)
                @php
                    $isToday = $date === $today;
                    $tgl = \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y');
                @endphp
                <div class="date-group">
                    <div class="date-header">
                        <span class="date-badge {{ $isToday ? 'today' : '' }}">{{ $tgl }}</span>
                        @if($isToday)<span class="today-badge">📍 Hari Ini</span>@endif
                        <div class="date-line"></div>
                    </div>

                    <div class="menu-grid">
                        @foreach($dayMenus as $menu)
                            <div class="menu-card">
                                <div class="card-dapur">🍳 {{ $menu->sppg->name ?? 'Semua Dapur' }}</div>
                                <div class="card-title">Menu {{ \Carbon\Carbon::parse($menu->date)->translatedFormat('l') }}</div>

                                <div class="menu-items">
                                    @if($menu->karbo)
                                    <div class="menu-item">
                                        <div class="item-dot dot-karbo"></div>
                                        <div>
                                            <div class="item-label">Karbohidrat</div>
                                            <div class="item-value">{{ $menu->karbo }}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($menu->protein_hewani)
                                    <div class="menu-item">
                                        <div class="item-dot dot-protein"></div>
                                        <div>
                                            <div class="item-label">Protein Hewani</div>
                                            <div class="item-value">{{ $menu->protein_hewani }}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($menu->protein_nabati)
                                    <div class="menu-item">
                                        <div class="item-dot dot-nabati"></div>
                                        <div>
                                            <div class="item-label">Protein Nabati</div>
                                            <div class="item-value">{{ $menu->protein_nabati }}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($menu->sayur)
                                    <div class="menu-item">
                                        <div class="item-dot dot-sayur"></div>
                                        <div>
                                            <div class="item-label">Sayuran</div>
                                            <div class="item-value">{{ $menu->sayur }}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($menu->buah)
                                    <div class="menu-item">
                                        <div class="item-dot dot-buah"></div>
                                        <div>
                                            <div class="item-label">Buah</div>
                                            <div class="item-value">{{ $menu->buah }}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($menu->pelengkap)
                                    <div class="menu-item">
                                        <div class="item-dot dot-pelengkap"></div>
                                        <div>
                                            <div class="item-label">Pelengkap</div>
                                            <div class="item-value">{{ $menu->pelengkap }}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($menu->dishes->count() > 0)
                                    <div class="menu-item" style="margin-top:8px;padding-top:8px;border-top:1px solid #f0f0f0;">
                                        <div>
                                            <div class="item-label">🍽️ Hidangan</div>
                                            <div class="item-value">{{ $menu->dishes->pluck('name')->implode(', ') }}</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </main>

    <footer class="footer">
        <p>© {{ date('Y') }} Program Makan Bergizi Gratis (MBG) — Yayasan Alad Elphi & Badan Gizi Nasional</p>
        <p style="margin-top:4px;">📍 <a href="/dapur" style="color:#f0c040;text-decoration:none;">Lihat Profil Dapur</a> &nbsp;|&nbsp; <a href="/complaints/create" style="color:#f0c040;text-decoration:none;">Sampaikan Pengaduan</a></p>
    </footer>
</body>
</html>
