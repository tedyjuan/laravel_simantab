<?php

namespace App\Livewire\master;

use App\Models\Kurikulum;
use Livewire\Component;
use Livewire\WithPagination;

class MasterKurikulum extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $kurikulum_id = null;
    public ?string $kode = null;
    public ?string $nama = null;
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
        $kurikulums = Kurikulum::where(function ($query) {
            $query->where('kode_kurikulum', 'like', '%' . $this->search . '%')
                ->orWhere('nama_kurikulum', 'like', '%' . $this->search . '%');
        })
            ->orderBy('kode_kurikulum', 'asc')
            ->paginate(10);

        return view('livewire.master.master-kurikulum', [
            'kurikulums' => $kurikulums,
        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit(int $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);

        $this->kurikulum_id   = $kurikulum->id;
        $this->kode_kurikulum = $kurikulum->kode_kurikulum;
        $this->nama_kurikulum = $kurikulum->nama_kurikulum;
        $this->deskripsi      = $kurikulum->deskripsi;
        $this->status         = $kurikulum->status;

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
            'kode_kurikulum'   => 'required|string|max:20|unique:acd_ms_kurikulum,kode_kurikulum,' . $this->kurikulum_id,
            'nama_kurikulum'   => 'required|string|max:100',
            'deskripsi'        => 'nullable|string',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        Kurikulum::updateOrCreate(
            ['id' => $this->kurikulum_id],
            $validated
        );

        $message = $this->kurikulum_id
            ? 'Kurikulum berhasil diperbarui.'
            : 'Kurikulum berhasil ditambahkan.';

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
        Kurikulum::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Kurikulum berhasil dihapus.', icon: 'success');
    }

    private function resetInputFields()
    {
        $this->kurikulum_id = null;
        $this->kode_kurikulum = '';
        $this->nama_kurikulum = '';
        $this->deskripsi = '';
        $this->status = 'aktif';
        $this->resetValidation();
    }
}
