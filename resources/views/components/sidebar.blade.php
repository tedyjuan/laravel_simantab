<aside id="sidebar"
    class=" fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full transform border-r border-gray-300 bg-base-100 transition-all duration-300 lg:sticky lg:top-0 lg:translate-x-0">
    {{-- Logo --}}
    <div class="logo-container h-16 flex items-center gap-3 px-6 border-b border-gray-200 transition-all duration-300">
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
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group
                    {{ request()->routeIs('dashboard')
                        ? 'bg-indigo-50 text-indigo-700 font-medium'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
            <svg class="w-5 h-5 shrink-0 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="sidebar-text">Dashboard</span>
        </a>
        <a href="{{ route('pegawai.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group
                    {{ request()->routeIs('pegawai.index')
                        ? 'bg-indigo-50 text-indigo-700 font-medium'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
            <svg class="w-5 h-5 shrink-0 group-hover:text-indigo-600 text-gray-400 transition-colors" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m-3 9V9" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3z" />
            </svg>
            <span class="sidebar-text">Master Pegawai</span>
        </a>
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
            <svg class="w-5 h-5 shrink-0 group-hover:text-indigo-600 text-gray-400 transition-colors" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <svg class="chevron w-4 h-4 text-gray-400 sidebar-text transition-transform duration-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
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
            <svg class="w-5 h-5 shrink-0 group-hover:text-indigo-600 text-gray-400 transition-colors" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="sidebar-text">Pengaturan</span>
        </a>
    </nav>
</aside>
