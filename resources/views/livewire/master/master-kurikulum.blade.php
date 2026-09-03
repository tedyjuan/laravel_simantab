<div id="halaman_master_kurikulum" x-data="{ modalOpen: false, deleteModalOpen: false }" x-on:open-modal.window="modalOpen = true"
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
            <span class="text-[#6552E0]">Kurikulum</span>
        </nav>
        <h1 class="text-2xl font-bold tracking-tight text-[#21203D] sm:text-[28px]">
            Data Kurikulum
        </h1>
        <p class="mt-1 text-sm text-[#767492]">
            Kelola Kurikulum dalam satu tempat.
        </p>
    </div>

    {{-- =========================================================
    FILTER + TAMBAH (1 ROW)
    ========================================================== --}}
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <label
            class="input flex grow items-center gap-2 rounded-2xl border border-[#ECE9F7] bg-white px-4 py-2.5 shadow-[0_2px_10px_-4px_rgba(33,32,61,0.06)] focus-within:border-[#B9AFF2] sm:max-w-sm">
            <span class="icon-[tabler--search] size-4 text-[#9A97B8]"></span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kode atau nama..."
                class="grow bg-transparent text-sm placeholder:text-[#B4B1CB] focus:outline-none" />
        </label>

        {{-- Tombol Tambah: 100% client-side, TIDAK ada request ke server.
             Semua field form dikosongkan langsung lewat $wire.set(..., false),
             nilai ini baru benar-benar disinkronkan ke server nanti,
             dibarengi saat form di-submit (wire:submit="store"). --}}
        <button type="button"
            @click="
                modalOpen = true;
                $wire.set('kurikulum_id', null, false);
                $wire.set('kode_kurikulum', '', false);
                $wire.set('nama_kurikulum', '', false);
                $wire.set('deskripsi', '', false);
                $wire.set('status', 'aktif', false);
            "
            class="btn shrink-0 border-none bg-[#7C6AEF] text-white shadow-[0_10px_20px_-8px_rgba(124,106,239,0.55)] hover:bg-[#6552E0]">
            <span class="icon-[tabler--plus] size-4"></span>
            Tambah Kurikulum
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
                        <th class="py-3.5 pl-6">Kode</th>
                        <th>Nama Kurikulum</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th class="pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kurikulums as $kurikulum)
                        <tr wire:key="kurikulum-{{ $kurikulum->id }}"
                            class="border-b border-[#F3F1FA] last:border-0 hover:bg-[#FAFAFD]">
                            {{-- KODE + AVATAR --}}
                            <td class="py-3.5 pl-6">
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-placeholder">
                                        <div
                                            class="w-9 rounded-full bg-[#F1EFFC] text-[#6D5BD0] ring-2 ring-[#F1EFFC] ring-offset-2">
                                            <span class="icon-[tabler--book-2] size-4"></span>
                                        </div>
                                    </div>
                                    <p class="text-sm font-semibold text-[#21203D]">
                                        {{ $kurikulum->kode_kurikulum ?? '-' }}
                                    </p>
                                </div>
                            </td>
                            {{-- NAMA --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $kurikulum->nama_kurikulum ?? '-' }}
                            </td>
                            {{-- DESKRIPSI --}}
                            <td class="max-w-xs truncate text-sm text-[#544F7A]" title="{{ $kurikulum->deskripsi }}">
                                {{ $kurikulum->deskripsi ?? '-' }}
                            </td>
                            {{-- STATUS --}}
                            <td>
                                @php
                                    $statusClass =
                                        $kurikulum->status === 'aktif'
                                            ? 'bg-[#E7F8EE] text-[#1E9E5A]'
                                            : 'bg-[#FBEAEA] text-[#C0392B]';
                                @endphp
                                <span class="badge badge-sm gap-1.5 border-none font-medium {{ $statusClass }}">
                                    <span class="size-1.5 rounded-full bg-current"></span>
                                    {{ ucfirst($kurikulum->status ?? '-') }}
                                </span>
                            </td>
                            {{-- AKSI --}}
                            <td class="pr-6">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Edit: WAJIB ke server, data harus diambil dari DB --}}
                                    <button type="button" wire:click="edit({{ $kurikulum->id }})" title="Edit"
                                        class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#EAF1FE] hover:text-[#2E6FE0]">
                                        <span class="icon-[tabler--edit] size-4"></span>
                                    </button>
                                    {{-- Hapus: 100% client-side untuk buka modal konfirmasi,
                                         cuma titip $deleteId ke Livewire tanpa request --}}
                                    <button type="button"
                                        @click="deleteModalOpen = true; $wire.set('deleteId', {{ $kurikulum->id }}, false)"
                                        title="Hapus"
                                        class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#FBEAEA] hover:text-[#C0392B]">
                                        <span class="icon-[tabler--trash] size-4"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-14 text-center">
                                <span class="icon-[tabler--book-2] mx-auto mb-2 block size-8 text-[#D8D5EC]"></span>
                                <p class="text-sm font-medium text-[#767492]">
                                    Tidak ada data Kurikulum
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
            {{ $kurikulums->links() }}
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

        <div class="relative z-10 max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl">
            {{-- HEADER --}}
            <div class="mb-5 flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-[#21203D]">
                        {{ $kurikulum_id ? 'Edit Kurikulum' : 'Tambah Kurikulum' }}
                    </h3>
                    <p class="text-xs text-[#9A97B8]">
                        {{ $kurikulum_id ? 'Perbarui data kurikulum' : 'Lengkapi data kurikulum baru' }}
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
                {{-- KODE + NAMA --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kode</label>
                        <input type="text" wire:model="kode_kurikulum"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. KUR-MERDEKA" />
                        @error('kode_kurikulum')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Nama Kurikulum</label>
                        <input type="text" wire:model="nama_kurikulum"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm"
                            placeholder="cth. Kurikulum Merdeka" />
                        @error('nama_kurikulum')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- DESKRIPSI --}}
                <div>
                    <label class="mb-1 block text-xs font-medium text-[#544F7A]">Deskripsi</label>
                    <textarea wire:model="deskripsi" rows="3" class="textarea w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm"
                        placeholder="Deskripsi singkat kurikulum..."></textarea>
                    @error('deskripsi')
                        <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                {{-- STATUS --}}
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
                            {{ $kurikulum_id ? 'Simpan Perubahan' : 'Simpan Data' }}
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
                Hapus kurikulum ini?
            </h3>
            <p class="mt-1 text-sm text-[#767492]">
                Data kurikulum akan dihapus permanen.
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
