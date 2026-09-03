<?php

namespace App\Livewire\master;

use App\Models\Jabatan;
use Livewire\Component;
use Livewire\WithPagination;

class MasterJabatan extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    public ?int $jabatan_id = null;
    public ?string $kode_jabatan = null;
    public ?string $nama_jabatan = null;
    public ?string $urutan = null;
    public ?string $status = null;

    // Untuk proses delete (di-set dari Alpine pakai $wire.set(..., false) saat klik icon hapus)
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $Jabatan = Jabatan::where(function ($query) {
            $query->where('kode_jabatan', 'like', '%' . $this->search . '%')
                ->orWhere('nama_jabatan', 'like', '%' . $this->search . '%');
        })
            ->orderBy('urutan', 'asc')
            ->paginate(10);

        return view('livewire.master.master-jabatan', [
            'Jabatans' => $Jabatan,
        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit($id)
    {
        $data = Jabatan::findOrFail($id);

        $this->jabatan_id   = $data->id;
        $this->kode_jabatan = $data->kode_jabatan;
        $this->nama_jabatan = $data->nama_jabatan;
        $this->urutan       = $data->urutan;
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
            'kode_jabatan' => 'required|string|max:50|unique:hr_ms_jabatan,kode_jabatan,' . $this->jabatan_id,
            'nama_jabatan' => 'required|string|max:100',
            'urutan'       => 'required|integer',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        Jabatan::updateOrCreate(
            ['id' => $this->jabatan_id],
            $validated
        );

        $message = $this->jabatan_id
            ? 'Jabatan berhasil diperbarui.'
            : 'Jabatan berhasil ditambahkan.';

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
        Jabatan::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Jabatan berhasil dihapus!', icon: 'success');
    }

    private function resetInputFields()
    {
        $this->jabatan_id = null;
        $this->kode_jabatan = '';
        $this->nama_jabatan = '';
        $this->urutan = '';
        $this->status = '';
        $this->is_aktif = false;
        $this->resetValidation();
    }
}
