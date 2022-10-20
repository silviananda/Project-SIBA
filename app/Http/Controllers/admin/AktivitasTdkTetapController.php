<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AktivitasTdkTetap;
use App\Models\Admin\AktivitasDosen;
use App\Models\Admin\DosenTdkTetap;
use App\Models\Admin\Dosen;
use App\Models\Admin\JenisDosen;
use App\Models\Admin\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Notifications\Deadline;
use Carbon\Carbon;
use Auth;
use Validator;
use App\Notifications\VerifikasiDosen;

class AktivitasTdkTetapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aktivitas = AktivitasTdkTetap::with(['aktivitas_dosen', 'aktivitas_dosen.kurikulum', 'dosen'])->whereHas('dosen', function ($q) {
            $q->where('jenis_dosen', 2);
        })->where('aktivitas.user_id', Auth::user()->kode_ps)->get();

        return view('admin.dosen-tdk-tetap.aktivitas-tdk-tetap.aktivitas-tdk-tetap', compact('aktivitas'));
    }

    public function create()
    {
        $dosen = DosenTdkTetap::get();
        $kategori_jenis_dosen = JenisDosen::get();
        $aktivitas = AktivitasTdkTetap::get();
        $aktivitas_dosen = AktivitasDosen::get();

        return view('admin.dosen-tdk-tetap.aktivitas-tdk-tetap.create', compact('aktivitas', 'aktivitas_dosen', 'dosen'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'nip' => 'required',
        //     'dosen_id' => 'required',
        //     'kode_mk' => 'required',
        //     'ket' => 'required',
        // ]);

        $data = $request->all();

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        if (count(array($data['kode_mk'] > 0))) {
            $aktivitas = new AktivitasTdkTetap();
            $aktivitas->user_id = \Auth::user()->kode_ps;
            $aktivitas->dosen_id = $data['dosen_id'];
            $aktivitas->sks_penelitian = $data['sks_penelitian'];
            $aktivitas->sks_p2m = $data['sks_p2m'];
            $aktivitas->m_pt_sendiri = $data['m_pt_sendiri'];
            $aktivitas->tanggal_create = $date1;
            $aktivitas->tahun = $data['tahun'];
            $aktivitas->deadline = $data['deadline'];
            $aktivitas->save();
            foreach ($data['kode_mk'] as $item1 => $value) {
                $aktivitas_dosen = new AktivitasDosen();
                $aktivitas_dosen->aktivitas_id = $aktivitas->id;
                $aktivitas_dosen->kode_mk = $value;
                $aktivitas_dosen->bobot_sks = $data['bobot_sks'][$item1];
                $aktivitas_dosen->ket = $data['ket'][$item1];
                $aktivitas_dosen->save();
            }
        }

        try {
            // Get admin prodi pada dosen
            $dosen = Dosen::find($request->dosen_id);

            $dosen->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->name,
                'pesan' => 'Telah mengirim data aktivitas untuk di verifikasi',
                'url' => route('aktivitas.index'),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        // return $request;
        return redirect('/dosen/tidak-tetap/aktivitas')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(AktivitasTdkTetap $aktivitasTdkTetap, $id)
    {
        $aktivitas = AktivitasTdkTetap::findOrfail($id);
        $aktivitas_dosen = AktivitasDosen::get();
        $dosen = Dosen::get();
        $kategori_jenis_dosen = JenisDosen::get();
        $kurikulum = Kurikulum::get();

        return view('admin.dosen-tdk-tetap.aktivitas-tdk-tetap.edit', compact('aktivitas', 'kategori_jenis_dosen', 'dosen', 'kurikulum'));
    }

    public function update(Request $request, AktivitasTdkTetap $aktivitasTdkTetap, $id)
    {
        $aktivitas = AktivitasTdkTetap::findOrfail($id);

        $data = $request->all();
        $list_kode_id = $data['kode_mk'] ?? [];
        DB::table('aktivitas_dosen')->where('aktivitas_id', '=', $aktivitas['id'] ?? 0)->whereNotIn('kode_mk', $list_kode_id)->delete();

        $aktivitas->dosen_id  = $data['dosen_id'];
        $aktivitas->user_id = \Auth::user()->kode_ps;
        $aktivitas->sks_penelitian = $data['sks_penelitian'];
        $aktivitas->sks_p2m = $data['sks_p2m'];
        $aktivitas->m_pt_sendiri = $data['m_pt_sendiri'];
        $aktivitas->tahun = $data['tahun'];
        $aktivitas->save();
        if (count($list_kode_id) > 0) {
            foreach ($list_kode_id as $item1 => $value) {
                $aktivitas_dosen = AktivitasDosen::firstOrNew(['aktivitas_id' => $aktivitas->id, 'kode_mk' => $value]);
                $aktivitas_dosen->aktivitas_id = $aktivitas->id;
                $aktivitas_dosen->kode_mk = $value;
                $aktivitas_dosen->bobot_sks = $data['bobot_sks'][$item1];
                $aktivitas_dosen->ket = $data['ket'][$item1];
                $aktivitas_dosen->save();
            }
        } else {
            AktivitasDosen::where('aktivitas_id', $id)->forceDelete();
        }

        return redirect('/dosen/tidak-tetap/aktivitas')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('aktivitas')->where('id', $id)->delete();
        return redirect()->back();
    }
}
