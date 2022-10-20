<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Dosen;
use App\Models\Admin\Produk;
use App\Models\Admin\DataPkm;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Notifications\VerifikasiDosen;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = DB::table('produk')
            ->join('dosen', 'produk.dosen_id', '=', 'dosen.dosen_id')
            ->join('data_pkm', 'produk.pkm_id', '=', 'data_pkm.id')
            ->select('produk.*', 'dosen.nama_dosen', 'data_pkm.judul_pkm')
            ->where('produk.dosen_id', \Auth::guard('dosen')->user()->dosen_id)->get();

        return view('dosen.publikasi.produk.produk', compact('produk', 'dosen', 'data_pkm'));
    }

    public function create()
    {
        $produk = Produk::get();
        $dosen = Dosen::get();
        $data_pkm = DataPkm::get();

        return view('dosen.publikasi.produk.create', compact('produk', 'dosen', 'data_pkm'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'pkm_id' => 'required',
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'kesiapan' => 'required'
        ]);

        DB::table('produk')->insert([
            'dosen_id' => \Auth::guard('dosen')->user()->dosen_id,
            'user_id' => \Auth::guard('dosen')->user()->user_id,
            'nama_produk' => $request->nama_produk,
            'pkm_id' => $request->pkm_id,
            'deskripsi' => $request->deskripsi,
            'kesiapan' => $request->kesiapan,
            'is_verification' => 1
        ]);
        return redirect('/publikasi/produk')->with(['added' => 'Data Produk berhasil ditambahkan!']);
    }

    public function edit(Produk $produk, $id)
    {
        $produk = Produk::findOrfail($id);
        $dosen = Dosen::get();
        $data_pkm = DataPkm::get();

        return view('dosen.publikasi.produk.edit', compact('produk', 'dosen', 'data_pkm'));
    }

    public function update(Request $request, Produk $produk, $id)
    {
        $produk = Produk::findOrfail($id);

        // return $request;
        $request->validate([
            'nama_produk' => 'required',
            'pkm_id' => 'required',
            'deskripsi' => 'required',
            'kesiapan' => 'required'
        ]);

        Produk::where('id', $produk->id)
            ->update([
                'nama_produk' => $request->nama_produk,
                'pkm_id' => $request->pkm_id,
                'deskripsi' => $request->deskripsi,
                'kesiapan' => $request->kesiapan,
                'is_verification' => $request->is_verification == 'on' ? 1 : 0
            ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan update data produk',
                'url' => route('luaran.produk.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/publikasi/produk')->with(['edit' => 'Data Produk berhasil diubah!']);
    }

    public function destroy($id)
    {
        DB::table('produk')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function confirm(Request $request, $id)
    {
        Produk::findOrfail($id)
            ->update([
                'is_verification' => $request->is_verification == 'on' ? 0 : 1
            ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            // Get admin prodi pada dosen
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan verifikasi data produk',
                'url' => route('luaran.produk.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }
}
