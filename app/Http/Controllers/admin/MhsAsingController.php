<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Alumni;
use App\Models\Admin\MhsReguler;
use App\Models\Admin\Dosen;
use App\Models\Admin\KategoriJalur;
use App\Models\Admin\Jurusan;
use App\Models\Admin\KategoriStatus;
use App\Models\Admin\KategoriAsal;
use App\Models\Admin\PembimbingTa;
use App\Models\Admin\JenisBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Validator;

class MhsAsingController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mahasiswa_asing()
    {
        return view('admin/mahasiswa-asing/halaman-mhs-asing');
    }

    public function index()
    {


        $mhs_asing = MhsReguler::with(['data_pembimbing_ta', 'kategori_jalur', 'data_pembimbing_ta.dosen'])->where('id_status', '3')->where('user_id', Auth::user()->kode_ps);
        if (request('withtrash') == 1) {
            $mhs_asing = $mhs_asing->whereNotNull('deleted_at')->withTrashed();
        }
        $mhs_asing = $mhs_asing->get();

        return view('admin.mahasiswa-asing.mhs-asing.mhs-asing', compact('mhs_asing', 'dosen'));
    }

    public function create()
    {
        $dosen = Dosen::get();
        $kategori_jalur = KategoriJalur::get();
        $data_pembimbing_ta = PembimbingTa::get();
        $jurusan = Jurusan::get();
        $kategori_status_mhs = KategoriStatus::get();
        $kategori_asal = KategoriAsal::get();
        $jenis_bimbingan = DB::table('jenis_bimbingan')->get();

        return view('admin.mahasiswa-asing.mhs-asing.create', compact('biodata_dosen', 'dosen', 'kategori_jalur', 'kategori_status_mhs', 'kategori_asal', 'jenis_bimbingan', 'data_pembimbing_ta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'npm' => 'required | int | unique:mhs_asing',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tahun_masuk' => 'required',
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
            return redirect('/mahasiswa-asing/biodata')->with(['error' => 'Dosen Penguji atau Dosen Pembimbing tidak boleh sama!']);
        };

        $mhs_asing = new MhsReguler();
        $mhs_asing->user_id = \Auth::user()->kode_ps;
        $mhs_asing->npm = $data['npm'];
        $mhs_asing->nama = $data['nama'];
        $mhs_asing->dosen_id = $data['dosen_id'];
        $mhs_asing->jenis_kelamin = $data['jenis_kelamin'];
        $mhs_asing->asal_sekolah = $data['asal_sekolah'];
        $mhs_asing->asal_id = 2;
        $mhs_asing->tahun_masuk = $data['tahun_masuk'];
        $mhs_asing->jalur_masuk_id = 5;
        $mhs_asing->id_status = 3;
        $mhs_asing->email = $data['email'];
        $mhs_asing->ipk = $data['ipk'];
        $mhs_asing->penguji1 = $data['penguji1'];
        $mhs_asing->penguji2 = $data['penguji2'];
        $mhs_asing->penguji3 = $data['penguji3'];
        $mhs_asing->proposal = $data['proposal'];
        $mhs_asing->hasil = $data['hasil'];
        $mhs_asing->sidang = $data['sidang'];
        $mhs_asing->tahun_keluar = $data['tahun_keluar'];
        $mhs_asing->save();
        $data_pembimbing_ta = new PembimbingTa();
        $data_pembimbing_ta->user_id = \Auth::user()->kode_ps;
        $data_pembimbing_ta->mhs_id = $mhs_asing->id;
        $data_pembimbing_ta->doping1 = $data['doping1'];
        $data_pembimbing_ta->doping2 = $data['doping2'];
        $data_pembimbing_ta->tahun = $data['tahun'];
        $data_pembimbing_ta->jenis_id1 = $data['jenis_id1'];
        $data_pembimbing_ta->jenis_id2 = $data['jenis_id2'];
        $data_pembimbing_ta->save();

        return redirect('/mahasiswa-asing/biodata')->with(['added' => 'Data Mahasiswa Asing berhasil ditambahkan!']);
    }

    public function edit(MhsReguler $mhsReguler, $id)
    {
        $mhs_asing = MhsReguler::findOrfail($id);
        $dosen['penguji1'] = Dosen::where('dosen_id', $mhs_asing->penguji1)->first();
        $dosen['penguji2'] = Dosen::where('dosen_id', $mhs_asing->penguji2)->first();
        $dosen['penguji3'] = Dosen::where('dosen_id', $mhs_asing->penguji3)->first();
        $kategori_jalur = KategoriJalur::get();
        $jurusan = Jurusan::get();
        $kategori_status_mhs = KategoriStatus::get();
        $kategori_asal = KategoriAsal::get();
        $data_pembimbing_ta = DB::table('data_pembimbing_ta')->where('mhs_id', $mhs_asing->id)->get();
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

        return view('admin.mahasiswa-asing.mhs-asing.edit', compact('mhs_asing', 'dosen', 'kategori_jalur', 'jurusan', 'kategori_status_mhs', 'kategori_asal', 'data_pembimbing_ta', 'listdoping1', 'listdoping2', 'item', 'listjenis_id1', 'listjenis_id2', 'jenis_bimbingan', 'data_tahun'));
    }

    public function update(Request $request, MhsReguler $mhsReguler, $id)
    {
        $mhs_asing = MhsReguler::findOrfail($id);

        $request->validate([
            'npm' => 'required | int',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tahun_masuk' => 'required',
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
            return redirect('/mahasiswa-asing/biodata')->with(['error' => 'Dosen Penguji atau Dosen Pembimbing tidak boleh sama!']);
        };

        if ($request->tahun_keluar != null) {
            $mhs_asing->delete();
            return $this->moveToAlumni($data);
        }

        $mhs_asing->user_id = \Auth::user()->kode_ps;
        $mhs_asing->npm = $data['npm'];
        $mhs_asing->nama = $data['nama'];
        $mhs_asing->dosen_id = $data['dosen_id'];
        $mhs_asing->jenis_kelamin = $data['jenis_kelamin'];
        $mhs_asing->asal_sekolah = $data['asal_sekolah'];
        $mhs_asing->asal_id = 2;
        $mhs_asing->tahun_masuk = $data['tahun_masuk'];
        $mhs_asing->jalur_masuk_id = 5;
        $mhs_asing->id_status = 3;
        $mhs_asing->email = $data['email'];
        $mhs_asing->ipk = $data['ipk'];
        $mhs_asing->penguji1 = $data['penguji1'];
        $mhs_asing->penguji2 = $data['penguji2'];
        $mhs_asing->penguji3 = $data['penguji3'];
        $mhs_asing->proposal = $data['proposal'];
        $mhs_asing->hasil = $data['hasil'];
        $mhs_asing->sidang = $data['sidang'];
        $mhs_asing->tahun_keluar = $data['tahun_keluar'];
        $mhs_asing->save();
        $data_pembimbing_ta = PembimbingTa::firstOrNew(['mhs_id' => $mhs_asing->id]);
        $data_pembimbing_ta->user_id = \Auth::user()->kode_ps;
        $data_pembimbing_ta->mhs_id = $mhs_asing->id;
        $data_pembimbing_ta->doping1 = $data['doping1'];
        $data_pembimbing_ta->doping2 = $data['doping2'];
        $data_pembimbing_ta->tahun = $data['tahun'];
        $data_pembimbing_ta->jenis_id1 = $data['jenis_id1'];
        $data_pembimbing_ta->jenis_id2 = $data['jenis_id2'];
        $data_pembimbing_ta->save();

        return redirect('/mahasiswa-asing/biodata')->with(['edit' => 'Data Mahasiswa Asing berhasil diubah!']);
    }

    public function destroy(MhsReguler $mhsReguler, $id)
    {
        $mhs_asing = MhsReguler::where('id', $id)->withTrashed()->first();
        if ($mhs_asing->deleted_at == null) {
            $mhs_asing->delete();
        } else {
            $mhs_asing->deleted_at = null;
            $mhs_asing->save();
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

        return redirect('/mahasiswa-asing/biodata')->with(['edit' => 'Data Mahasiswa Non Reguler berhasil dipindahkan ke Data Alumni!']);
    }

    public function detail(MhsReguler $mhsReguler, $id)
    {
        $mhs_asing = MhsReguler::withTrashed()->findOrfail($id);
        $dosen['penguji1'] = Dosen::where('dosen_id', $mhs_asing->penguji1)->first();
        $dosen['penguji2'] = Dosen::where('dosen_id', $mhs_asing->penguji2)->first();
        $dosen['penguji3'] = Dosen::where('dosen_id', $mhs_asing->penguji3)->first();
        $kategori_jalur = KategoriJalur::get();
        $jurusan = Jurusan::get();
        $kategori_status_mhs = KategoriStatus::get();
        $kategori_asal = KategoriAsal::get();
        $data_pembimbing_ta = DB::table('data_pembimbing_ta')->where('mhs_id', $mhs_asing->id)->get();

        foreach ($data_pembimbing_ta as $item) {
            $data_pembimbing_ta['doping1'] = Dosen::where('dosen_id', $item->doping1)->select('nama_dosen')->get();
            $listdoping1[] = $data_pembimbing_ta['doping1'];

            $data_pembimbing_ta['doping2'] = Dosen::where('dosen_id', $item->doping2)->select('nama_dosen')->get();
            $listdoping2[] = $data_pembimbing_ta['doping2'];
        }

        return view('admin..mahasiswa-asing.mhs-asing.detail', compact('mhs_asing', 'dosen', 'kategori_jalur', 'kategori_status_mhs', 'listdoping1', 'listdoping2', 'data_pembimbing_ta'));
    }
}
