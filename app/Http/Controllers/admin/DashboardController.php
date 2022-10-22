<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\KategoriJalur;
use App\Models\Admin\KategoriTingkat;
use App\Models\Admin\KaryaIlmiahDsn;
use App\Models\Admin\Pendaftar;
use App\Models\Admin\Alumni;
use App\Models\Admin\MhsReguler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // grafik pendaftar pertahun
        $pendaftar = Pendaftar::get();
        $kategori_jalur = KategoriJalur::get();

        $snmptn = Pendaftar::select(
            'kategori_jalur.jalur_masuk',
            \DB::raw("COUNT(pendaftar.id) as count")
        )
            ->join('kategori_jalur', 'pendaftar.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->where('jalur_masuk_id', '=', 1)
            ->where('pendaftar.user_id', Auth::user()->kode_ps)
            ->orderBy('tahun_masuk', 'ASC')
            ->groupBy(\DB::raw("tahun_masuk"))
            ->pluck('count');

        $sbmptn = Pendaftar::select(
            'kategori_jalur.jalur_masuk',
            \DB::raw("COUNT(pendaftar.id) as count")
        )
            ->join('kategori_jalur', 'pendaftar.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->where('jalur_masuk_id', '=', 2)
            ->where('pendaftar.user_id', Auth::user()->kode_ps)
            ->orderBy('tahun_masuk', 'ASC')
            ->groupBy(\DB::raw("tahun_masuk"))
            ->pluck('count');

        $smmptn = Pendaftar::select(
            'kategori_jalur.jalur_masuk',
            \DB::raw("COUNT(pendaftar.id) as count")
        )
            ->join('kategori_jalur', 'pendaftar.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->where('jalur_masuk_id', '=', 3)
            ->where('pendaftar.user_id', Auth::user()->kode_ps)
            ->orderBy('tahun_masuk', 'ASC')
            ->groupBy(\DB::raw("tahun_masuk"))
            ->pluck('count');

        $afirmasi = Pendaftar::select(
            'kategori_jalur.jalur_masuk',
            \DB::raw("COUNT(pendaftar.id) as count")
        )
            ->join('kategori_jalur', 'pendaftar.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->where('jalur_masuk_id', '=', 4)
            ->where('pendaftar.user_id', Auth::user()->kode_ps)
            ->orderBy('tahun_masuk', 'ASC')
            ->groupBy(\DB::raw("tahun_masuk"))
            ->pluck('count');


        // jalur masuk tahun terbaru
        $jalur_masuk = KategoriJalur::get();
        $biodata_mhs = MhsReguler::get();
        $jalur = [];

        // $lastYear = array_key_last($biodata_mhs);
        // $filteredData = $biodata_mhs->filter(function ($d) use ($lastYear) {
        //     return $d['tahun_masuk'] == $lastYear;
        // });
        // dd($lastYear);

        $jalur_masuk = KategoriJalur::select([
            'kategori_jalur.id', 'biodata_mhs.jalur_masuk_id',
            \DB::raw('(jalur_masuk) as jm'),
            \DB::raw('COUNT(biodata_mhs.id) as jumlah'),
        ])
            ->join('biodata_mhs', 'kategori_jalur.id', '=', 'biodata_mhs.jalur_masuk_id')
            ->whereYEAR('tahun_masuk', '=', Carbon::now())
            ->where('user_id', Auth::user()->kode_ps)
            ->groupBy('id')
            ->get();

        foreach ($jalur_masuk as $jalur_masuk) {
            $jalur[] = [
                "name" => strval($jalur_masuk['jm']),
                "y" => floatval($jalur_masuk['jumlah'])
            ];
        }
        // return $jalur;

        //diagram batang
        $artikel_dosen = KaryaIlmiahDsn::get();
        $publikasi = [];

        $artikel_dosen = KaryaIlmiahDsn::select([
            'artikel_dosen.tahun',
            \DB::raw("(tahun) as tahun"),
            \DB::raw('COUNT(artikel_dosen.id) as jumlah'),
        ])
            ->whereNotNull('tahun')
            ->where('user_id', Auth::user()->kode_ps)
            ->groupBY('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        foreach ($artikel_dosen as $ad) {
            $publikasi['x'][] = $ad->tahun;
            $publikasi['y'][] = $ad->jumlah;
        }
        //   return $publikasi;

        //diagram lulusan
        $alumni = Alumni::get();
        $alumni_array = [];

        $alumni = Alumni::select([
            'alumni.tahun_lulus',
            \DB::raw('YEAR(tahun_lulus) as tahun'),
            \DB::raw('COUNT(alumni.id) as jumlah'),
        ])
            ->whereNotNull('tahun_lulus')
            ->where('user_id', Auth::user()->kode_ps)
            ->groupBY('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        foreach ($alumni as $mhs) {
            $alumni_array['x'][] = $mhs->tahun;
            $alumni_array['y'][] = $mhs->jumlah;
        }

        // dd($mahasiswa);
        //count data2
        $count_maba = DB::table('biodata_mhs')
            ->whereYEAR('tahun_masuk', '=', Carbon::now())
            ->where('user_id', Auth::user()->kode_ps)
            ->count();

        $count_lulusan = DB::table('alumni')
            ->whereNotNull('tahun_lulus')
            ->whereYEAR('tahun_lulus', '=', Carbon::now())
            ->where('user_id', Auth::user()->kode_ps)
            ->count();

        $count_dosen = DB::table('dosen')
            ->where('user_id', Auth::user()->kode_ps)
            ->count();

        $count_pkm = DB::table('data_pkm')
            ->where('user_id', Auth::user()->kode_ps)
            ->count();

        $count_penelitian = DB::table('data_penelitian')
            ->where('user_id', Auth::user()->kode_ps)
            ->count();

        $count_kerjasama = DB::table('kerjasama')
            ->where('user_id', Auth::user()->kode_ps)
            ->count();
        // dd($publikasi);

        // return $biodata_mhs;
        return view('admin.layout.dashboard', compact('publikasi', 'snmptn', 'sbmptn', 'smmptn', 'afirmasi', /*'dataPoints',*/ 'count_maba', 'count_lulusan', 'count_dosen', 'count_pkm', 'count_penelitian', 'count_kerjasama', 'jalur', 'alumni_array'));
    }
}
