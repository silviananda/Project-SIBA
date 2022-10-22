<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dosen;
use App\Models\Admin\DosenTetap;
use App\Models\Admin\JenisDosen;
use App\Models\Admin\KategoriJabatan;
use App\Models\Admin\KategoriPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use Validator;

class DosenTetapController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dosen_tetap()
    {
        return view('admin/dosen-tetap/halaman-dsn-tetap');
    }

    public function index()
    {
        $dosen = DosenTetap::with('jenis_dosen', 'jabatan_fungsional', 'kategori_pendidikan')->where('jenis_dosen', '1')->where('user_id', Auth::user()->kode_ps);

        if (request('withtrash') == 1) {
            $dosen = $dosen->whereNotNull('deleted_at')->withTrashed();
        }
        $dosen = $dosen->get();

        return view('admin.dosen-tetap.biodata.biodata-dosen-tetap', compact('jenis_dosen', 'dosen', 'jabatan_fungsional', 'kategori_pendidikan'));
    }

    public function create()
    {
        $dosen = DosenTetap::get();
        $kategori_jenis_dosen = JenisDosen::get();
        $jabatan_fungsional = KategoriJabatan::get();
        $kategori_pendidikan = KategoriPendidikan::get();
        return view('admin.dosen-tetap.biodata.create', compact('kategori_jenis_dosen', 'dosen', 'jabatan_fungsional', 'kategori_pendidikan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required | int | unique:dosen',
            'nama_dosen' => 'required',
            'jabatan_id' => 'required',
            'pendidikan_id' => 'required',
            'golongan' => 'required',
            'tempat' => 'required',
            'sertifikat_pendidik' => 'required',
            'tgl_lahir' => 'required',
            'jenis_dosen' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i'
        ]);

        // return $request;

        DB::table('dosen')->insert([
            'user_id' => Auth::user()->kode_ps,
            'nidn' => $request->nidn,
            'nip' => $request->nip,
            'nama_dosen' => $request->nama_dosen,
            'jabatan_id' => $request->jabatan_id,
            'pendidikan_id' => $request->pendidikan_id,
            'bidang' => $request->bidang,
            'sinta' => $request->sinta,
            'wos' => $request->wos,
            'scopus' => $request->scopus,
            'sertifikasi' => $request->sertifikasi,
            'sertifikat_pendidik' => $request->sertifikat_pendidik,
            'sertifikat_kompetensi' => $request->sertifikat_kompetensi,
            'pend_s2' => $request->pend_s2,
            'pend_s3' => $request->pend_s3,
            'golongan' => $request->golongan,
            'tempat' => $request->tempat,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_dosen' => $request->jenis_dosen,
            'email' => $request->email
        ]);

        return redirect('/dosen/tetap/biodata')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(DosenTetap $dosenTetap, $dosen_id)
    {
        $dosen = DosenTetap::findOrfail($dosen_id);
        $kategori_jenis_dosen = JenisDosen::get();
        $jabatan_fungsional = KategoriJabatan::get();
        $kategori_pendidikan = KategoriPendidikan::get();

        return view('admin.dosen-tetap.biodata.edit', compact('kategori_jenis_dosen', 'dosen', 'jabatan_fungsional', 'kategori_pendidikan'));
    }

    public function update(Request $request, DosenTetap $dosenTetap, $dosen_id)
    {
        // return $request;
        $request->validate([
            'nip' => 'required | int',
            'nama_dosen' => 'required',
            'jabatan_id' => 'required',
            'pendidikan_id' => 'required',
            'golongan' => 'required',
            'tempat' => 'required',
            'sertifikat_pendidik' => 'required',
            'tgl_lahir' => 'required',
            'jenis_dosen' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i'
        ]);

        DosenTetap::findOrfail($dosen_id)
            ->update([
                'nidn' => $request->nidn,
                'nip' => $request->nip,
                'jabatan_id' => $request->jabatan_id,
                'pendidikan_id' => $request->pendidikan_id,
                'bidang' => $request->bidang,
                'sinta' => $request->sinta,
                'wos' => $request->wos,
                'scopus' => $request->scopus,
                'sertifikasi' => $request->sertifikasi,
                'sertifikat_pendidik' => $request->sertifikat_pendidik,
                'sertifikat_kompetensi' => $request->sertifikat_kompetensi,
                'pend_s2' => $request->pend_s2,
                'pend_s3' => $request->pend_s3,
                'golongan' => $request->golongan,
                'tempat' => $request->tempat,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_dosen' => $request->jenis_dosen
            ]);

        return redirect('/dosen/tetap/biodata')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($dosen_id)
    {
        $dosen = DosenTetap::where('dosen_id', $dosen_id)->withTrashed()->first();
        if ($dosen->deleted_at == null) {
            $dosen->delete();
        } else {
            $dosen->deleted_at = null;
            $dosen->save();
        }
        return redirect()->back();
    }
}
