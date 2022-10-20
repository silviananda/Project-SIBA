<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\KurikulumImport;
use App\Models\Admin\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Controllers\admin\xml;
use App\Http\Controllers\admin\mysql_query;

class KurikulumImportController extends Controller
{
    public function index()
    {
        return view('admin.kurikulum.import-kurikulum');
    }

    public function kurikulum(Request $request)
    {
        $kd_prodi = Auth::user()->kode_ps;

        $response = Http::get('http://ws.unsyiah.ac.id/webservice/ws_siba/cSiba/makulkurikulum/kdprodi/' . $kd_prodi . '/key/021infsiba/');

        $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE); //setting jadi true untuk mendapatkan data berupa array

        $array_semester = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8'
        ];

        $data = collect($array['item']['item']);

        $lastYear = $array['item']['item'][array_key_last($array['item']['item'])]['tahun'];

        $filteredData = $data->filter(function ($d) use ($lastYear) {
            return $d['tahun'] == $lastYear;
        });

        foreach ($filteredData as $row) {
            $list_mk[] = $row['kode_mata_kuliah'];

            if (count($list_mk) > 0) {
                $list[] = array(
                    'kode_mk' => $row['kode_mata_kuliah'],
                    'nama_mk' => $row['nama_mata_kuliah'],
                    'bobot_sks' => $row['bobot_sks'],
                    'tahun' => $row['tahun'],
                    'semester_id' => array_search($row['semester'], $array_semester),
                    'user_id' => $kd_prodi
                );
            }
        }
        DB::table('kurikulum')->insertOrIgnore($list);

        return redirect('/kurikulum/struktur/')->with(['added' => 'Data Berhasil Diimport']);
    }
}
