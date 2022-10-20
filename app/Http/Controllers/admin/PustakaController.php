<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Pustaka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PustakaController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sarana()
    {
        return view('admin.sarana.halaman-sarana');
    }

    public function index()
    {
        $pustaka = DB::table('pustaka')
            ->where('user_id', Auth::user()->kode_ps)->get();
        return view('admin.sarana.pustaka.pustaka', ['pustaka' => $pustaka]);
    }

    public function create()
    {
        return view('admin.sarana.pustaka.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pustaka' => 'required',
            'jumlah_judul' => 'required | int',
            'jumlah_copy' => 'required | int'
        ]);

        DB::table('pustaka')->insert([
            'user_id' => Auth::user()->kode_ps,
            'jenis_pustaka' => $request->jenis_pustaka,
            'jumlah_judul' => $request->jumlah_judul,
            'jumlah_copy' => $request->jumlah_copy
        ]);

        return redirect('/sarana/pustaka')->with(['added' => 'Data Pustaka Berhasil di tambahkan!']);
    }

    public function edit(Pustaka $pustaka, $id)
    {
        $pustaka = Pustaka::findOrfail($id);

        return view('admin.sarana.pustaka.edit', compact('pustaka'));
    }

    public function update(Request $request, Pustaka $pustaka, $id)
    {
        // return $request;
        $pustaka = Pustaka::findOrfail($id);

        $request->validate([
            'jenis_pustaka' => 'required',
            'jumlah_judul' => 'required | int',
            'jumlah_copy' => 'required | int'
        ]);

        Pustaka::where('id', $pustaka->id)
            ->update([
                'jenis_pustaka' => $request->jenis_pustaka,
                'jumlah_judul' => $request->jumlah_judul,
                'jumlah_copy' => $request->jumlah_copy
            ]);
        return redirect('/sarana/pustaka')->with(['edit' => 'Data Pustaka berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('pustaka')->where('id', $id)->delete();
        return redirect()->back();
    }
}
