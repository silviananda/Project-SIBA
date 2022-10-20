<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\AktivitasTetap;
use App\Models\Admin\AktivitasDosen;
use App\Models\Admin\Dosen;
use App\Models\Admin\Kurikulum;
use App\Models\Admin\JenisDosen;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Notifications\VerifikasiDosen;

class AktivitasDosenController extends Controller
{

    public function index()
    {
        $aktivitas = AktivitasTetap::with(['aktivitas_dosen', 'aktivitas_dosen.kurikulum', 'dosen'])->where('aktivitas.dosen_id', Auth::guard('dosen')->user()->dosen_id)->get();


        return view('dosen.aktivitas.aktivitas-dosen', compact('aktivitas', 'aktivitas_dosen', 'kategori_jenis_dosen', 'dosen', 'listmk1', 'listmk2'));
    }

    public function create()
    {
        $aktivitas = AktivitasTetap::get();
        $dosen = Dosen::get();

        return view('dosen.aktivitas.create', compact('aktivitas', 'dosen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ket[]' => 'required',
            'kode_mk[]' => 'required',
            'tahun' => 'required',
        ]);

        $data = $request->all();

        if (count(array($data['kode_mk'] > 0))) {
            $aktivitas = new AktivitasTetap();
            $aktivitas->dosen_id = \Auth::guard('dosen')->user()->dosen_id;
            $aktivitas->user_id = \Auth::guard('dosen')->user()->user_id;
            $aktivitas->sks_penelitian = $data['sks_penelitian'];
            $aktivitas->sks_p2m = $data['sks_p2m'];
            $aktivitas->m_pt_sendiri = $data['m_pt_sendiri'];
            $aktivitas->tahun = $data['tahun'];
            $aktivitas->is_verification = 1;
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

        return redirect('/aktivitas')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(AktivitasTetap $aktivitasTetap, $id)
    {
        $aktivitas = AktivitasTetap::findOrfail($id);
        $aktivitas_dosen = AktivitasDosen::get();
        $dosen = Dosen::get();
        $kategori_jenis_dosen = JenisDosen::get();
        $kurikulum = Kurikulum::get();

        return view('dosen.aktivitas.edit', compact('aktivitas', 'dosen', 'kurikulum', 'aktivitas_dosen'));
    }

    public function update(Request $request, $id)
    {
        $aktivitas = AktivitasTetap::findOrfail($id);

        $data = $request->all();
        $list_kode_id = $data['kode_mk'] ?? [];

        DB::table('aktivitas_dosen')->where('aktivitas_id', '=', $aktivitas['id'] ?? 0)->whereNotIn('kode_mk', $list_kode_id)->delete();

        $aktivitas->dosen_id  = \Auth::guard('dosen')->user()->dosen_id;
        $aktivitas->user_id = \Auth::guard('dosen')->user()->user_id;
        $aktivitas->sks_penelitian = $data['sks_penelitian'];
        $aktivitas->sks_p2m = $data['sks_p2m'];
        $aktivitas->m_pt_sendiri = $data['m_pt_sendiri'];
        $aktivitas->tahun = $data['tahun'];
        $aktivitas->is_verification = $request->is_verification == 'on' ? 1 : 0;
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

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        try {
            // Get admin prodi pada dosen
            $admin = User::select('id')->where('kode_ps', Auth::guard('dosen')->user()->user_id)->first();

            $admin->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->nama_dosen,
                'pesan' => 'Telah melakukan update data aktivitas',
                'url' => route('dosen.tetap.aktivitas.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/aktivitas')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('aktivitas')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function confirm(Request $request, $id)
    {
        AktivitasTetap::findOrfail($id)
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
                'pesan' => 'Telah melakukan verifikasi data aktivitas',
                'url' => route('dosen.tetap.aktivitas.index', ['tablesearch' => Auth::user()->nip]),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }
}
