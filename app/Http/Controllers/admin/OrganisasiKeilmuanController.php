<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\OrganisasiKeilmuan;
use App\Models\Admin\Dosen;
use App\Models\Admin\KategoriTingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;

class OrganisasiKeilmuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $organisasi = DB::table('organisasi')
            ->join('dosen', 'organisasi.dosen_id', '=', 'dosen.dosen_id')
            ->join('kategori_tingkat', 'organisasi.tingkat', '=', 'kategori_tingkat.id')
            ->select('organisasi.*', 'kategori_tingkat.nama_kategori', 'dosen.nip', 'dosen.nama_dosen')
            ->where('organisasi.user_id', Auth::user()->kode_ps)->get();

        return view('admin.upaya.organisasi.organisasi', compact('organisasi'));
    }

    public function create()
    {
        $organisasi = OrganisasiKeilmuan::get();
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();
        return view('admin.upaya.organisasi.create', compact('organisasi', 'dosen', 'kategori_tingkat'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'nip' => 'required | int',
            'nama_organisasi' => 'required',
            'mulai' => 'required',
            'tingkat' => 'required'
        ]);

        DB::table('organisasi')->insert([
            'user_id' => Auth::user()->kode_ps,
            'dosen_id' => $request->dosen_id,
            'nama_organisasi' => $request->nama_organisasi,
            'mulai' => $request->mulai,
            'tingkat' => $request->tingkat
        ]);

        return redirect('/upaya/organisasi')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(OrganisasiKeilmuan $organisasiKeilmuan, $id)
    {
        $organisasi = OrganisasiKeilmuan::findOrfail($id);
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();

        return view('admin.upaya.organisasi.edit', compact('organisasi', 'dosen', 'kategori_tingkat'));
    }

    public function update(Request $request, OrganisasiKeilmuan $organisasiKeilmuan, $id)
    {
        $organisasi = OrganisasiKeilmuan::findOrfail($id);

        // return $request;
        $request->validate([
            'nip' => 'required | int',
            'nama_organisasi' => 'required',
            'mulai' => 'required',
            'tingkat' => 'required'
        ]);

        OrganisasiKeilmuan::findOrfail($id)
            ->update([
                'user_id' => Auth::user()->kode_ps,
                'dosen_id' => $request->dosen_id,
                'nama_organisasi' => $request->nama_organisasi,
                'mulai' => $request->mulai,
                'tingkat' => $request->tingkat
            ]);

        return redirect('/upaya/organisasi')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('organisasi')->where('id', $id)->delete();
        return redirect()->back();
    }
}
