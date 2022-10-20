<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Alumni;
use App\Models\Admin\MhsReguler;
use App\Models\Admin\Dosen;
use App\Models\Admin\KategoriJalur;
use App\Models\Admin\Jurusan;
use App\Models\Admin\KategoriStatus;
use App\Models\Admin\KategoriAsal;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\PembimbingTa;
use App\Models\Admin\JenisBimbingan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Validator;

class MhsRegController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mahasiswa()
    {
        return view('admin/mahasiswa/halaman-mhs');
    }

    public function index()
    {
        $biodata_mhs = MhsReguler::with(['data_pembimbing_ta', 'kategori_status_mhs', 'kategori_jalur', 'data_pembimbing_ta.dosen'])
            ->where('id_status', '1')->where('user_id', Auth::user()->kode_ps);
        if (request('withtrash') == 1) {
            $biodata_mhs = $biodata_mhs->whereNotNull('deleted_at')->withTrashed();
        }
        $biodata_mhs = $biodata_mhs->get();

        return view('admin.mahasiswa.mhs-reguler.mhs-reguler', compact('biodata_mhs'));
    }

    public function create(Request $request)
    {
        $dosen = Dosen::get();
        $kategori_jalur = KategoriJalur::get();
        $data_pembimbing_ta = PembimbingTa::get();
        $jurusan = Jurusan::get();
        $kategori_status_mhs = KategoriStatus::get();
        $kategori_asal = KategoriAsal::get();
        $jenis_bimbingan = DB::table('jenis_bimbingan')->get();

        return view('admin.mahasiswa.mhs-reguler.create', compact('dosen', 'kategori_jalur', 'kategori_status_mhs', 'kategori_asal', 'jenis_bimbingan', 'data_pembimbing_ta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'npm' => 'required | int | unique:biodata_mhs',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'asal_sekolah' => 'required',
            'asal_id' => 'required',
            'tahun_masuk' => 'required',
            'jalur_masuk_id' => 'required',
            'id_status' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i'
        ]);

        $data = $request->all();

        $nip_dosen = [
            $data['penguji1'] == '-' ? 'penguji1' : $data['penguji1'],
            $data['penguji2'] == '-' ? 'penguji2' : $data['penguji2'],
            $data['penguji3'] == '-' ? 'penguji3' : $data['penguji3'],
            $data['doping1'] == '-' ? 'doping1' : $data['doping1'],
            $data['doping2'] == '-' ? 'doping2' : $data['doping2']
        ];
        if (count(array_unique($nip_dosen)) < 5) {
            return redirect('/mahasiswa/reguler/')->with(['error' => 'Dosen Penguji atau Dosen Pembimbing tidak boleh sama!']);
        };


        $biodata_mhs = new MhsReguler();
        $biodata_mhs->user_id = \Auth::user()->kode_ps;
        $biodata_mhs->npm = $data['npm'];
        $biodata_mhs->nama = $data['nama'];
        $biodata_mhs->dosen_id = $data['dosen_id'];
        $biodata_mhs->jenis_kelamin = $data['jenis_kelamin'];
        $biodata_mhs->asal_sekolah = $data['asal_sekolah'];
        $biodata_mhs->asal_id = $data['asal_id'];
        $biodata_mhs->tahun_masuk = $data['tahun_masuk'];
        $biodata_mhs->jalur_masuk_id = $data['jalur_masuk_id'];
        $biodata_mhs->id_status = 1;
        $biodata_mhs->email = $data['email'];
        $biodata_mhs->ipk = $data['ipk'];
        $biodata_mhs->penguji1 = $data['penguji1'];
        $biodata_mhs->penguji2 = $data['penguji2'];
        $biodata_mhs->penguji3 = $data['penguji3'];
        $biodata_mhs->proposal = $data['proposal'];
        $biodata_mhs->hasil = $data['hasil'];
        $biodata_mhs->sidang = $data['sidang'];
        $biodata_mhs->tahun_keluar = $data['tahun_keluar'];
        $biodata_mhs->save();
        $data_pembimbing_ta = new PembimbingTa();
        $data_pembimbing_ta->user_id = \Auth::user()->kode_ps;
        $data_pembimbing_ta->mhs_id = $biodata_mhs->id;
        $data_pembimbing_ta->doping1 = $data['doping1'];
        $data_pembimbing_ta->doping2 = $data['doping2'];
        $data_pembimbing_ta->tahun = $data['tahun'];
        $data_pembimbing_ta->jenis_id1 = $data['jenis_id1'];
        $data_pembimbing_ta->jenis_id2 = $data['jenis_id2'];
        $data_pembimbing_ta->save();

        return redirect('/mahasiswa/reguler/')->with(['added' => 'Data Mahasiswa Reguler berhasil ditambahkan!']);
    }

    public function edit(MhsReguler $mhsReguler, $id)
    {
        $biodata_mhs = MhsReguler::findOrfail($id);
        $dosen['penguji1'] = Dosen::where('dosen_id', $biodata_mhs->penguji1)->first();
        $dosen['penguji2'] = Dosen::where('dosen_id', $biodata_mhs->penguji2)->first();
        $dosen['penguji3'] = Dosen::where('dosen_id', $biodata_mhs->penguji3)->first();
        $kategori_jalur = KategoriJalur::get();
        $jurusan = Jurusan::get();
        $kategori_status_mhs = KategoriStatus::get();
        $kategori_asal = KategoriAsal::get();
        $data_pembimbing_ta = DB::table('data_pembimbing_ta')->where('mhs_id', $biodata_mhs->id)->get();
        $jenis_bimbingan = JenisBimbingan::get();

        foreach ($data_pembimbing_ta as $item) {
            $data_pembimbing_ta['doping1'] = Dosen::where('dosen_id', $item->doping1)->get();
            $listdoping1[] = $data_pembimbing_ta['doping1'];

            $data_pembimbing_ta['doping2'] = Dosen::where('dosen_id', $item->doping2)->get();
            $listdoping2[] = $data_pembimbing_ta['doping2'];

            $data_pembimbing_ta['jenis_id1'] = JenisBimbingan::where('id', $item->jenis_id1)->get();
            $listjenis_id1[] = $data_pembimbing_ta['jenis_id1'] ?? '-';

            $data_pembimbing_ta['jenis_id2'] = JenisBimbingan::where('id', $item->jenis_id2)->get();
            $listjenis_id2[] = $data_pembimbing_ta['jenis_id2'] ?? '-';

            $data_tahun = PembimbingTa::where('id', $item->id)->get();
        }

        return view('admin.mahasiswa.mhs-reguler.edit', compact('biodata_mhs', 'dosen', 'kategori_jalur', 'jurusan', 'kategori_status_mhs', 'kategori_asal', 'data_pembimbing_ta', 'jenis_bimbingan'));
    }

    public function update(Request $request, MhsReguler $mhsReguler, $id)
    {
        $biodata_mhs = MhsReguler::findOrfail($id);

        $request->validate([
            'npm' => 'required | int',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'asal_sekolah' => 'required',
            'asal_id' => 'required',
            'tahun_masuk' => 'required',
            'jalur_masuk_id' => 'required',
            'id_status' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i'
        ]);

        $data = $request->all();

        $nip_dosen = [
            $data['penguji1'] == '-' ? 'penguji1' : $data['penguji1'],
            $data['penguji2'] == '-' ? 'penguji2' : $data['penguji2'],
            $data['penguji3'] == '-' ? 'penguji3' : $data['penguji3'],
            $data['doping1'] == '-' ? 'doping1' : $data['doping1'],
            $data['doping2'] == '-' ? 'doping2' : $data['doping2']
        ];
        if (count(array_unique($nip_dosen)) < 5) {
            return redirect('/mahasiswa/reguler/')->with(['error' => 'Dosen Penguji atau Dosen Pembimbing tidak boleh sama!']);
        };


        if ($request->tahun_keluar != null) {
            $biodata_mhs->delete();
            return $this->moveToAlumni($data);
        }

        $biodata_mhs->user_id = \Auth::user()->kode_ps;
        $biodata_mhs->npm = $data['npm'];
        $biodata_mhs->nama = $data['nama'];
        $biodata_mhs->dosen_id = $data['dosen_id'];
        $biodata_mhs->jenis_kelamin = $data['jenis_kelamin'];
        $biodata_mhs->asal_sekolah = $data['asal_sekolah'];
        $biodata_mhs->asal_id = $data['asal_id'];
        $biodata_mhs->tahun_masuk = $data['tahun_masuk'];
        $biodata_mhs->jalur_masuk_id = $data['jalur_masuk_id'];
        $biodata_mhs->id_status = 1;
        $biodata_mhs->email = $data['email'];
        $biodata_mhs->ipk = $data['ipk'];
        $biodata_mhs->penguji1 = $data['penguji1'];
        $biodata_mhs->penguji2 = $data['penguji2'];
        $biodata_mhs->penguji3 = $data['penguji3'];
        $biodata_mhs->proposal = $data['proposal'];
        $biodata_mhs->hasil = $data['hasil'];
        $biodata_mhs->sidang = $data['sidang'];
        $biodata_mhs->tahun_keluar = $data['tahun_keluar'];
        $biodata_mhs->save();
        $data_pembimbing_ta = PembimbingTa::firstOrNew(['mhs_id' => $biodata_mhs->id]);
        $data_pembimbing_ta->user_id = \Auth::user()->kode_ps;
        $data_pembimbing_ta->mhs_id = $biodata_mhs->id;
        $data_pembimbing_ta->doping1 = $data['doping1'];
        $data_pembimbing_ta->doping2 = $data['doping2'];
        $data_pembimbing_ta->tahun = $data['tahun'];
        $data_pembimbing_ta->jenis_id1 = $data['jenis_id1'];
        $data_pembimbing_ta->jenis_id2 = $data['jenis_id2'];
        $data_pembimbing_ta->save();

        return redirect('/mahasiswa/reguler')->with(['edit' => 'Data Mahasiswa Reguler berhasil diubah!']);
    }

    public function destroy($id)
    {
        $biodata_mhs = MhsReguler::where('id', $id)->withTrashed()->first();
        if ($biodata_mhs->deleted_at == null) {
            $biodata_mhs->delete();
        } else {
            $biodata_mhs->deleted_at = null;
            $biodata_mhs->save();
        }
        return redirect()->back();
    }

    private function moveToAlumni($data)
    {
        $newAlumni = new Alumni;
        $newAlumni->user_id = \Auth::user()->kode_ps;
        $newAlumni->npm = $data['npm'];
        $newAlumni->nama = $data['nama'];
        $newAlumni->tahun_masuk = $data['tahun_masuk'];
        $newAlumni->tahun_lulus = $data['tahun_keluar'];
        $newAlumni->ipk = $data['ipk'];
        $newAlumni->save();

        return redirect('/mahasiswa/reguler')->with(['edit' => 'Data Mahasiswa Reguler berhasil dipindahkan ke Data Alumni!']);
    }

    public function detail(MhsReguler $mhsReguler, $id)
    {
        $biodata_mhs = MhsReguler::withTrashed()->findOrfail($id);

        $dosen['penguji1'] = Dosen::where('dosen_id', $biodata_mhs->penguji1)->first();
        $dosen['penguji2'] = Dosen::where('dosen_id', $biodata_mhs->penguji2)->first();
        $dosen['penguji3'] = Dosen::where('dosen_id', $biodata_mhs->penguji3)->first();
        $kategori_jalur = KategoriJalur::get();
        $jurusan = Jurusan::get();
        $kategori_status_mhs = KategoriStatus::get();
        $kategori_asal = KategoriAsal::get();
        $data_pembimbing_ta = DB::table('data_pembimbing_ta')->where('mhs_id', $biodata_mhs->id)->get();

        foreach ($data_pembimbing_ta as $item) {
            $data_pembimbing_ta['doping1'] = Dosen::where('dosen_id', $item->doping1)->select('nama_dosen')->get();
            $listdoping1[] = $data_pembimbing_ta['doping1'];

            $data_pembimbing_ta['doping2'] = Dosen::where('dosen_id', $item->doping2)->select('nama_dosen')->get();
            $listdoping2[] = $data_pembimbing_ta['doping2'];
        }

        return view('admin.mahasiswa.mhs-reguler.detail', compact('biodata_mhs', 'dosen', 'kategori_jalur', 'kategori_status_mhs', 'data_pembimbing_ta'));
    }
}
