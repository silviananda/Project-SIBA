<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PembimbingAkademik;
use App\Models\Admin\Dosen;
use App\Models\Admin\MhsReguler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Auth;

class PembimbingAkademikController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bimbingan()
    {
        return view('admin.bimbingan.halaman-bimbingan');
    }

    public function index()
    {
        // $data_pembimbing_akademik = MhsReguler::select([
        //     'dosen.nama_dosen', 'biodata_mhs.tahun_masuk', 'biodata_mhs.id',
        //     \DB::raw("(biodata_mhs.dosen_id) as dosen"),
        //     \DB::raw('COUNT(biodata_mhs.id) as jumlah'),
        // ])
        //     ->join('dosen', 'biodata_mhs.dosen_id', '=', 'dosen.dosen_id')
        //     ->where('biodata_mhs.user_id', Auth::user()->kode_ps)
        //     ->groupBY('biodata_mhs.dosen_id')
        //     ->groupBY('biodata_mhs.tahun_masuk')
        //     ->orderBy('biodata_mhs.tahun_masuk', 'asc')
        //     ->get();

        $now = Date::now()->year;
        $years[] = $now;
        for ($i = 1; $i < 3; $i++) {
            $years[] = Date::now()->subYears($i)->year;
        }
        $tahun = array_reverse($years);

        $data_pembimbing_akademik = Dosen::where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.bimbingan.pembimbing-akademik.pembimbing-akademik', compact('data_pembimbing_akademik', 'tahun'));
    }

    public function destroy($id)
    {
        DB::table('data_pembimbing_akademik')->where('id', $id)->delete();
        return redirect()->back();
    }
}
