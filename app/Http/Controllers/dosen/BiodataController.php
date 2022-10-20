<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dosen;
use App\Models\Admin\JenisDosen;
use App\Models\Admin\KategoriJabatan;
use App\Models\Admin\KategoriPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\VerifikasiDosen;
use App\User;
use Auth;
use Validator;

class BiodataController extends Controller
{
    public function dashboard()
    {
        return view('dosen.layout.dashboard-dosen');
    }

    public function index()
    {
        $dosen = Dosen::with('jabatan_fungsional')
            ->where('dosen.dosen_id', \Auth::guard('dosen')->user()->dosen_id)->get();

        // dd($dosen);
        return view('dosen.biodata.biodata', compact('jabatan_fungsional', 'dosen'));
    }

    public function edit()
    {
        $dosen = Dosen::get();
        $jabatan_fungsional = KategoriJabatan::get();

        return view('dosen.biodata.edit', compact('jabatan_fungsional', 'dosen'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tempat' => 'required',
            'tgl_lahir' => 'required',
            'nip' => 'required',
            'nidn' => 'required',
            'email' => 'required',
            'bidang' => 'required',
            'jabatan_id' => 'required',
            'golongan' => 'required',
            'pend_s1' => 'required',
            'pend_s2' => 'required',
            'password' => 'required'
        ]);

        $request->user()->update(
            $request->all()
        );

        try {
            // Get admin prodi pada dosen
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan update data biodata',
                'url' => route('dosen.tetap.biodata.index', ['tablesearch' => Auth::user()->nip]),
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/biodata')->with(['edit' => 'Data Berhasil Diubah']);
    }
}
