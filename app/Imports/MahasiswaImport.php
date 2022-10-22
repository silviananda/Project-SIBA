<?php

namespace App\Imports;

use App\Models\Admin\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $login = Auth::user()->kode_ps;

        // dd($login);
        $npm = explode("'", $row['npm'])[0];

        $response = Http::get('');

        try {
            $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
        } catch (\Throwable $th) {
            return null;
        }

        $json = json_encode($xml);
        $array = json_decode($json, TRUE); // kalo return nya true dia akan kembalikan assosiative array, kalo false dikembalikan objek

        $array_prodi = [
            '0800101' => 'Manajemen Informatika',
            '0800202' => 'Teknik Elektronika',
            '0810101' => 'Matematika',
            '0810201' => 'Fisika',
            '0810301' => 'Kimia',
            '0810401' => 'Biologi',
            '0810701' => 'Informatika',
            '0810901' => 'Farmasi',
            '0810801' => 'Statistika',
            '0820101' => 'Matematika',
            '0820301' => 'Kimia',
            '0820201' => 'Fisika',
            '0820401' => 'Biologi',
            '0820701' => 'Kecerdasan Buatan',
        ];

        $array_jalur = [
            '1' => 'SNMPTN',
            '2' => 'SBMPTN',
            '3' => 'UMB',
            '4' => 'Afirmasi',
            '5' => 'Internasional'
        ];

        $list_npm[] = $array['npm'];

        $kd_prodi = array_search($array['prodi'], $array_prodi);
        $kd_jalur = array_search($row['jalur_masuk'], $array_jalur);

        $kode_tahun = substr($npm, 0, 2);
        $kode = 20;

        // $hari = 10;
        // $bulan = 9;
        $tahun = $kode . $kode_tahun;

        $date = Carbon::now()->toDateTime();
        $date1 = new Carbon($date);
        $dt = Carbon::now();

        if ($login == $kd_prodi) {
            if (count($list_npm) > 0) {
                foreach ($list_npm as $value) {
                    $datetime = $dt->year($tahun)->month(9)->day(1)->hour(22)->minute(32)->second(5)->toDateTimeString();
                    $data[] = array(
                        'npm'     => $value,
                        'nama'     => $array['nama'],
                        'jenis_kelamin'     => $array['jenis_kelamin'],
                        'email'     => $array['email'],
                        'ipk'     => $array['ipk'],
                        'user_id'     => $kd_prodi,
                        'jalur_masuk_id'     => $kd_jalur,
                        'tahun_masuk'      => $datetime
                    );
                }
                DB::table('biodata_mhs')->insertOrIgnore($data);
            }
        } else {
            "Data Tidak Sesuai dengan Program Studi";
        }
    }
}
