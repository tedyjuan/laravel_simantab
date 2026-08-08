<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 text-gray-800 overflow-x-hidden">

    <div class="flex min-h-screen relative">

        {{-- Mobile Overlay --}}
        <div id="mobileOverlay" class="fixed inset-0 bg-gray-900/50 z-20 hidden lg:hidden transition-opacity opacity-0">
        </div>

        {{-- ============ SIDEBAR ============ --}}
        <x-sidebar />


        {{-- ============ MAIN CONTENT (Header + Main + Footer) ============ --}}
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">

            {{-- Topbar --}}
            @persist('topbar')
                <x-topbar />
            @endpersist


            {{-- Content --}}
            <main class="flex-1 p-6 space-y-6">
                {{-- Stat cards --}}
                {{ $slot }}
            </main>

            {{-- Footer --}}
            @persist('footer')
                <x-footer />
            @endpersist



        </div>
    </div>


    @livewireScripts
</body>

</html>
