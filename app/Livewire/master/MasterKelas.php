<?php

namespace App\Livewire\master;

use App\Models\Jenjang;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MasterKelas extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $kelas_id = null;
    public ?string $kode_kelas = null;
    public ?string $nama_kelas = null;
    public ?string $kode_jenjang = null;
    public ?string $kode_tingkatan = null;
    public ?string $tingkat = null;
    public ?string $status = null;

    // Untuk proses delete (di-set dari Alpine pakai $wire.set(..., false) saat klik icon hapus)
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $kelass = Kelas::with([
            'jenjang',
        ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('kode_kelas', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_kelas', 'like', '%' . $this->search . '%')
                        ->orWhere('kode_jenjang', 'like', '%' . $this->search . '%')
                        ->orWhere('kode_tingkatan', 'like', '%' . $this->search . '%')
                        ->orWhere('tingkat', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.master.master-kelas', [
            'kelass'      => $kelass,
            'jenjangs'    => Jenjang::orderBy('kode_jenjang', 'asc')->get(),
        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit(int $id)
    {
        $kelas              = Kelas::findOrFail($id);
        $this->kelas_id     = $kelas->id;
        $this->kode_kelas   = $kelas->kode_kelas;
        $this->nama_kelas   = $kelas->nama_kelas;
        $this->kode_jenjang = $kelas->kode_jenjang;
        $this->kode_tingkatan = $kelas->kode_tingkatan;
        $this->tingkat      = $kelas->tingkat;
        $this->status       = $kelas->status;

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
            'kode_jenjang'   => 'required|string|max:50',
            'kode_tingkatan' => 'required|string|max:50',
            'nama_kelas'     => 'required|string|max:50',
            'tingkat'      => 'nullable|string|max:50',
            'status'       => 'required|in:aktif,nonaktif',
        ]);
        // Generate kode kelas
        $kodeKelas = 'KLS-' . strtoupper($this->kode_tingkatan) . '-' . $this->tingkat;
        // Cek apakah kode sudah digunakan oleh kelas lain
        $kodeSudahAda = Kelas::where('kode_kelas', $kodeKelas)
            ->when($this->kelas_id, function ($query) {
                $query->where('id', '!=', $this->kelas_id);
            })
            ->exists();

        if ($kodeSudahAda) {
            $this->addError('kode_tingkatan', "Kombinasi tingkatan dan tingkat tersebut sudah digunakan ({$kodeKelas}).");
            return;
        }

        $validated['kode_kelas'] = $kodeKelas;

        if ($this->kelas_id) {
            // UPDATE
            Kelas::findOrFail($this->kelas_id)->update($validated);
            $message = 'Kelas berhasil diperbarui.';
        } else {
            // CREATE
            Kelas::create([
                ...$validated,
                'ulid' => (string) Str::ulid(),
            ]);

            $message = 'Kelas berhasil ditambahkan.';
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
        Kelas::find($this->deleteId)?->delete();

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
        $message = 'Kelas berhasil dihapus.';
        $this->dispatch('tampil-toast', pesan: $message, icon: 'success');
    }

    private function resetInputFields()
    {
        $this->kelas_id = null;
        $this->kode_kelas = '';
        $this->nama_kelas = '';
        $this->kode_jenjang = null;
        $this->kode_tingkatan = null;
        $this->tingkat = '';
        $this->status = '';
        $this->resetValidation();
    }
}
