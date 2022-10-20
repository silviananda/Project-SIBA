<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DataPenelitian;
use App\Models\Admin\PenelitianMhsS2;
use App\Models\Admin\SumberDana;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Illuminate\Validation\Rules\NotIn;
use Validator;
use App\Notifications\Deadline;
use Carbon\Carbon;

class PenelitianMhsS2Controller extends Controller
{
    public function index()
    {
        $data_penelitian = DataPenelitian::with(['penelitianmagister', 'dosen', 'penelitianmagister.biodata_mhs', 'sumberdana'])
            ->where('jenis_penelitian', '=', 2)
            ->where('user_id', Auth::user()->kode_ps)->get();

        // dd($data_penelitian);
        return view('admin.penelitian-mhs.halaman-penelitian-mhsS2', compact('data_penelitian', 'dosen', 'biodata_mhs'));
    }

    public function create()
    {
        $data_penelitian = DataPenelitian::get();
        $data_penelitian_mhs_s2 = PenelitianMhsS2::get();
        $dosen = Dosen::get();
        $biodata_mhs = Mahasiswa::get();
        $sumber_dana = SumberDana::get();

        return view('admin.penelitian-mhs.create', compact('data_penelitian', 'dosen', 'data_penelitian_mhs_s2', 'sumber_dana', 'biodata_mhs'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'nip' => 'required | int',
            'npm' => 'required | int',
            'tema' => 'required',
            'judul_penelitian' => 'required',
            'tahun_penelitian' => 'required'
        ]);

        $data_penelitian = new DataPenelitian();
        $data_penelitian->user_id = \Auth::user()->kode_ps;
        $data_penelitian->dosen_id = $data['dosen_id'];
        $data_penelitian->tema = $data['tema'];
        $data_penelitian->sumber_dana_id = $data['sumber_dana_id'];
        $data_penelitian->judul_penelitian = $data['judul_penelitian'];
        $data_penelitian->tahun_penelitian = $data['tahun_penelitian'];
        $data_penelitian->jenis_penelitian = 2;
        $data_penelitian->save();
        foreach ($data['mhs_id'] as $item => $value) {
            $data_penelitian_mhs_s2 = new PenelitianMhsS2();
            $data_penelitian_mhs_s2->data_penelitian_id = $data_penelitian->id;
            $data_penelitian_mhs_s2->mhs_id = $value;
            $data_penelitian_mhs_s2->save();
        }

        return redirect('/penelitian/mahasiswa')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Request $request, $id)
    {
        $data_penelitian = DataPenelitian::findOrfail($id);
        $data_penelitian_mhs_s2 = PenelitianMhsS2::get();
        $dosen = Dosen::get();
        $biodata_mhs = Mahasiswa::get();
        $sumber_dana = SumberDana::get();

        return view('admin.penelitian-mhs.edit', compact('data_penelitian', 'dosen', 'data_penelitian_mhs_s2', 'sumber_dana', 'biodata_mhs'));
    }

    public function update(Request $request, $id)
    {
        $data_penelitian = DataPenelitian::findOrfail($id);

        $request->validate([
            'nip' => 'required | int',
            'npm' => 'required | int',
            'tema' => 'required',
            'judul_penelitian' => 'required',
            'tahun_penelitian' => 'required'
        ]);

        $data = $request->all();
        $list_mhs_id = $data['mhs_id'];

        // dd($data);
        DB::table('data_penelitian_mhs_s2')->where('data_penelitian_id', '=', $data_penelitian['id'])->whereNotIn('mhs_id', $list_mhs_id)->delete();

        $data_penelitian->user_id = \Auth::user()->kode_ps;
        $data_penelitian->dosen_id = $data['dosen_id'];
        $data_penelitian->tema = $data['tema'];
        $data_penelitian->sumber_dana_id = $data['sumber_dana_id'];
        $data_penelitian->judul_penelitian = $data['judul_penelitian'];
        $data_penelitian->tahun_penelitian = $data['tahun_penelitian'];
        $data_penelitian->jenis_penelitian = 2;
        $data_penelitian->save();
        foreach ($data['mhs_id'] as $item => $value) {
            $data_penelitian_mhs_s2 = PenelitianMhsS2::firstOrNew(['data_penelitian_id' =>  $data_penelitian->id, 'mhs_id' => $value]);
            $data_penelitian_mhs_s2->data_penelitian_id = $data_penelitian->id;
            $data_penelitian_mhs_s2->mhs_id = $value;
            $data_penelitian_mhs_s2->save();
        }

        // return $request;
        return redirect('/penelitian/mahasiswa')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('data_penelitian')->where('id', $id)->delete();
        return redirect()->back();
    }
}
