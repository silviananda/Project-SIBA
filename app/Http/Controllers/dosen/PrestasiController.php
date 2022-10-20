<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Admin\PrestasiDosen;
use App\Models\Admin\Dosen;
use App\Models\Admin\KategoriTingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Notifications\VerifikasiDosen;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi_dosen = DB::table('prestasi_dosen')
            ->join('dosen', 'prestasi_dosen.dosen_id', '=', 'dosen.dosen_id')
            ->join('kategori_tingkat', 'prestasi_dosen.tingkat', '=', 'kategori_tingkat.id')
            ->select('prestasi_dosen.*', 'kategori_tingkat.nama_kategori', 'dosen.nip', 'dosen.nama_dosen')
            ->where('prestasi_dosen.dosen_id', Auth::guard('dosen')->user()->dosen_id)->get();

        return view('dosen.prestasi.prestasi-dosen', compact('prestasi_dosen', 'dosen', 'kategori_tingkat'));
    }

    public function create()
    {
        $prestasi_dosen = PrestasiDosen::get();
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();
        return view('dosen.prestasi.create', compact('prestasi_dosen', 'dosen', 'kategori_tingkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_prestasi' => 'required',
            'tingkat' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,jpeg,jpg,png|max:10000'
        ]);

        $prestasi_dosen = new PrestasiDosen;
        $prestasi_dosen->user_id = \Auth::guard('dosen')->user()->user_id;
        $prestasi_dosen->dosen_id = \Auth::guard('dosen')->user()->dosen_id;
        $prestasi_dosen->judul_prestasi = $request->judul_prestasi;
        $prestasi_dosen->tingkat = $request->tingkat;
        $prestasi_dosen->tahun = $request->tahun;
        $prestasi_dosen->is_verification = 1;
        $prestasi_dosen->save();

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $prestasi_dosen->softcopy = $nama_file;

            $file->move(public_path() . '/file', $nama_file);
            $prestasi_dosen->save();
        }

        return redirect('/prestasi-dosen')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(PrestasiDosen $prestasiDosen, $id)
    {
        $prestasi_dosen = PrestasiDosen::findOrfail($id);
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();

        return view('dosen.prestasi.edit', compact('prestasi_dosen', 'dosen', 'kategori_tingkat'));
    }

    public function update(Request $request, $id)
    {
        $prestasi_dosen = PrestasiDosen::findOrfail($id);

        $request->validate([
            'judul_prestasi' => 'required',
            'tingkat' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,jpeg,jpg,png|max:10000'
        ]);

        $prestasi_dosen->judul_prestasi = $request->input('judul_prestasi');
        $prestasi_dosen->tingkat = $request->input('tingkat');
        $prestasi_dosen->tahun = $request->input('tahun');
        $prestasi_dosen->is_verification = $request->is_verification == 'on' ? 1 : 0;
        $prestasi_dosen->update();

        if ($request->softcopy != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = PrestasiDosen::where('id', $request->id)->first();

            $path = $deletePath->softcopy;

            if ($prestasi_dosen->softcopy != '' & $prestasi_dosen->softcopy != null) {
                unlink(public_path('/file/') . $path);
            }

            $softcopy = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $softcopy->getClientOriginalExtension();
            $softcopy->move($path_baru, $nama_file);

            $prestasi_dosen->update(['softcopy' => $nama_file]);
        }

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            // $admin = User::find(Auth::user()->user_id);
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            // dd($admin);
            // dd(Auth::user()->user_id);
            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan update data prestasi',
                'url' => route('upaya.prestasi.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/prestasi-dosen')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('prestasi_dosen')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function confirm(Request $request, $id)
    {
        PrestasiDosen::findOrfail($id)
            ->update([
                'is_verification' => $request->is_verification == 'on' ? 0 : 1
            ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            // $admin = User::find(Auth::user()->user_id);
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan verifikasi data prestasi',
                'url' => route('upaya.prestasi.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }
}
