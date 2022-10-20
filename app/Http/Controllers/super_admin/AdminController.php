<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Jurusan;
use App\Models\Admin\KategoriAkun;
use App\Models\Admin\Dosen;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $admin = DB::table('users')
            ->join('jurusan', 'users.kode_ps', '=', 'jurusan.jurusan')
            ->select('users.*', 'jurusan.jurusan')
            ->get();

        return view('super.data-admin', compact('admin', 'jurusan'));
    }

    public function create()
    {
        $admin = User::get();
        $jurusan = Jurusan::get();
        $akun = KategoriAkun::get();

        return view('super.create-admin', compact('admin', 'jurusan', 'akun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_ps' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $tingkat = $request['kode_ps'];
        $kode = substr($tingkat, 2, -4);

        // return $request;
        // dd($kode);

        DB::table('users')->insert([
            'kode_ps' => $request->kode_ps,
            'name' => $request->name,
            'email' => $request->email,
            'tingkat' => $kode,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/data-admin')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(User $user, $id)
    {
        $admin = User::findOrfail($id);
        $jurusan = Jurusan::get();
        $akun = KategoriAkun::get();
        $dosen = Dosen::get();

        // return "tesss";

        return view('super.edit-admin', compact('admin', 'jurusan', 'akun', 'dosen'));
    }

    public function update(Request $request, User $user, $id)
    {
        $request->validate([
            'kode_ps' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $tingkat = $request['kode_ps'];
        $kode = substr($tingkat, 2, -4);

        // return $request;
        User::findOrfail($id)
            ->update([
                'kode_ps' => $request->kode_ps,
                'name' => $request->name,
                'email' => $request->email,
                'tingkat' => $kode,
                'password' => Hash::make($request->password)
            ]);

        return redirect('/data-admin')->with(['edit' => 'Data berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->back();
    }
}
