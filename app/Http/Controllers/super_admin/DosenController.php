<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Dosen;
use App\Models\Admin\Jurusan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;

class DosenController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // dd(Auth::user()->user_id);
        $dosen = DB::table('dosen')
            ->join('jurusan', 'dosen.user_id', '=', 'jurusan.jurusan')
            ->select('dosen.*', 'jurusan.nama_jurusan')
            ->get();

        return view('super.data-dosen', compact('dosen', 'jurusan'));
    }

    public function create()
    {
        $dosen = Dosen::get();
        $jurusan = Jurusan::get();

        return view('super.create-dosen', compact('dosen', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nama_dosen' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        DB::table('dosen')->insert([
            'user_id' => $request->user_id,
            'nama_dosen' => $request->nama_dosen,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect('/data-dosen')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Dosen $dosen, $dosen_id)
    {
        $dosen = Dosen::findOrfail($dosen_id);
        $jurusan = Jurusan::get();

        // dd($admin);
        return view('super.edit-dosen', compact('dosen', 'jurusan'));
    }
    public function update(Request $request, Dosen $dosen, $dosen_id)
    {
        // return $request;
        $request->validate([
            'user_id' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        Dosen::findOrfail($dosen_id)
            ->update([
                'user_id' => $request->user_id,
                'nama_dosen' => $request->nama_dosen,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

        return redirect('/data-dosen')->with(['edit' => 'Data berhasil di ubah!']);
    }

    public function destroy($dosen_id)
    {
        DB::table('dosen')->where('dosen_id', $dosen_id)->delete();
        return redirect()->back();
    }
}
