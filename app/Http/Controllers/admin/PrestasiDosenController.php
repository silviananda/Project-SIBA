<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PrestasiDosen;
use App\Models\Admin\Dosen;
use App\Models\Admin\KategoriTingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;
use App\Notifications\VerifikasiDosen;
use App\Notifications\Deadline;
use Carbon\Carbon;

class PrestasiDosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $prestasi_dosen = DB::table('prestasi_dosen')
            ->join('dosen', 'prestasi_dosen.dosen_id', '=', 'dosen.dosen_id')
            ->join('kategori_tingkat', 'prestasi_dosen.tingkat', '=', 'kategori_tingkat.id')
            ->select('prestasi_dosen.*', 'kategori_tingkat.nama_kategori', 'dosen.nip', 'dosen.nama_dosen')
            ->where('prestasi_dosen.user_id', Auth::user()->kode_ps)->get();

        return view('admin.upaya.prestasi.prestasi', compact('prestasi_dosen', 'dosen', 'kategori_tingkat'));
    }

    public function create()
    {
        $prestasi_dosen = PrestasiDosen::get();
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();
        return view('admin.upaya.prestasi.create', compact('prestasi_dosen', 'dosen', 'kategori_tingkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required | int',
            'judul_prestasi' => 'required',
            'tingkat' => 'required',
            'tahun' => 'required',
            'deadline' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,jpeg,jpg,png|max:10000'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        $prestasi_dosen = new PrestasiDosen;
        $prestasi_dosen->user_id = Auth::user()->kode_ps;
        $prestasi_dosen->dosen_id = $request->dosen_id;
        $prestasi_dosen->judul_prestasi = $request->judul_prestasi;
        $prestasi_dosen->tingkat = $request->tingkat;
        $prestasi_dosen->tahun = $request->tahun;
        $prestasi_dosen->tanggal_create = $date1;
        $prestasi_dosen->deadline = $request->deadline;
        $prestasi_dosen->save();

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $prestasi_dosen->softcopy = $nama_file;

            $file->move(public_path() . '/file', $nama_file);
            $prestasi_dosen->save();
        }

        try {
            // Get admin prodi pada dosen
            $dosen = Dosen::find($request->dosen_id);

            // dd($request->dosen_id);
            $dosen->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->name,
                'pesan' => 'Telah mengirim data prestasi untuk di verifikasi',
                'url' => route('prestasi-dosen.index'),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/upaya/prestasi')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(PrestasiDosen $prestasiDosen, $id)
    {
        $prestasi_dosen = PrestasiDosen::findOrfail($id);
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();

        return view('admin.upaya.prestasi.edit', compact('prestasi_dosen', 'dosen', 'kategori_tingkat'));
    }

    public function update(Request $request, PrestasiDosen $prestasiDosen, $id)
    {
        $prestasi_dosen = PrestasiDosen::findOrfail($id);

        $request->validate([
            'nip' => 'required | int',
            'judul_prestasi' => 'required',
            'tingkat' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,jpeg,jpg,png|max:10000'
        ]);

        $prestasi_dosen->dosen_id = $request->input('dosen_id');
        $prestasi_dosen->judul_prestasi = $request->input('judul_prestasi');
        $prestasi_dosen->tingkat = $request->input('tingkat');
        $prestasi_dosen->tahun = $request->input('tahun');
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

        return redirect('/upaya/prestasi')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('prestasi_dosen')->where('id', $id)->delete();
        return redirect()->back();
    }
}
