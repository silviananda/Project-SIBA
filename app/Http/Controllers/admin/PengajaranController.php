<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Pengajaran;
use App\Models\Admin\Dosen;
use App\Models\Admin\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;

class PengajaranController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mengajar = DB::table('mengajar')
            ->join('dosen', 'mengajar.dosen_id', '=', 'dosen.dosen_id')
            ->join('kurikulum', 'mengajar.kurikulum_id', '=', 'kurikulum.id')
            ->select('mengajar.*', 'dosen.nama_dosen', 'dosen.nip', 'kurikulum.nama_mk')
            ->where('mengajar.user_id', Auth::user()->kode_ps)->get();

        return view('admin.dosen-tetap.pengajaran.pengajaran-dosen', compact('mengajar', 'dosen', 'kurikulum'));
    }

    public function create()
    {
        $mengajar = Pengajaran::get();
        $dosen = Dosen::get();
        $kurikulum = Kurikulum::get();

        return view('admin.dosen-tetap.pengajaran.create', compact('mengajar', 'dosen', 'kurikulum'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'nip' => 'required | int',
            'kode_mk' => 'required',
            // 'nama_mk' => 'required'
        ]);

        DB::table('mengajar')->insert([
            'user_id' => Auth::user()->kode_ps,
            'dosen_id' => $request->dosen_id,
            'kurikulum_id' => $request->kurikulum_id,
            'jumlah_kelas' => $request->jumlah_kelas,
            'rencana' => $request->rencana,
            'laksana' => $request->laksana,
            'updated_at' => $request->updated_at
        ]);
        return redirect('/dosen/tetap/pengajaran')->with(['added' => 'Data Pengajaran Dosen berhasil ditambahkan!']);
    }

    public function edit(Pengajaran $pengajaran, $id)
    {
        $mengajar = Pengajaran::findOrfail($id);
        $dosen = Dosen::get();
        $kurikulum = Kurikulum::get();

        // dump($mengajar);
        return view('admin.dosen-tetap.pengajaran.edit', compact('mengajar', 'dosen', 'kurikulum'));
    }

    public function update(Request $request, Pengajaran $pengajaran, $id)
    {
        $mengajar = Pengajaran::findOrfail($id);

        // return $request;
        $request->validate([
            'nip' => 'required | int',
            'kode_mk' => 'required'
        ]);

        Pengajaran::where('id', $mengajar->id)
            ->update([
                'dosen_id' => $request->dosen_id,
                'kurikulum_id' => $request->kurikulum_id,
                'jumlah_kelas' => $request->jumlah_kelas,
                'rencana' => $request->rencana,
                'laksana' => $request->laksana,
                'updated_at' => $request->updated_at
            ]);

        return redirect('/dosen/tetap/pengajaran')->with(['edit' => 'Data Pengajaran Dosen berhasil diubah!']);
    }

    public function destroy(Pengajaran $pengajaran, $id)
    {
        DB::table('mengajar')->where('id', $id)->delete();
        return redirect()->back();
    }
}
