<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kependidikan;
use App\Models\Admin\DaftarPendidikan;
use App\Models\Admin\UnitKerja;
use App\Models\Admin\TenagaKependidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class KependidikanController extends Controller
{
    public function index()
    {
        $tenaga_kependidikan = DB::table('tenaga_kependidikan')
            ->join('data_unit_kerja', 'tenaga_kependidikan.unit_kerja_id', '=', 'data_unit_kerja.id')
            ->join('data_tenaga_kependidikan', 'tenaga_kependidikan.data_tenaga_kependidikan_id', '=', 'data_tenaga_kependidikan.id')
            ->join('daftar_pendidikan', 'tenaga_kependidikan.pendidikan_id', '=', 'daftar_pendidikan.id')
            ->select('tenaga_kependidikan.*', 'data_tenaga_kependidikan.posisi', 'daftar_pendidikan.nama_pendidikan', 'data_unit_kerja.unit')
            ->where('tenaga_kependidikan.user_id', Auth::user()->kode_ps)->get();

        // dump($aktivitas);

        return view('admin.kependidikan.halaman-kependidikan', compact('tenaga_kependidikan'));
    }

    public function create()
    {
        $tenaga_kependidikan = Kependidikan::get();
        $data_tenaga_kependidikan = TenagaKependidikan::get();
        $daftar_pendidikan = DaftarPendidikan::get();
        $data_unit_kerja = UnitKerja::get();

        // return "hwlooooooo";
        return view('admin.kependidikan.create', compact('tenaga_kependidikan', 'data_tenaga_kependidikan', 'daftar_pendidikan', 'data_unit_kerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required | int',
            'data_tenaga_kependidikan_id' => 'required',
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'pendidikan_id' => 'required',
            'unit_kerja_id' => 'required'
        ]);

        DB::table('tenaga_kependidikan')->insert([
            'user_id' => Auth::user()->kode_ps,
            'nidn' => $request->nidn,
            'data_tenaga_kependidikan_id' => $request->data_tenaga_kependidikan_id,
            'pendidikan_id' => $request->pendidikan_id,
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'unit_kerja_id' => $request->unit_kerja_id
        ]);
        // return $request;
        return redirect('/tenaga-kependidikan')->with(['added' => 'Data Tenaga Kependidikan Berhasil di tambahkan!']);
    }

    public function edit(Kependidikan $kependidikan, $id)
    {
        $tenaga_kependidikan = Kependidikan::findOrfail($id);
        $data_tenaga_kependidikan = TenagaKependidikan::get();
        $daftar_pendidikan = DaftarPendidikan::get();
        $data_unit_kerja = UnitKerja::get();
        // return "helooooooo";
        return view('admin.kependidikan.edit', compact('tenaga_kependidikan', 'data_tenaga_kependidikan', 'daftar_pendidikan', 'data_unit_kerja'));
    }

    public function update(Request $request, Kependidikan $kependidikan, $id)
    {
        $tenaga_kependidikan = Kependidikan::findOrfail($id);

        $request->validate([
            'nidn' => 'required | int',
            'data_tenaga_kependidikan_id' => 'required',
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'pendidikan_id' => 'required',
            'unit_kerja_id' => 'required'
        ]);

        Kependidikan::where('id', $tenaga_kependidikan->id)
            ->update([
                'nidn' => $request->nidn,
                'data_tenaga_kependidikan_id' => $request->data_tenaga_kependidikan_id,
                'pendidikan_id' => $request->pendidikan_id,
                'nama' => $request->nama,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'unit_kerja_id' => $request->unit_kerja_id
            ]);

        return redirect('/tenaga-kependidikan')->with(['edit' => 'Data Pustaka berhasil di ubah!']);
    }

    public function destroy(Kependidikan $kependidikan, $id)
    {
        DB::table('tenaga_kependidikan')->where('id', $id)->delete();
        return redirect()->back();
    }
}
