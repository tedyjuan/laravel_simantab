    <header
        class="h-16 bg-white border-b border-base-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-10">
        <div class="flex items-center gap-4">
            {{-- Hamburger Button --}}
            <button id="toggleSidebar"
                class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            {{-- ...search input tetap sama... --}}
            <div class="relative hidden sm:block shrink-0">
                <input type="text" placeholder="Cari transaksi..." class="input input-bordered input-sm w-64 pl-9">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
            </div>
        </div>

        <div class="flex flex-1 items-center justify-end gap-3 sm:gap-4 ml-auto">

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
                            class="w-4 h-4 text-gray-400 shrink-0 transition-transform hidden sm:block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>

                                    <button type="button" onclick="handleLogout()"
                                        class="flex items-center gap-2.5 px-4 py-2 text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors w-full text-left">

                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>

                                        Keluar

                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </header>
