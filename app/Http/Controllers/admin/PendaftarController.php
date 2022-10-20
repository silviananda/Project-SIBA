<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Pendaftar;
use App\Models\Admin\KategoriJalur;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class PendaftarController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pendaftar = DB::table('pendaftar')
            ->join('kategori_jalur', 'pendaftar.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->select('pendaftar.*', 'kategori_jalur.jalur_masuk')
            ->where('user_id', Auth::user()->kode_ps)->get();
        return view('admin.mahasiswa.pendaftar.pendaftar', ['pendaftar' => $pendaftar]);
    }

    public function create()
    {
        $pendaftar = Pendaftar::get();
        $kategori_jalur = KategoriJalur::get();
        return view('admin.mahasiswa.pendaftar.create', compact('pendaftar', 'kategori_jalur'));
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

        DB::table('pendaftar')->insert([
            'user_id' => Auth::user()->kode_ps,
            'no_ujian' => $request->no_ujian,
            'nama' => $request->nama,
            'asal_sekolah' => $request->asal_sekolah,
            'jalur_masuk_id' => $request->jalur_masuk_id,
            'tahun_masuk' => $request->tahun_masuk,
            'updated_at' => $request->updated_at,
            'created_at' => $request->created_at
        ]);

        return redirect('/mahasiswa/daftar')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Pendaftar $pendaftar, $id)
    {
        // return "hello";
        $pendaftar = Pendaftar::findOrfail($id);
        $kategori_jalur = KategoriJalur::get();

        return view('admin.mahasiswa.pendaftar.edit', compact('pendaftar', 'kategori_jalur'));
    }

    public function update(Request $request, Pendaftar $pendaftar, $id)
    {
        $pendaftar = Pendaftar::findOrfail($id);

        $request->validate([
            'no_ujian' => 'required | int',
            'nama' => 'required',
            'asal_sekolah' => 'required',
            'jalur_masuk_id' => 'required',
            'tahun_masuk' => 'required'
        ]);

        Pendaftar::findOrfail($id)
            ->update([
                'no_ujian' => $request->no_ujian,
                'nama' => $request->nama,
                'asal_sekolah' => $request->asal_sekolah,
                'jalur_masuk_id' => $request->jalur_masuk_id,
                'tahun_masuk' => $request->tahun_masuk,
                'updated_at' => $request->updated_at,
                'created_at' => $request->created_at
            ]);
        // return "hello";
        return redirect('/mahasiswa/daftar')->with(['edit' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id)
    {
        DB::table('pendaftar')->where('id', $id)->delete();
        return redirect()->back();
    }
}
