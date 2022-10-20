<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PublikasiMhsTerapan;
use App\Models\Admin\DataPkm;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\KategoriTingkat;
use App\Models\Admin\JenisPublikasiTerapan;
use Illuminate\Support\Facades\DB;
use Auth;

class PublikasiMhsTerapanController extends Controller
{
    public function index()
    {
        $artikel_mhs_terapan = DB::table('artikel_mhs_terapan')
            ->join('biodata_mhs', 'artikel_mhs_terapan.mhs_id', '=', 'biodata_mhs.id')
            ->join('kategori_tingkat', 'artikel_mhs_terapan.id_tingkat', '=', 'kategori_tingkat.id')
            ->join('jenis_publikasi_terapan', 'artikel_mhs_terapan.jenis_publikasi', '=', 'jenis_publikasi_terapan.id')
            ->select('artikel_mhs_terapan.*', 'biodata_mhs.npm', 'biodata_mhs.nama', 'kategori_tingkat.nama_kategori', 'jenis_publikasi_terapan.jenis_publikasi')
            ->where('artikel_mhs_terapan.user_id', Auth::user()->kode_ps)->get();

        return view('admin.luaran.publikasi-mhs-terapan.publikasi', compact('artikel_mhs_terapan', 'biodata_mhs', 'kategori_tingkat', 'jenis_publikasi_terapan'));
    }

    public function create()
    {
        $artikel_mhs_terapan = PublikasiMhsTerapan::get();
        $biodata_mhs = Mahasiswa::get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi_terapan = JenisPublikasiTerapan::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.publikasi-mhs-terapan.create', compact('artikel_mhs_terapan', 'biodata_mhs', 'kategori_tingkat', 'jenis_publikasi_terapan', 'data_pkm'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'npm' => 'required',
            'pkm_id' => 'required',
            'judul' => 'required',
            'jumlah' => 'required | int',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'tahun' => 'required'
        ]);

        DB::table('artikel_mhs_terapan')->insert([
            'user_id' => Auth::user()->kode_ps,
            'mhs_id' => $request->mhs_id,
            'pkm_id' => $request->pkm_id,
            'judul' => $request->judul,
            'id_tingkat' => $request->id_tingkat,
            'jumlah' => $request->jumlah,
            'jenis_publikasi' => $request->jenis_publikasi,
            'tahun' => $request->tahun
        ]);

        return redirect('/luaran/publikasi-mhs-terapan')->with(['added' => 'Data Karya Ilmiah berhasil ditambahkan!']);
    }

    public function edit(PublikasiMhsTerapan $artikel_mhs_terapan, $id)
    {
        $artikel_mhs_terapan = PublikasiMhsTerapan::findOrfail($id);
        $biodata_mhs = Mahasiswa::get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi_terapan = JenisPublikasiTerapan::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.publikasi-mhs.edit', compact('artikel_mhs_terapan', 'biodata_mhs', 'kategori_tingkat', 'jenis_publikasi_terapan', 'data_pkm'));
    }

    public function update(Request $request, PublikasiMhsTerapan $artikel_mhs_terapan, $id)
    {
        $artikel_mhs_terapan = PublikasiMhsTerapan::findOrfail($id);

        // return $request;
        $request->validate([
            'pkm_id' => 'required',
            'judul' => 'required',
            'jumlah' => 'required | int',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'tahun' => 'required'
        ]);

        PublikasiMhsTerapan::where('id', $artikel_mhs_terapan->id)
            ->update([
                'pkm_id' => $request->pkm_id,
                'judul' => $request->judul,
                'id_tingkat' => $request->id_tingkat,
                'jumlah' => $request->jumlah,
                'jenis_publikasi' => $request->jenis_publikasi,
                'tahun' => $request->tahun
            ]);

        return redirect('/luaran/publikasi-mhs-terapan')->with(['edit' => 'Data Karya Ilmiah berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('artikel_mhs_terapan')->where('id', $id)->delete();
        return redirect()->back();
    }
}
