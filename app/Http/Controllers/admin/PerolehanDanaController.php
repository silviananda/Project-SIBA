<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PerolehanDana;
use App\Models\Admin\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PerolehanDanaController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function alokasi()
    {
        return view('admin.alokasi-dana.halaman-dana');
    }

    public function index()
    {
        $jenis_dana = DB::table('jenis_dana')
            ->join('sumber_dana', 'jenis_dana.sumber_dana_id', '=', 'sumber_dana.id')
            ->select('jenis_dana.*', 'sumber_dana.nama_sumber_dana')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.alokasi-dana.perolehan-dana.perolehan', ['jenis_dana' => $jenis_dana]);
    }

    public function create()
    {
        $sumber_dana = SumberDana::get();
        $jenis_dana = PerolehanDana::get();

        return view('admin.alokasi-dana.perolehan-dana.create', compact('sumber_dana', 'jenis_dana'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sumber_dana_id' => 'required',
            'nama_jenis_dana' => 'required',
            'tahun' => 'required',
            'jumlah_dana' => 'required | int'
        ]);

        DB::table('jenis_dana')->insert([
            'user_id' => Auth::user()->kode_ps,
            'sumber_dana_id' => $request->sumber_dana_id,
            'nama_jenis_dana' => $request->nama_jenis_dana,
            'tahun' => $request->tahun,
            'jumlah_dana' => $request->jumlah_dana
        ]);

        return redirect('/alokasi-dana/perolehan')->with('added', 'Data Berhasil Ditambahkan');
    }

    public function edit(PerolehanDana $perolehanDana, $id)
    {
        $jenis_dana = PerolehanDana::findOrfail($id);
        $sumber_dana = SumberDana::get();

        return view('admin.alokasi-dana.perolehan-dana.edit', compact('jenis_dana', 'sumber_dana'));
    }

    public function update(Request $request, PerolehanDana $perolehanDana, $id)
    {
        $jenis_dana = PerolehanDana::findOrfail($id);

        $request->validate([
            'sumber_dana_id' => 'required',
            'nama_jenis_dana' => 'required',
            'tahun' => 'required',
            'jumlah_dana' => 'required | int'
        ]);

        PerolehanDana::where('id', $jenis_dana->id)
            ->update([
                'sumber_dana_id' => $request->sumber_dana_id,
                'nama_jenis_dana' => $request->nama_jenis_dana,
                'tahun' => $request->tahun,
                'jumlah_dana' => $request->jumlah_dana
            ]);

        return redirect('/alokasi-dana/perolehan')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('jenis_dana')->where('id', $id)->delete();
        return redirect()->back();
    }
}
