<?php

namespace App\Livewire\master;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MasterPegawai extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti Form (di-bind lewat wire:model, di-reset dari Alpine pakai $wire.set(..., false) saat "Tambah")
    public ?string $pegawai_id = null;
    public ?string $kode_pegawai = null;
    public ?string $nip = null;
    public ?string $nama = null;
    public ?string $jenis_kelamin = null;
    public ?string $email = null;
    public ?string $no_hp = null;
    public ?string $alamat = null;
    public ?string $tanggal_lahir = null;
    public ?string $kode_jabatan = null;
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
                ->orWhere('kode_jabatan', 'like', '%' . $this->search . '%')
                ->orWhere('nip', 'like', '%' . $this->search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $jabatans = Jabatan::where('status', 'aktif')
            ->orderBy('nama_jabatan')
            ->get();

        return view(
            'livewire.master.master-pegawai',
            [
                'pegawais'  => $pegawais,
                'jabatans'  => $jabatans,
            ]
        );
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
        $this->kode_jabatan  = $pegawai->kode_jabatan;
        $this->kode_pegawai  = $pegawai->kode_pegawai;
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
            'kode_jabatan'  => 'required|exists:hr_ms_jabatan,kode_jabatan',
            'status'        => 'required|in:aktif,nonaktif,cuti',
        ]);

        // =========================
        // UPDATE
        // =========================
        if ($this->pegawai_id) {

            $pegawai = Pegawai::findOrFail($this->pegawai_id);

            $pegawai->update([
                'nip'           => $this->nip,
                'nama'          => $this->nama,
                'jenis_kelamin' => $this->jenis_kelamin,
                'email'         => $this->email,
                'no_hp'         => $this->no_hp,
                'alamat'        => $this->alamat,
                'tanggal_lahir' => $this->tanggal_lahir ?: null,
                'kode_jabatan'  => $this->kode_jabatan,
                'tanggal_masuk' => $this->tanggal_masuk ?: null,
                'status'        => $this->status,
            ]);

            $pesan = 'Data Pegawai berhasil diupdate!';

            // =========================
            // CREATE
            // =========================
        } else {

            $pegawai = Pegawai::create([
                'ulid'          => (string) Str::ulid(),
                'nip'           => $this->nip,
                'nama'          => $this->nama,
                'jenis_kelamin' => $this->jenis_kelamin,
                'email'         => $this->email,
                'no_hp'         => $this->no_hp,
                'alamat'        => $this->alamat,
                'tanggal_lahir' => $this->tanggal_lahir ?: null,
                'kode_jabatan'  => $this->kode_jabatan,
                'tanggal_masuk' => $this->tanggal_masuk ?: null,
                'status'        => $this->status,
            ]);

            // Buat kode pegawai berdasarkan ID
            $pegawai->update([
                'kode_pegawai' => 'PGW-' . str_pad($pegawai->id, 5, '0', STR_PAD_LEFT),
            ]);

            $pesan = 'Data Pegawai berhasil ditambahkan!';
        }

        $this->dispatch('tampil-toast', pesan: $pesan, icon: 'success');

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
        $this->kode_pegawai = '';
        $this->nama = '';
        $this->jenis_kelamin = '';
        $this->email = '';
        $this->no_hp = '';
        $this->alamat = '';
        $this->tanggal_lahir = '';
        $this->kode_jabatan = '';
        $this->tanggal_masuk = '';
        $this->status = 'aktif';
        $this->resetValidation();
    }
}
