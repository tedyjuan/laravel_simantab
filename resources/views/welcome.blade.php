<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        /* Sidebar Collapsed State */
        .sidebar-collapsed {
            width: 5rem !important;
            /* w-20 */
        }

        .sidebar-collapsed .sidebar-text {
            display: none;
        }

        .sidebar-collapsed .logo-container {
            padding-left: 0;
            padding-right: 0;
            justify-content: center;
        }

        .sidebar-collapsed #profileCard {
            padding-left: .5rem;
            padding-right: .5rem;
        }

        .sidebar-collapsed #profileCard .avatar-ring {
            margin: 0 auto;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 overflow-x-hidden">

    <div class="flex min-h-screen relative">

        {{-- Mobile Overlay --}}
        <div id="mobileOverlay" class="fixed inset-0 bg-gray-900/50 z-20 hidden lg:hidden transition-opacity opacity-0">
        </div>

        {{-- ============ SIDEBAR ============ --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-30 w-64 transform -translate-x-full lg:translate-x-0 lg:static lg:block shrink-0 bg-white border-r border-gray-200 text-gray-700 flex flex-col transition-all duration-300">

            {{-- Logo --}}
            <div
                class="logo-container h-16 flex items-center gap-3 px-6 border-b border-gray-200 transition-all duration-300">
                <div
                    class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white shrink-0 shadow-sm">
                    S
                </div>
                <span class="sidebar-text font-bold text-gray-900 tracking-wide text-lg">Simantab</span>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

                <p class="sidebar-text px-3 pt-2 pb-1 text-xs uppercase tracking-wider text-gray-400 font-semibold">Menu
                    Utama</p>

                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-indigo-50 text-indigo-700 font-medium group">
                    <svg class="w-5 h-5 shrink-0 text-indigo-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="sidebar-text">Dashboard</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                    <svg class="w-5 h-5 shrink-0 group-hover:text-indigo-600 text-gray-400 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m-3 9V9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3z" />
                    </svg>
                    <span class="sidebar-text">Transaksi</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                    <svg class="w-5 h-5 shrink-0 group-hover:text-indigo-600 text-gray-400 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 11-8 0 4 4 0 018 0zm6 4a4 4 0 10-8 0" />
                    </svg>
                    <span class="sidebar-text">Karyawan / Driver</span>
                </a>

                {{-- Laporan with Submenu --}}
                <div>
                    <button
                        onclick="document.getElementById('submenu-laporan').classList.toggle('hidden'); this.querySelector('.chevron').classList.toggle('rotate-180')"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-colors group focus:outline-none">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 group-hover:text-indigo-600 text-gray-400 transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                            </svg>
                            <span class="sidebar-text">Laporan</span>
                        </div>
                        <svg class="chevron w-4 h-4 text-gray-400 sidebar-text transition-transform duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="submenu-laporan" class="hidden pl-4 pr-2 py-1 space-y-1 sidebar-text">
                        <a href="#"
                            class="group flex items-center gap-2 px-3 py-2 text-sm text-gray-500 rounded-lg hover:text-indigo-600 hover:bg-gray-50 transition-colors">
                            <span
                                class="w-1.5 h-1.5 rounded-full bg-gray-400 group-hover:bg-indigo-600 transition-colors shrink-0"></span>
                            Laporan Harian
                        </a>
                        <a href="#"
                            class="group flex items-center gap-2 px-3 py-2 text-sm text-gray-500 rounded-lg hover:text-indigo-600 hover:bg-gray-50 transition-colors">
                            <span
                                class="w-1.5 h-1.5 rounded-full bg-gray-400 group-hover:bg-indigo-600 transition-colors shrink-0"></span>
                            Laporan Bulanan
                        </a>
                    </div>
                </div>

                <p class="sidebar-text px-3 pt-5 pb-1 text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    Lainnya</p>

                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                    <svg class="w-5 h-5 shrink-0 group-hover:text-indigo-600 text-gray-400 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="sidebar-text">Pengaturan</span>
                </a>
            </nav>


        </aside>

        {{-- ============ MAIN CONTENT (Header + Main + Footer) ============ --}}
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">

            {{-- Topbar --}}
            <header
                class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    {{-- Hamburger Button --}}
                    <button id="toggleSidebar"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="relative hidden sm:block shrink-0">
                        <input type="text" placeholder="Cari transaksi..."
                            class="input input-bordered input-sm w-64 pl-9">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </div>
                </div>

                <div class="flex flex-1 items-center justify-end gap-3 sm:gap-4 ml-auto">
                    <label class="btn btn-text btn-circle swap swap-rotate shrink-0">
                        <input type="checkbox" value="dark" class="theme-controller"
                            data-toggle-theme="dark,light" />
                        <svg class="swap-off w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="swap-on w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </label>
                    {{-- ============ USER PROFILE CARD ============ --}}
                    <div id="profileCard" class="relative">
                        <div class="dropdown relative">
                            <button type="button" id="profileBtn"
                                class="flex items-center gap-3 rounded-xl px-2.5 py-2 hover:bg-gray-50 transition-colors focus:outline-none">

                                {{-- Avatar + status dot --}}
                                <div class="avatar-ring relative shrink-0">
                                    <div
                                        class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-sm font-semibold ring-2 ring-white shadow-sm">
                                        AD
                                    </div>
                                    <span
                                        class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                                </div>

                                {{-- Name + role --}}
                                <div class="flex-1 min-w-0 text-left leading-tight hidden sm:block">
                                    <p class="text-sm font-semibold text-gray-900 truncate">Admin</p>
                                    <p class="text-xs text-gray-400 truncate">Branch 318</p>
                                </div>

                                <svg id="profileChevron"
                                    class="w-4 h-4 text-gray-400 shrink-0 transition-transform hidden sm:block"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Dropdown menu (muncul di bawah tombol) --}}
                            <div id="profileDropdown" class="absolute top-full right-0 mt-1 w-48 hidden z-50">
                                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                                    <ul class="py-1.5 text-sm text-gray-600">
                                        <li>
                                            <a href="#"
                                                class="flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 hover:text-indigo-600 transition-colors">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Profil Saya
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center gap-2.5 px-4 py-2 hover:bg-gray-50 hover:text-indigo-600 transition-colors">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Pengaturan
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="my-1 border-gray-100">
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center gap-2.5 px-4 py-2 text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Keluar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-6 space-y-6">

                {{-- Stat cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    <div class="card bg-white shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="card-body p-5">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">Total Transaksi</p>
                                <span class="badge badge-success badge-soft text-xs">+12.4%</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900 mt-1">1.284</p>
                            <p class="text-xs text-gray-400 mt-1">Dibanding kemarin</p>
                        </div>
                    </div>

                    <div class="card bg-white shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="card-body p-5">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">Total Setoran</p>
                                <span class="badge badge-success badge-soft text-xs">+8.1%</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900 mt-1">Rp 482,3jt</p>
                            <p class="text-xs text-gray-400 mt-1">Dibanding kemarin</p>
                        </div>
                    </div>

                    <div class="card bg-white shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="card-body p-5">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">Belum Transfer</p>
                                <span class="badge badge-warning badge-soft text-xs">-3.2%</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900 mt-1">37</p>
                            <p class="text-xs text-gray-400 mt-1">Perlu ditindaklanjuti</p>
                        </div>
                    </div>

                    <div class="card bg-white shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="card-body p-5">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">Driver Aktif</p>
                                <span class="badge badge-success badge-soft text-xs">+2</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900 mt-1">64</p>
                            <p class="text-xs text-gray-400 mt-1">Dari 70 driver terdaftar</p>
                        </div>
                    </div>
                </div>


            </main>

            {{-- Footer: sekarang berada di dalam kolom konten (bukan sejajar sidebar) --}}
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div
                    class="flex flex-col sm:flex-row items-center justify-between gap-2 px-4 sm:px-6 py-4 text-xs text-gray-400">
                    <p>&copy; {{ date('Y') }} Simantab. Semua hak dilindungi.</p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="hover:text-gray-600 transition-colors">Bantuan</a>
                        <a href="#" class="hover:text-gray-600 transition-colors">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-gray-600 transition-colors">Syarat & Ketentuan</a>
                    </div>
                </div>
            </footer>


        </div>
    </div>

    <script>
        // Profile Dropdown Toggle Logic
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const profileChevron = document.getElementById('profileChevron');

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
                if (profileChevron) {
                    profileChevron.classList.toggle('rotate-180');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                    if (profileChevron) {
                        profileChevron.classList.remove('rotate-180');
                    }
                }
            });
        }

        // Mobile and Desktop Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        toggleBtn.addEventListener('click', function() {
            if (window.innerWidth >= 1024) {
                // lg breakpoint: toggle mini sidebar on desktop
                sidebar.classList.toggle('sidebar-collapsed');
            } else {
                // mobile: toggle off-canvas sidebar
                sidebar.classList.toggle('-translate-x-full');
                mobileOverlay.classList.toggle('hidden');
                setTimeout(() => mobileOverlay.classList.toggle('opacity-0'), 10);
            }
        });

        // Close sidebar when clicking overlay on mobile
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('opacity-0');
                setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
            });
        }
    </script>
    @livewireScripts
</body>

</html>
