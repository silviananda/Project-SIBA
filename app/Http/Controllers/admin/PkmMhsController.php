<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin\DataPkm;
use App\Models\Admin\Dosen;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\SumberDana;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class PkmMhsController extends Controller
{
    public function index()
    {
        $data_pkm = DataPkm::with(['biodata_mhs', 'dosen', 'sumberdana'])->where('jenis_pkm', '=', 2)->where('data_pkm.user_id', Auth::user()->kode_ps)->get();

        return view('admin.PkM.pkm-mhs.pkm', compact('data_pkm'));
    }

    public function create()
    {
        $data_pkm = DataPkm::get();
        $biodata_mhs = Mahasiswa::get();
        $dosen = Dosen::get();
        $sumber_dana = SumberDana::get();

        return view('admin.PkM.pkm-mhs.create', compact('data_pkm', 'biodata_mhs', 'dosen', 'sumber_dana'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'nip' => 'required | int',
            'npm' => 'required | int',
            'tema' => 'required',
            'judul_pkm' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,png,jpg,jpeg,zip|max:20000'
        ]);

        $data_pkm = new DataPkm;
        $data_pkm->user_id = Auth::user()->kode_ps;
        $data_pkm->dosen_id = $data['dosen_id'];
        $data_pkm->tema = $data['tema'];
        $data_pkm->judul_pkm = $data['judul_pkm'];
        $data_pkm->mhs_id = $data['mhs_id'];
        $data_pkm->sumber_dana_id = $data['sumber_dana_id'];
        $data_pkm->jumlah_dana = $data['jumlah_dana'];
        $data_pkm->tahun = $data['tahun'];
        $data_pkm->jenis_pkm = 2;
        $data_pkm->save();

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $data_pkm->softcopy = $nama_file;

            $file->move(public_path() . '/file/', $nama_file);
            $data_pkm->save();
        }
        return redirect('/pkm/mhs')->with(['added' => 'Data PKM berhasil ditambahkan!']);
    }

    public function edit(DataPkm $data_pkm, $id)
    {
        $data_pkm = DataPkm::findOrfail($id);
        $biodata_mhs = Mahasiswa::get();
        $dosen = Dosen::get();
        $sumber_dana = SumberDana::get();

        return view('admin.PkM.pkm-mhs.edit', compact('data_pkm', 'biodata_mhs', 'dosen', 'sumber_dana'));
    }

    public function update(Request $request, DataPkm $data_pkm, $id)
    {
        $data_pkm = DataPkm::findOrfail($id);

        $data = $request->all();

        $request->validate([
            'nip' => 'required | int',
            'npm' => 'required | int',
            'tema' => 'required',
            'judul_pkm' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,png,jpg,jpeg,zip|max:20000'
        ]);

        $data_pkm->user_id = Auth::user()->kode_ps;
        $data_pkm->mhs_id = $data['mhs_id'];
        $data_pkm->dosen_id = $data['dosen_id'];
        $data_pkm->tema = $data['tema'];
        $data_pkm->judul_pkm = $data['judul_pkm'];
        $data_pkm->sumber_dana_id = $data['sumber_dana_id'];
        $data_pkm->jumlah_dana = $data['jumlah_dana'];
        $data_pkm->tahun = $data['tahun'];
        $data_pkm->jenis_pkm = 2;
        $data_pkm->save();

        if ($request->softcopy != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = DataPkm::where('id', $request->id)->first();

            $path = $deletePath->softcopy;

            if ($data_pkm->softcopy != '' & $data_pkm->softcopy != null) {
                unlink(public_path('/file/') . $path);
            }
            $softcopy = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $softcopy->getClientOriginalExtension();
            $softcopy->move($path_baru, $nama_file);

            $data_pkm->update(['softcopy' => $nama_file]);
        }

        return redirect('/pkm/mhs')->with(['edit' => 'Data PKM berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('data_pkm')->where('id', $id)->delete();
        return redirect()->back();
    }
}
