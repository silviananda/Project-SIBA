<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Prasarana;
use App\Models\Admin\KategoriKepemilikan;
use App\Models\Admin\KategoriKondisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PrasaranaController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function prasarana()
    {
        return view('admin.prasarana.halaman-prasarana');
    }

    public function index()
    {
        $data_prasarana = DB::table('data_prasarana')
            ->join('kategori_kondisi', 'data_prasarana.kondisi', '=', 'kategori_kondisi.id')
            ->join('kategori_kepemilikan', 'data_prasarana.kepemilikan', '=', 'kategori_kepemilikan.id')
            ->select('data_prasarana.*', 'kategori_kondisi.kondisi', 'kategori_kepemilikan.jenis')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.prasarana.prasarana.prasarana', ['data_prasarana' => $data_prasarana]);
    }

    public function create()
    {
        $kategori_kepemilikan = KategoriKepemilikan::get();
        $kategori_kondisi = KategoriKondisi::get();

        return view('admin.prasarana.prasarana.create', compact('data_prasarana', 'kategori_kepemilikan', 'kategori_kondisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_prasarana' => 'required',
            'jumlah_unit' => 'required | int',
            'total_luas' => 'required | numeric',
            'kepemilikan' => 'required',
            'kondisi' => 'required'
        ]);

        DB::table('data_prasarana')->insert([
            'user_id' => Auth::user()->kode_ps,
            'jenis_prasarana' => $request->jenis_prasarana,
            'jumlah_unit' => $request->jumlah_unit,
            'total_luas' => $request->total_luas,
            'kepemilikan' => $request->kepemilikan,
            'kondisi' => $request->kondisi
        ]);

        return redirect('/prasarana/data')->with(['added' => 'Data Prasarana berhasil ditambahkan!']);
    }

    public function edit(Prasarana $prasarana, $id)
    {
        $data_prasarana = Prasarana::findOrfail($id);
        $kategori_kepemilikan = KategoriKepemilikan::get();
        $kategori_kondisi = KategoriKondisi::get();

        return view('admin.prasarana.prasarana.edit', compact('data_prasarana', 'kategori_kepemilikan', 'kategori_kondisi'));
    }

    public function update(Request $request, Prasarana $prasarana, $id)
    {
        $data_prasarana = Prasarana::findOrfail($id);

        $request->validate([
            'jenis_prasarana' => 'required',
            'jumlah_unit' => 'required | int',
            'total_luas' => 'required | numeric',
            'kepemilikan' => 'required',
            'kondisi' => 'required'
        ]);

        Prasarana::where('id', $data_prasarana->id)
            ->update([
                'jenis_prasarana' => $request->jenis_prasarana,
                'jumlah_unit' => $request->jumlah_unit,
                'total_luas' => $request->total_luas,
                'kepemilikan' => $request->kepemilikan,
                'kondisi' => $request->kondisi
            ]);
        return redirect('/prasarana/data')->with(['edit' => 'Data Prasarana berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('data_prasarana')->where('id', $id)->delete();
        return redirect()->back();
    }
}
