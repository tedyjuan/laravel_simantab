<?php

namespace App\Livewire\master;

use App\Models\TahunAjar;
use Livewire\Component;
use Livewire\WithPagination;

class MasterTahunAjar extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $tahun_ajaran_id = null;
    public ?string $kode = null;
    public ?string $nama = null;
    public ?string $tanggal_mulai = null;
    public ?string $tanggal_selesai = null;
    public ?string $semester = null;
    public $is_aktif = false;

    // Untuk proses delete (di-set dari Alpine pakai $wire.set(..., false) saat klik icon hapus)
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tahun_ajar = TahunAjar::where(function ($query) {
            $query->where('kode', 'like', '%' . $this->search . '%')
                ->orWhere('nama', 'like', '%' . $this->search . '%')
                ->orWhere('semester', 'like', '%' . $this->search . '%');
        })
            ->orderBy('kode', 'asc')
            ->paginate(10);

        return view('livewire.master.master-tahun-ajar', [
            'tahun_ajar' => $tahun_ajar,
        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit($id)
    {
        $data = TahunAjar::findOrFail($id);

        $this->tahun_ajaran_id = $data->id;
        $this->kode            = $data->kode;
        $this->nama            = $data->nama;
        $this->tanggal_mulai   = $data->tanggal_mulai;
        $this->tanggal_selesai = $data->tanggal_selesai;
        $this->semester        = $data->semester;
        $this->is_aktif        = $data->is_aktif;

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
            'kode'            => 'required|string|max:50|unique:acd_ms_tahun_ajaran,kode,' . $this->tahun_ajaran_id,
            'nama'            => 'required|string|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'semester'        => 'required|in:Ganjil,Genap',
            'is_aktif'        => 'required|boolean',
        ]);

        TahunAjar::updateOrCreate(
            ['id' => $this->tahun_ajaran_id],
            $validated
        );

        $message = $this->tahun_ajaran_id
            ? 'Tahun ajaran berhasil diperbarui.'
            : 'Tahun ajaran berhasil ditambahkan.';

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
        TahunAjar::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Tahun ajaran berhasil dihapus!', icon: 'success');
    }

    private function resetInputFields()
    {
        $this->tahun_ajaran_id = null;
        $this->kode = '';
        $this->nama = '';
        $this->tanggal_mulai = '';
        $this->tanggal_selesai = '';
        $this->semester = '';
        $this->is_aktif = false;
        $this->resetValidation();
    }
}
