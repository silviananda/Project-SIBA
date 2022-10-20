<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DayaTampung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class DayaTampungController extends Controller
{
    public function index()
    {
        $daya_tampung = DB::table('daya_tampung')->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.mahasiswa.daya-tampung.daya_tampung', compact('daya_tampung'));
    }

    public function create()
    {
        $daya_tampung = DayaTampung::get();

        return view('admin.mahasiswa.daya-tampung.create', compact('daya_tampung'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'daya_tampung' => 'required | int'
        ]);

        DB::table('daya_tampung')->insert([
            'user_id' => Auth::user()->kode_ps,
            'tahun' => $request->tahun,
            'daya_tampung' => $request->daya_tampung
        ]);

        return redirect('/mahasiswa/daya-tampung')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(DayaTampung $daya_tampung, $id)
    {
        $daya_tampung = DayaTampung::findOrfail($id);

        return view('admin.mahasiswa.daya-tampung.edit', compact('daya_tampung'));
    }

    public function update(Request $request, DayaTampung $daya_tampung, $id)
    {
        $daya_tampung = DayaTampung::findOrfail($id);

        $request->validate([
            'tahun' => 'required',
            'daya_tampung' => 'required | int'
        ]);

        DayaTampung::findOrfail($id)
            ->update([
                'tahun' => $request->tahun,
                'daya_tampung' => $request->daya_tampung
            ]);

        return redirect('/mahasiswa/daya-tampung')->with(['edit' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id)
    {
        DB::table('daya_tampung')->where('id', $id)->delete();
        return redirect()->back();
    }
}
