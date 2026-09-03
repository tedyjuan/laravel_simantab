<?php

namespace App\Livewire\master;

use App\Models\Ruangan;
use App\Models\Gedung;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MasterRuangan extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $ruangan_id = null;
    public ?string $kode_ruangan = null;
    public ?string $nama_ruangan = null;
    public ?string $kode_gedung = null;
    public ?int $lantai = null;
    public ?string $kapasitas = null;
    public ?string $jenis = null;
    public ?string $deskripsi = null;
    public ?string $status = null;

    // Untuk proses delete (di-set dari Alpine pakai $wire.set(..., false) saat klik icon hapus)
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $master_ruangan = Ruangan::with([
            'gedung',
        ])->when($this->search, function ($query) {
            $query->where('kode_ruangan', 'like', '%' . $this->search . '%')
                ->orWhere('nama_ruangan', 'like', '%' . $this->search . '%')
                ->orWhere('lantai', 'like', '%' . $this->search . '%')
                ->orWhere('kapasitas', 'like', '%' . $this->search . '%')
                ->orWhere('jenis', 'like', '%' . $this->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%');
        })
            ->orderBy('kode_ruangan', 'asc')
            ->paginate(10);
        $gedungs = Gedung::where('status', 'aktif')
            ->orderBy('nama_gedung', 'asc')
            ->get();
        return view('livewire.master.master-ruangan', [
            'master_ruangan' => $master_ruangan,
            'gedungs' => $gedungs,

        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit(string $id)
    {
        $data               = Ruangan::findOrFail($id);
        $this->ruangan_id   = $data->id;
        $this->kode_ruangan = $data->kode_ruangan;
        $this->nama_ruangan = $data->nama_ruangan;
        $this->kode_gedung = $data->kode_gedung;
        $this->lantai       = $data->lantai;
        $this->kapasitas    = $data->kapasitas;
        $this->jenis        = $data->jenis;
        $this->deskripsi    = $data->deskripsi;
        $this->status       = $data->status;
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
        $validated = $this->validate([
            'kode_ruangan' => 'required|string|max:50|unique:inv_ms_ruangan,kode_ruangan,' . $this->ruangan_id,
            'nama_ruangan' => 'required|string|max:100',
            'kode_gedung'  => 'required|string|max:100',
            'lantai'       => 'required|int|max:100',
            'jenis'        => 'required|string|max:100',
            'kapasitas'    => 'required|string|max:100',
            'deskripsi'    => 'nullable|string|max:100',
            'status'       => 'required|in:aktif,nonaktif',
        ]);
        if ($this->ruangan_id) {
            // UPDATE
            Ruangan::findOrFail($this->ruangan_id)->update($validated);
            $message = 'Data ruangan berhasil diperbarui.';
        } else {
            // CREATE
            Ruangan::create([
                ...$validated,
                'ulid' => (string) Str::ulid(),
            ]);

            $message = 'Data ruangan berhasil ditambahkan.';
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
        Ruangan::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Data ruangan berhasil dihapus!', icon: 'success');
    }

    private function resetInputFields()
    {
        $this->ruangan_id = null;
        $this->kode_ruangan = '';
        $this->nama_ruangan = '';
        $this->kode_gedung = '';
        $this->lantai = null;
        $this->kapasitas = '';
        $this->jenis = '';
        $this->deskripsi = '';
        $this->status = '';
        $this->resetValidation();
    }
}
