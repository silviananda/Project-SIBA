<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class RuangController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_ruang = DB::table('data_ruang')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.prasarana.ruangan.ruangan', compact('data_ruang'));
    }

    public function create()
    {
        return view('admin.prasarana.ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruang_kerja' => 'required',
            'jumlah' => 'required | int',
            'luas' => 'required | numeric'
        ]);

        DB::table('data_ruang')->insert([
            'user_id' => Auth::user()->kode_ps,
            'ruang_kerja' => $request->ruang_kerja,
            'jumlah' => $request->jumlah,
            'luas' => $request->luas
        ]);

        return redirect('/prasarana/ruangan')->with(['added' => 'Data Ruangan berhasil di tambahkan!']);
        // return $request;
    }

    public function edit(Ruang $ruang, $id)
    {
        $data_ruang = Ruang::findOrfail($id);
        return view('admin.prasarana.ruangan.edit', compact('data_ruang'));
    }

    public function update(Request $request, Ruang $ruang, $id)
    {
        $request->validate([
            'ruang_kerja' => 'required',
            'jumlah' => 'required | int',
            'luas' => 'required | numeric'
        ]);

        Ruang::findOrfail($id)
            ->update([
                'ruang_kerja' => $request->ruang_kerja,
                'jumlah' => $request->jumlah,
                'luas' => $request->luas
            ]);

        // return $request;
        return redirect('/prasarana/ruangan')->with(['edit' => 'Data Ruang berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('data_ruang')->where('id', $id)->delete();
        return redirect()->back();
    }
}
