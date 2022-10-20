<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Admin\DataPenelitian;
use App\Models\Admin\PenelitianMhs;
use App\Models\Admin\Dosen;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Illuminate\Validation\Rules\NotIn;
use Validator;
use App\Notifications\VerifikasiDosen;
use App\Notifications\Deadline;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;

class PenelitianController extends Controller
{
    public function index()
    {
        $data_penelitian = DataPenelitian::with(['penelitianmhs', 'dosen', 'penelitianmhs.mahasiswa'])
            ->where('data_penelitian.jenis_penelitian', '=', 1)
            ->where('data_penelitian.dosen_id', \Auth::guard('dosen')->user()->dosen_id)->get();

        // dd($data_penelitian);
        return view('dosen.publikasi.penelitian.penelitian', compact('data_penelitian', 'biodata_mhs'));
    }

    public function create()
    {
        $data_penelitian = DataPenelitian::get();
        $data_penelitian_mhs = PenelitianMhs::get();
        $dosen = Dosen::get();
        $biodata_mhs = Mahasiswa::get();
        $sumber_dana = SumberDana::get();

        return view('dosen.publikasi.penelitian.create', compact('data_penelitian_mhs', 'data_penelitian', 'dosen', 'biodata_mhs', 'sumber_dana'));
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'tema' => 'required',
            'judul_penelitian' => 'required',
            'tahun_penelitian' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf|max:20000'
        ]);

        if (count(array($data['mhs_id'] > 0))) {
            $data_penelitian = new DataPenelitian();
            $data_penelitian->dosen_id = \Auth::guard('dosen')->user()->dosen_id;
            $data_penelitian->user_id = \Auth::guard('dosen')->user()->user_id;
            $data_penelitian->tema = $data['tema'];
            $data_penelitian->sumber_dana_id = $data['sumber_dana_id'];
            $data_penelitian->jumlah_dana = $data['jumlah_dana'];
            $data_penelitian->judul_penelitian = $data['judul_penelitian'];
            $data_penelitian->tahun_penelitian = $data['tahun_penelitian'];
            $data_penelitian->jenis_penelitian = 1;
            $data_penelitian->is_verification = 1;
            $data_penelitian->save();
            foreach ($data['mhs_id'] as $item => $value) {
                $data_penelitian_mhs = new PenelitianMhs();
                $data_penelitian_mhs->data_penelitian_id = $data_penelitian->id;
                $data_penelitian_mhs->mhs_id = $value;
                $data_penelitian_mhs->save();
            }
        }

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $data_penelitian->softcopy = $nama_file;

            $file->move(public_path() . '/file', $nama_file);
            $data_penelitian->save();
        }


        return redirect('/publikasi/penelitian')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(Request $request, $id)
    {
        $data_penelitian = DataPenelitian::findOrfail($id);
        $sumber_dana = SumberDana::get();
        $data_penelitian_mhs = PenelitianMhs::get();
        $dosen = Dosen::get();
        $biodata_mhs = Mahasiswa::get();

        return view('dosen.publikasi.penelitian.edit', compact('data_penelitian', 'data_penelitian_mhs', 'dosen', 'sumber_dana'));
    }

    public function update(Request $request, $id)
    {
        $data_penelitian = DataPenelitian::findOrfail($id);

        $request->validate([
            'tema' => 'required',
            'judul_penelitian' => 'required',
            'tahun_penelitian' => 'required',
            'softcopy' => 'file|mimes:docx,doc,pdf|max:20000'
        ]);

        $data = $request->all();
        $list_mhs_id = $data['mhs_id'] ?? [];

        // dd($data_penelitian);
        DB::table('data_penelitian_mhs')->where('data_penelitian_id', '=', $data_penelitian['id'] ?? 0)->whereNotIn('mhs_id', $list_mhs_id)->delete();

        $data_penelitian->dosen_id = \Auth::guard('dosen')->user()->dosen_id;
        $data_penelitian->user_id = \Auth::guard('dosen')->user()->user_id;
        $data_penelitian->tema = $data['tema'];
        $data_penelitian->sumber_dana_id = $data['sumber_dana_id'];
        $data_penelitian->jumlah_dana = $data['jumlah_dana'];
        $data_penelitian->judul_penelitian = $data['judul_penelitian'];
        $data_penelitian->tahun_penelitian = $data['tahun_penelitian'];
        $data_penelitian->jenis_penelitian = 1;
        $data_penelitian->is_verification = $request->is_verification == 'on' ? 1 : 0;
        $data_penelitian->save();

        if ($request->softcopy != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = DataPenelitian::where('id', $request->id)->first();

            $path = $deletePath->softcopy;

            if ($data_penelitian->softcopy != '' & $data_penelitian->softcopy != null) {
                unlink(public_path('/file/') . $path);
            }
            $softcopy = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $softcopy->getClientOriginalExtension();
            $softcopy->move($path_baru, $nama_file);

            $data_penelitian->update(['softcopy' => $nama_file]);
            $data_penelitian->save();
        }

        if (count($list_mhs_id) > 0) {
            foreach ($list_mhs_id as $item => $value) {
                $data_penelitian_mhs = PenelitianMhs::firstOrNew(['data_penelitian_id' =>  $data_penelitian->id, 'mhs_id' => $value]);
                $data_penelitian_mhs->data_penelitian_id = $data_penelitian->id;
                $data_penelitian_mhs->mhs_id = $value;
                $data_penelitian_mhs->save();
            }
        } else {
            PenelitianMhs::where('data_penelitian_id', $id)->forceDelete();
        }

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            // Get admin prodi pada dosen
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan verifikasi data penelitian',
                'url' => route('penelitian.dosen.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }


        return redirect('/publikasi/penelitian')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('data_penelitian')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function confirm(Request $request, $id)
    {
        DataPenelitian::findOrfail($id)
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
                'pesan' => 'Telah melakukan verifikasi data penelitian',
                'url' => route('penelitian.dosen.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }
}
