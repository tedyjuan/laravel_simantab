<div id="halaman_master_rombel" x-data="{ modalOpen: false, deleteModalOpen: false, modalTitle: '', modalTitleDetail: '' }" x-on:open-modal.window="modalOpen = true"
    x-on:rombel-saved.window="modalOpen = false" x-on:rombel-deleted.window="deleteModalOpen = false">
    {{-- =========================================================
    HEADER
    ========================================================== --}}
    <div class="mb-7">
        <nav class="mb-1 flex items-center gap-1.5 text-xs font-medium text-[#9A97B8]">
            <span>Master Data</span>
            <span class="icon-[tabler--chevron-right] size-3.5"></span>
            <span class="text-[#6552E0]">Rombel</span>
        </nav>
        <h1 class="text-2xl font-bold tracking-tight text-[#21203D] sm:text-[28px]">
            Data Rombongan Belajar (Rombel)
        </h1>
        <p class="mt-1 text-sm text-[#767492]">
            Kelola Rombongan Belajar dalam satu tempat.
        </p>
    </div>

    {{-- =========================================================
    FILTER + TAMBAH (1 ROW)
    ========================================================== --}}
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <label
            class="input flex grow items-center gap-2 rounded-2xl border border-[#ECE9F7] bg-white px-4 py-2.5 shadow-[0_2px_10px_-4px_rgba(33,32,61,0.06)] focus-within:border-[#B9AFF2] sm:max-w-sm">
            <span class="icon-[tabler--search] size-4 text-[#9A97B8]"></span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kode atau nama rombel..."
                class="grow bg-transparent text-sm placeholder:text-[#B4B1CB] focus:outline-none" />
        </label>

        {{-- Tombol Tambah: panggil resetForm() ke server supaya semua field
             (termasuk default status = 'aktif') balik ke kondisi awal,
             baru modal dibuka lewat Alpine. --}}
        <button type="button" wire:click="resetForm"
            @click="
                modalOpen = true;
                modalTitle = 'Tambah Rombel';
                modalTitleDetail = 'Lengkapi data Rombel baru';
            "
            class="btn shrink-0 border-none bg-[#7C6AEF] text-white shadow-[0_10px_20px_-8px_rgba(124,106,239,0.55)] hover:bg-[#6552E0]">
            <span class="icon-[tabler--plus] size-4"></span>
            Tambah Data
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
                        <th>Nama Rombel</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Wali Kelas</th>
                        <th>Ruangan</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th class="pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rombel as $item)
                        <tr wire:key="rombel-{{ $item->id }}"
                            class="border-b border-[#F3F1FA] last:border-0 hover:bg-[#FAFAFD]">
                            {{-- KODE --}}
                            <td class="py-3.5 pl-6">
                                <p class="text-sm font-semibold text-[#21203D]">
                                    {{ $item->kode_rombel ?? '-' }}
                                </p>
                            </td>
                            {{-- NAMA --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->nama_rombel ?? '-' }}
                            </td>
                            {{-- KELAS --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->kelas->nama_kelas ?? '-' }}
                            </td>
                            {{-- TAHUN AJARAN --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->tahunAjar->nama_tahun_ajaran_header ?? '-' }}
                            </td>
                            {{-- WALI KELAS / PEGAWAI --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->pegawai->nama_pegawai ?? '-' }}
                            </td>
                            {{-- RUANGAN --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->ruangan->nama_ruangan ?? '-' }}
                            </td>
                            {{-- KAPASITAS --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->kapasitas ?? '-' }}
                            </td>
                            {{-- STATUS --}}
                            <td>
                                @php
                                    $statusClass =
                                        $item->status === 'aktif'
                                            ? 'bg-[#E7F8EE] text-[#1E9E5A]'
                                            : 'bg-[#F3F1FA] text-[#6B6890]';
                                    $statusLabel = $item->status === 'aktif' ? 'Aktif' : 'Nonaktif';
                                @endphp
                                <span class="badge badge-sm gap-1.5 border-none font-medium {{ $statusClass }}">
                                    <span class="size-1.5 rounded-full bg-current"></span>
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            {{-- AKSI --}}
                            <td class="pr-6">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Edit: WAJIB ke server, data diambil dari DB --}}
                                    <button type="button" wire:click="edit({{ $item->id }})" title="Edit"
                                        @click="
                                            modalOpen = true;
                                            modalTitle = 'Edit Rombel';
                                            modalTitleDetail = 'Perbarui data Rombel';
                                        "
                                        class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#EAF1FE] hover:text-[#2E6FE0]">
                                        <span class="icon-[tabler--edit] size-4"></span>
                                    </button>
                                    {{-- Hapus: panggil confirmDelete() ke server dulu buat set $deleteId,
                                         baru modal konfirmasi dibuka lewat Alpine --}}
                                    <button type="button" wire:click="confirmDelete({{ $item->id }})"
                                        @click="deleteModalOpen = true" title="Hapus"
                                        class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#FBEAEA] hover:text-[#C0392B]">
                                        <span class="icon-[tabler--trash] size-4"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-14 text-center">
                                <span
                                    class="icon-[tabler--users-group] mx-auto mb-2 block size-8 text-[#D8D5EC]"></span>
                                <p class="text-sm font-medium text-[#767492]">
                                    Tidak ada data Rombel
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
            {{ $rombel->links() }}
        </div>
    </div>

    {{-- =========================================================
    MODAL TAMBAH / EDIT
    ========================================================== --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">
        <div @click="modalOpen = false" class="absolute inset-0 bg-[#21203D]/40 backdrop-blur-[2px]"></div>

        <div class="relative z-10 max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl">
            {{-- HEADER --}}
            <div class="mb-5 flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-[#21203D]" id="modalTitle" x-text="modalTitle"></h3>
                    <p class="text-xs text-[#9A97B8]" id="modalTitleDetail" x-text="modalTitleDetail"></p>
                </div>
                <button type="button" @click="modalOpen = false"
                    class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#F3F1FA]">
                    <span class="icon-[tabler--x] size-4"></span>
                </button>
            </div>
            {{-- FORM --}}
            <form wire:submit="save" class="space-y-4">
                {{-- KODE + NAMA --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kode Rombel</label>
                        <input type="text" wire:model="kode_rombel"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. ROM001" />
                        @error('kode_rombel')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Nama Rombel</label>
                        <input type="text" wire:model="nama_rombel"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. Kelas 7A" />
                        @error('nama_rombel')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- KELAS + TAHUN AJARAN --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kelas</label>
                        <select wire:model="kode_kelas" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="">Pilih kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->kode_kelas }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kode_kelas')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Tahun Ajaran</label>
                        <select wire:model="kode_tahun_ajaran_header"
                            class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="">Pilih tahun ajaran</option>
                            @foreach ($tahunAjarList as $ta)
                                <option value="{{ $ta->kode_tahun_ajaran_header }}">
                                    {{ $ta->nama_tahun_ajaran_header }}</option>
                            @endforeach
                        </select>
                        @error('kode_tahun_ajaran_header')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- WALI KELAS + RUANGAN --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Wali Kelas</label>
                        <select wire:model="kode_pegawai" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="">Pilih wali kelas</option>
                            @foreach ($pegawaiList as $pegawai)
                                <option value="{{ $pegawai->kode_pegawai }}">{{ $pegawai->nama_pegawai }}</option>
                            @endforeach
                        </select>
                        @error('kode_pegawai')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Ruangan</label>
                        <select wire:model="kode_ruangan" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="">Pilih ruangan</option>
                            @foreach ($ruanganList as $ruangan)
                                <option value="{{ $ruangan->kode_ruangan }}">{{ $ruangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('kode_ruangan')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- KAPASITAS + STATUS --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kapasitas</label>
                        <input type="number" wire:model="kapasitas"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. 32" />
                        @error('kapasitas')
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
                    <button type="button" @click="modalOpen = false"
                        class="btn btn-soft border border-[#ECE9F7] bg-white text-[#544F7A] hover:bg-[#F3F1FA]">
                        Batal
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="btn border-none bg-[#7C6AEF] text-white hover:bg-[#6552E0]">
                        <span wire:loading.remove wire:target="save">
                            {{ $id ? 'Simpan Perubahan' : 'Simpan Data' }}
                        </span>
                        <span wire:loading wire:target="save">
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
                Hapus Rombel ini?
            </h3>
            <p class="mt-1 text-sm text-[#767492]">
                Data Rombel akan dihapus permanen.
                Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-5 flex items-center justify-end gap-2">
                <button type="button" @click="deleteModalOpen = false"
                    class="btn btn-soft border border-[#ECE9F7] bg-white text-[#544F7A] hover:bg-[#F3F1FA]">
                    Batal
                </button>
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
