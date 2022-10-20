<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProdukMhs;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\DataPkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ProdukMhsController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $produk = DB::table('produk')
            ->join('biodata_mhs', 'produk.mhs_id', '=', 'biodata_mhs.id')
            ->select('produk.*', 'biodata_mhs.npm', 'biodata_mhs.nama')
            ->where('jenis_produk', '=', 2)
            ->where('produk.user_id', Auth::user()->kode_ps)->get();

        return view('admin.luaran.produk-mhs.produk', compact('produk'));
    }

    public function create()
    {
        $produk = ProdukMhs::get();
        $data_pkm = DataPkm::get();
        return view('admin.luaran.produk-mhs.create', compact('produk', 'data_pkm'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'npm' => 'required',
            'pkm_id' => 'required',
            'nama_produk' => 'required'
        ]);

        DB::table('produk')->insert([
            'user_id' => Auth::user()->kode_ps,
            'mhs_id' => $request->mhs_id,
            'pkm_id' => $request->pkm_id,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'kesiapan' => $request->kesiapan,
            'jenis_produk' => 2
        ]);

        return redirect('/luaran/produk-mhs')->with(['added' => 'Data Produk/Jasa berhasil ditambahkan!']);
    }

    public function edit(ProdukMhs $produk, $id)
    {
        $produk = ProdukMhs::findOrfail($id);
        $data_pkm = DataPkm::get();

        return view('admin.luaran.produk-mhs.edit', compact('produk', 'data_pkm'));
    }

    public function update(Request $request, ProdukMhs $produk, $id)
    {
        $produk = ProdukMhs::findOrfail($id);

        // return $request;
        $request->validate([
            'npm' => 'required',
            'pkm_id' => 'required',
            'nama_produk' => 'required'
        ]);

        ProdukMhs::where('id', $produk->id)
            ->update([
                'mhs_id' => $request->mhs_id,
                'pkm_id' => $request->pkm_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'kesiapan' => $request->kesiapan
            ]);

        // return $request;

        return redirect('/luaran/produk-mhs')->with(['edit' => 'Data Produk/Jasa berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('produk')->where('id', $id)->delete();
        return redirect()->back();
    }
}
