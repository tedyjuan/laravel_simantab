<?php

namespace App\Livewire\master;

use App\Models\TahunAjar;
use App\Models\TahunAjarDetail;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            'tahun_mulai'   => 'required|integer|digits:4',
            'tahun_selesai' => 'required|integer|digits:4|gt:tahun_mulai',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $message = DB::transaction(function () use ($validated) {

            // =====================================================
            // GENERATE NAMA TAHUN AJARAN
            // =====================================================

            $tahunMulai   = $validated['tahun_mulai'];
            $tahunSelesai = $validated['tahun_selesai'];

            $namaTahunAjaran = "Tahun Ajaran {$tahunMulai}/{$tahunSelesai}";


            // =====================================================
            // UPDATE
            // =====================================================

            if ($this->tahun_ajaran_id) {

                $tahunAjar = TahunAjar::findOrFail(
                    $this->tahun_ajaran_id
                );

                // ---------------------------------------------
                // UPDATE HEADER
                // ---------------------------------------------

                $tahunAjar->update([
                    'nama_tahun_ajaran_header' => $namaTahunAjaran,
                    'tahun_mulai'              => $validated['tahun_mulai'],
                    'tahun_selesai'            => $validated['tahun_selesai'],
                    'status'                   => $validated['status'],
                ]);


                // ---------------------------------------------
                // UPDATE DETAIL
                // ---------------------------------------------

                // Semester Ganjil
                TahunAjarDetail::where('kode_tahun_ajaran_header', $tahunAjar->kode_tahun_ajaran_header)
                    ->where('semester', 'ganjil')
                    ->update([
                        'nama_tahun_ajaran_detail' => $namaTahunAjaran,
                        'tanggal_mulai'            => "{$tahunMulai}-07-01",
                        'tanggal_selesai'          => "{$tahunMulai}-12-31",
                    ]);


                // Semester Genap
                TahunAjarDetail::where('kode_tahun_ajaran_header', $tahunAjar->kode_tahun_ajaran_header)
                    ->where('semester', 'genap')
                    ->update([
                        'nama_tahun_ajaran_detail' => $namaTahunAjaran,
                        'tanggal_mulai'            => "{$tahunSelesai}-01-01",
                        'tanggal_selesai'          => "{$tahunSelesai}-06-30",
                    ]);


                return 'Tahun ajaran berhasil diperbarui.';
            }


            // =====================================================
            // CREATE HEADER
            // =====================================================

            $tahunAjar = TahunAjar::create([
                'ulid'                     => (string) Str::ulid(),
                'nama_tahun_ajaran_header' => $namaTahunAjaran,
                'tahun_mulai'              => $validated['tahun_mulai'],
                'tahun_selesai'            => $validated['tahun_selesai'],
                'status'                   => $validated['status'],
            ]);


            // =====================================================
            // GENERATE KODE HEADER
            // =====================================================

            $tahunAjar->update(['kode_tahun_ajaran_header' => 'TAH' . str_pad($tahunAjar->id, 3, '0', STR_PAD_LEFT)]);


            // =====================================================
            // CREATE SEMESTER GANJIL
            // =====================================================

            TahunAjarDetail::create([
                'ulid'                     => (string) Str::ulid(),
                'kode_tahun_ajaran_detail' => 'TAD' . str_pad(($tahunAjar->id * 2) - 1, 3, '0', STR_PAD_LEFT),
                'kode_tahun_ajaran_header' => $tahunAjar->kode_tahun_ajaran_header,
                'nama_tahun_ajaran_detail' => $namaTahunAjaran,
                'semester'        => 'ganjil',
                'tanggal_mulai'   => "{$tahunMulai}-07-01",
                'tanggal_selesai' => "{$tahunMulai}-12-31",
            ]);


            // =====================================================
            // CREATE SEMESTER GENAP
            // =====================================================

            TahunAjarDetail::create([
                'ulid'                     => (string) Str::ulid(),
                'kode_tahun_ajaran_detail' => 'TAD' . str_pad($tahunAjar->id * 2, 3, '0', STR_PAD_LEFT),
                'kode_tahun_ajaran_header' => $tahunAjar->kode_tahun_ajaran_header,
                'nama_tahun_ajaran_detail' => $namaTahunAjaran,
                'semester'        => 'genap',
                'tanggal_mulai'   => "{$tahunSelesai}-01-01",
                'tanggal_selesai' => "{$tahunSelesai}-06-30",
            ]);


            return 'Tahun ajaran berhasil ditambahkan.';
        });


        // =====================================================
        // RESET FORM
        // =====================================================

        $this->resetInputFields();


        // =====================================================
        // CLOSE MODAL
        // =====================================================

        $this->dispatch('close-modal');


        // =====================================================
        // TOAST
        // =====================================================

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
        DB::transaction(function () {
            $tahunAjar = TahunAjar::find($this->deleteId);
            if (!$tahunAjar) {
                return;
            }
            // Hapus detail semester terlebih dahulu
            TahunAjarDetail::where('kode_tahun_ajaran_header', $tahunAjar->kode_tahun_ajaran_header)->delete();
            // Hapus header
            $tahunAjar->delete();
        });

        $this->deleteId = null;

        $this->dispatch('close-delete-modal');

        $this->dispatch(
            'tampil-toast',
            pesan: 'Tahun ajaran berhasil dihapus!',
            icon: 'success'
        );
    }

    private function resetInputFields()
    {
        $this->tahun_ajaran_id = null;
        $this->tahun_mulai = null;
        $this->tahun_selesai = null;
        $this->status = null;
        $this->resetValidation();
    }
    public function showDetail(string $id)
    {
        $tahunAjar = TahunAjar::with('details')->findOrFail($id);
        $ganjil = $tahunAjar->details->firstWhere('semester', 'ganjil');
        $genap = $tahunAjar->details->firstWhere('semester', 'genap');

        $this->dispatch(
            'open-detail-modal',
            kode_header: $tahunAjar->kode_tahun_ajaran_header,
            nama_header: $tahunAjar->nama_tahun_ajaran_header,
            tahun_mulai: $tahunAjar->tahun_mulai,
            tahun_selesai: $tahunAjar->tahun_selesai,
            status: $tahunAjar->status,

            ganjil: [
                'kode' => $ganjil?->kode_tahun_ajaran_detail ?? '-',
                'nama' => $ganjil?->nama_tahun_ajaran_detail ?? '-',
                'tanggal_mulai' => $ganjil?->tanggal_mulai?->format('d M Y') ?? '-',
                'tanggal_selesai' => $ganjil?->tanggal_selesai?->format('d M Y') ?? '-',
            ],

            genap: [
                'kode' => $genap?->kode_tahun_ajaran_detail ?? '-',
                'nama' => $genap?->nama_tahun_ajaran_detail ?? '-',
                'tanggal_mulai' => $genap?->tanggal_mulai?->format('d M Y') ?? '-',
                'tanggal_selesai' => $genap?->tanggal_selesai?->format('d M Y') ?? '-',
            ],
        );
    }
}
