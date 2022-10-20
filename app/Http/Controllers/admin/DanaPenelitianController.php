<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DataPenelitian;
use App\Models\Admin\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class DanaPenelitianController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_penelitian = DB::table('data_penelitian')
            ->join('sumber_dana', 'data_penelitian.sumber_dana_id', '=', 'sumber_dana.id')
            ->select('data_penelitian.*', 'sumber_dana.nama_sumber_dana')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.alokasi-dana.dana-penelitian.dana-penelitian', ['data_penelitian' => $data_penelitian]);
    }

    public function edit(DataPenelitian $dataPenelitian, $id)
    {
        $data_penelitian = DataPenelitian::findOrfail($id);
        $sumber_dana = SumberDana::get();

        return view('admin.alokasi-dana.dana-penelitian.edit', compact('data_penelitian', 'sumber_dana'));
    }

    public function update(Request $request, DataPenelitian $dataPenelitian, $id)
    {
        $data_penelitian = DataPenelitian::findOrfail($id);

        $request->validate([
            'judul_penelitian' => 'required',
            'tahun_penelitian' => 'required',
            'sumber_dana_id' => 'required',
            'jumlah_dana' => 'required | int'
        ]);

        DataPenelitian::where('id', $data_penelitian->id)
            ->update([
                'judul_penelitian' => $request->judul_penelitian,
                'tahun_penelitian' => $request->tahun_penelitian,
                'sumber_dana_id' => $request->sumber_dana_id,
                'jumlah_dana' => $request->jumlah_dana
            ]);

        // return $request;
        return redirect('/alokasi-dana/penelitian')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('data_penelitian')->where('id', $id)->delete();
        return redirect()->back();
    }
}
