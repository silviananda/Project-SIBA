<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kurikulum;
use App\Models\Admin\Semester;
use App\Models\Admin\StrukturKurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class StrukturKurikulumController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function peninjauan()
    {
        return view('admin.kurikulum.peninjauan');
    }

    public function index()
    {
        $kurikulum = DB::table('kurikulum')
            ->join('semester', 'kurikulum.semester_id', '=', 'semester.id')
            ->select('kurikulum.*', 'semester.nama_semester')
            ->where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.kurikulum.struktur-kurikulum.struktur-kurikulum', compact('kurikulum'));
    }

    public function create()
    {
        $kurikulum = Kurikulum::get();
        $semester = Semester::get();

        return view('admin.kurikulum.struktur-kurikulum.create', compact('kurikulum', 'semester'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required',
            'kode_mk' => 'required | unique:kurikulum',
            'nama_mk' => 'required',
            'bobot_sks' => 'required | int',
            'rps' => 'file|mimes:docx,doc,pdf,zip,xml|max:50000',
            'silabus' => 'file|mimes:docx,doc,pdf,zip,xml|max:50000'
        ]);

        $kurikulum = new Kurikulum;
        $kurikulum->user_id = Auth::user()->kode_ps;
        $kurikulum->semester_id = $request->semester_id;
        // $kurikulum->tahun = $request->tahun;
        $kurikulum->kode_mk = $request->kode_mk;
        $kurikulum->nama_mk = $request->nama_mk;
        $kurikulum->bobot_sks = $request->bobot_sks;
        $kurikulum->sks_praktikum = $request->sks_praktikum;
        $kurikulum->bobot_tugas = $request->bobot_tugas;
        $kurikulum->sks_seminar = $request->sks_seminar;
        $kurikulum->wajib = $request->wajib;
        $kurikulum->unit = $request->unit;
        $kurikulum->save();

        if ($request->rps != '') {
            $file_rps = $request->rps;
            $nama_file = time() . rand(100, 999) . "." . $file_rps->getClientOriginalExtension();

            $kurikulum->rps = $nama_file;

            $file_rps->move(public_path() . '/file', $nama_file);
            $kurikulum->save();
        }


        if ($request->silabus != '') {

            $file_silabus = $request->silabus;
            $nama_file_silabus = time() . rand(100, 999) . "." . $file_silabus->getClientOriginalExtension();

            $kurikulum->silabus = $nama_file_silabus;
            $file_silabus->move(public_path() . '/file', $nama_file_silabus);
            $kurikulum->save();
        }
        return redirect('/kurikulum/struktur')->with(['added' => 'Data Kerjasama Berhasil Ditambahkan']);
    }

    public function edit(Request $request, Kurikulum $kurikulum, $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $semester = Semester::get();

        return view('admin.kurikulum.struktur-kurikulum.edit', compact('kurikulum', 'semester'));
    }

    public function update(Request $request, Kurikulum $kurikulum, $id)
    {

        $request->validate([
            'semester_id' => 'required',
            'kode_mk' => 'required',
            'nama_mk' => 'required',
            'bobot_sks' => 'required | int',
            'rps' => 'file|mimes:docx,doc,pdf,zip,xml|max:50000',
            'silabus' => 'file|mimes:docx,doc,pdf,zip,xml|max:50000'
        ]);

        $kurikulum = Kurikulum::find($id);
        $kurikulum->semester_id = $request->semester_id;
        // $kurikulum->tahun = $request->tahun;
        $kurikulum->kode_mk = $request->kode_mk;
        $kurikulum->nama_mk = $request->nama_mk;
        $kurikulum->bobot_sks = $request->bobot_sks;
        $kurikulum->sks_praktikum = $request->sks_praktikum;
        $kurikulum->bobot_tugas = $request->bobot_tugas;
        $kurikulum->sks_seminar = $request->sks_seminar;
        $kurikulum->wajib = $request->wajib;
        $kurikulum->unit = $request->unit;
        $kurikulum->update();

        if ($request->rps != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = Kurikulum::where('id', $request->id)->first();

            $path = $deletePath->rps;

            if ($kurikulum->rps != '' & $kurikulum->rps != null) {
                unlink(public_path('/file/') . $path);
            }

            $rps = $request->rps;
            $nama_file_rps = time() . rand(100, 999) . "." . $rps->getClientOriginalExtension();
            $rps->move($path_baru, $nama_file_rps);

            $kurikulum->update(['rps' => $nama_file_rps]);
        }

        if ($request->silabus != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = Kurikulum::where('id', $request->id)->first();

            $path = $deletePath->silabus;

            if ($kurikulum->silabus != '' & $kurikulum->silabus != null) {
                unlink(public_path('/file/') . $path);
            }

            $silabus = $request->silabus;
            $nama_file_silabus = time() . rand(100, 999) . "." . $silabus->getClientOriginalExtension();
            $silabus->move($path_baru, $nama_file_silabus);

            $kurikulum->update(['silabus' => $nama_file_silabus]);
        }
        return redirect('/kurikulum/struktur')->with(['edit' => 'Data Kerjasama berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('kurikulum')->where('id', $id)->delete();
        return redirect()->back();
    }
}
