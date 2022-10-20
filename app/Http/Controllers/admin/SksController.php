<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Sks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class SksController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function kurikulum()
    {
        return view('admin.kurikulum.halaman-kurikulum');
    }

    public function index()
    {
        $kurikulum = DB::table('kurikulum')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.kurikulum.jumlah-sks.sks', ['kurikulum' => $kurikulum]);
    }

    public function create()
    {
        return view('admin.kurikulum.jumlah-sks.create', compact('kurikulum'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mk' => 'required',
            'bobot_sks' => 'required | int'
        ]);

        DB::table('kurikulum')->insert([
            'user_id' => Auth::user()->kode_ps,
            'nama_mk' => $request->nama_mk,
            'bobot_sks' => $request->bobot_sks,
            'sks_praktikum' => $request->sks_praktikum,
            'sks_seminar' => $request->sks_seminar,
        ]);

        return redirect('/kurikulum/jumlah-sks')->with(['added' => 'Data Jumlah Sks Berhasil di tambahkan!']);
    }

    public function edit(Sks $kurikulum, $id)
    {
        $kurikulum = Sks::findOrfail($id);

        return view('admin.kurikulum.jumlah-sks.edit', compact('kurikulum'));
    }

    public function update(Request $request, Sks $kurikulum, $id)
    {
        // return $request;
        $kurikulum = Sks::findOrfail($id);

        $request->validate([
            'nama_mk' => 'required',
            'bobot_sks' => 'required | int'
        ]);

        Sks::where('id', $kurikulum->id)
            ->update([
                'nama_mk' => $request->nama_mk,
                'bobot_sks' => $request->bobot_sks,
                'sks_praktikum' => $request->sks_praktikum,
                'sks_seminar' => $request->sks_seminar,
            ]);

        return redirect('/kurikulum/jumlah-sks')->with(['edit' => 'Data Sks berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('kurikulum')->where('id', $id)->delete();
        return redirect()->back();
    }
}
