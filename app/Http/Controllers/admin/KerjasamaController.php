<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kerjasama;
use App\Models\Admin\KategoriTingkat;
use App\Models\Admin\KategoriKerjasama;
use App\Models\Admin\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class KerjasamaController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kerjasama = DB::table('kerjasama')
            ->join('kategori_tingkat', 'kerjasama.id_kategori_tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_kerjasama', 'kerjasama.id_kategori_kerjasama', '=', 'kategori_kerjasama.id')
            ->select('kerjasama.*', 'kategori_tingkat.nama_kategori', 'kategori_kerjasama.kategori')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.kerjasama.halaman-kerjasama', ['kerjasama' => $kerjasama]);
    }

    public function create()
    {
        $kategori_tingkat = KategoriTingkat::get();
        $kategori_kerjasama = KategoriKerjasama::get();
        $kerjasama = Kerjasama::get();

        return view('admin.kerjasama.create', compact('kategori_tingkat', 'kerjasama', 'kategori_kerjasama'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required',
            'id_kategori_tingkat' => 'required',
            'judul_kegiatan' => 'required',
            'id_kategori_kerjasama' => 'required',
            'tanggal_kegiatan' => 'required',
            'softcopy' => 'file|mimes:docx,png,jpg,jpeg,pdf|max:10000'
        ]);

        // $request->validate($rules, $messages, $attributes);

        $kerjasama = new Kerjasama;
        $kerjasama->user_id = Auth::user()->kode_ps;
        $kerjasama->nama_instansi = $request->nama_instansi;
        $kerjasama->judul_kegiatan = $request->judul_kegiatan;
        $kerjasama->id_kategori_tingkat = $request->id_kategori_tingkat;
        $kerjasama->id_kategori_kerjasama = $request->id_kategori_kerjasama;
        $kerjasama->manfaat = $request->manfaat;
        $kerjasama->tanggal_kegiatan = $request->tanggal_kegiatan;
        $kerjasama->kepuasan = $request->kepuasan;
        $kerjasama->save();

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $kerjasama->softcopy = $nama_file;

            $file->move(public_path() . '/file', $nama_file);
            $kerjasama->save();
        }

        return redirect('/kerjasama')->with(['added' => 'Data Kerjasama Berhasil Ditambahkan']);
    }

    public function show(Kerjasama $kerjasama)
    {
        return view('admin.kerjasama.show', compact('kerjasama'));
    }

    public function edit(Request $request, Kerjasama $kerjasama, $id)
    {
        $kerjasama = Kerjasama::findOrFail($id);
        $kategori_tingkat = KategoriTingkat::get();
        $kategori_kerjasama = KategoriKerjasama::get();

        return view('admin.kerjasama.edit', compact('kategori_tingkat', 'kerjasama', 'kategori_kerjasama'));
    }

    public function update(Request $request, Kerjasama $kerjasama, $id)
    {
        $request->validate([
            'nama_instansi' => 'required',
            'id_kategori_tingkat' => 'required',
            'judul_kegiatan' => 'required',
            'id_kategori_kerjasama' => 'required',
            'tanggal_kegiatan' => 'required',
            'softcopy' => 'file|mimes:docx,png,jpg,jpeg,pdf|max:10000'
        ]);

        $kerjasama = Kerjasama::find($id);

        $kerjasama->nama_instansi = $request->input('nama_instansi');
        $kerjasama->judul_kegiatan = $request->input('judul_kegiatan');
        $kerjasama->id_kategori_tingkat = $request->input('id_kategori_tingkat');
        $kerjasama->id_kategori_kerjasama = $request->input('id_kategori_kerjasama');
        $kerjasama->manfaat = $request->input('manfaat');
        $kerjasama->tanggal_kegiatan = $request->input('tanggal_kegiatan');
        $kerjasama->kepuasan = $request->input('kepuasan');
        $kerjasama->update();

        if ($request->softcopy != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = Kerjasama::where('id', $request->id)->first();

            $path = $deletePath->softcopy;

            if ($kerjasama->softcopy != '' & $kerjasama->softcopy != null) {
                unlink(public_path('/file/') . $path);
            }

            $softcopy = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $softcopy->getClientOriginalExtension();
            $softcopy->move($path_baru, $nama_file);

            $kerjasama->update(['softcopy' => $nama_file]);
        }

        return redirect('/kerjasama')->with(['edit' => 'Data Kerjasama berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('kerjasama')->where('id', $id)->delete();
        return redirect()->back();
    }
}
