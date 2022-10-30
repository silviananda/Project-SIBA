<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\KaryaIlmiahDsn;
use App\Models\Admin\DataPkm;
use App\Models\Admin\Dosen;
use App\Models\Admin\KategoriTingkat;
use App\Models\Admin\JenisPublikasi;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Auth;
use App\Notifications\Deadline;
use Carbon\Carbon;
use Validator;
use App\Notifications\VerifikasiDosen;
use Symfony\Component\Process\Exception\ProcessFailedException;

class KaryaIlmiahController extends Controller
{
    public $users;

    public $link;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $artikel_dosen = KaryaIlmiahDsn::with('dosen', 'kategori_tingkat', 'publikasi')->where('artikel_dosen.user_id', Auth::user()->kode_ps)->get();
        $list_dosen = DB::table('dosen')->where('dosen.user_id', Auth::user()->kode_ps)->get();
        // $list_dosen = KaryaIlmiahDsn::with('dosen', 'kategori_tingkat', 'publikasi')->where('artikel_dosen.user_id', Auth::user()->kode_ps)->get();

        return view('admin.luaran.karya-ilmiah.karya', compact('list_dosen'));
    }

    public function create()
    {
        $artikel_dosen = KaryaIlmiahDsn::get();
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi = JenisPublikasi::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.karya-ilmiah.create', compact('artikel_dosen', 'dosen', 'kategori_tingkat', 'jenis_publikasi', 'data_pkm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required | int',
            'link' => 'required'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        $artikel_dosen = new KaryaIlmiahDsn();
        $artikel_dosen->user_id = Auth::user()->kode_ps;
        $artikel_dosen->dosen_id = $request->dosen_id;
        $artikel_dosen->link = $request->link;
        $artikel_dosen->save();

        // return $request;
        try {
            $dosen = Dosen::find($request->dosen_id);

            $dosen->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->name,
                'pesan' => 'Telah mengirim data karya ilmiah untuk di verifikasi',
                'url' => route('publikasi.artikel.index'),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('/luaran/karya-ilmiah')->with(['added' => 'Data Karya Ilmiah berhasil ditambahkan!']);
    }

    public function edit(KaryaIlmiahDsn $artikel_dosen, $dosen_id)
    {
        $list_dosen = Dosen::findOrfail($dosen_id);
        $dosen = Dosen::get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi = JenisPublikasi::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.karya-ilmiah.edit', compact('list_dosen', 'dosen', 'kategori_tingkat', 'jenis_publikasi', 'data_pkm'));
    }

    public function update(Request $request, Dosen $list_dosen, $dosen_id)
    {
        $list_dosen = Dosen::findOrfail($dosen_id);

        $request->validate([
            'link' => 'required'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        $list_dosen->user_id = Auth::user()->kode_ps;
        $list_dosen->dosen_id = $request->dosen_id;
        $list_dosen->link = $request->link;
        $list_dosen->update();

        return redirect('/luaran/karya-ilmiah')->with(['edit' => 'Data Karya Ilmiah Dosen berhasil diubah!']);
    }

    public function destroy($dosen_id)
    {
        DB::table('dosen')->where('dosen_id', $dosen_id)->delete();
        return redirect()->back();
    }

    // public function getLink()
    // {
    //     $link = DB::table('dosen')->select('link')->get();

    //     return view('admin.luaran.karya-ilmiah.detail', compact('link'));
    // }

    public function run(Request $request)
    {
        $link = $request->link;
        $dosen_id = $request->dosen_id;
        $process = new Process(["python3",  env("LOCAL_URL")."resources/python/scrap_main.py", $link]);
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            echo "error";
            throw new ProcessFailedException($process);
        }

        // scraping utama
        $valstr = $process->getOutput();
        $valjson = json_decode(strval($valstr), true);

        // scraping detail
        $dict_detail_title = [];
        $type_doc = ['Journal', 'Conference'];

        foreach($valjson as $val) {
            $link_detail = $val["Link Detail Title"];
            $name = $val["Name"];
            $title = $val["Document"];
            $item_detail = new KaryaIlmiahDsn;


            if ($link_detail == 'None') {
                $item_detail->in_db = False;
                $item_detail->nama = $name;
                $item_detail->judul = $title;
                $item_detail->tahun = "None";
                $item_detail->doc_type = "None";
                $item_detail->authors = "None";
                $item_detail->name_of_doctype = "None";
                $item_detail->volume = "None";
                $item_detail->issue = "None";
                $item_detail->pages = "None";
                $item_detail->publisher = "None";
                $item_detail->description = "None";
                $item_detail->total_citation = "None";

            }
            else {
                $result = 'https://scholar.google.co.id'.$link_detail;

                $process = new Process(["python3", env("LOCAL_URL")."resources/python/scrap_detail.py", $result]);
                $process->setTimeout(300);
                $process->run();
                if (!$process->isSuccessful()) {
                    echo "error";
                    throw new ProcessFailedException($process);
                }

                $valdetailstr = $process->getOutput();
                $valdetailjson = json_decode(strval($valdetailstr), true);

                $item_detail->in_db = False;
                $item_detail->nama = $name;
                $item_detail->judul = $title;
                $item_detail->tahun = $valdetailjson["Publication date"][0];
                $item_detail->doc_type = $valdetailjson["Document Type"][0];
                $item_detail->authors = $valdetailjson["Authors"][0];
                $item_detail->name_of_doctype = $valdetailjson["Name Of Document Type"][0];
                $item_detail->volume = $valdetailjson["Volume"][0];
                $item_detail->issue = $valdetailjson["Issue"][0];
                $item_detail->pages = $valdetailjson["Pages"][0];
                $item_detail->publisher = $valdetailjson["Publisher"][0];
                $item_detail->description = $valdetailjson["Description"][0];
                $item_detail->total_citation = $valdetailjson["Total citations"][0];

            }

            array_push($dict_detail_title, $item_detail);
        }

        // DAFTAR ARTIKEL YANG SUDAH ADA DI DATABASE
        $artikel_res = KaryaIlmiahDsn::get();
        $title_db = [];
        foreach ($artikel_res as $artikel) {
            array_push($title_db, $artikel->judul);
        }

        foreach($dict_detail_title as $dict) {
            if (in_array($dict->judul, $title_db)) {
                $dict->in_db = True;
            }
        }
        return view('admin.luaran.karya-ilmiah.daftar-detail', compact('dict_detail_title', 'dosen_id'));
    }

    public function submit(Request $request) {
        $dosen_id = $request->dosen_id;

        foreach ($request->artikel as $number => $val) {
            // siapkan value untuk diinput ke database
            $idx = $number - 1;
            $artikel_dosen = new KaryaIlmiahDsn();
            $artikel_dosen->user_id = Auth::user()->kode_ps;
            $artikel_dosen->dosen_id = $dosen_id;
            $artikel_dosen->nama = $request->nama[$idx];
            $artikel_dosen->judul = $request->judul[$idx];
            $artikel_dosen->tahun = $request->tahun[$idx];
            $artikel_dosen->doc_type = $request->doc_type[$idx];
            $artikel_dosen->authors = $request->authors[$idx];
            $artikel_dosen->name_of_doctype = $request->name_of_doctype[$idx];
            $artikel_dosen->volume = $request->volume[$idx];
            $artikel_dosen->issue = $request->issue[$idx];
            $artikel_dosen->pages = $request->pages[$idx];
            $artikel_dosen->publisher = $request->publisher[$idx];
            $artikel_dosen->description = $request->description[$idx];
            $artikel_dosen->total_citation = $request->total_citation[$idx];
            $artikel_dosen->save();
        }

        return redirect('/luaran/karya-ilmiah/'.$dosen_id.'/detail')->with(['added' => 'Detail Karya Ilmiah berhasil ditambahkan!']);

    }

    public function save(Request $request)
    {
        $request->validate([
            'pkm_id' => 'required',
            'judul' => 'required',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'deadline' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,pdf|max:20000'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        $artikel_dosen = new KaryaIlmiahDsn();
        $artikel_dosen->user_id = Auth::user()->kode_ps;
        $artikel_dosen->dosen_id = $request->dosen_id;
        $artikel_dosen->pkm_id = $request->pkm_id;
        $artikel_dosen->judul = $request->judul;
        $artikel_dosen->volume = $request->volume;
        $artikel_dosen->page = $request->page;
        $artikel_dosen->issue = $request->issue;
        $artikel_dosen->publisher = $request->publisher;
        $artikel_dosen->id_tingkat = $request->id_tingkat;
        $artikel_dosen->jumlah = $request->jumlah;
        $artikel_dosen->jenis_publikasi = $request->jenis_publikasi;
        $artikel_dosen->tanggal_create = $date1;
        $artikel_dosen->deadline = $request->deadline;
        $artikel_dosen->tahun = $request->tahun;
        $artikel_dosen->save();

        return redirect('/luaran/karya-ilmiah')->with(['added' => 'Data Karya Ilmiah berhasil ditambahkan!']);
    }

    public function detail($dosen_id)
    {
        $list_dosen = Dosen::findOrfail($dosen_id);

        $artikel_dosen = KaryaIlmiahDsn::with('dosen', 'kategori_tingkat', 'publikasi')->where('dosen_id', $list_dosen->dosen_id)->get();

        $dosen_id_test = DB::table('dosen')->where('dosen.user_id', Auth::user()->kode_ps)->get();
        // return view('admin.luaran.karya-ilmiah.detail', compact('artikel_dosen', 'dosen', 'kategori_tingkat', 'list_dosen'));
        return view('admin.luaran.karya-ilmiah.detail', compact('artikel_dosen', 'list_dosen'));
    }

    public function create_detail($dosen_id)
    {
        $list_dosen = Dosen::findOrfail($dosen_id);
        $artikel_dosen = KaryaIlmiahDsn::with('dosen', 'kategori_tingkat', 'publikasi')->where('artikel_dosen.dosen_id', '=', 'dosen.dosen_id')->get();
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi = JenisPublikasi::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.karya-ilmiah.create-detail', compact('artikel_dosen', 'list_dosen', 'kategori_tingkat', 'jenis_publikasi', 'data_pkm'));
    }

    public function store_detail(Request $request)
    {
        $request->validate([
            'pkm_id' => 'required',
            'judul' => 'required',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'deadline' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,pdf|max:20000'
        ]);

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);

        $artikel_dosen = new KaryaIlmiahDsn();
        $artikel_dosen->user_id = Auth::user()->kode_ps;
        $artikel_dosen->dosen_id = $request->dosen_id;
        $artikel_dosen->pkm_id = $request->pkm_id;
        $artikel_dosen->judul = $request->judul;
        $artikel_dosen->volume = $request->volume;
        $artikel_dosen->page = $request->page;
        $artikel_dosen->issue = $request->issue;
        $artikel_dosen->publisher = $request->publisher;
        $artikel_dosen->id_tingkat = $request->id_tingkat;
        $artikel_dosen->jumlah = $request->jumlah;
        $artikel_dosen->jenis_publikasi = $request->jenis_publikasi;
        $artikel_dosen->tanggal_create = $date1;
        $artikel_dosen->deadline = $request->deadline;
        $artikel_dosen->tahun = $request->tahun;
        $artikel_dosen->save();

        if ($request->softcopy != '') {
            $file = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();

            $artikel_dosen->softcopy = $nama_file;

            $file->move(public_path() . '/file', $nama_file);
            $artikel_dosen->save();
        }

        try {
            $dosen = Dosen::find($request->dosen_id);

            $dosen->notify(new VerifikasiDosen([
                'dosen_name' => Auth::user()->name,
                'pesan' => 'Telah mengirim data karya ilmiah untuk di verifikasi',
                'url' => route('publikasi.artikel.index'),
                'tanggal' => $date1
            ]));
        } catch (\Throwable $th) {
            throw $th;
        }

        // return redirect()->route('/luaran/karya-ilmiah/' . '$artikel_dosen->dosen_id' . '/detail');

        return redirect('/luaran/karya-ilmiah')->with(['added' => 'Data Karya Ilmiah berhasil ditambahkan!']);
    }

    public function edit_detail(KaryaIlmiahDsn $artikel_dosen, $id)
    {
        $artikel_dosen = KaryaIlmiahDsn::findOrfail($id);
        $kategori_tingkat = KategoriTingkat::get();
        $jenis_publikasi = JenisPublikasi::get();
        $data_pkm = DataPkm::get();

        return view('admin.luaran.karya-ilmiah.edit-detail', compact('artikel_dosen', 'dosen', 'kategori_tingkat', 'jenis_publikasi', 'data_pkm'));
    }

    public function update_detail(Request $request, $id)
    {
        $artikel_dosen = KaryaIlmiahDsn::findOrfail($id);

        $request->validate([
            'pkm_id' => 'required',
            'judul' => 'required',
            'id_tingkat' => 'required',
            'jenis_publikasi' => 'required',
            'deadline' => 'required',
            'tahun' => 'required',
            'softcopy' => 'file|mimes:docx,pdf|max:20000'
        ]);

        KaryaIlmiahDsn::where('id', $artikel_dosen->id)
            ->update([
                'dosen_id' => $request->dosen_id,
                'judul' => $request->judul,
                'volume' => $request->volume,
                'page' => $request->page,
                'issue' => $request->issue,
                'publisher' => $request->publisher,
                'id_tingkat' => $request->id_tingkat,
                'pkm_id' => $request->pkm_id,
                'jumlah' => $request->jumlah,
                'jenis_publikasi' => $request->jenis_publikasi,
                'deadline' => $request->deadline,
                'tahun' => $request->tahun
            ]);

        if ($request->softcopy != '') {
            $path_baru = public_path() . '/file/';
            $deletePath = KaryaIlmiahDsn::where('id', $request->id)->first();

            $path = $deletePath->softcopy;

            if ($artikel_dosen->softcopy != '' & $artikel_dosen->softcopy != null) {
                unlink(public_path('/file/') . $path);
            }

            $softcopy = $request->softcopy;
            $nama_file = time() . rand(100, 999) . "." . $softcopy->getClientOriginalExtension();
            $softcopy->move($path_baru, $nama_file);

            $artikel_dosen->update(['softcopy' => $nama_file]);
        }

        return redirect('/luaran/karya-ilmiah')->with(['edit' => 'Data Karya Ilmiah Dosen berhasil diubah!']);
    }

    public function destroy_detail($id)
    {
        DB::table('artikel_dosen')->where('id', $id)->delete();
        return redirect()->back();
    }
}
