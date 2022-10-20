<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PrasaranaLain;
use App\Models\Admin\KategoriKepemilikan;
use App\Models\Admin\KategoriKondisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


class PrasaranaLainController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_prasarana_lain = DB::table('data_prasarana_lain')
            ->join('kategori_kondisi', 'data_prasarana_lain.kondisi', '=', 'kategori_kondisi.id')
            ->join('kategori_kepemilikan', 'data_prasarana_lain.kepemilikan', '=', 'kategori_kepemilikan.id')
            ->select('data_prasarana_lain.*', 'kategori_kondisi.kondisi', 'kategori_kepemilikan.jenis')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.prasarana.prasarana-lain.prasarana-lain', ['data_prasarana_lain' => $data_prasarana_lain]);
    }

    public function create()
    {
        $kategori_kepemilikan = KategoriKepemilikan::get();
        $kategori_kondisi = KategoriKondisi::get();

        return view('admin.prasarana.prasarana-lain.create', compact('kategori_kepemilikan', 'kategori_kondisi'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'jenis_prasarana' => 'required',
            'jumlah_unit' => 'required | int',
            'total_luas' => 'required | numeric',
            'kepemilikan' => 'required',
            'kondisi' => 'required',
            'unit_pengelola' => 'required'
        ]);

        DB::table('data_prasarana_lain')->insert([
            'user_id' => Auth::user()->kode_ps,
            'jenis_prasarana' => $request->jenis_prasarana,
            'jumlah_unit' => $request->jumlah_unit,
            'total_luas' => $request->total_luas,
            'kepemilikan' => $request->kepemilikan,
            'kondisi' => $request->kondisi,
            'unit_pengelola' => $request->unit_pengelola
        ]);

        return redirect('/prasarana/prasarana-lain')->with(['added' => 'Data Prasarana lain berhasil ditambahkan!']);
    }

    public function edit(PrasaranaLain $prasaranaLain, $id)
    {
        $data_prasarana_lain = PrasaranaLain::findOrfail($id);
        $kategori_kepemilikan = KategoriKepemilikan::get();
        $kategori_kondisi = KategoriKondisi::get();

        return view('admin.prasarana.prasarana-lain.edit', compact('data_prasarana_lain', 'kategori_kepemilikan', 'kategori_kondisi'));
    }

    public function update(Request $request, PrasaranaLain $prasaranaLain, $id)
    {
        $data_prasarana_lain = PrasaranaLain::findOrfail($id);

        $request->validate([
            'jenis_prasarana' => 'required',
            'jumlah_unit' => 'required | int',
            'total_luas' => 'required | numeric',
            'kepemilikan' => 'required',
            'kondisi' => 'required',
            'unit_pengelola' => 'required'
        ]);

        PrasaranaLain::where('id', $data_prasarana_lain->id)
            ->update([
                'jenis_prasarana' => $request->jenis_prasarana,
                'jumlah_unit' => $request->jumlah_unit,
                'total_luas' => $request->total_luas,
                'kepemilikan' => $request->kepemilikan,
                'kondisi' => $request->kondisi,
                'unit_pengelola' => $request->unit_pengelola
            ]);
        return redirect('/prasarana/prasarana-lain')->with(['edit' => 'Data Prasarana Lain berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('data_prasarana_lain')->where('id', $id)->delete();
        return redirect()->back();
    }
}
