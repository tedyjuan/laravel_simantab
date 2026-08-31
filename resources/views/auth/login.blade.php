<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — Simantab</title>

    <!-- Tailwind + FlyonUI (same design system family as the dashboard) -->
    @vite(['resources/css/login.css', 'resources/js/login.js'])
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
                        Kelola data akademik, keuangan, siswa, dan guru dalam satu dashboard yang terintegrasi dan
                        real-time.
                    </p>
                </div>

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

                <form id="loginForm" class="space-y-7" method="POST" action="{{ route('login.process') }}"
                    onsubmit="return handleLogin(event)">
                    @csrf

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
                                placeholder="Masukkan username" class="field-input focus" tabindex="1">
                        </div>
                        <p id="usernameError" class="hidden text-sm text-red-500"></p>
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
                                tabindex="2" required placeholder="Masukkan password" class="field-input pr-8">
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
                            <p id="passwordError" class="hidden text-sm text-red-500"></p>
                        </div>
                    </div>

                    {{-- Remember + row --}}
                    <div class="fade-up d3 flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input type="checkbox" name="remember" value="1"
                                class="checkbox checkbox-sm rounded-md border-gray-300 [--chkbg:theme(colors.indigo.600)] [--chkfg:white]">
                            <span class="text-sm text-gray-500">Remember Me</span>
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

    <script></script>
</body>

</html>
