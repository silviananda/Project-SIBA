<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kemampuan;
use App\Models\Admin\Dosen;
use App\Models\Admin\KategoriPendidikan;
use App\Models\Admin\JenisDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;

class KemampuanDosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kemampuan_dosen = DB::table('kemampuan_dosen')
            ->join('dosen', 'kemampuan_dosen.dosen_id', '=', 'dosen.dosen_id')
            ->join('kategori_jenis_dosen', 'dosen.jenis_dosen', '=', 'kategori_jenis_dosen.id')
            ->select('kemampuan_dosen.*', 'dosen.nama_dosen')->where('jenis_dosen', '1')
            ->where('kemampuan_dosen.user_id', Auth::user()->kode_ps)->get();

        return view('admin.upaya.kemampuan.kemampuan-dosen', compact('kemampuan_dosen'));
    }

    public function create()
    {
        $kemampuan_dosen = Kemampuan::get();
        $kategori_pendidikan = KategoriPendidikan::get();
        $dosen = Dosen::get();
        $kategori_jenis_dosen = JenisDosen::get();
        return view('admin.upaya.kemampuan.create', compact('kemampuan_dosen', 'dosen', 'kategori_jenis_dosen', 'kategori_pendidikan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required | int',
            'bidang' => 'required',
            'perguruan' => 'required',
            'negara' => 'required',
            'tahun' => 'required'
        ]);

        DB::table('kemampuan_dosen')->insert([
            'user_id' => Auth::user()->kode_ps,
            'dosen_id' => $request->dosen_id,
            'bidang' => $request->bidang,
            'perguruan' => $request->perguruan,
            'negara' => $request->negara,
            'tahun' => $request->tahun
        ]);

        return redirect('/upaya/tugas-belajar')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Kemampuan $kemampuan, $id)
    {
        $kemampuan_dosen = Kemampuan::findOrfail($id);
        $kategori_pendidikan = KategoriPendidikan::get();
        $dosen = Dosen::get();
        $kategori_jenis_dosen = JenisDosen::get();

        return view('admin.upaya.kemampuan.edit', compact('kemampuan_dosen', 'dosen', 'kategori_jenis_dosen', 'kategori_pendidikan'));
    }

    public function update(Request $request, Kemampuan $kemampuan, $id)
    {
        $kemampuan_dosen = Kemampuan::findOrfail($id);

        $request->validate([
            'nip' => 'required | int',
            'bidang' => 'required',
            'perguruan' => 'required',
            'negara' => 'required',
            'tahun' => 'required'
        ]);

        Kemampuan::findOrfail($id)
            ->update([
                'user_id' => Auth::user()->kode_ps,
                'dosen_id' => $request->dosen_id,
                'bidang' => $request->bidang,
                'perguruan' => $request->perguruan,
                'negara' => $request->negara,
                'tahun' => $request->tahun
            ]);

        // dd($request);
        return redirect('/upaya/tugas-belajar')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('kemampuan_dosen')->where('id', $id)->delete();
        return redirect()->back();
    }
}
