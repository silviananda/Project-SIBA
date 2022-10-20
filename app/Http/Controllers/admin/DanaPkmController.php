<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DanaPkm;
use App\Models\Admin\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class DanaPkmController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_pkm = DB::table('data_pkm')
            ->join('sumber_dana', 'data_pkm.sumber_dana_id', '=', 'sumber_dana.id')
            ->select('data_pkm.*', 'sumber_dana.nama_sumber_dana')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.alokasi-dana.dana-pkm.dana-pkm', ['data_pkm' => $data_pkm]);
    }

    public function edit(DanaPkm $danaPkm, $id)
    {
        $data_pkm = DanaPkm::findOrfail($id);
        $sumber_dana = SumberDana::get();

        return view('admin.alokasi-dana.dana-pkm.edit', compact('data_pkm', 'sumber_dana'));
    }

    public function update(Request $request, DanaPkm $danaPkm, $id)
    {
        // return $request;
        $data_pkm = DanaPkm::findOrfail($id);

        $request->validate([
            'judul_pkm' => 'required',
            'tahun' => 'required',
            'sumber_dana_id' => 'required',
            'jumlah_dana' => 'required | int'
        ]);

        DanaPkm::where('id', $data_pkm->id)
            ->update([
                'judul_pkm' => $request->judul_pkm,
                'tahun' => $request->tahun,
                'sumber_dana_id' => $request->sumber_dana_id,
                'jumlah_dana' => $request->jumlah_dana
            ]);

        return redirect('/alokasi-dana/pkm')->with(['edit' => 'Data Dana PkM berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('data_pkm')->where('id', $id)->delete();
        return redirect()->back();
    }
}
