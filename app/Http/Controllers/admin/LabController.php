<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class LabController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_lab = DB::table('data_lab')
            ->where('data_lab.user_id', Auth::user()->kode_ps)->get();

        return view('admin.sarana.lab.lab', ['data_lab' => $data_lab]);
    }

    public function create()
    {
        $data_lab = Lab::get();

        return view('admin.sarana.lab.create', compact('data_lab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required',
            'nama_alat' => 'required',
            'jumlah_alat' => 'required | int',
            'tahun_pengadaan' => 'required'
        ]);

        DB::table('data_lab')->insert([
            'user_id' => Auth::user()->kode_ps,
            'lokasi' => $request->lokasi,
            'nama_alat' => $request->nama_alat,
            'jumlah_alat' => $request->jumlah_alat,
            'tahun_pengadaan' => $request->tahun_pengadaan,
            'fungsi' => $request->fungsi
        ]);

        // return $request;
        return redirect('/sarana/lab')->with(['added' => 'Data Perlatan Lab Berhasil di tambahkan!']);
    }

    public function edit(Lab $lab, $id)
    {
        $data_lab = Lab::findOrFail($id);

        return view('admin.sarana.lab.edit', compact('data_lab'));
    }

    public function update(Request $request, Lab $lab, $id)
    {
        $data_lab = Lab::findOrFail($id);
        $request->validate([
            'lokasi' => 'required',
            'nama_alat' => 'required',
            'jumlah_alat' => 'required | int',
            'tahun_pengadaan' => 'required'
        ]);

        Lab::where('id', $data_lab->id)
            ->update([
                'lokasi' => $request->lokasi,
                'nama_alat' => $request->nama_alat,
                'jumlah_alat' => $request->jumlah_alat,
                'tahun_pengadaan' => $request->tahun_pengadaan,
                'fungsi' => $request->fungsi
            ]);

        return redirect('/sarana/lab')->with(['edit' => 'Data Perlatan Lab berhasil di ubah!']);
    }

    public function destroy(Lab $lab, $id)
    {
        DB::table('data_lab')->where('id', $id)->delete();
        return redirect()->back();
    }
}
