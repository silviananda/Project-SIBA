<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\Dosen;
use App\Models\Admin\PembimbingTa;
use App\Models\Admin\KategoriPembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class PembimbingTaController extends Controller
{
    public function index()
    {
        $data_pembimbing_ta = PembimbingTa::with(['dosen', 'biodata_mhs'])->where('doping1', Auth::guard('dosen')->user()->dosen_id)->orWhere('doping2', Auth::guard('dosen')->user()->dosen_id)->get();

        return view('dosen.bimbingan.tugas-akhir.tugas-akhir', compact('data_pembimbing_ta', 'kategori_pembimbing'));
    }

    public function create()
    {
        $data_pembimbing_ta = PembimbingTa::get();
        $dosen = Dosen::get();
        $biodata_mhs = Mahasiswa::get();
        $kategori_pembimbing = KategoriPembimbing::get();
        $jenis_bimbingan = DB::table('jenis_bimbingan')->get();

        return view('dosen.bimbingan.tugas-akhir.create', compact('data_pembimbing_ta', 'dosen', 'biodata_mhs', 'kategori_pembimbing', 'jenis_bimbingan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required',
            'tahun' => 'required',
            'kategori_id' => 'required',
            'npm' => 'required'
        ]);

        if ($request->kategori_id == 1) {
            DB::table('data_pembimbing_ta')->insert([
                'doping1' => \Auth::guard('dosen')->user()->dosen_id,
                'user_id' => \Auth::guard('dosen')->user()->user_id,
                'mhs_id' => $request->mhs_id,
                'jenis_id1' => $request->jenis_id,
                'tahun' => $request->tahun
            ]);
        } else {
            DB::table('data_pembimbing_ta')->insert([
                'doping2' => \Auth::guard('dosen')->user()->dosen_id,
                'user_id' => \Auth::guard('dosen')->user()->user_id,
                'mhs_id' => $request->mhs_id,
                'jenis_id2' => $request->jenis_id,
                'tahun' => $request->tahun
            ]);
        }

        // return $request;
        return redirect('/bimbingan/tugas-akhir')->with(['added' => 'Data Pembimbing Tugas Akhir berhasil ditambahkan!']);
    }

    public function edit($id)
    {
        $data_pembimbing_ta = PembimbingTa::findOrFail($id);
        $dosen = Dosen::get();
        $biodata_mhs = Mahasiswa::get();
        $kategori_pembimbing = KategoriPembimbing::get();
        $jenis_bimbingan = DB::table('jenis_bimbingan')->get();

        return view('dosen.bimbingan.tugas-akhir.edit', compact('data_pembimbing_ta', 'dosen', 'biodata_mhs', 'kategori_pembimbing', 'jenis_bimbingan'));
    }

    public function update(Request $request, PembimbingTa $data_pembimbing_ta, $id)
    {
        // dd($request);
        if ($request->kategori_id == 1) {
            PembimbingTa::findOrFail($id)
                ->update([
                    'doping1' => \Auth::guard('dosen')->user()->dosen_id,
                    'mhs_id' => $request->mhs_id,
                    'jenis_id1' => $request->jenis_id,
                    'tahun' => $request->tahun
                ]);
        } else {
            PembimbingTa::findOrFail($id)
                ->update([
                    'doping2' => \Auth::guard('dosen')->user()->dosen_id,
                    'mhs_id' => $request->mhs_id,
                    'jenis_id2' => $request->jenis_id,
                    'tahun' => $request->tahun
                ]);
        }

        return redirect('/bimbingan/tugas-akhir')->with(['edit' => 'Data Berhasil Diubah']);
    }

    //data yang akan di hapus berdasarkan id dari mahasiswa (mhs_id)
    public function destroy($id)
    {
        DB::table('data_pembimbing_ta')->where('id', $id)->delete();
        return redirect()->back();
    }
}
