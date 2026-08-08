<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password — Simantab</title>

    <!-- Tailwind + FlyonUI (same design system family as the dashboard) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flyonui@1.4.0/dist/full.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flyonui@1.4.0/dist/index.min.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>

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
                        Akun Anda,<br class="hidden sm:block"> aman dan mudah dipulihkan.
                    </h1>
                    <p class="text-indigo-100/80 text-sm mt-3 max-w-sm">
                        Lupa password bukan masalah — kami bantu Anda kembali mengakses dashboard sekolah dalam hitungan
                        menit.
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
                        Tautan reset dikirim langsung ke email terdaftar
                    </li>
                    <li class="flex items-center gap-3">
                        <span
                            class="w-7 h-7 rounded-lg bg-white/10 ring-1 ring-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Proses terenkripsi & aman
                    </li>
                    <li class="flex items-center gap-3">
                        <span
                            class="w-7 h-7 rounded-lg bg-white/10 ring-1 ring-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Butuh bantuan? Admin sistem siap membantu
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

                {{-- ===== STATE 1: request form ===== --}}
                <div id="requestState">

                    <a href="#"
                        class="fade-up inline-flex items-center gap-1.5 text-xs font-medium text-gray-400 hover:text-indigo-600 transition-colors mb-7">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke halaman masuk
                    </a>

                    <div class="fade-up d1 mb-9">
                        <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h2 class="font-display text-2xl font-bold text-gray-900">Lupa password?</h2>
                        <p class="text-sm text-gray-400 mt-1.5">Masukkan email atau username akun Anda, kami akan
                            mengirimkan tautan untuk mengatur ulang password.</p>
                    </div>

                    <form class="space-y-7" onsubmit="return handleReset(event)">

                        {{-- Email / Username --}}
                        <div class="fade-up d2 space-y-1.5">
                            <label for="identity" class="field-label">Email atau Username</label>
                            <div class="field-wrap">
                                <svg class="field-icon w-4.5 h-4.5" width="18" height="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-3.5 7.13" />
                                </svg>
                                <input id="identity" name="identity" type="text" autocomplete="username"
                                    required placeholder="nama@sekolah.sch.id" class="field-input">
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button id="resetBtn" type="submit"
                            class="fade-up d3 btn-brand w-full text-white font-semibold text-sm rounded-xl py-3 flex items-center justify-center gap-2">
                            <svg id="resetSpinner" class="hidden w-4 h-4 animate-spin" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>
                            </svg>
                            <span id="resetBtnText">Kirim Tautan Reset</span>
                        </button>
                    </form>

                    <p class="fade-up d4 text-center text-xs text-gray-400 mt-9">
                        Ingat password Anda? <a href="login.html"
                            class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">Masuk di
                            sini</a>
                    </p>
                </div>

                {{-- ===== STATE 2: confirmation ===== --}}
                <div id="sentState" class="hidden text-center">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="font-display text-2xl font-bold text-gray-900">Periksa email Anda</h2>
                    <p class="text-sm text-gray-400 mt-2 leading-relaxed">
                        Kami telah mengirimkan tautan reset password ke <span id="sentToEmail"
                            class="font-medium text-gray-600">akun Anda</span>. Tautan berlaku selama 30 menit.
                    </p>

                    <button onclick="resendLink()"
                        class="mt-8 w-full border border-gray-200 text-gray-600 font-semibold text-sm rounded-xl py-3 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                        Kirim ulang tautan
                    </button>

                    <a href="login.html"
                        class="inline-flex items-center gap-1.5 justify-center text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors mt-6">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke halaman masuk
                    </a>
                </div>

                <p class="text-center text-xs text-gray-300 mt-10 lg:hidden">
                    &copy; {{ date('Y') ?? '2026' }} Simantab. Semua hak dilindungi.
                </p>
            </div>
        </main>
    </div>

    <script>
        function handleReset(e) {
            e.preventDefault();
            const btn = document.getElementById('resetBtn');
            const spinner = document.getElementById('resetSpinner');
            const text = document.getElementById('resetBtnText');
            const identity = document.getElementById('identity').value.trim();

            spinner.classList.remove('hidden');
            text.textContent = 'Mengirim...';
            btn.disabled = true;
            btn.classList.add('opacity-90', 'cursor-not-allowed');

            // Demo only — replace with actual form submission / Livewire action.
            setTimeout(() => {
                spinner.classList.add('hidden');
                text.textContent = 'Kirim Tautan Reset';
                btn.disabled = false;
                btn.classList.remove('opacity-90', 'cursor-not-allowed');

                document.getElementById('sentToEmail').textContent = identity || 'akun Anda';
                document.getElementById('requestState').classList.add('hidden');
                document.getElementById('sentState').classList.remove('hidden');
                document.getElementById('sentState').classList.add('fade-up');
            }, 1400);
            return false;
        }

        function resendLink() {
            const label = document.querySelector('#sentState button');
            const original = label.textContent;
            label.textContent = 'Mengirim ulang...';
            label.disabled = true;
            setTimeout(() => {
                label.textContent = 'Tautan terkirim ulang';
                setTimeout(() => {
                    label.textContent = original;
                    label.disabled = false;
                }, 2000);
            }, 1000);
        }
    </script>
</body>

</html>