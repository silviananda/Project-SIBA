<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Alumni;
use App\Models\Admin\JenisPekerjaan;
use App\Models\Admin\WaktuTunggu;
use App\Models\Admin\Pendapatan;
use App\Models\Admin\MulaiKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::with(['waktu_tunggu', 'jenis_pekerjaan', 'kategori_pendapatan', 'mulai_kerja'])->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.alumni.halaman-alumni', compact('alumni', 'waktu_tunggu', 'jenis_pekerjaan', 'kategori_pendapatan', 'mulai_kerja', 'years', 'month'));
    }

    public function create()
    {
        $alumni = Alumni::get();
        $waktu_tunggu = WaktuTunggu::get();
        $jenis_pekerjaan = JenisPekerjaan::get();
        $kategori_pendapatan = Pendapatan::get();
        $mulai_kerja = MulaiKerja::get();

        return view('admin.alumni.create', compact('alumni', 'waktu_tunggu', 'jenis_pekerjaan', 'kategori_pendapatan', 'mulai_kerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'npm' => 'required | int',
            'ipk' => 'required | numeric',
            'tahun_masuk' => 'required',
            'tahun_lulus' => 'required'
        ]);

        // return $request;

        DB::table('alumni')->insert([
            'user_id' => Auth::user()->kode_ps,
            'nama' => $request->nama,
            'npm' => $request->npm,
            'ipk' => $request->ipk,
            'tahun_masuk' => $request->tahun_masuk,
            'id_jenis_pekerjaan' => $request->id_jenis_pekerjaan,
            'id_pendapatan' => $request->id_pendapatan,
            'id_waktu_tunggu' => $request->id_waktu_tunggu,
            'tahun_lulus' => $request->tahun_lulus,
            'id_mulai_kerja' => $request->id_mulai_kerja
        ]);

        return redirect('/alumni')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Alumni $alumni, $id)
    {
        $alumni = Alumni::findOrfail($id);
        $waktu_tunggu = WaktuTunggu::get();
        $jenis_pekerjaan = JenisPekerjaan::get();
        $kategori_pendapatan = Pendapatan::get();
        $mulai_kerja = MulaiKerja::get();

        return view('admin.alumni.edit', compact('alumni', 'waktu_tunggu', 'jenis_pekerjaan', 'kategori_pendapatan', 'mulai_kerja'));
    }

    public function update(Request $request, Alumni $alumni, $id)
    {
        $request->validate([
            'nama' => 'required',
            'npm' => 'required | int',
            'ipk' => 'required | numeric',
            'tahun_masuk' => 'required',
            'tahun_lulus' => 'required'
        ]);

        Alumni::findOrfail($id)
            ->update([
                'nama' => $request->nama,
                'npm' => $request->npm,
                'ipk' => $request->ipk,
                'tahun_masuk' => $request->tahun_masuk,
                'id_jenis_pekerjaan' => $request->id_jenis_pekerjaan,
                'id_pendapatan' => $request->id_pendapatan,
                'id_waktu_tunggu' => $request->id_waktu_tunggu,
                'tahun_lulus' => $request->tahun_lulus,
                'id_mulai_kerja' => $request->id_mulai_kerja
            ]);

        // return $request;
        return redirect('/alumni')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('alumni')->where('id', $id)->delete();
        return redirect()->back();
    }
}
