<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\PatenMhs;
use App\Models\Admin\DataPkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class PatenMhsController extends Controller
{
    public function index()
    {
        $paten = DB::table('paten')
            ->join('biodata_mhs', 'paten.mhs_id', '=', 'biodata_mhs.id')
            ->select('paten.*', 'biodata_mhs.npm', 'biodata_mhs.nama')
            ->where('jenis_paten', '=', 2)
            ->where('paten.user_id', Auth::user()->kode_ps)->get();

        // dd($paten);
        return view('admin.luaran.paten-mhs.paten', compact('paten'));
    }


    public function create()
    {
        $paten = PatenMhs::get();
        $biodata_mhs = Mahasiswa::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.paten-mhs.create', compact('paten', 'biodata_mhs', 'data_pkm'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'npm' => 'required | int',
            'pkm_id' => 'required',
            'karya' => 'required',
            'tahun' => 'required'
        ]);

        DB::table('paten')->insert([
            'user_id' => Auth::user()->kode_ps,
            'jenis_paten' => 2,
            'mhs_id' => $request->mhs_id,
            'pkm_id' => $request->pkm_id,
            'karya' => $request->karya,
            'no_hki' => $request->no_hki,
            'tahun' => $request->tahun
        ]);

        return redirect('/luaran/paten-mhs')->with(['added' => 'Data Paten berhasil ditambahkan!']);
    }

    public function edit(PatenMhs $paten, $id)
    {
        $paten = PatenMhs::findOrfail($id);
        $biodata_mhs = Mahasiswa::get();
        $data_pkm = DataPkm::get();

        // dd($paten);
        return view('admin.luaran.paten-mhs.edit', compact('paten', 'biodata_mhs', 'data_pkm'));
    }

    public function update(Request $request, PatenMhs $paten, $id)
    {
        $paten = PatenMhs::findOrfail($id);

        $request->validate([
            'npm' => 'required | int',
            'pkm_id' => 'required',
            'karya' => 'required',
            'tahun' => 'required'
        ]);

        PatenMhs::findOrfail($id)
            ->update([
                'user_id' => Auth::user()->kode_ps,
                'mhs_id' => $request->mhs_id,
                'pkm_id' => $request->pkm_id,
                'karya' => $request->karya,
                'no_hki' => $request->no_hki,
                'tahun' => $request->tahun
            ]);

        // return $request;
        return redirect('/luaran/paten-mhs')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('paten')->where('id', $id)->delete();

        return redirect()->back();
    }
}
