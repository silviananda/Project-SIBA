<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Admin\PeningkatanKegiatan;
use App\Models\Admin\KategoriPeran;
use App\Models\Admin\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Notifications\VerifikasiDosen;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = DB::table('kegiatan')
            ->join('kategori_peran', 'kegiatan.peran_id', '=', 'kategori_peran.id')
            ->join('dosen', 'kegiatan.dosen_id', '=', 'dosen.dosen_id')
            ->select('kegiatan.*', 'kategori_peran.peran', 'dosen.nip', 'dosen.nama_dosen')
            ->where('kegiatan.dosen_id', Auth::guard('dosen')->user()->dosen_id)->get();

        return view('dosen.kegiatan.kegiatan-dosen', compact('kegiatan', 'dosen', 'kategori_peran'));
    }

    public function create()
    {
        $kegiatan = PeningkatanKegiatan::get();
        $kategori_peran = KategoriPeran::get();
        $dosen = Dosen::get();

        return view('dosen.kegiatan.create', compact('kegiatan', 'dosen', 'kategori_peran'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'jenis_kegiatan' => 'required',
            'tempat' => 'required',
            'waktu' => 'required | date',
            'peran_id' => 'required'
        ]);

        DB::table('kegiatan')->insert([
            'dosen_id' => \Auth::guard('dosen')->user()->dosen_id,
            'user_id' => \Auth::guard('dosen')->user()->user_id,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tempat' => $request->tempat,
            'waktu' => $request->waktu,
            'peran_id' => $request->peran_id,
            'is_verification' => 1
        ]);

        return redirect('/kegiatan-dosen')->with(['added' => 'Data Peningkatan Kegiatan berhasil ditambahkan!']);
    }

    public function edit(PeningkatanKegiatan $kegiatan, $id)
    {
        $kegiatan = PeningkatanKegiatan::findOrfail($id);
        $kategori_peran = KategoriPeran::get();
        $dosen = Dosen::get();

        return view('dosen.kegiatan.edit', compact('kegiatan', 'dosen', 'kategori_peran'));
    }

    public function update(Request $request, PeningkatanKegiatan $kegiatan, $id)
    {
        $kegiatan = PeningkatanKegiatan::findOrfail($id);

        // return $request;
        $request->validate([
            'jenis_kegiatan' => 'required',
            'tempat' => 'required',
            'waktu' => 'required | date',
            'peran_id' => 'required'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        PeningkatanKegiatan::where('id', $kegiatan->id)
            ->update([
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'tempat' => $request->tempat,
                'waktu' => $request->waktu,
                'peran_id' => $request->peran_id,
                'is_verification' => $request->is_verification == 'on' ? 1 : 0
            ]);

        try {
            // Get admin prodi pada dosen
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan update data kegiatan',
                'url' => route('kegiatan-akademik.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/kegiatan-dosen')->with(['edit' => 'Data Peningkatan Kegiatan berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('kegiatan')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function confirm(Request $request, $id)
    {
        PeningkatanKegiatan::findOrfail($id)
            ->update([
                'is_verification' => $request->is_verification == 'on' ? 0 : 1
            ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            // Get admin prodi pada dosen
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan update data kegiatan',
                'url' => route('kegiatan-akademik.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }
}
