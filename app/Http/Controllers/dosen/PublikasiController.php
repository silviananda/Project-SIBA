<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\KaryaIlmiahDsn;
use App\Models\Admin\Dosen;
use App\Models\Admin\KategoriTingkat;
use App\Models\Admin\JenisPublikasi;
use App\Models\Admin\DataPkm;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Notifications\VerifikasiDosen;

class PublikasiController extends Controller
{

    public function index()
    {
        $artikel_dosen = KaryaIlmiahDsn::with('dosen', 'kategori_tingkat', 'publikasi', 'data_pkm')->where('artikel_dosen.dosen_id', \Auth::guard('dosen')->user()->dosen_id)->get();

        return view('dosen.publikasi.artikel-dosen.artikel', compact('artikel_dosen', 'dosen', 'kategori_tingkat', 'data_pkm'));
    }

    public function create()
    {
        $artikel_dosen = KaryaIlmiahDsn::get();
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi = JenisPublikasi::get();
        $data_pkm = DataPkm::get();

        return view('dosen.publikasi.artikel-dosen.create', compact('artikel_dosen', 'dosen', 'kategori_tingkat', 'data_pkm', 'jenis_publikasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pkm_id' => 'required',
            'judul' => 'required',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf|max:20000'
        ]);

        $artikel_dosen = new KaryaIlmiahDsn();
        $artikel_dosen->user_id = \Auth::guard('dosen')->user()->user_id;
        $artikel_dosen->dosen_id = \Auth::guard('dosen')->user()->dosen_id;
        $artikel_dosen->pkm_id = $request->pkm_id;
        $artikel_dosen->judul = $request->judul;
        $artikel_dosen->id_tingkat = $request->id_tingkat;
        $artikel_dosen->jumlah = $request->jumlah;
        $artikel_dosen->jenis_publikasi = $request->jenis_publikasi;
        $artikel_dosen->tahun = $request->tahun;
        $artikel_dosen->is_verification = 1;
        $artikel_dosen->save();

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $artikel_dosen->softcopy = $nama_file;

            $file->move(public_path() . '/file', $nama_file);
            $artikel_dosen->save();
        }

        return redirect('/publikasi/artikel')->with(['added' => 'Data Artikel berhasil ditambahkan!']);
    }

    public function edit(KaryaIlmiahDsn $KaryaIlmiahDsn, $id)
    {
        $artikel_dosen = KaryaIlmiahDsn::findOrfail($id);
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi = JenisPublikasi::get();
        $data_pkm = DataPkm::get();

        return view('dosen.publikasi.artikel-dosen.edit', compact('artikel_dosen', 'dosen', 'kategori_tingkat', 'jenis_publikasi', 'data_pkm'));
    }

    public function update(Request $request, $id)
    {
        $artikel_dosen = KaryaIlmiahDsn::findOrfail($id);

        $request->validate([
            'pkm_id' => 'required',
            'judul' => 'required',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf|max:20000'
        ]);

        $artikel_dosen->pkm_id = $request->input('pkm_id');
        $artikel_dosen->judul = $request->input('judul');
        $artikel_dosen->id_tingkat = $request->input('id_tingkat');
        $artikel_dosen->jumlah = $request->input('jumlah');
        $artikel_dosen->jenis_publikasi = $request->input('jenis_publikasi');
        $artikel_dosen->tahun = $request->input('tahun');
        $artikel_dosen->is_verification = $request->is_verification == 'on' ? 1 : 0;
        $artikel_dosen->update();

        if ($request->softcopy != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = KaryaIlmiahDsn::where('id', $request->id)->first();

            $path = $deletePath->softcopy;

            if ($artikel_dosen->softcopy != '' & $artikel_dosen->softcopy != null) {
                unlink(public_path('/file/') . $path);
            }

            $softcopy = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $softcopy->getClientOriginalExtension();
            $softcopy->move($path_baru, $nama_file);

            $artikel_dosen->update(['softcopy' => $nama_file]);
        }

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan update data publikasi karya ilmiah',
                'url' => route('luaran.karya-ilmiah.index', ['tablesearch' => Auth::user()->nip]),
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/publikasi/artikel')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('artikel_dosen')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function confirm(Request $request, $id)
    {
        KaryaIlmiahDsn::findOrfail($id)
            ->update([
                'is_verification' => $request->is_verification == 'on' ? 0 : 1
            ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan verifikasi data publikasi karya ilmiah',
                'url' => route('luaran.karya-ilmiah.index', ['tablesearch' => Auth::user()->nip]),
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }
}
