<?php

namespace App\Livewire\master;

use App\Models\Gedung;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MasterGedung extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $gedung_id = null;
    public ?string $kode_gedung = null;
    public ?string $nama_gedung = null;
    public ?string $jumlah_lantai = null;
    public ?string $alamat = null;
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
        $master_gedung = Gedung::where(function ($query) {
            $query->where('kode_gedung', 'like', '%' . $this->search . '%')
                ->orWhere('nama_gedung', 'like', '%' . $this->search . '%')
                ->orWhere('jumlah_lantai', 'like', '%' . $this->search . '%')
                ->orWhere('alamat', 'like', '%' . $this->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%');
        })
            ->orderBy('kode_gedung', 'asc')
            ->paginate(10);

        return view('livewire.master.master-gedung', [
            'master_gedung' => $master_gedung,
        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit(string $id)
    {
        $data                = Gedung::findOrFail($id);
        $this->gedung_id     = $data->id;
        $this->kode_gedung   = $data->kode_gedung;
        $this->nama_gedung   = $data->nama_gedung;
        $this->jumlah_lantai = $data->jumlah_lantai;
        $this->deskripsi     = $data->deskripsi;
        $this->alamat        = $data->alamat;
        $this->status        = $data->status;
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
            'kode_gedung'   => 'required|string|max:50|unique:inv_ms_gedung,kode_gedung,' . $this->gedung_id,
            'nama_gedung'   => 'required|string|max:100',
            'jumlah_lantai' => 'required|string|max:100',
            'deskripsi'     => 'nullable|string|max:100',
            'alamat'        => 'nullable|string|max:100',
            'status'        => 'required|in:aktif,nonaktif',
        ]);
        if ($this->gedung_id) {
            // UPDATE
            Gedung::findOrFail($this->gedung_id)->update($validated);
            $message = 'Gedung berhasil diperbarui.';
        } else {
            // CREATE
            Gedung::create([
                ...$validated,
                'ulid' => (string) Str::ulid(),
            ]);

            $message = 'Gedung berhasil ditambahkan.';
        }

        $this->resetInputFields();

        $this->dispatch('close-modal');

        $this->dispatch(
            'tampil-toast',
            pesan: $message,
            icon: 'success'
        );
    }

    /**
     * Proses hapus. WAJIB ke server karena eksekusi query delete.
     * $this->deleteId sudah di-set dari client (Alpine) sebelum method ini dipanggil.
     */
    public function delete()
    {
        Gedung::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Gedung berhasil dihapus!', icon: 'success');
    }

    private function resetInputFields()
    {
        $this->gedung_id = null;
        $this->kode_gedung = '';
        $this->nama_gedung = '';
        $this->jumlah_lantai = '';
        $this->deskripsi = '';
        $this->alamat = '';
        $this->status = '';
        $this->resetValidation();
    }
}
