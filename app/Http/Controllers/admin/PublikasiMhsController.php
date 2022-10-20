<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PublikasiMhs;
use App\Models\Admin\DataPkm;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\KategoriTingkat;
use App\Models\Admin\JenisPublikasi;
use Illuminate\Support\Facades\DB;
use Auth;

class PublikasiMhsController extends Controller
{
    public function index()
    {
        $artikel_mhs = DB::table('artikel_mhs')
            ->join('biodata_mhs', 'artikel_mhs.mhs_id', '=', 'biodata_mhs.id')
            ->join('kategori_tingkat', 'artikel_mhs.id_tingkat', '=', 'kategori_tingkat.id')
            ->join('jenis_publikasi', 'artikel_mhs.jenis_publikasi', '=', 'jenis_publikasi.id')
            ->select('artikel_mhs.*', 'biodata_mhs.npm', 'biodata_mhs.nama', 'kategori_tingkat.nama_kategori', 'jenis_publikasi.jenis_publikasi')
            ->where('artikel_mhs.user_id', Auth::user()->kode_ps)->get();

        return view('admin.luaran.publikasi-mhs.publikasi', compact('artikel_mhs', 'biodata_mhs', 'kategori_tingkat', 'jenis_publikasi'));
    }

    public function create()
    {
        $artikel_mhs = PublikasiMhs::get();
        $biodata_mhs = Mahasiswa::get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi = JenisPublikasi::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.publikasi-mhs.create', compact('artikel_mhs', 'biodata_mhs', 'kategori_tingkat', 'jenis_publikasi', 'data_pkm'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'npm' => 'required | int',
            'pkm_id' => 'required',
            'judul' => 'required',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'tahun' => 'required'
        ]);

        DB::table('artikel_mhs')->insert([
            'user_id' => Auth::user()->kode_ps,
            'mhs_id' => $request->mhs_id,
            'pkm_id' => $request->pkm_id,
            'judul' => $request->judul,
            'id_tingkat' => $request->id_tingkat,
            'jumlah' => $request->jumlah,
            'jenis_publikasi' => $request->jenis_publikasi,
            'tahun' => $request->tahun
        ]);

        return redirect('/luaran/publikasi-mhs')->with(['added' => 'Data Karya Ilmiah berhasil ditambahkan!']);
    }

    public function edit(PublikasiMhs $artikel_mhs, $id)
    {
        $artikel_mhs = PublikasiMhs::findOrfail($id);
        $biodata_mhs = Mahasiswa::get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi = JenisPublikasi::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.publikasi-mhs.edit', compact('artikel_mhs', 'biodata_mhs', 'kategori_tingkat', 'jenis_publikasi', 'data_pkm'));
    }

    public function update(Request $request, PublikasiMhs $artikel_mhs, $id)
    {
        $artikel_mhs = PublikasiMhs::findOrfail($id);

        // return $request;
        $request->validate([
            'npm' => 'required | int',
            'pkm_id' => 'required',
            'judul' => 'required',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'tahun' => 'required'
        ]);

        PublikasiMhs::where('id', $artikel_mhs->id)
            ->update([
                'mhs_id' => $request->mhs_id,
                'pkm_id' => $request->pkm_id,
                'judul' => $request->judul,
                'id_tingkat' => $request->id_tingkat,
                'jumlah' => $request->jumlah,
                'jenis_publikasi' => $request->jenis_publikasi,
                'tahun' => $request->tahun
            ]);

        // return $request;

        return redirect('/luaran/publikasi-mhs')->with(['edit' => 'Data Karya Ilmiah berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('artikel_mhs')->where('id', $id)->delete();
        return redirect()->back();
    }
}
