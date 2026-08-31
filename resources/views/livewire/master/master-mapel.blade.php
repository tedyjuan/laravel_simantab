<div id="halaman_master_mapel" x-data="{ modalOpen: false, deleteModalOpen: false }" x-on:open-modal.window="modalOpen = true"
    x-on:close-modal.window="modalOpen = false" x-on:close-delete-modal.window="deleteModalOpen = false">

    {{-- =========================================================
    FLASH MESSAGE
    ========================================================== --}}
    @if (session()->has('message'))
        <div class="mb-4 rounded-xl border border-[#D8F3E3] bg-[#E7F8EE] px-4 py-3 text-sm text-[#1E9E5A]">
            {{ session('message') }}
        </div>
    @endif

    {{-- =========================================================
    HEADER
    ========================================================== --}}
    <div class="mb-7">
        <nav class="mb-1 flex items-center gap-1.5 text-xs font-medium text-[#9A97B8]">
            <span>Master Data</span>
            <span class="icon-[tabler--chevron-right] size-3.5"></span>
            <span class="text-[#6552E0]">Mata Pelajaran (MAPEL)</span>
        </nav>
        <h1 class="text-2xl font-bold tracking-tight text-[#21203D] sm:text-[28px]">
            Data Mata Pelajaran (MAPEL)
        </h1>
        <p class="mt-1 text-sm text-[#767492]">
            Kelola Mata Pelajaran (MAPEL) dalam satu tempat.
        </p>
    </div>

    {{-- =========================================================
    FILTER + TAMBAH (1 ROW)
    ========================================================== --}}
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <label
            class="input flex grow items-center gap-2 rounded-2xl border border-[#ECE9F7] bg-white px-4 py-2.5 shadow-[0_2px_10px_-4px_rgba(33,32,61,0.06)] focus-within:border-[#B9AFF2] sm:max-w-sm">
            <span class="icon-[tabler--search] size-4 text-[#9A97B8]"></span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kode, nama, kurikulum, ..."
                class="grow bg-transparent text-sm placeholder:text-[#B4B1CB] focus:outline-none" />
        </label>

        {{-- Tombol Tambah: 100% client-side, TIDAK ada request ke server.
             Semua field form dikosongkan langsung lewat $wire.set(..., false),
             nilai ini baru benar-benar disinkronkan ke server nanti,
             dibarengi saat form di-submit (wire:submit="store"). --}}
        <button type="button"
            @click="
                modalOpen = true;
                $wire.set('kode_mapel', null, false);
                $wire.set('nama_mapel', '', false);
                $wire.set('kkm', '', false);
                $wire.set('id_kurikulum', null, false);
                $wire.set('kelompok', 'wajib', false);
                $wire.set('status', 'aktif', false);
            "
            class="btn shrink-0 border-none bg-[#7C6AEF] text-white shadow-[0_10px_20px_-8px_rgba(124,106,239,0.55)] hover:bg-[#6552E0]">
            <span class="icon-[tabler--plus] size-4"></span>
            Tambah Mapel
        </button>
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
                        <th class="py-3.5 pl-6">Kode Mapel</th>
                        <th>Nama Mapel</th>
                        <th>KKM</th>
                        <th>Jenjang</th>
                        <th>Kurikulum</th>
                        <th>Kelompok</th>
                        <th>Status</th>
                        <th class="pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mapels as $mapel)
                        <tr wire:key="mapel-{{ $mapel->id }}"
                            class="border-b border-[#F3F1FA] last:border-0 hover:bg-[#FAFAFD]">
                            {{-- KODE MAPEL --}}
                            <td class="py-3.5 pl-6">
                                <div class="flex items-center gap-3">
                                    <p class="text-sm font-semibold text-[#21203D]">
                                        {{ $mapel->kode_mapel ?? '-' }}
                                    </p>
                                </div>
                            </td>
                            {{-- NAMA MAPEL --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $mapel->nama_mapel ?? '-' }}
                            </td>
                            {{-- KKM --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $mapel->kkm ?? '-' }}
                            </td>
                            {{-- jenjang (via relasi) --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $mapel->jenjang?->kode_jenjang ?? '-' }}
                            </td>
                            {{-- kurikulum (via relasi) --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $mapel->kurikulum?->nama_kurikulum ?? '-' }}
                            </td>
                            {{-- kelompok --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $mapel->kelompok ?? '-' }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @php
                                    $statusClass =
                                        $mapel->status === 'aktif'
                                            ? 'bg-[#E7F8EE] text-[#1E9E5A]'
                                            : 'bg-[#FBEAEA] text-[#C0392B]';
                                @endphp
                                <span class="badge badge-sm gap-1.5 border-none font-medium {{ $statusClass }}">
                                    <span class="size-1.5 rounded-full bg-current"></span>
                                    {{ ucfirst($mapel->status ?? '-') }}
                                </span>
                            </td>
                            {{-- AKSI --}}
                            <td class="pr-6">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Edit: WAJIB ke server, data harus diambil dari DB --}}
                                    <button type="button" wire:click="edit({{ $mapel->id }})" title="Edit"
                                        class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#EAF1FE] hover:text-[#2E6FE0]">
                                        <span class="icon-[tabler--edit] size-4"></span>
                                    </button>
                                    {{-- Hapus: 100% client-side untuk buka modal konfirmasi,
                                         cuma titip $deleteId ke Livewire tanpa request --}}
                                    <button type="button"
                                        @click="deleteModalOpen = true; $wire.set('deleteId', {{ $mapel->id }}, false)"
                                        title="Hapus"
                                        class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#FBEAEA] hover:text-[#C0392B]">
                                        <span class="icon-[tabler--trash] size-4"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-14 text-center">
                                <span
                                    class="icon-[solar--square-academic-cap-outline] mx-auto mb-2 block size-8 text-[#D8D5EC]"></span>
                                <p class="text-sm font-medium text-[#767492]">
                                    Tidak ada data Mapel
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
            {{ $mapels->links() }}
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
                        {{ $mapel_id ? 'Edit Mapel' : 'Tambah Mapel' }}
                    </h3>
                    <p class="text-xs text-[#9A97B8]">
                        {{ $mapel_id ? 'Perbarui data Mapel' : 'Lengkapi data Mapel baru' }}
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
                {{-- KODE MAPEL + NAMA MAPEL --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kode Mapel</label>
                        <input type="text" wire:model="kode_mapel"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. MTK-01" />
                        @error('kode_mapel')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Nama Mapel</label>
                        <input type="text" wire:model="nama_mapel"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. Matematika" />
                        @error('nama_mapel')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- KKM + KELOMPOK --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">KKM</label>
                        <input type="number" step="1" min="0" max="100" wire:model="kkm"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. 75" />
                        @error('kkm')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kelompok</label>
                        <select wire:model="kelompok" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="wajib">Wajib</option>
                            <option value="peminatan">Peminatan</option>
                            <option value="muatan_lokal">Muatan Lokal</option>
                        </select>
                        @error('kelompok')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- KURIKULUM + STATUS --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kurikulum</label>
                        <select wire:model="id_kurikulum" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="">-- Pilih Kurikulum --</option>
                            @foreach ($kurikulums as $kurikulum)
                                <option value="{{ $kurikulum->kode_kurikulum }}">
                                    {{ $kurikulum->kode_kurikulum }} - {{ $kurikulum->nama_kurikulum }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kurikulum')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Status</label>
                        <select wire:model="status" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                        @error('status')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="mt-6 flex items-center justify-end gap-2">
                    {{-- Batal: murni client-side, TIDAK ada wire:click --}}
                    <button type="button" @click="modalOpen = false"
                        class="btn btn-soft border border-[#ECE9F7] bg-white text-[#544F7A] hover:bg-[#F3F1FA]">
                        Batal
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="btn border-none bg-[#7C6AEF] text-white hover:bg-[#6552E0]">
                        <span wire:loading.remove wire:target="store">
                            {{ $mapel_id ? 'Simpan Perubahan' : 'Simpan Mapel' }}
                        </span>
                        <span wire:loading wire:target="store">
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- =========================================================
    MODAL KONFIRMASI DELETE
    ========================================================== --}}
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">
        <div @click="deleteModalOpen = false" class="absolute inset-0 bg-[#21203D]/40 backdrop-blur-[2px]"></div>
        <div class="relative z-10 w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
            <div class="mb-4 flex size-11 items-center justify-center rounded-xl bg-[#FBEAEA] text-[#C0392B]">
                <span class="icon-[tabler--alert-triangle] size-5"></span>
            </div>
            <h3 class="text-base font-bold text-[#21203D]">
                Hapus Mapel ini?
            </h3>
            <p class="mt-1 text-sm text-[#767492]">
                Data Mapel akan dihapus permanen.
                Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-5 flex items-center justify-end gap-2">
                {{-- Batal: murni client-side --}}
                <button type="button" @click="deleteModalOpen = false"
                    class="btn btn-soft border border-[#ECE9F7] bg-white text-[#544F7A] hover:bg-[#F3F1FA]">
                    Batal
                </button>
                {{-- Ya, Hapus: WAJIB ke server, eksekusi query delete --}}
                <button type="button" wire:click="delete" wire:loading.attr="disabled"
                    class="btn border-none bg-[#E0554A] text-white hover:bg-[#C0392B]">
                    <span wire:loading.remove wire:target="delete">
                        Ya, Hapus
                    </span>
                    <span wire:loading wire:target="delete">
                        Menghapus...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
