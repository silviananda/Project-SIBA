<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Jurusan;
use App\Models\Himpunan;
use App\Models\Admin\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;

class HimpunanController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $himpunan = DB::table('himpunan')
            ->join('jurusan', 'himpunan.user_id', '=', 'jurusan.jurusan')
            ->select('himpunan.*', 'jurusan.nama_jurusan')
            ->get();

        return view('super.data-himpunan', compact('himpunan', 'jurusan'));
    }

    public function create()
    {
        $himpunan = Himpunan::get();
        $jurusan = Jurusan::get();

        return view('super.create-himpunan', compact('himpunan', 'jurusan'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        // return $request;
        DB::table('himpunan')->insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/data-himpunan')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Himpunan $himpunan, $id)
    {
        $himpunan = Himpunan::findOrfail($id);
        $jurusan = Jurusan::get();

        // dd($admin);
        return view('super.edit-himpunan', compact('himpunan', 'jurusan'));
    }

    public function update(Request $request, Himpunan $himpunan, $id)
    {
        $himpunan = Himpunan::findOrfail($id);

        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        Himpunan::where('id', $himpunan->id)
            ->update([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

        return redirect('/data-himpunan')->with(['edit' => 'Data berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('himpunan')->where('id', $id)->delete();
        return redirect()->back();
    }
}
