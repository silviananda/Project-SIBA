<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PenggunaanDana;
use App\Models\Admin\KategoriPengelola;
use App\Models\Admin\JenisPenggunaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PenggunaanDanaController extends Controller
{
    public function index()
    {
        $penggunaan_dana = DB::table('penggunaan_dana')
            ->join('jenis_penggunaan', 'penggunaan_dana.jenis_penggunaan_id', '=', 'jenis_penggunaan.id')
            ->join('kategori_pengelola', 'penggunaan_dana.kategori_pengelola_id', '=', 'kategori_pengelola.id')
            ->select('penggunaan_dana.*', 'jenis_penggunaan.nama_jenis_penggunaan', 'kategori_pengelola.pengelola')
            ->where('penggunaan_dana.user_id', Auth::user()->kode_ps)->get();

        return view('admin.alokasi-dana.penggunaan.penggunaan', ['penggunaan_dana' => $penggunaan_dana]);
    }

    public function create()
    {
        $penggunaan_dana = PenggunaanDana::get();
        $kategori_pengelola = KategoriPengelola::get();
        $jenis_penggunaan = JenisPenggunaan::get();

        return view('admin.alokasi-dana.penggunaan.create', compact('penggunaan_dana', 'kategori_pengelola', 'jenis_penggunaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_penggunaan_id' => 'required',
            'kategori_pengelola_id' => 'required',
            'dana' => 'required | int',
            'tahun' => 'required'
        ]);

        DB::table('penggunaan_dana')->insert([
            'user_id' => Auth::user()->kode_ps,
            'jenis_penggunaan_id' => $request->jenis_penggunaan_id,
            'kategori_pengelola_id' => $request->kategori_pengelola_id,
            'dana' => $request->dana,
            'tahun' => $request->tahun
        ]);

        return redirect('/alokasi-dana/penggunaan')->with('added', 'Data Berhasil Ditambahkan');
    }

    public function edit(PenggunaanDana $penggunaanDana, $id)
    {
        $penggunaan_dana = PenggunaanDana::findOrfail($id);
        $kategori_pengelola = KategoriPengelola::get();
        $jenis_penggunaan = JenisPenggunaan::get();

        return view('admin.alokasi-dana.penggunaan.edit', compact('penggunaan_dana', 'kategori_pengelola', 'jenis_penggunaan'));
    }

    public function update(Request $request, PenggunaanDana $penggunaanDana, $id)
    {
        $penggunaan_dana = PenggunaanDana::findOrfail($id);

        $request->validate([
            'jenis_penggunaan_id' => 'required',
            'kategori_pengelola_id' => 'required',
            'dana' => 'required | int',
            'tahun' => 'required'
        ]);

        PenggunaanDana::where('id', $penggunaan_dana->id)
            ->update([
                'jenis_penggunaan_id' => $request->jenis_penggunaan_id,
                'kategori_pengelola_id' => $request->kategori_pengelola_id,
                'dana' => $request->dana,
                'tahun' => $request->tahun
            ]);

        return redirect('/alokasi-dana/penggunaan')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('penggunaan_dana')->where('id', $id)->delete();
        return redirect()->back();
    }
}
