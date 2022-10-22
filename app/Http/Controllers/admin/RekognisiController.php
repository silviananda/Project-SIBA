<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dosen;
use App\Models\Admin\Rekognisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;

class RekognisiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function upaya()
    {
        return view('admin.upaya.halaman-upaya');
    }

    public function index()
    {
        $rekognisi = DB::table('rekognisi')
            ->join('dosen', 'rekognisi.dosen_id', '=', 'dosen.dosen_id')
            ->select('rekognisi.*', 'dosen.nama_dosen')
            ->where('rekognisi.user_id', Auth::user()->kode_ps)->get();

        return view('admin.upaya.rekognisi.rekognisi', compact('rekognisi', 'dosen'));
    }

    public function create()
    {
        $rekognisi = Rekognisi::get();
        $dosen = Dosen::get();
        return view('admin.upaya.rekognisi.create', compact('rekognisi', 'dosen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required | int',
            'bidang_keahlian' => 'required',
            'rekognisi' => 'required',
            'tahun' => 'required'
        ]);

        // return $request;

        DB::table('rekognisi')->insert([
            'user_id' => Auth::user()->kode_ps,
            'dosen_id' => $request->dosen_id,
            'bidang_keahlian' => $request->bidang_keahlian,
            'rekognisi' => $request->rekognisi,
            'tahun' => $request->tahun
        ]);

        return redirect('/upaya/rekognisi')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Rekognisi $rekognisi, $id)
    {
        $rekognisi = Rekognisi::findOrfail($id);
        $dosen = Dosen::get();

        return view('admin.upaya.rekognisi.edit', compact('rekognisi', 'dosen'));
    }

    public function update(Request $request, Rekognisi $rekognisi, $id)
    {
        $rekognisi = Rekognisi::findOrfail($id);

        $request->validate([
            'nip' => 'required | int',
            'bidang_keahlian' => 'required',
            'rekognisi' => 'required',
            'tahun' => 'required'
        ]);

        Rekognisi::findOrfail($id)
            ->update([
                'dosen_id' => $request->dosen_id,
                'bidang_keahlian' => $request->bidang_keahlian,
                'rekognisi' => $request->rekognisi,
                'tahun' => $request->tahun
            ]);

        return redirect('/upaya/rekognisi')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('rekognisi')->where('id', $id)->delete();
        return redirect()->back();
    }
}
