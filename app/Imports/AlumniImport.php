<?php

namespace App\Imports;

use App\Models\Admin\Alumni;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $login = Auth::user()->kode_ps;

        $nim = explode("'", $row['npm'])[0];

        $alumni = DB::table('alumni')->where('user_id', $login)->get();

        $response = Http::get('');

        try {
            $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
        } catch (\Throwable $th) {
            return null;
        }

        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        $npm = [];

        foreach ($alumni as $al) {
            $npm[] = $al->npm;
        }

        $kode_ps = substr($nim, 2, 7);
        $list_npm[] = substr($nim, 0, 13);

        $tahun = $array['periode'];

        $kode_tahun = substr($nim, 0, 2);
        $kode = 20;
        $tahun_masuk = $kode . $kode_tahun;

        $array_periode = [
            '02' => '1',
            '05' => '2',
            '08' => '3'
        ];

        $tahun_lulus = substr($tahun, 0, 4);

        $kd_periode = array_search($array['periode'][4], $array_periode);
        $dt = Carbon::now();

        if ($login == $kode_ps) {
            if (count($list_npm) > 0) {
                foreach ($list_npm as $value) {

                    $datetime_masuk = $dt->year($tahun_masuk)->month(9)->day(0)->hour(0)->minute(0)->second(0)->toDateTimeString();

                    $datetime_lulus = $dt->year($tahun_lulus)->month($kd_periode)->day(0)->hour(0)->minute(0)->second(0)->toDateTimeString();
                    $data[] = array(
                        'npm'   => $value,
                        'nama'     => $array['nama'],
                        'tahun_masuk'     => $datetime_masuk,
                        'tahun_lulus'     => $datetime_lulus,
                        'ipk'     => $array['ipk'],
                        // 'masa_studi'     => $array['masa_studi'],
                        'user_id'     => $kode_ps
                    );
                }
                DB::table('alumni')->insertOrIgnore($data);
            }
        } else {
            "Data Tidak Sesuai dengan Program Studi";
        }
    }
}
