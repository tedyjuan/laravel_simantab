<?php

namespace App\Livewire\master;

use App\Models\Kurikulum;
use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MasterKurikulum extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $kurikulum_id = null;
    public ?string $nama_kurikulum = null;
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
            'nama_kurikulum' => 'required|string|max:100',
            'deskripsi'      => 'nullable|string',
            'status'         => 'required|in:aktif,nonaktif',
        ]);

        if ($this->kurikulum_id) {
            // UPDATE
            $kurikulum = Kurikulum::findOrFail($this->kurikulum_id);
            $kurikulum->update($validated);
            $message = 'Kurikulum berhasil diperbarui.';
        } else {
            // CREATE
            $kurikulum = Kurikulum::create([
                ...$validated,
                'ulid' => (string) Str::ulid(),
            ]);

            // Generate kode berdasarkan ID
            $kurikulum->update([
                'kode_kurikulum' => 'KKM' . $kurikulum->id,
            ]);

            $message = 'Kurikulum berhasil ditambahkan.';
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
        $kurikulum = Kurikulum::find($this->deleteId);

        if (!$kurikulum) {
            return;
        }

        // 1. Data aktif tidak boleh dihapus
        if ($kurikulum->status == 'aktif') {
            $this->dispatch('tampil-toast', pesan: 'Kurikulum masih aktif. Silakan ubah status menjadi nonaktif terlebih dahulu.', icon: 'warning');
            return;
        }

        $kode = $kurikulum->kode_kurikulum;

        // 2. Cek penggunaan data
        $jumlahMapel  = Mapel::where('kode_kurikulum', $kode)->count();

        // 3. Masih digunakan → tidak boleh dihapus
        if ($jumlahMapel != 0) {

            $pesan = "Data tidak dapat dihapus.<br><br>";
            $pesan .= "Kurikulum <b>{$kode}</b> masih digunakan oleh:<br><br>";

            if ($jumlahMapel != 0) {
                $pesan .= "• {$jumlahMapel} Master Mata Pelajaran<br>";
            }

            $pesan .= "<br>Silakan hapus data Master Mata Pelajaran terkait terlebih dahulu.";

            $this->dispatch('tampil-toast', pesan: $pesan, icon: 'error');
            return;
        }

        // 4. Sudah nonaktif dan tidak digunakan → soft delete
        $kurikulum->delete();
        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $this->dispatch('tampil-toast', pesan: 'Kurikulum berhasil dihapus.', icon: 'success');
    }
    private function resetInputFields()
    {
        $this->kurikulum_id = null;
        $this->nama_kurikulum = '';
        $this->deskripsi = '';
        $this->status = 'aktif';
        $this->resetValidation();
    }
}
