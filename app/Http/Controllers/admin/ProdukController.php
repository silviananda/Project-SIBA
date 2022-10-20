<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Produk;
use App\Models\Admin\Dosen;
use App\Models\Admin\DataPkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Notifications\VerifikasiDosen;
use App\Notifications\Deadline;
use Carbon\Carbon;

class ProdukController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $produk = DB::table('produk')
            ->join('dosen', 'produk.dosen_id', '=', 'dosen.dosen_id')
            ->select('produk.*', 'dosen.nip', 'dosen.nama_dosen')
            ->where('produk.user_id', Auth::user()->kode_ps)->get();

        return view('admin.luaran.produk.produk', compact('produk'));
    }

    public function create()
    {
        $produk = Produk::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.produk.create', compact('produk', 'data_pkm'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'nip' => 'required',
            'pkm_id' => 'required',
            'nama_produk' => 'required',
            'deadline' => 'required'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        DB::table('produk')->insert([
            'user_id' => Auth::user()->kode_ps,
            'dosen_id' => $request->dosen_id,
            'pkm_id' => $request->pkm_id,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'kesiapan' => $request->kesiapan,
            'tanggal_create' => $date1,
            'deadline' => $request->deadline
        ]);


        try {
            // Get admin prodi pada dosen
            $dosen = Dosen::find($request->dosen_id);

            $dosen->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->name,
                'pesan' => 'Telah mengirim data produk untuk di verifikasi',
                'url' => route('publikasi.produk.index'),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/luaran/produk')->with(['added' => 'Data Produk/Jasa berhasil ditambahkan!']);
    }

    public function edit(Produk $produk, $id)
    {
        $produk = Produk::findOrfail($id);
        $data_pkm = DataPkm::get();

        return view('admin.luaran.produk.edit', compact('produk', 'data_pkm'));
    }

    public function update(Request $request, Produk $produk, $id)
    {
        $produk = Produk::findOrfail($id);

        // return $request;
        $request->validate([
            'nip' => 'required',
            'pkm_id' => 'required',
            'nama_produk' => 'required'
        ]);

        Produk::where('id', $produk->id)
            ->update([
                'dosen_id' => $request->dosen_id,
                'nama_produk' => $request->nama_produk,
                'pkm_id' => $request->pkm_id,
                'deskripsi' => $request->deskripsi,
                'kesiapan' => $request->kesiapan
            ]);

        return redirect('/luaran/produk')->with(['edit' => 'Data Produk/Jasa berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('produk')->where('id', $id)->delete();
        return redirect()->back();
    }
}
