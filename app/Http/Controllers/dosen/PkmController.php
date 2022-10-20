<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\DataPkm;
use App\Models\Admin\DataPkmMhs;
use App\Models\Admin\SumberDana;
use App\Models\Admin\Dosen;
use App\Models\Admin\Mahasiswa;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;
use App\Notifications\VerifikasiDosen;
use App\Notifications\Deadline;
use Carbon\Carbon;

class PkmController extends Controller
{
    public function index()
    {
        $data_pkm = DataPkm::with(['pkm_mhs', 'dosen', 'sumberdana', 'pkm_mhs.biodata_mhs'])->where('jenis_pkm', '=', 1)
            ->where('data_pkm.dosen_id', \Auth::guard('dosen')->user()->dosen_id)->get();

        return view('dosen.publikasi.pkm.pkm', compact('data_pkm'));
    }

    public function create()
    {
        $data_pkm = DataPkm::get();
        $data_pkm_mhs = DataPkmMhs::get();
        $biodata_mhs = Mahasiswa::get();
        $dosen = Dosen::get();
        $sumber_dana = SumberDana::get();

        return view('dosen.publikasi.pkm.create', compact('data_pkm', 'biodata_mhs', 'dosen', 'sumber_dana'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'tema' => 'required',
            'judul_pkm' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,png,jpg,jpeg,zip|max:20000'
        ]);

        if (count(array($data['mhs_id'] > 0))) {
            $data_pkm = new DataPkm;
            $data_pkm->dosen_id = \Auth::guard('dosen')->user()->dosen_id;
            $data_pkm->user_id = \Auth::guard('dosen')->user()->user_id;
            $data_pkm->tema = $data['tema'];
            $data_pkm->judul_pkm = $data['judul_pkm'];
            $data_pkm->sumber_dana_id = $data['sumber_dana_id'];
            $data_pkm->jumlah_dana = $data['jumlah_dana'];
            $data_pkm->tahun = $data['tahun'];
            $data_pkm->jenis_pkm = 1;
            $data_pkm->is_verification = 1;
            $data_pkm->save();

            foreach ($data['mhs_id'] as $item => $value) {
                if ($value == null) {
                    continue;
                }
                $data_pkm_mhs = new DataPkmMhs();
                $data_pkm_mhs->data_pkm_id = $data_pkm->id;
                $data_pkm_mhs->mhs_id = $value;
                $data_pkm_mhs->save();
            }
        }

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $data_pkm->softcopy = $nama_file;

            $file->move(public_path() . '/file', $nama_file);
            $data_pkm->save();
        }

        return redirect('/publikasi/pkm')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Request $request, $id)
    {
        $data_pkm = DataPkm::findOrfail($id);
        $data_pkm_mhs = DataPkmMhs::get();
        $dosen = Dosen::get();
        $biodata_mhs = Mahasiswa::get();
        $sumber_dana = SumberDana::get();

        return view('dosen.publikasi.pkm.edit', compact('data_pkm', 'data_pkm_mhs', 'dosen', 'biodata_mhs', 'sumber_dana'));
    }

    public function update(Request $request, $id)
    {
        $data_pkm = DataPkm::findOrfail($id);

        $request->validate([
            'tema' => 'required',
            'judul_pkm' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf,png,jpg,jpeg,zip|max:20000'
        ]);

        $data = $request->all();
        $list_mhs_id = $data['mhs_id'] ?? [];

        DB::table('data_pkm_mhs')->where('data_pkm_id', '=', $data_pkm['id'] ?? 0)->whereNotIn('mhs_id', $list_mhs_id)->delete();

        $data_pkm->dosen_id = \Auth::guard('dosen')->user()->dosen_id;
        $data_pkm->user_id = \Auth::guard('dosen')->user()->user_id;
        $data_pkm->tema = $data['tema'];
        $data_pkm->judul_pkm = $data['judul_pkm'];
        $data_pkm->sumber_dana_id = $data['sumber_dana_id'];
        $data_pkm->jumlah_dana = $data['jumlah_dana'];
        $data_pkm->tahun = $data['tahun'];
        $data_pkm->jenis_pkm = 1;
        $data_pkm->is_verification = $request->is_verification == 'on' ? 1 : 0;
        $data_pkm->update();

        if (count($list_mhs_id) > 0) {
            foreach ($list_mhs_id as $item => $value) {
                if ($value == null) {
                    continue;
                }
                $data_pkm_mhs = DataPkmMhs::firstOrNew(['data_pkm_id' =>  $data_pkm->id, 'mhs_id' => $value]);
                $data_pkm_mhs->data_pkm_id = $data_pkm->id;
                $data_pkm_mhs->mhs_id = $value;
                $data_pkm_mhs->save();
            }
        } else {
            DataPkmMhs::where('data_pkm_id', $id)->forceDelete();
        }

        if ($request->softcopy != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = DataPkm::where('id', $request->id)->first();

            $path = $deletePath->softcopy;

            if ($data_pkm->softcopy != '' & $data_pkm->softcopy != null) {
                unlink(public_path('/file/') . $path);
            }

            $softcopy = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $softcopy->getClientOriginalExtension();
            $softcopy->move($path_baru, $nama_file);

            $data_pkm->update(['softcopy' => $nama_file]);
            $data_pkm->save();
        }

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan verifikasi data pkm',
                'url' => route('pkm.dosen.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/publikasi/pkm')->with(['edit' => 'Data PKM berhasil di ubah!']);
    }

    public function destroy($id)
    {
        DB::table('data_pkm')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function confirm(Request $request, $id)
    {
        DataPkm::findOrfail($id)
            ->update([
                'is_verification' => $request->is_verification == 'on' ? 0 : 1
            ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan verifikasi data pkm',
                'url' => route('pkm.dosen.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }
}
