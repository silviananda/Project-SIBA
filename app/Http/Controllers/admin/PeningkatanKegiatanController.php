<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PeningkatanKegiatan;
use App\Models\Admin\KategoriPeran;
use App\Models\Admin\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;
use App\Notifications\Deadline;
use Carbon\Carbon;
use App\Notifications\VerifikasiDosen;

class PeningkatanKegiatanController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kegiatan = DB::table('kegiatan')
            ->join('kategori_peran', 'kegiatan.peran_id', '=', 'kategori_peran.id')
            ->join('dosen', 'kegiatan.dosen_id', '=', 'dosen.dosen_id')
            ->select('kegiatan.*', 'kategori_peran.peran', 'dosen.nip', 'dosen.nama_dosen')
            ->where('kegiatan.user_id', Auth::user()->kode_ps)->get();

        return view('admin.peningkatan-kegiatan.halaman-peningkatan-kegiatan', compact('kegiatan'));
    }

    public function create()
    {
        $kategori_peran = KategoriPeran::get();
        $dosen = Dosen::get();

        return view('admin.peningkatan-kegiatan.create', compact('kategori_peran', 'dosen'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'nip' => 'required | int',
            'jenis_kegiatan' => 'required',
            'tempat' => 'required',
            'waktu' => 'required | date',
            'peran_id' => 'required',
            'deadline' => 'required'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        DB::table('kegiatan')->insert([
            'user_id' => Auth::user()->kode_ps,
            'dosen_id' => $request->dosen_id,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tempat' => $request->tempat,
            'waktu' => $request->waktu,
            'peran_id' => $request->peran_id,
            'tanggal_create' => $date1,
            'deadline' => $request->deadline,

        ]);

        try {
            // Get admin prodi pada dosen
            $dosen = Dosen::find($request->dosen_id);

            $dosen->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->name,
                'pesan' => 'Telah mengirim data kegiatan untuk di verifikasi',
                'url' => route('kegiatan-dosen.index'),  //route tujuan
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/kegiatan-akademik')->with(['added' => 'Data Peningkatan Kegiatan berhasil ditambahkan!']);
    }

    public function edit(PeningkatanKegiatan $kegiatan, $id)
    {
        $kegiatan = PeningkatanKegiatan::findOrfail($id);
        $kategori_peran = KategoriPeran::get();
        $dosen = Dosen::get();

        return view('admin.peningkatan-kegiatan.edit', compact('kegiatan', 'kategori_peran', 'dosen'));
    }

    public function update(Request $request, PeningkatanKegiatan $kegiatan, $id)
    {
        $kegiatan = PeningkatanKegiatan::findOrfail($id);

        // return $request;
        $request->validate([
            'nip' => 'required',
            'jenis_kegiatan' => 'required',
            'tempat' => 'required',
            'waktu' => 'required | date',
            'peran_id' => 'required',
        ]);

        PeningkatanKegiatan::where('id', $kegiatan->id)
            ->update([
                'dosen_id' => $request->dosen_id,
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'tempat' => $request->tempat,
                'waktu' => $request->waktu,
                'peran_id' => $request->peran_id
            ]);
        return redirect('/kegiatan-akademik')->with(['edit' => 'Data Peningkatan Kegiatan berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('kegiatan')->where('id', $id)->delete();
        return redirect()->back();
    }
}
