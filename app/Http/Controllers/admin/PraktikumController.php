<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Praktikum;
use App\Models\Admin\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PraktikumController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $praktikum = DB::table('praktikum')
            ->join('kurikulum', 'praktikum.kode_mk', '=', 'kurikulum.kode_mk')
            ->select('praktikum.*', 'kurikulum.nama_mk')
            ->where('praktikum.user_id', Auth::user()->kode_ps)->get();

        return view('admin.kurikulum.praktikum.praktikum', compact('praktikum'));
    }

    public function create()
    {
        $kurikulum = Kurikulum::get();

        return view('admin.kurikulum.praktikum.create', compact('kurikulum'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'kode_mk' => 'required',
            'judul' => 'required'
        ]);

        DB::table('praktikum')->insert([
            'user_id' => Auth::user()->kode_ps,
            'kode_mk' => $request->kode_mk,
            'judul' => $request->judul,
            'jam' => $request->jam,
            'tempat' => $request->tempat
        ]);

        return redirect('/kurikulum/praktikum')->with(['added' => 'Data Praktikum berhasil di tambahkan!']);
    }

    public function edit(Praktikum $praktikum, $id)
    {
        $praktikum = Praktikum::findOrfail($id);
        $kurikulum = Kurikulum::get();

        return view('admin.kurikulum.praktikum.edit', compact('praktikum', 'kurikulum'));
    }

    public function update(Request $request, Praktikum $praktikum, $id)
    {
        $praktikum = Praktikum::findOrfail($id);

        $request->validate([
            'kode_mk' => 'required',
            'judul' => 'required'
        ]);

        Praktikum::where('id', $praktikum->id)
            ->update([
                'kode_mk' => $request->kode_mk,
                'judul' => $request->judul,
                'jam' => $request->jam,
                'tempat' => $request->tempat
            ]);
        return redirect('/kurikulum/praktikum')->with(['edit' => 'Data Praktikum berhasil diubah']);
    }

    public function destroy($id)
    {
        DB::table('praktikum')->where('id', $id)->delete();
        return redirect()->back();
    }
}
