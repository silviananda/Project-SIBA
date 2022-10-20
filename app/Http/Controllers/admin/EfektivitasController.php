<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Alumni;
use Illuminate\Http\Request;
use App\Models\Admin\MhsReguler;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;

class EfektivitasController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $efektivitas = DB::table('alumni')
            ->orderBy('tahun_masuk', 'asc')
            ->where('user_id', Auth::user()->kode_ps)->get();

        // dd($efektivitas);
        return view('admin.efektivitas.pendidikan.efektivitas', compact('efektivitas'));
    }

    public function edit(Alumni $alumni, $id)
    {
        $efektivitas = Alumni::findOrfail($id);
        // $biodata_mhs = MhsReguler::get();

        return view('admin.efektivitas.pendidikan.edit', compact('efektivitas'));
    }

    public function update(Request $request, Alumni $alumni, $id)
    {
        $efektivitas = Alumni::findOrfail($id);

        $request->validate([
            'tahun_masuk' => 'required',
            'tahun_lulus' => 'required'
        ]);

        Alumni::findOrfail($id)
            ->update([
                'npm' => $request->npm,
                'nama' => $request->nama,
                'tahun_masuk' => $request->tahun_masuk,
                'tahun_lulus' => $request->tahun_lulus
            ]);

        // return $request;
        return redirect('/efektivitas/pendidikan')->with(['edit' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id)
    {
        DB::table('alumni')->where('id', $id)->delete();
        return redirect()->back();
    }
}
