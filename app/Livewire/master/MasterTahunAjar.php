<?php

namespace App\Livewire\master;

use App\Models\TahunAjar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MasterTahunAjar extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $tahun_ajaran_id = null;
    public ?string $nama_tahun_ajaran_header = null;
    public ?int $tahun_mulai = null;
    public ?int $tahun_selesai = null;
    public ?string $status = null;

    // Untuk proses delete (di-set dari Alpine pakai $wire.set(..., false) saat klik icon hapus)
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tahun_ajar = TahunAjar::where(function ($query) {
            $query->where('kode_tahun_ajaran_header', 'like', '%' . $this->search . '%')
                ->orWhere('nama_tahun_ajaran_header', 'like', '%' . $this->search . '%')
                ->orWhere('tahun_mulai', 'like', '%' . $this->search . '%')
                ->orWhere('tahun_selesai', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%');
        })
            ->orderBy('id', 'desc')
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
    public function edit(string $id)
    {
        $data                           = TahunAjar::findOrFail($id);
        $this->tahun_ajaran_id          = $data->id;
        $this->nama_tahun_ajaran_header = $data->nama_tahun_ajaran_header;
        $this->tahun_mulai              = $data->tahun_mulai;
        $this->tahun_selesai            = $data->tahun_selesai;
        $this->status                   = $data->status;
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
            'nama_tahun_ajaran_header' => 'required|string|max:100',
            'tahun_mulai'              => 'required|date',
            'tahun_selesai'            => 'required|date|after:tahun_mulai',
            'status'                   => 'required|in:aktif,nonaktif',
        ]);

        if ($this->tahun_ajaran_id) {

            // UPDATE
            TahunAjar::findOrFail($this->tahun_ajaran_id)->update($validated);
            $message = 'Tahun ajaran berhasil diperbarui.';
        } else {
            // CREATE
            $TahunAjar = TahunAjar::create([
                ...$validated,
                'ulid' => (string) Str::ulid(),
            ]);

            // Generate kode berdasarkan ID
            $TahunAjar->update([
                'kode_tahun_ajaran_header' => 'TAH' . str_pad($TahunAjar->id, 3, '0', STR_PAD_LEFT),
            ]);

            $message = 'Tahun ajaran berhasil ditambahkan.';
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
        TahunAjar::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Tahun ajaran berhasil dihapus!', icon: 'success');
    }

    private function resetInputFields()
    {
        $this->tahun_ajaran_id = null;
        $this->nama_tahun_ajaran_header = '';
        $this->tahun_mulai = '';
        $this->tahun_selesai = '';
        $this->status = '';
        $this->resetValidation();
    }
}
