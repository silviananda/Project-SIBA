<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PrestasiMhs;
use App\Models\Admin\KategoriTingkat;
use App\Models\Admin\KategoriPrestasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Validated;
use Auth;

class PrestasiMhsController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $prestasi_mhs = DB::table('prestasi_mhs')
            ->join('kategori_tingkat', 'prestasi_mhs.tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_jenis_prestasi', 'prestasi_mhs.jenis_prestasi', '=', 'kategori_jenis_prestasi.id')
            ->select('prestasi_mhs.*', 'kategori_tingkat.nama_kategori', 'kategori_jenis_prestasi.jenis')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.prestasi-mhs.halaman-prestasi-mhs', compact('prestasi_mhs', 'kategori_jenis_prestasi'));
    }

    public function create()
    {
        $kategori_tingkat = KategoriTingkat::get();
        $kategori_jenis_prestasi = KategoriPrestasi::get();
        $kategori_data = DB::table('kategori_data')->get();

        return view('admin.prestasi-mhs.create', compact('kategori_tingkat', 'kategori_jenis_prestasi', 'kategori_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tahun' => 'required',
            'tingkat' => 'required',
            'prestasi' => 'required',
            'jenis_prestasi' => 'required',
            'kategori_id' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,jpeg,jpg,png|max:10000'
        ]);

        $prestasi_mhs = new PrestasiMhs;
        $prestasi_mhs->user_id = Auth::user()->kode_ps;
        $prestasi_mhs->nama_kegiatan = $request->nama_kegiatan;
        $prestasi_mhs->tingkat = $request->tingkat;
        $prestasi_mhs->tahun = $request->tahun;
        $prestasi_mhs->prestasi = $request->prestasi;
        $prestasi_mhs->jenis_prestasi = $request->jenis_prestasi;
        $prestasi_mhs->kategori_id = $request->kategori_id;
        $prestasi_mhs->save();

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $prestasi_mhs->softcopy = $nama_file;

            $file->move(public_path() . '/file', $nama_file);
            $prestasi_mhs->save();
        }

        return redirect('/mahasiswa/prestasi')->with(['added' => 'Data Prestasi Mahasiswa berhasil ditambahkan!']);
    }

    public function edit(PrestasiMhs $prestasi_mhs, $id)
    {
        $prestasi_mhs = PrestasiMhs::findOrfail($id);
        $kategori_tingkat = KategoriTingkat::get();
        $kategori_jenis_prestasi = KategoriPrestasi::get();
        $kategori_data = DB::table('kategori_data')->get();

        return view('admin.prestasi-mhs.edit', compact('prestasi_mhs', 'kategori_tingkat', 'kategori_jenis_prestasi', 'kategori_data'));
    }

    public function update(Request $request, PrestasiMhs $prestasi_mhs, $id)
    {
        $prestasi_mhs = PrestasiMhs::findOrfail($id);

        $request->validate([
            'nama_kegiatan' => 'required',
            'tahun' => 'required',
            'tingkat' => 'required',
            'prestasi' => 'required',
            'jenis_prestasi' => 'required',
            'kategori_id' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,jpeg,jpg,png|max:10000'
        ]);

        $prestasi_mhs->nama_kegiatan = $request->input('nama_kegiatan');
        $prestasi_mhs->tingkat = $request->input('tingkat');
        $prestasi_mhs->tahun = $request->input('tahun');
        $prestasi_mhs->prestasi = $request->input('prestasi');
        $prestasi_mhs->jenis_prestasi = $request->input('jenis_prestasi');
        $prestasi_mhs->kategori_id = $request->input('kategori_id');
        $prestasi_mhs->update();

        if ($request->softcopy != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = PrestasiMhs::where('id', $request->id)->first();

            $path = $deletePath->softcopy;

            if ($prestasi_mhs->softcopy != '' & $prestasi_mhs->softcopy != null) {
                unlink(public_path('/file/') . $path);
            }

            $softcopy = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $softcopy->getClientOriginalExtension();
            $softcopy->move($path_baru, $nama_file);

            $prestasi_mhs->update(['softcopy' => $nama_file]);
        }

        return redirect('/mahasiswa/prestasi')->with(['edit' => 'Data Prestasi Mahasiswa berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('prestasi_mhs')->where('id', $id)->delete();
        return redirect()->back();
    }
}
