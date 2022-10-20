<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AktivitasTetap;
use App\Models\Admin\AktivitasDosen;
use App\Models\Admin\DosenTetap;
use App\Models\Admin\Dosen;
use App\Models\Admin\JenisDosen;
use App\Models\Admin\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Notifications\Deadline;
use Auth;
use Validator;
use Carbon\Carbon;
use App\Notifications\VerifikasiDosen;

class AktivitasTetapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //method construct di jalankan pertama kali
    }

    public function index() //function index
    {
        $aktivitas = AktivitasTetap::with(['aktivitas_dosen', 'aktivitas_dosen.kurikulum', 'dosen'])->whereHas('dosen', function ($q) {
            $q->where('jenis_dosen', 1);
        })->where('aktivitas.user_id', Auth::user()->kode_ps)->get();

        return view('admin.dosen-tetap.aktivitas.aktivitas-dosen-tetap', compact('aktivitas'));
    }

    public function create()
    {
        $aktivitas = AktivitasTetap::get();
        $dosen = DosenTetap::get();
        $kategori_jenis_dosen = JenisDosen::get();
        return view('admin.dosen-tetap.aktivitas.create', compact('aktivitas', 'kategori_jenis_dosen', 'dosen'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        if (count(array($data['kode_mk'] > 0))) {
            $aktivitas = new AktivitasTetap(); //instansiasi class AktivitasTetap
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

        return redirect('/dosen/tetap/aktivitas')->with(['added' => 'Data Berhasil Ditambahkan']);
    }

    public function edit(AktivitasTetap $aktivitasTetap, $id)
    {
        $aktivitas = AktivitasTetap::findOrfail($id);
        $aktivitas_dosen = AktivitasDosen::get();
        $dosen = Dosen::get();
        $kategori_jenis_dosen = JenisDosen::get();
        $kurikulum = Kurikulum::get();


        return view('admin.dosen-tetap.aktivitas.edit', compact('aktivitas', 'kategori_jenis_dosen', 'dosen', 'kurikulum', 'aktivitas_dosen'));
    }

    public function update(Request $request, AktivitasTetap $aktivitasTetap, $id)
    {

        $aktivitas = AktivitasTetap::findOrfail($id);

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

        return redirect('/dosen/tetap/aktivitas')->with(['edit' => 'Data Berhasil Diubah']);
    }

    public function destroy($id)
    {
        DB::table('aktivitas')->where('id', $id)->delete();
        return redirect()->back();
    }
}
