<div id="halaman_master_Jabatan" x-data="{ modalOpen: false, deleteModalOpen: false }" x-on:open-modal.window="modalOpen = true"
    x-on:close-modal.window="modalOpen = false" x-on:close-delete-modal.window="deleteModalOpen = false">

    {{-- =========================================================
    HEADER
    ========================================================== --}}
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <nav class="mb-1 flex items-center gap-1.5 text-xs font-medium text-[#9A97B8]">
                <span>Master Data</span>
                <span class="icon-[tabler--chevron-right] size-3.5"></span>
                <span class="text-[#6552E0]">Jabatan</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-[#21203D] sm:text-[28px]">
                Data Jabatan
            </h1>
            <p class="mt-1 text-sm text-[#767492]">
                Kelola Jabatan dalam satu tempat.
            </p>
        </div>

    </div>


    {{-- =========================================================
    FILTER + TAMBAH (1 ROW)
    ========================================================== --}}
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <label
            class="input flex grow items-center gap-2 rounded-2xl border border-[#ECE9F7] bg-white px-4 py-2.5 shadow-[0_2px_10px_-4px_rgba(33,32,61,0.06)] focus-within:border-[#B9AFF2] sm:max-w-sm">
            <span class="icon-[tabler--search] size-4 text-[#9A97B8]"></span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau NIP..."
                class="grow bg-transparent text-sm placeholder:text-[#B4B1CB] focus:outline-none" />
        </label>

    </div>

    {{-- =========================================================
    TABLE
    ========================================================== --}}
    <div
        class="overflow-hidden rounded-2xl border border-[#ECE9F7] bg-white shadow-[0_2px_10px_-4px_rgba(33,32,61,0.06)]">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr class="border-b border-[#ECE9F7] bg-[#FBFAFE] text-xs uppercase tracking-wide text-[#9A97B8]">
                        <th>Urutan</th>
                        <th>Kode Jabatan</th>
                        <th>Nama Jabatan</th>
                        <th>Jenis Jabatan</th>
                        <th>Status</th>
                        <th class="pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($Jabatans as $Jabatan)
                        <tr wire:key="Jabatan-{{ $Jabatan->id }}"
                            class="border-b border-[#F3F1FA] last:border-0 hover:bg-[#FAFAFD]">
                            {{-- Urutan --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $Jabatan->urutan ?? '-' }}
                            </td>
                            {{-- Kode jejang --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $Jabatan->kode_jabatan ?? '-' }}
                            </td>
                            {{-- Nama Jabatan --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $Jabatan->nama_jabatan ?? '-' }}
                            </td>
                            {{-- Jenis Jabatan --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $Jabatan->jenis_jabatan ?? '-' }}
                            </td>

                            {{-- status --}}
                            <td>
                                @php
                                    $statusClass = match ($Jabatan->status) {
                                        'aktif' => 'bg-[#E7F8EE] text-[#1E9E5A]',
                                        'nonaktif' => 'bg-[#FBEAEA] text-[#C0392B]',
                                        default => 'bg-[#F3F1FA] text-[#6B6890]',
                                    };
                                    $statusLabel = ucfirst($Jabatan->status ?? '-');
                                @endphp
                                <span class="badge badge-sm gap-1.5 border-none font-medium {{ $statusClass }}">
                                    <span class="size-1.5 rounded-full bg-current"></span>
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            {{-- AKSI --}}
                            <td class="pr-6">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Edit: WAJIB ke server, data harus diambil dari DB --}}
                                    <button type="button" wire:click="edit('{{ $Jabatan->id }}')" title="Edit"
                                        class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#EAF1FE] hover:text-[#2E6FE0]">
                                        <span class="icon-[tabler--edit] size-4"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-14 text-center">
                                <span
                                    class="icon-[tabler--user-search] mx-auto mb-2 block size-8 text-[#D8D5EC]"></span>
                                <p class="text-sm font-medium text-[#767492]">
                                    Tidak ada data Jabatan
                                </p>
                                <p class="text-xs text-[#B4B1CB]">
                                    Coba ubah kata kunci pencarian
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- PAGINATION --}}
        <div class="border-t border-[#ECE9F7] px-6 py-3.5">
            {{ $Jabatans->links() }}
        </div>
    </div>

    {{-- =========================================================
    MODAL TAMBAH / EDIT
    Kontrol tampil/sembunyi murni Alpine (x-show), TIDAK pakai @if server.
    ========================================================== --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">
        {{-- Backdrop: klik = tutup modal, murni client-side --}}
        <div @click="modalOpen = false" class="absolute inset-0 bg-[#21203D]/40 backdrop-blur-[2px]"></div>

        <div class="relative z-10 max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl">
            {{-- HEADER --}}
            <div class="mb-5 flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-[#21203D]">
                        {{ $jabatan_id ? 'Edit Jabatan' : 'Tambah Jabatan' }}
                    </h3>
                    <p class="text-xs text-[#9A97B8]">
                        {{ $jabatan_id ? 'Perbarui data Jabatan' : 'Lengkapi data Jabatan baru' }}
                    </p>
                </div>
                {{-- Tombol X: murni client-side --}}
                <button type="button" @click="modalOpen = false"
                    class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#F3F1FA]">
                    <span class="icon-[tabler--x] size-4"></span>
                </button>
            </div>
            {{-- FORM --}}
            <form wire:submit="store" class="space-y-4">

                <div class="grid grid-cols-12 gap-4">

                    {{-- KODE [6] --}}
                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">
                            Kode
                        </label>

                        <input type="text" wire:model="kode_jabatan"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="Masukkan Kode" />

                        @error('kode_jabatan')
                            <span class="mt-1 block text-xs text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>


                    {{-- URUTAN [3] --}}
                    <div class="col-span-12 md:col-span-3">
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">
                            Urutan
                        </label>

                        <input type="number" wire:model="urutan"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="Urutan" />

                        @error('urutan')
                            <span class="mt-1 block text-xs text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>


                    {{-- STATUS [3] --}}
                    <div class="col-span-12 md:col-span-3">
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">
                            Status
                        </label>

                        <select wire:model="status" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>

                        @error('status')
                            <span class="mt-1 block text-xs text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>


                    {{-- NAMA [12] --}}
                    <div class="col-span-12">
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">
                            Nama Jabatan
                        </label>

                        <input type="text" wire:model="nama_jabatan"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm"
                            placeholder="Masukkan Nama Jabatan" />

                        @error('nama_jabatan')
                            <span class="mt-1 block text-xs text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="mt-6 flex items-center justify-end gap-2">

                    <button type="button" @click="modalOpen = false"
                        class="btn btn-soft border border-[#ECE9F7] bg-white text-[#544F7A] hover:bg-[#F3F1FA]">
                        Batal
                    </button>

                    <button type="submit" wire:loading.attr="disabled"
                        class="btn border-none bg-[#7C6AEF] text-white hover:bg-[#6552E0]">
                        <span wire:loading.remove wire:target="store">
                            {{ $jabatan_id ? 'Simpan Perubahan' : 'Simpan Jabatan' }}
                        </span>

                        <span wire:loading wire:target="store">
                            Menyimpan...
                        </span>
                    </button>

                </div>

            </form>
        </div>
    </div>


</div>
