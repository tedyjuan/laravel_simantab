<?php

namespace App\Livewire\master;

use App\Models\Pegawai;
use Livewire\Component;
use Livewire\WithPagination;

class MasterPegawai extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?string $pegawai_id = null;
    public ?string $nip = null;
    public ?string $nama = null;
    public ?string $jenis_kelamin = null;
    public ?string $email = null;
    public ?string $no_hp = null;
    public ?string $alamat = null;
    public ?string $tanggal_lahir = null;
    public ?string $jenis_pegawai = null;
    public ?string $jabatan = null;
    public ?string $tanggal_masuk = null;
    public ?string $status = null;

    // Untuk proses delete (di-set dari Alpine pakai $wire.set(..., false) saat klik icon hapus)
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pegawais = Pegawai::where(function ($query) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('jabatan', 'like', '%' . $this->search . '%')
                ->orWhere('nip', 'like', '%' . $this->search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.master.master-pegawai', ['pegawais' => $pegawais]);
    }

    /**
     * Buka modal edit.
     * WAJIB ke server karena harus ambil data dari database.
     * Modal ditampilkan lewat event 'open-modal' yang ditangkap Alpine.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $this->pegawai_id    = $id;
        $this->nip           = $pegawai->nip;
        $this->nama          = $pegawai->nama;
        $this->jenis_kelamin = $pegawai->jenis_kelamin;
        $this->email         = $pegawai->email;
        $this->no_hp         = $pegawai->no_hp;
        $this->alamat        = $pegawai->alamat;
        $this->tanggal_lahir = $pegawai->tanggal_lahir ? $pegawai->tanggal_lahir->format('Y-m-d') : null;
        $this->jenis_pegawai = $pegawai->jenis_pegawai;
        $this->jabatan       = $pegawai->jabatan;
        $this->tanggal_masuk = $pegawai->tanggal_masuk ? $pegawai->tanggal_masuk->format('Y-m-d') : null;
        $this->status        = $pegawai->status;

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
        $this->validate([
            'nama'          => 'required|string|max:100',
            'nip'           => 'nullable|string|max:30|unique:hr_ms_pegawai,nip,' . $this->pegawai_id,
            'email'         => 'nullable|email|max:100|unique:hr_ms_pegawai,email,' . $this->pegawai_id,
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'nullable|string|max:20',
            'jenis_pegawai' => 'required|in:guru,staff,kepala_sekolah',
            'status'        => 'required|in:aktif,nonaktif,cuti',
        ]);

        Pegawai::updateOrCreate(
            ['id' => $this->pegawai_id],
            [
                'nip'           => $this->nip,
                'nama'          => $this->nama,
                'jenis_kelamin' => $this->jenis_kelamin,
                'email'         => $this->email,
                'no_hp'         => $this->no_hp,
                'alamat'        => $this->alamat,
                'tanggal_lahir' => $this->tanggal_lahir ?: null,
                'jenis_pegawai' => $this->jenis_pegawai,
                'jabatan'       => $this->jabatan,
                'tanggal_masuk' => $this->tanggal_masuk ?: null,
                'status'        => $this->status,
            ]
        );

        $this->dispatch(
            'tampil-toast',
            pesan: $this->pegawai_id ? 'Data Pegawai berhasil diupdate!' : 'Data Pegawai berhasil ditambahkan!',
            icon: 'success'
        );

        $this->resetInputFields();
        $this->dispatch('close-modal');
    }

    /**
     * Proses hapus. WAJIB ke server karena eksekusi query delete.
     * $this->deleteId sudah di-set dari client (Alpine) sebelum method ini dipanggil.
     */
    public function delete()
    {
        if ($this->deleteId) {
            Pegawai::find($this->deleteId)?->delete();
            $this->dispatch('tampil-toast', pesan: 'Data Pegawai berhasil dihapus!', icon: 'success');
        }

        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
    }

    private function resetInputFields()
    {
        $this->pegawai_id = null;
        $this->nip = '';
        $this->nama = '';
        $this->jenis_kelamin = '';
        $this->email = '';
        $this->no_hp = '';
        $this->alamat = '';
        $this->tanggal_lahir = '';
        $this->jenis_pegawai = 'guru';
        $this->jabatan = '';
        $this->tanggal_masuk = '';
        $this->status = 'aktif';
        $this->resetValidation();
    }
}
