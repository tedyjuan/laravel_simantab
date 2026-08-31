<?php

namespace App\Livewire\master;

use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\TahunAjar;
use Livewire\Component;
use Livewire\WithPagination;

class MasterKelas extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?int $kelas_id = null;
    public ?string $kode_kelas = null;
    public ?string $nama_kelas = null;
    public ?int $tingkat = null;
    public ?string $jurusan = null;
    public ?string $rombel = null;
    public ?int $id_tahun_ajaran = null;
    public ?int $id_wali_kelas = null;
    public ?int $kapasitas = 30;
    public ?string $ruangan = null;
    public ?string $status = null;

    // Untuk proses delete (di-set dari Alpine pakai $wire.set(..., false) saat klik icon hapus)
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $kelass = Kelas::with(['tahunAjaran', 'waliKelas'])
            ->where(function ($query) {
                $query->where('kode_kelas', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_kelas', 'like', '%' . $this->search . '%')
                    ->orWhere('jurusan', 'like', '%' . $this->search . '%');
            })
            ->orderBy('tingkat', 'asc')
            ->orderBy('kode_kelas', 'asc')
            ->paginate(10);

        return view('livewire.master.master-kelas', [
            'kelass'       => $kelass,
            'pegawais'     => Pegawai::orderBy('nama')->get(),
            'tahunAjarans' => TahunAjar::orderBy('kode', 'desc')->get(),
        ]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit(int $id)
    {
        $kelas = Kelas::findOrFail($id);

        $this->kelas_id        = $kelas->id;
        $this->kode_kelas      = $kelas->kode_kelas;
        $this->nama_kelas      = $kelas->nama_kelas;
        $this->tingkat         = $kelas->tingkat;
        $this->jurusan         = $kelas->jurusan;
        $this->rombel          = $kelas->rombel;
        $this->id_tahun_ajaran = $kelas->id_tahun_ajaran;
        $this->id_wali_kelas   = $kelas->id_wali_kelas;
        $this->kapasitas       = $kelas->kapasitas;
        $this->ruangan         = $kelas->ruangan;
        $this->status          = $kelas->status;

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
            'kode_kelas'      => 'required|string|max:20|unique:acd_ms_kelas,kode_kelas,' . $this->kelas_id,
            'nama_kelas'      => 'required|string|max:50',
            'tingkat'         => 'required|integer|min:1|max:255',
            'jurusan'         => 'nullable|string|max:50',
            'rombel'          => 'nullable|string|max:5',
            'id_tahun_ajaran' => 'required|exists:acd_ms_tahun_ajaran,id',
            'id_wali_kelas'   => 'nullable|exists:hr_ms_pegawai,id',
            'kapasitas'       => 'required|integer|min:1|max:65535',
            'ruangan'         => 'nullable|string|max:50',
            'status'          => 'required|in:aktif,nonaktif',
        ]);

        Kelas::updateOrCreate(
            ['id' => $this->kelas_id],
            $validated
        );

        $message = $this->kelas_id
            ? 'Kelas berhasil diperbarui.'
            : 'Kelas berhasil ditambahkan.';

        $this->resetInputFields();
        $this->dispatch('close-modal');

        session()->flash('message', $message);
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

        session()->flash('message', 'Kelas berhasil dihapus.');
    }

    private function resetInputFields()
    {
        $this->kelas_id = null;
        $this->kode_kelas = '';
        $this->nama_kelas = '';
        $this->tingkat = null;
        $this->jurusan = '';
        $this->rombel = '';
        $this->id_tahun_ajaran = null;
        $this->id_wali_kelas = null;
        $this->kapasitas = 30;
        $this->ruangan = '';
        $this->status = 'aktif';
        $this->resetValidation();
    }
}
