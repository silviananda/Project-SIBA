<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MkPilihan;
use App\Models\Admin\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class MkPilihanController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mk_pilihan = DB::table('mk_pilihan')
            ->join('semester', 'mk_pilihan.semester_id', '=', 'semester.id')
            ->select('mk_pilihan.*', 'semester.nama_semester')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.kurikulum.mk-pilihan.mk-pilihan', compact('mk_pilihan'));
    }

    public function create()
    {
        $semester = Semester::get();

        return view('admin.kurikulum.mk-pilihan.create', compact('mk_pilihan', 'semester'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'kode_mk' => 'required',
            'nama' => 'required',
            'semester_id' => 'required',
            'bobot_sks' => 'required |int'
        ]);

        DB::table('mk_pilihan')->insert([
            'user_id' => Auth::user()->kode_ps,
            'kode_mk' => $request->kode_mk,
            'nama' => $request->nama,
            'semester_id' => $request->semester_id,
            'bobot_sks' => $request->bobot_sks,
            'bobot_tugas' => $request->bobot_tugas,
            'unit' => $request->unit
        ]);

        return redirect('/kurikulum/mk-pilihan')->with(['added' => 'Data Matakuliah PIlihan berhasil ditambahkan!']);
    }

    public function edit(MkPilihan $mk_pilihan, $id)
    {
        $mk_pilihan = MkPilihan::findOrfail($id);
        $semester = Semester::get();

        return view('admin.kurikulum.mk-pilihan.edit', compact('mk_pilihan', 'semester'));
    }

    public function update(Request $request, MkPilihan $mk_pilihan, $id)
    {
        $mk_pilihan = MkPilihan::findOrfail($id);

        $request->validate([
            'kode_mk' => 'required',
            'nama' => 'required',
            'semester_id' => 'required',
            'bobot_sks' => 'required |int'
        ]);

        MkPilihan::where('id', $mk_pilihan->id)
            ->update([
                'kode_mk' => $request->kode_mk,
                'nama' => $request->nama,
                'semester_id' => $request->semester_id,
                'bobot_sks' => $request->bobot_sks,
                'bobot_tugas' => $request->bobot_tugas,
                'unit' => $request->unit
            ]);
        return redirect('/kurikulum/mk-pilihan')->with(['edit' => 'Data Mata Kuliah berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('mk_pilihan')->where('id', $id)->delete();
        return redirect()->back();
    }
}
