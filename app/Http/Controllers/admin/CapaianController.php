<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Capaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class CapaianController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $capaian = DB::table('capaian')
            ->where('user_id', Auth::user()->kode_ps)->get();

        // return $capaian;
        return view('admin.capaian.halaman-capaian', compact('capaian'));
    }

    public function create()
    {
        $capaian = Capaian::get();

        return view('admin.capaian.create', compact('capaian', 'mk_pilihan', 'data_mk_pilihan'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'tahun' => 'required | unique:capaian',
            'jumlah' => 'required | int',
            'minimum' => 'required | numeric',
            'rata' => 'required | numeric',
            'maksimum' => 'required | numeric'
        ]);

        DB::table('capaian')->insert([
            'user_id' => Auth::user()->kode_ps,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
            'minimum' => $request->minimum,
            'rata' => $request->rata,
            'maksimum' => $request->maksimum
        ]);

        return redirect('/capaian')->with(['added' => 'Data Capaian Lulusan berhasil ditambahkan!']);
    }

    public function edit(Capaian $capaian, $id)
    {
        $capaian = Capaian::findOrfail($id);

        return view('admin.capaian.edit', compact('capaian'));
    }

    public function update(Request $request, Capaian $capaian, $id)
    {
        $capaian = Capaian::findOrfail($id);

        $request->validate([
            'tahun' => 'required',
            'jumlah' => 'required | int',
            'minimum' => 'required | numeric',
            'rata' => 'required | numeric',
            'maksimum' => 'required | numeric'
        ]);

        Capaian::where('id', $capaian->id)
            ->update([
                'tahun' => $request->tahun,
                'jumlah' => $request->jumlah,
                'minimum' => $request->minimum,
                'rata' => $request->rata,
                'maksimum' => $request->maksimum
            ]);
        return redirect('/capaian')->with(['edit' => 'Data Capaian Lulusan berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('capaian')->where('id', $id)->delete();
        return redirect()->back();
    }
}
