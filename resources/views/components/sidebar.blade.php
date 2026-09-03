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
            <span
                class="icon-[solar--home-2-outline] w-5 h-5 shrink-0 group-hover:text-indigo-600 text-gray-400 transition-colors"></span>
            <span class="sidebar-text">Dashboard</span>
        </a>
        {{-- Master with Submenu --}}
        @php
            $masterOpen = request()->routeIs(
                'kelas.*',
                'pegawai.*',
                'tahunajar.*',
                'kurikulum.*',
                'mapel.*',
                'jenjang.*',
                'jabatan.*',
                'gedung.*',
                'ruangan.*',
            );
        @endphp

        <div>
            <button
                onclick="
            document.getElementById('submenu-master').classList.toggle('hidden');
            this.querySelector('.chevron').classList.toggle('rotate-180')
        "
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-colors group focus:outline-none">

                <div class="flex items-center gap-3">
                    <span
                        class="icon-[solar--database-outline] w-5 h-5 shrink-0
                {{ $masterOpen ? 'text-indigo-600' : 'text-gray-400' }}
                group-hover:text-indigo-600 transition-colors">
                    </span>

                    <span class="sidebar-text
                {{ $masterOpen ? 'text-indigo-600' : '' }}">
                        Master
                    </span>
                </div>

                <svg class="chevron w-4 h-4 text-gray-400 sidebar-text transition-transform duration-200
            {{ $masterOpen ? 'rotate-180' : '' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="submenu-master" class="{{ $masterOpen ? '' : 'hidden' }} pl-4 pr-2 py-1 space-y-1 sidebar-text">

                {{-- Master Kelas --}}
                <a href="{{ route('kelas.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('kelas.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                    <span
                        class="icon-[streamline--class-lesson] w-5 h-5 shrink-0 {{ request()->routeIs('kelas.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }} transition-colors">
                    </span>
                    Master Kelas
                </a>

                {{-- Master Pegawai --}}
                <a href="{{ route('pegawai.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors{{ request()->routeIs('pegawai.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">

                    <span
                        class="icon-[solar--users-group-rounded-outline] w-5 h-5 shrink-0
                {{ request()->routeIs('pegawai.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}
                transition-colors">
                    </span>

                    Master Pegawai
                </a>
                {{-- Master Tahun Ajar --}}
                <a href="{{ route('tahunajar.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors{{ request()->routeIs('tahunajar.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">

                    <span
                        class="icon-[fluent-mdl2:calendar-year] w-5 h-5 shrink-0  
                        {{ request()->routeIs('tahunajar.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}
                        transition-colors">
                    </span>

                    Master Tahun Ajar
                </a>
                {{-- Master kurikulum --}}
                <a href="{{ route('kurikulum.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors{{ request()->routeIs('kurikulum.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                    <span
                        class="icon-[ic--outline-book] w-5 h-5 shrink-0
                        {{ request()->routeIs('kurikulum.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}
                        transition-colors">
                    </span>
                    Master kurikulum
                </a>
                {{-- Master Mapel --}}
                <a href="{{ route('mapel.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors{{ request()->routeIs('mapel.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                    <span
                        class=" icon-[solar--book-outline] w-5 h-5 shrink-0
                        {{ request()->routeIs('mapel.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}
                        transition-colors">
                    </span>
                    Master Mapel
                </a>
                {{-- Master Jenjang --}}
                <a href="{{ route('jenjang.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors{{ request()->routeIs('jenjang.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                    <span
                        class="icon-[ion--school-outline] w-5 h-5 shrink-0
                        {{ request()->routeIs('jenjang.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}
                        transition-colors">
                    </span>
                    Master Jenjang
                </a>
                {{-- Master Jabatan --}}
                <a href="{{ route('jabatan.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors{{ request()->routeIs('jabatan.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                    <span
                        class="icon-[mdi--account-tie] w-5 h-5 shrink-0
                        {{ request()->routeIs('jabatan.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}
                        transition-colors">
                    </span>
                    Master Jabatan
                </a>
                {{-- Master Gedung --}}
                <a href="{{ route('gedung.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors{{ request()->routeIs('gedung.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                    <span
                        class="icon-[carbon--building] w-5 h-5 shrink-0
                        {{ request()->routeIs('gedung.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}
                        transition-colors">
                    </span>
                    Master Gedung
                </a>
                <a href="{{ route('ruangan.index') }}"
                    class="group flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors{{ request()->routeIs('ruangan.*')
                        ? 'text-indigo-600 bg-indigo-50'
                        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50' }}">
                    <span
                        class="icon-[cil--room] w-5 h-5 shrink-0
                        {{ request()->routeIs('ruangan.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}
                        transition-colors">
                    </span>
                    Master Ruangan
                </a>

            </div>
        </div>




    </nav>
</aside>
