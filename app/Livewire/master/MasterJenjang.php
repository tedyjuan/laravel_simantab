<?php

namespace App\Livewire\master;

use App\Models\Jenjang;
use Livewire\Component;
use Livewire\WithPagination;

class MasterJenjang extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    public ?int $jenjang_id = null;
    public ?string $kode_jenjang = null;
    public ?string $nama_jenjang = null;
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
        $jenjang = Jenjang::where(function ($query) {
            $query->where('kode_jenjang', 'like', '%' . $this->search . '%')
                ->orWhere('nama_jenjang', 'like', '%' . $this->search . '%');
        })
            ->orderBy('urutan', 'asc')
            ->paginate(10);

        return view('livewire.master.master-jenjang', [
            'jenjangs' => $jenjang,
        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit($id)
    {
        $data = Jenjang::findOrFail($id);

        $this->jenjang_id   = $data->id;
        $this->kode_jenjang = $data->kode_jenjang;
        $this->nama_jenjang = $data->nama_jenjang;
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
            'kode_jenjang' => 'required|string|max:50|unique:acd_ms_jenjang,kode_jenjang,' . $this->jenjang_id,
            'nama_jenjang' => 'required|string|max:100',
            'urutan'       => 'required|integer',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        Jenjang::updateOrCreate(
            ['id' => $this->jenjang_id],
            $validated
        );

        $message = $this->jenjang_id
            ? 'Jenjang berhasil diperbarui.'
            : 'Jenjang berhasil ditambahkan.';

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
        Jenjang::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Jenjang berhasil dihapus!', icon: 'success');
    }

    private function resetInputFields()
    {
        $this->jenjang_id = null;
        $this->kode_jenjang = '';
        $this->nama_jenjang = '';
        $this->urutan = '';
        $this->status = '';
        $this->is_aktif = false;
        $this->resetValidation();
    }
}
