<?php

namespace App\Livewire\master;

use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Jenjang;
use App\Models\TahunAjar;
use App\Models\Pegawai;
use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MasterRombel extends Component
{
    use WithPagination;

    public $search = '';

    public ?int $id = null;
    public ?string $ulid = null;
    public ?string $kode_rombel = null;
    public ?string $nama_rombel = null;
    public ?string $kode_jenjang = null;        // <- BARU
    public ?string $kode_kelas = null;
    public ?string $kode_tahun_ajaran_header = null;
    public ?string $kode_pegawai = null;
    public ?int $kapasitas = null;
    public ?string $kode_ruangan = null;
    public ?string $status = 'aktif';

    public ?int $deleteId = null;

    protected function rules()
    {
        return [
            'kode_rombel'              => 'nullable|string|max:20|unique:acd_ms_rombel,kode_rombel,' . $this->id,
            'nama_rombel'              => 'required|string|max:50',
            'kode_jenjang'             => 'required|exists:acd_ms_jenjang,kode_jenjang',
            'kode_kelas'               => 'required|exists:acd_ms_kelas,kode_kelas',
            'kode_tahun_ajaran_header' => 'required|exists:acd_ms_tahun_ajaran_header,kode_tahun_ajaran_header',
            'kode_pegawai'             => 'nullable|exists:hr_ms_pegawai,kode_pegawai',
            'kapasitas'                => 'nullable|integer|min:1',
            'kode_ruangan'             => 'nullable|exists:inv_ms_ruangan,kode_ruangan',
            'status'                   => 'required|in:aktif,nonaktif',
        ];
    }

    protected $messages = [
        'nama_rombel.required'              => 'Nama rombel wajib diisi.',
        'kode_jenjang.required'             => 'Jenjang wajib dipilih.',
        'kode_jenjang.exists'               => 'Jenjang tidak ditemukan.',
        'kode_kelas.required'               => 'Kelas wajib dipilih.',
        'kode_kelas.exists'                 => 'Kelas tidak ditemukan.',
        'kode_tahun_ajaran_header.required' => 'Tahun ajaran wajib dipilih.',
        'kode_tahun_ajaran_header.exists'   => 'Tahun ajaran tidak ditemukan.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Setiap kode_jenjang berubah (lewat wire:model.live di select Jenjang),
     * reset kode_kelas supaya user nggak nyangkut milih kelas dari jenjang lama.
     */
    public function updatedKodeJenjang($value)
    {
        $this->kode_kelas = null;
    }

    /**
     * Daftar kelas yang tampil di dropdown, ke-filter otomatis
     * berdasarkan kode_jenjang yang lagi dipilih di form.
     */
    public function getKelasFilteredProperty()
    {
        if (!$this->kode_jenjang) {
            return collect();
        }

        return Kelas::where('kode_jenjang', $this->kode_jenjang)
            ->orderBy('nama_kelas')
            ->get();
    }

    public function resetForm()
    {
        $this->reset([
            'id',
            'ulid',
            'kode_rombel',
            'nama_rombel',
            'kode_jenjang',
            'kode_kelas',
            'kode_tahun_ajaran_header',
            'kode_pegawai',
            'kapasitas',
            'kode_ruangan',
        ]);
        $this->status = 'aktif';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function edit($id)
    {
        $rombel = Rombel::with('kelas')->findOrFail($id);

        $this->id                       = $rombel->id;
        $this->ulid                     = $rombel->ulid;
        $this->kode_rombel              = $rombel->kode_rombel;
        $this->nama_rombel              = $rombel->nama_rombel;
        $this->kode_jenjang             = $rombel->kelas->kode_jenjang ?? null; // ambil dari relasi kelas
        $this->kode_kelas               = $rombel->kode_kelas;
        $this->kode_tahun_ajaran_header = $rombel->kode_tahun_ajaran_header;
        $this->kode_pegawai             = $rombel->kode_pegawai;
        $this->kapasitas                = $rombel->kapasitas;
        $this->kode_ruangan             = $rombel->kode_ruangan;
        $this->status                   = $rombel->status;
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $payload = [
                'kode_rombel'              => $this->kode_rombel,
                'nama_rombel'              => $this->nama_rombel,
                'kode_kelas'               => $this->kode_kelas,
                'kode_tahun_ajaran_header' => $this->kode_tahun_ajaran_header,
                'kode_pegawai'             => $this->kode_pegawai,
                'kapasitas'                => $this->kapasitas ?? 30,
                'kode_ruangan'             => $this->kode_ruangan,
                'status'                   => $this->status,
            ];
            // catatan: kode_jenjang TIDAK disimpan ke tabel rombel,
            // karena jenjang cuma dipakai sebagai filter bantu buat milih kelas.
            // Data jenjang tetap "nempel" ke rombel lewat relasi kelas->jenjang.

            if ($this->id) {
                $rombel = Rombel::findOrFail($this->id);
                $rombel->update($payload);
                session()->flash('success', 'Data rombel berhasil diperbarui.');
            } else {
                $payload['ulid'] = (string) Str::ulid();
                Rombel::create($payload);
                session()->flash('success', 'Data rombel berhasil ditambahkan.');
            }

            DB::commit();
            $this->resetForm();
            $this->dispatch('rombel-saved');
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            Rombel::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Data rombel berhasil dihapus.');
            $this->deleteId = null;
            $this->dispatch('rombel-deleted');
        }
    }

    public function render()
    {
        $rombel = Rombel::with(['kelas.jenjang', 'tahunAjar', 'pegawai', 'ruangan'])
            ->where(function ($query) {
                $query->where('kode_rombel', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_rombel', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kelas', function ($q) {
                        $q->where('nama_kelas', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('tahunAjar', function ($q) {
                        $q->where('nama_tahun_ajaran_header', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('pegawai', function ($q) {
                        $q->where('nama_pegawai', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('ruangan', function ($q) {
                        $q->where('nama_ruangan', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.master-rombel', [
            'rombel'        => $rombel,
            'jenjangList'   => Jenjang::orderBy('nama_jenjang')->get(), // <- BARU
            'kelasList'     => Kelas::orderBy('nama_kelas')->get(),
            'tahunAjarList' => TahunAjar::orderBy('id', 'desc')->get(),
            'pegawaiList'   => Pegawai::orderBy('nama_pegawai')->get(),
            'ruanganList'   => Ruangan::orderBy('nama_ruangan')->get(),
        ]);
    }
}
