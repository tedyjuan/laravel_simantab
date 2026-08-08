<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Simantab</title>

    <!-- Tailwind + FlyonUI (same design system family as the dashboard) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flyonui@1.4.0/dist/full.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flyonui@1.4.0/dist/index.min.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --brand-50: #eef2ff;
            --brand-500: #6366f1;
            --brand-600: #4f46e5;
            --brand-700: #4338ca;
            --brand-800: #3730a3;
            --brand-900: #312e81;
            --cool-400: #38bdf8;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        .font-display {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }

        /* ---------- Brand panel ---------- */
        .brand-panel {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(120% 140% at 15% 0%, var(--brand-500) 0%, var(--brand-700) 46%, var(--brand-900) 100%);
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(rgba(255, 255, 255, 0.14) 1px, transparent 1px);
            background-size: 26px 26px;
            opacity: .5;
            mask-image: radial-gradient(ellipse 80% 80% at 30% 20%, black 10%, transparent 75%);
        }

        .glow-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(60px);
            pointer-events: none;
        }

        /* Signature element: animated hub connecting the school's core modules —
           Akademik, Keuangan, Siswa, Guru — echoing the ERP's integrated nature */
        .route-path {
            stroke-dasharray: 6 10;
            animation: dash-flow 14s linear infinite;
        }

        @keyframes dash-flow {
            to {
                stroke-dashoffset: -400;
            }
        }

        .route-dot {
            animation: dot-pulse 2.6s ease-in-out infinite;
        }

        .route-dot.d2 {
            animation-delay: .5s;
        }

        .route-dot.d3 {
            animation-delay: 1s;
        }

        @keyframes dot-pulse {

            0%,
            100% {
                opacity: .55;
                r: 4;
            }

            50% {
                opacity: 1;
                r: 5.5;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .route-path {
                animation: none;
            }

            .route-dot {
                animation: none;
            }
        }

        /* ---------- Premium underline inputs ---------- */
        .field-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid #E5E7EB;
            padding: .65rem .1rem .65rem 2.1rem;
            font-size: .925rem;
            color: #111827;
            transition: border-color .2s ease;
        }

        .field-input:focus {
            outline: none;
            border-bottom-color: var(--brand-600);
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: .1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            transition: color .2s ease;
            pointer-events: none;
        }

        .field-input:focus~.field-icon {
            color: var(--brand-600);
        }

        .field-label {
            font-size: .72rem;
            letter-spacing: .04em;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
        }

        .btn-brand {
            background: linear-gradient(135deg, var(--brand-600), var(--brand-700));
            box-shadow: 0 10px 25px -8px rgba(79, 70, 229, .55);
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }

        .btn-brand:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
            box-shadow: 0 14px 30px -8px rgba(79, 70, 229, .6);
        }

        .btn-brand:active {
            transform: translateY(0);
        }

        .fade-up {
            animation: fadeUp .6s cubic-bezier(.16, 1, .3, 1) both;
        }

        .fade-up.d1 {
            animation-delay: .05s;
        }

        .fade-up.d2 {
            animation-delay: .12s;
        }

        .fade-up.d3 {
            animation-delay: .19s;
        }

        .fade-up.d4 {
            animation-delay: .26s;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">

    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- ============ BRAND / SIGNATURE PANEL ============ --}}
        <aside
            class="brand-panel lg:w-[46%] xl:w-[42%] text-white flex flex-col justify-between px-8 py-10 sm:px-12 sm:py-12 lg:px-14 lg:py-14 min-h-[280px] lg:min-h-screen shrink-0">

            <div class="glow-orb w-72 h-72 bg-sky-400/30 -top-16 -left-10"></div>
            <div class="glow-orb w-80 h-80 bg-indigo-400/20 bottom-0 right-0"></div>

            {{-- Logo --}}
            <div class="relative z-10 flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-white/15 backdrop-blur-sm ring-1 ring-white/25 flex items-center justify-center font-bold text-white shadow-lg">
                    S
                </div>
                <span class="font-display font-bold tracking-wide text-lg">Simantab</span>
            </div>

            {{-- Signature: school modules orbiting a connected hub (Akademik, Keuangan, Siswa, Guru) --}}
            <div class="relative z-10 my-10 lg:my-0 hidden sm:block">
                <svg viewBox="0 0 420 240" class="w-full max-w-md" fill="none" xmlns="http://www.w3.org/2000/svg">
                    {{-- connecting lines --}}
                    <path class="route-path" d="M210 118 L 60 50" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"
                        stroke-linecap="round" />
                    <path class="route-path" d="M210 118 L 360 50" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"
                        stroke-linecap="round" />
                    <path class="route-path" d="M210 118 L 60 175" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"
                        stroke-linecap="round" />
                    <path class="route-path" d="M210 118 L 360 175" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"
                        stroke-linecap="round" />

                    {{-- center hub: school building icon --}}
                    <circle cx="210" cy="118" r="20" fill="rgba(255,255,255,0.14)" stroke="white"
                        stroke-opacity="0.35" />
                    <g transform="translate(198,107)" stroke="white" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round" fill="none">
                        {{-- roof --}}
                        <path d="M0 7 L12 0 L24 7" />
                        {{-- building body --}}
                        <path d="M3 7 V22 H21 V7" />
                        {{-- door --}}
                        <path d="M10 22 V15 H14 V22" />
                        {{-- windows --}}
                        <path d="M6.5 11h2M15.5 11h2" />
                        {{-- flag --}}
                        <path d="M12 0 V-5" />
                        <path d="M12 -5 L17 -3.3 L12 -1.6 Z" fill="white" stroke="none" />
                    </g>

                    {{-- Akademik --}}
                    <g class="route-dot">
                        <circle cx="60" cy="50" r="22" fill="rgba(255,255,255,0.12)"
                            stroke="rgba(255,255,255,0.3)" />
                        <path d="M50 46l10-4 10 4-10 4-10-4z" stroke="#C7D2FE" stroke-width="1.6"
                            stroke-linejoin="round" />
                        <path d="M50 49v5c0 1.5 4.5 3 10 3s10-1.5 10-3v-5" stroke="#C7D2FE" stroke-width="1.6"
                            stroke-linecap="round" />
                    </g>
                    {{-- Keuangan --}}
                    <g class="route-dot d2">
                        <circle cx="360" cy="50" r="22" fill="rgba(255,255,255,0.12)"
                            stroke="rgba(255,255,255,0.3)" />
                        <circle cx="360" cy="50" r="8" stroke="#7DD3FC" stroke-width="1.6" />
                        <path
                            d="M360 46v8M357 48.5c0-1.5 1.3-2.5 3-2.5s3 1 3 2.2c0 2.8-6 1.6-6 4.3 0 1.2 1.3 2.2 3 2.2s3-1 3-2.5"
                            stroke="#7DD3FC" stroke-width="1.3" stroke-linecap="round" />
                    </g>
                    {{-- Siswa --}}
                    <g class="route-dot d3">
                        <circle cx="60" cy="175" r="22" fill="rgba(255,255,255,0.12)"
                            stroke="rgba(255,255,255,0.3)" />
                        <circle cx="55" cy="170" r="4.5" fill="#A5B4FC" />
                        <circle cx="66" cy="170" r="4.5" fill="#C7D2FE" />
                        <path d="M48 183c0-4.5 3.5-7 7-7s7 2.5 7 7M59 183c0-4.5 3.5-7 7-7s7 2.5 7 7" stroke="#A5B4FC"
                            stroke-width="1.5" stroke-linecap="round" />
                    </g>
                    {{-- Guru --}}
                    <g class="route-dot">
                        <circle cx="360" cy="175" r="22" fill="rgba(255,255,255,0.12)"
                            stroke="rgba(255,255,255,0.3)" />
                        <circle cx="360" cy="168" r="6" fill="#7DD3FC" />
                        <path d="M348 184c0-6.5 5.4-11 12-11s12 4.5 12 11" stroke="#7DD3FC" stroke-width="1.6"
                            stroke-linecap="round" />
                    </g>

                    {{-- labels --}}
                    <text x="60" y="90" text-anchor="middle" fill="rgba(238,242,255,0.75)" font-size="11"
                        font-family="Inter, sans-serif">Akademik</text>
                    <text x="360" y="90" text-anchor="middle" fill="rgba(238,242,255,0.75)" font-size="11"
                        font-family="Inter, sans-serif">Keuangan</text>
                    <text x="60" y="215" text-anchor="middle" fill="rgba(238,242,255,0.75)" font-size="11"
                        font-family="Inter, sans-serif">Siswa</text>
                    <text x="360" y="215" text-anchor="middle" fill="rgba(238,242,255,0.75)" font-size="11"
                        font-family="Inter, sans-serif">Guru</text>
                </svg>
            </div>

            {{-- Headline + trust points --}}
            <div class="relative z-10 space-y-8">
                <div>
                    <p class="text-indigo-200/80 text-xs font-semibold tracking-widest uppercase mb-2">Sistem ERP
                        Sekolah</p>
                    <h1 class="font-display text-2xl sm:text-3xl font-bold leading-snug">
                        Satu sistem,<br class="hidden sm:block"> kendali penuh operasional sekolah.
                    </h1>
                    <p class="text-indigo-100/80 text-sm mt-3 max-w-sm">
                        Kelola data akademik, keuangan, siswa, dan guru dalam satu dashboard yang terintegrasi dan rapi.
                    </p>
                </div>

                <ul class="space-y-3 text-sm text-indigo-50/90">
                    <li class="flex items-center gap-3">
                        <span
                            class="w-7 h-7 rounded-lg bg-white/10 ring-1 ring-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Rekap SPP & pembayaran otomatis
                    </li>
                    <li class="flex items-center gap-3">
                        <span
                            class="w-7 h-7 rounded-lg bg-white/10 ring-1 ring-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Data siswa & guru real-time
                    </li>
                    <li class="flex items-center gap-3">
                        <span
                            class="w-7 h-7 rounded-lg bg-white/10 ring-1 ring-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Laporan akademik & administrasi sekali klik
                    </li>
                </ul>
            </div>

            <p class="relative z-10 text-xs text-indigo-100/50 mt-10 hidden lg:block">
                &copy; {{ date('Y') ?? '2026' }} Simantab. Semua hak dilindungi.
            </p>
        </aside>

        {{-- ============ FORM PANEL ============ --}}
        <main class="flex-1 flex items-center justify-center px-6 py-12 sm:px-10">
            <div class="w-full max-w-sm">

                <div class="fade-up mb-9">
                    <h2 class="font-display text-2xl font-bold text-gray-900">Selamat datang kembali</h2>
                    <p class="text-sm text-gray-400 mt-1.5">Masuk ke akun admin untuk melanjutkan.</p>
                </div>

                <form class="space-y-7" onsubmit="return handleLogin(event)">

                    {{-- Username --}}
                    <div class="fade-up d1 space-y-1.5">
                        <label for="username" class="field-label">Username</label>
                        <div class="field-wrap">
                            <svg class="field-icon w-4.5 h-4.5" width="18" height="18" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input id="username" name="username" type="text" autocomplete="username" required
                                placeholder="Masukkan username" class="field-input">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="fade-up d2 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="password" class="field-label">Password</label>
                            <a href="#"
                                class="text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors">Lupa
                                password?</a>
                        </div>
                        <div class="field-wrap">
                            <svg class="field-icon w-4.5 h-4.5" width="18" height="18" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required placeholder="Masukkan password" class="field-input pr-8">
                            <button type="button" onclick="togglePassword()" aria-label="Tampilkan password"
                                class="absolute right-0.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600 transition-colors">
                                <svg id="eyeIcon" class="w-4.5 h-4.5" width="18" height="18"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember + row --}}
                    <div class="fade-up d3 flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input type="checkbox"
                                class="checkbox checkbox-sm rounded-md border-gray-300 [--chkbg:theme(colors.indigo.600)] [--chkfg:white]">
                            <span class="text-sm text-gray-500">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button id="loginBtn" type="submit"
                        class="fade-up d4 btn-brand w-full text-white font-semibold text-sm rounded-xl py-3 flex items-center justify-center gap-2">
                        <svg id="loginSpinner" class="hidden w-4 h-4 animate-spin" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                            </path>
                        </svg>
                        <span id="loginBtnText">Masuk</span>
                    </button>
                </form>

                <p class="fade-up d4 text-center text-xs text-gray-400 mt-9">
                    Butuh bantuan? <a href="#"
                        class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">Hubungi admin
                        sistem</a>
                </p>

                <p class="text-center text-xs text-gray-300 mt-6 lg:hidden">
                    &copy; {{ date('Y') ?? '2026' }} Simantab. Semua hak dilindungi.
                </p>
            </div>
        </main>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden ?
                '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.774 3.162 10.066 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.243L9.88 9.88" />' :
                '<path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
        }

        function handleLogin(e) {
            e.preventDefault();
            const btn = document.getElementById('loginBtn');
            const spinner = document.getElementById('loginSpinner');
            const text = document.getElementById('loginBtnText');
            spinner.classList.remove('hidden');
            text.textContent = 'Memproses...';
            btn.disabled = true;
            btn.classList.add('opacity-90', 'cursor-not-allowed');
            // Demo only — replace with actual form submission / Livewire action.
            setTimeout(() => {
                spinner.classList.add('hidden');
                text.textContent = 'Masuk';
                btn.disabled = false;
                btn.classList.remove('opacity-90', 'cursor-not-allowed');
            }, 1600);
            return false;
        }
    </script>
</body>

</html>
