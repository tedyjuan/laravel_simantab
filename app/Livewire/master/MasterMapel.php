<?php

namespace App\Livewire\master;

use App\Models\Mapel;
use App\Models\Kurikulum;
use App\Models\Jenjang;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MasterMapel extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $mapel_id = null;
    public ?string $kode_mapel = null;
    public ?string $nama_mapel = null;
    public ?string $kkm = null;
    public ?string $kode_kurikulum = null;
    public ?string $kode_jenjang = null;
    public ?string $kelompok = null;
    public ?string $status = null;
    public $is_aktif = false;

    // Untuk proses delete (di-set dari Alpine pakai $wire.set(..., false) saat klik icon hapus)
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $mapels = Mapel::with([
            'kurikulum',
            'jenjang',
        ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('kode_mapel', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_mapel', 'like', '%' . $this->search . '%')
                        ->orWhere('kelompok', 'like', '%' . $this->search . '%')
                        ->orWhere('kode_jenjang', 'like', '%' . $this->search . '%')
                        ->orWhere('kode_jenjang', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.master.master-mapel', [
            'mapels'      => $mapels,
            'kurikulums'  => Kurikulum::orderBy('kode_kurikulum', 'asc')->get(),
            'jenjangs'    => Jenjang::orderBy('kode_jenjang', 'asc')->get(),
        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit(string $id)
    {
        $data = Mapel::findOrFail($id);

        $this->mapel_id       = $data->id;
        $this->kode_mapel     = $data->kode_mapel;
        $this->nama_mapel     = $data->nama_mapel;
        $this->kkm            = $data->kkm;
        $this->kode_kurikulum = $data->kode_kurikulum;
        $this->kode_jenjang   = $data->kode_jenjang;
        $this->kelompok       = $data->kelompok;
        $this->status         = $data->status;

        $this->resetValidation();
        $this->dispatch('open-modal');
    }

    /**
     * Simpan data (create/update).
     * Kalau validasi gagal, event 'close-modal' TIDAK dikirim,
     * sehingga modal tetap terbuka dan pesan error tampil ke user.
     */
    public function store()
    {

        $this->kode_mapel = strtoupper($this->kode_mapel);
        $this->nama_mapel = ucwords(strtolower($this->nama_mapel));
        $validated = $this->validate([
            'kode_mapel'     => 'required|string|max:50|unique:acd_ms_mapel,kode_mapel,' . $this->mapel_id,
            'nama_mapel'     => 'required|string|max:100',
            'kkm'            => 'required|numeric|min:0|max:100',
            'kode_kurikulum' => 'required|exists:acd_ms_kurikulum,kode_kurikulum',
            'kelompok'       => 'required|string|max:50',
            'kode_jenjang'   => 'required|exists:acd_ms_jenjang,kode_jenjang',
            'status'         => 'required|in:aktif,nonaktif',
        ]);

        if ($this->mapel_id) {
            // UPDATE
            Mapel::findOrFail($this->mapel_id)->update($validated);
            $message = 'Mapel berhasil diperbarui.';
        } else {
            // CREATE
            Mapel::create([
                ...$validated,
                'ulid' => (string) Str::ulid(),
            ]);

            $message = 'Mapel berhasil ditambahkan.';
        }
        $this->resetInputFields();
        $this->dispatch('close-modal');
        $this->dispatch('tampil-toast', pesan: $message, icon: 'success');
    }

    /**
     * Proses hapus. WAJIB ke server karena eksekusi query delete.
     * $this->deleteId sudah di-set dari client (Alpine) sebelum method ini dipanggil.
     */
    public function delete()
    {
        Mapel::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Mapel berhasil dihapus!', icon: 'success');
    }

    private function resetInputFields()
    {
        $this->mapel_id = null;
        $this->kode_mapel = '';
        $this->nama_mapel = '';
        $this->kkm = '';
        $this->kode_kurikulum = '';
        $this->kode_jenjang = '';
        $this->kelompok = '';
        $this->status = '';
        $this->resetValidation();
    }
}
