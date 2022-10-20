<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\JenisProduk;
use App\Models\Admin\Lainnya;
use App\Models\Admin\DataPkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class LainnyaController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $produk_lain = DB::table('produk_lain')
            ->join('jenis_produk', 'produk_lain.jenis', '=', 'jenis_produk.id')
            ->select('produk_lain.*', 'jenis_produk.jenis')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.luaran.lainnya.lainnya', compact('produk_lain'));
    }

    public function create()
    {
        $jenis_produk = JenisProduk::get();
        $produk_lain = Lainnya::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.lainnya.create', compact('produk_lain', 'jenis_produk', 'data_pkm'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'pkm_id' => 'required',
            'nama' => 'required',
            'jenis' => 'required',
            'tahun' => 'required',
            'jenis_data' => 'required'
        ]);

        DB::table('produk_lain')->insert([
            'user_id' => Auth::user()->kode_ps,
            'pkm_id' => $request->pkm_id,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'tahun' => $request->tahun,
            'link' => $request->link,
            'jenis_data' => $request->jenis_data
        ]);

        return redirect('/luaran/lainnya')->with(['added' => 'Data Luaran Lainnya berhasil ditambahkan!']);
    }

    public function edit(Lainnya $data_pkm, $id)
    {
        $produk_lain = Lainnya::findOrfail($id);
        $jenis_produk = JenisProduk::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.lainnya.edit', compact('produk_lain', 'jenis_produk', 'data_pkm'));
    }

    public function update(Request $request, Lainnya $produk_lain, $id)
    {
        $produk_lain = Lainnya::findOrfail($id);

        // return $request;
        $request->validate([
            'pkm_id' => 'required',
            'nama' => 'required',
            'jenis' => 'required',
            'tahun' => 'required',
            'jenis_data' => 'required'
        ]);

        Lainnya::where('id', $produk_lain->id)
            ->update([
                'user_id' => Auth::user()->kode_ps,
                'pkm_id' => $request->pkm_id,
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'keterangan' => $request->keterangan,
                'tahun' => $request->tahun,
                'link' => $request->link,
                'jenis_data' => $request->jenis_data
            ]);

        return redirect('/luaran/lainnya')->with(['edit' => 'Data Luaran Lainnya berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('produk_lain')->where('id', $id)->delete();
        return redirect()->back();
    }
}
