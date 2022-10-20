<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dosen;
use App\Models\Admin\Paten;
use App\Models\Admin\DataPkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Notifications\VerifikasiDosen;
use App\Notifications\Deadline;
use Carbon\Carbon;

class PatenController extends Controller
{
    public function index()
    {
        $paten = DB::table('paten')
            ->join('dosen', 'paten.dosen_id', '=', 'dosen.dosen_id')
            ->select('paten.*', 'dosen.nip', 'dosen.nama_dosen')
            ->where('paten.user_id', Auth::user()->kode_ps)->get();

        return view('admin.luaran.paten.paten', compact('paten'));
    }

    public function create()
    {
        $paten = Paten::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.paten.create', compact('paten', 'data_pkm'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'nip' => 'required | int',
            'pkm_id' => 'required',
            'karya' => 'required',
            'tahun' => 'required',
            'deadline' => 'required'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        DB::table('paten')->insert([
            'user_id' => Auth::user()->kode_ps,
            'dosen_id' => $request->dosen_id,
            'pkm_id' => $request->pkm_id,
            'karya' => $request->karya,
            'no_hki' => $request->no_hki,
            'tahun' => $request->tahun,
            'tanggal_create' => $date1,
            'deadline' => $request->deadline
        ]);

        try {
            // Get admin prodi pada dosen
            $dosen = Dosen::find($request->dosen_id);

            $dosen->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->name,
                'pesan' => 'Telah mengirim data produk untuk di verifikasi',
                'url' => route('publikasi.produk.index'),
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/luaran/paten')->with(['added' => 'Data Paetn berhasil ditambahkan!']);
    }

    public function edit(Paten $paten, $id)
    {
        $paten = Paten::findOrfail($id);
        $dosen = Dosen::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.paten.edit', compact('paten', 'dosen', 'data_pkm'));
    }

    public function update(Request $request, Paten $paten, $id)
    {
        $paten = Paten::findOrfail($id);

        $request->validate([
            'nip' => 'required | int',
            'pkm_id' => 'required',
            'karya' => 'required',
            'tahun' => 'required'
        ]);

        Paten::findOrfail($id)
            ->update([
                'user_id' => Auth::user()->kode_ps,
                'pkm_id' => $request->pkm_id,
                'dosen_id' => $request->dosen_id,
                'karya' => $request->karya,
                'no_hki' => $request->no_hki,
                'tahun' => $request->tahun
            ]);

        // return $request;
        return redirect('/luaran/paten')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('paten')->where('id', $id)->delete();

        return redirect()->back();
    }
}
