<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Admin\PembimbingAkademik;
use App\Models\Admin\Dosen;
use App\Models\Admin\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class PembimbingAkademikController extends Controller
{
    public function index()
    {
        $data_pembimbing_akademik = DB::table('biodata_mhs')
            ->join('dosen', 'biodata_mhs.dosen_id', '=', 'dosen.dosen_id')
            ->select('biodata_mhs.*')
            ->where('biodata_mhs.dosen_id', Auth::guard('dosen')->user()->dosen_id)->get();

        return view('dosen.bimbingan.akademik.akademik', compact('data_pembimbing_akademik'));
    }

    public function destroy($id)
    {
        DB::table('data_pembimbing_akademik')->where('mhs_id', $id)->delete();
        return redirect()->back();
    }
}
