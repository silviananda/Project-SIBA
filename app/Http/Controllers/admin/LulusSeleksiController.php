<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\LulusSeleksi;
use App\Models\Admin\KategoriJalur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;

class LulusSeleksiController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mhs_lulus = DB::table('mhs_lulus')
            ->join('kategori_jalur', 'mhs_lulus.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->select('mhs_lulus.*', 'kategori_jalur.jalur_masuk')
            ->where('user_id', Auth::user()->kode_ps)->get();
        return view('admin.mahasiswa.lulus-seleksi.lulus-seleksi', compact('mhs_lulus'));
    }

    public function create()
    {
        $mhs_lulus = LulusSeleksi::get();
        $kategori_jalur = KategoriJalur::get();
        return view('admin.mahasiswa.lulus-seleksi.create', compact('mhs_lulus', 'kategori_jalur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_ujian' => 'required | int',
            'nama' => 'required',
            'asal_sekolah' => 'required',
            'jalur_masuk_id' => 'required',
            'tahun_masuk' => 'required'
        ]);

        // return $request;

        DB::table('mhs_lulus')->insert([
            'user_id' => Auth::user()->kode_ps,
            'no_ujian' => $request->no_ujian,
            'nama' => $request->nama,
            'asal_sekolah' => $request->asal_sekolah,
            'jalur_masuk_id' => $request->jalur_masuk_id,
            'tahun_masuk' => $request->tahun_masuk
        ]);

        return redirect('/mahasiswa/lulus-seleksi')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(LulusSeleksi $lulusSeleksi, $id)
    {
        $mhs_lulus = LulusSeleksi::findOrfail($id);
        $kategori_jalur = KategoriJalur::get();

        return view('admin.mahasiswa.lulus-seleksi.edit', compact('mhs_lulus', 'kategori_jalur'));
    }

    public function update(Request $request, LulusSeleksi $lulusSeleksi, $id)
    {
        $request->validate([
            'no_ujian' => 'required | int',
            'nama' => 'required',
            'asal_sekolah' => 'required',
            'jalur_masuk_id' => 'required',
            'tahun_masuk' => 'required'
        ]);

        // return $request;
        LulusSeleksi::findOrfail($id)
            ->update([
                'no_ujian' => $request->no_ujian,
                'nama' => $request->nama,
                'asal_sekolah' => $request->asal_sekolah,
                'jalur_masuk_id' => $request->jalur_masuk_id,
                'tahun_masuk' => $request->tahun_masuk
            ]);

        return redirect('/mahasiswa/lulus-seleksi')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('mhs_lulus')->where('id', $id)->delete();
        return redirect()->back();
    }
}
