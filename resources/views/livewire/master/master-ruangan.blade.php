<div id="halaman_master_tahun_ajar" x-data="{ modalOpen: false, deleteModalOpen: false }" x-on:open-modal.window="modalOpen = true"
    x-on:close-modal.window="modalOpen = false" x-on:close-delete-modal.window="deleteModalOpen = false">
    {{-- =========================================================
    HEADER
    ========================================================== --}}
    <div class="mb-7">
        <nav class="mb-1 flex items-center gap-1.5 text-xs font-medium text-[#9A97B8]">
            <span>Master Data</span>
            <span class="icon-[tabler--chevron-right] size-3.5"></span>
            <span class="text-[#6552E0]">Ruangan</span>
        </nav>
        <h1 class="text-2xl font-bold tracking-tight text-[#21203D] sm:text-[28px]">
            Data Ruangan
        </h1>
        <p class="mt-1 text-sm text-[#767492]">
            Kelola ruangan dalam satu tempat.
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
             yang cuma "menitipkan" nilai baru ke Livewire tanpa kirim network request.
             Nilai ini baru benar-benar disinkronkan ke server nanti, dibarengi
             saat form di-submit (wire:submit="store"). --}}
        <button type="button"
            @click="
                modalOpen = true;
                $wire.set('ruangan_id', null, false);
                $wire.set('kode_ruangan', '', false);
                $wire.set('nama_ruangan', '', false);
                $wire.set('lantai', '', false); 
                $wire.set('kapasitas', '', false);
                $wire.set('jenis', '', false);
                $wire.set('deskripsi', '', false);
                $wire.set('status', null, false);
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
                        <th>Nama Ruangan</th>
                        <th>Lantai</th>
                        <th>Kapasitas</th>
                        <th>Jenis</th>
                        <th>Gedung</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th class="pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($master_ruangan as $item)
                        <tr wire:key="thn_ajar-{{ $item->id }}"
                            class="border-b border-[#F3F1FA] last:border-0 hover:bg-[#FAFAFD]">
                            {{-- KODE + AVATAR --}}
                            <td class="py-3.5 pl-6">
                                <p class="text-sm font-semibold text-[#21203D]">
                                    {{ $item->kode_ruangan ?? '-' }}
                                </p>
                            </td>
                            {{-- NAMA --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->nama_ruangan ?? '-' }}
                            </td>
                            {{-- Lantai --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->lantai ?? '-' }}
                            </td>
                            {{-- Kapasitas --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->kapasitas ?? '-' }}
                            </td>
                            {{-- Jenis --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->jenis ?? '-' }}
                            </td>
                            {{-- Gedung --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->gedung->nama_gedung ?? '-' }}
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
                            {{-- DESKRIPSI --}}
                            <td class="text-sm text-[#544F7A]">
                                {{ $item->deskripsi ?? '-' }}
                            </td>
                            {{-- AKSI --}}
                            <td class="pr-6">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Edit: WAJIB ke server, data harus diambil dari DB --}}
                                    <button type="button" wire:click="edit({{ $item->id }})" title="Edit"
                                        class="flex size-8 items-center justify-center rounded-lg text-[#9A97B8] hover:bg-[#EAF1FE] hover:text-[#2E6FE0]">
                                        <span class="icon-[tabler--edit] size-4"></span>
                                    </button>
                                    {{-- Hapus: 100% client-side untuk buka modal konfirmasi,
                                         cuma titip $deleteId ke Livewire tanpa request --}}
                                    <button type="button"
                                        @click="deleteModalOpen = true; $wire.set('deleteId', {{ $item->id }}, false)"
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
                                <span class="icon-[cil--room] mx-auto mb-2 block size-8 text-[#D8D5EC]"></span>
                                <p class="text-sm font-medium text-[#767492]">
                                    Tidak ada data ruangan
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
            {{ $master_ruangan->links() }}
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
                        {{ $ruangan_id ? 'Edit Ruangan' : 'Tambah Ruangan' }}
                    </h3>
                    <p class="text-xs text-[#9A97B8]">
                        {{ $ruangan_id ? 'Perbarui data ruangan' : 'Lengkapi data ruangan baru' }}
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
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kode Ruangan</label>
                        <input type="text" wire:model="kode_ruangan"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. GD-A1" />
                        @error('kode_ruangan')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Nama Ruangan</label>
                        <input type="text" wire:model="nama_ruangan"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm"
                            placeholder="cth. ruangan Utama" />
                        @error('nama_ruangan')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Kapasitas</label>
                        <input type="number" wire:model="kapasitas"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" placeholder="cth. 100" />
                        @error('kapasitas')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- TANGGAL MULAI + SELESAI --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Lantai</label>
                        <input type="number" wire:model="lantai"
                            class="input w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm" />
                        @error('lantai')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Status</label>
                        <select wire:model="status" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="">Pilih status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                        @error('status')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- TANGGAL MULAI + SELESAI --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Jenis Ruangan</label>
                        <select wire:model="jenis" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="">Pilih Jenis Ruangan</option>
                            <option value="kelas">Kelas</option>
                            <option value="laboratorium">Laboratorium</option>
                            <option value="perpustakaan">Perpustakaan</option>
                            <option value="kantor">Kantor</option>
                            <option value="aula">Aula</option>
                            <option value="ruang_guru">Ruang Guru</option>
                            <option value="uks">UKS</option>
                            <option value="gudang">Gudang</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        @error('jenis')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Gedung</label>
                        <select wire:model="kode_gedung" class="select w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm">
                            <option value="">-- Pilih Gedung --</option>
                            @foreach ($gedungs as $gedung)
                                <option value="{{ $gedung->kode_gedung }}">
                                    {{ $gedung->kode_gedung }} - {{ $gedung->nama_gedung }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_gedung')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- SEMESTER + STATUS --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-1">

                    <div>
                        <label class="mb-1 block text-xs font-medium text-[#544F7A]">Deskripsi</label>
                        <textarea wire:model="deskripsi" class="textarea  w-full border-[#ECE9F7] bg-[#FAFAFD] text-sm"
                            aria-label="Textarea"></textarea>
                        @error('deskripsi')
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
                            {{ $ruangan_id ? 'Simpan Perubahan' : 'Simpan Data' }}
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
                Hapus ruangan ini?
            </h3>
            <p class="mt-1 text-sm text-[#767492]">
                Data ruangan akan dihapus permanen.
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
