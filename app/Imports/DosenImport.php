<?php

namespace App\Imports;

use App\Models\Admin\Dosen;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        $login = Auth::user()->kode_ps;

        // $nip = explode("'", $row[1])[1] ?? $row[1];

        $nip = explode("'", $row['nip'])[0];

        $response = Http::get('');
        try {
            $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
        } catch (\Throwable $th) {
            return null;
        }

        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        $array_prodi = [
            '0800101' => 'Manajemen Informatika',
            '0800202' => 'Teknik Elektronika',
            '0810101' => 'Matematika',
            '0810201' => 'Fisika',
            '0810301' => 'Kimia',
            '0810401' => 'Biologi',
            '0810701' => 'Teknik Informatika',
            '0810901' => 'Farmasi',
            '0810801' => 'Statistika',
            '0820101' => 'Matematika',
            '0820301' => 'Kimia',
            '0820201' => 'Fisika',
            '0820401' => 'Biologi',
            '0820701' => 'Kecerdasan Buatan',
        ];

        $array_jabatan = [
            '1' => 'Guru Besar',
            '2' => 'Lektor Kepala',
            '3' => 'Lektor',
            '4' => 'Asisten Ahli',
            '5' => 'Tenaga Pengajar',
        ];

        $array_pendidikan = [
            '1' => 'D3/Sarjana Muda',
            '2' => 'S1',
            '3' => 'S2',
            '4' => 'S3',
        ];

        $list_nip[] = $array['nip'];

        $kd_prodi = array_search($array['nama_jurusan'], $array_prodi);
        $kd_jabatan = array_search($array['jabfung'], $array_jabatan);
        $kd_pendidikan = array_search($array['jenjang_pendidikan_S3'], $array_pendidikan);

        // dd($list_nip);

        if ($login == $kd_prodi) {
            if (count($list_nip) > 0) {
                foreach ($list_nip as $value) {
                    $data[] = array(
                        'nip'    => $value,
                        'nama_dosen'     => $array['nama'],
                        'nidn'    => $array['nidn'],
                        'tempat'    => $array['tempatlahir'],
                        'tgl_lahir'    => $array['tanggallahir'],
                        'golongan'    => $array['golruang_pangkat'],
                        'jabatan_id'    => $kd_jabatan,
                        'bidang'    => $array['bidangilmu'],
                        'email'    => $array['email'],
                        'jenis_dosen'    => $array['status_pegawai'],
                        'pend_s3'    => $array['nama_perguruan_tinggi_S3'],
                        'pend_s2'    => $array['nama_perguruan_tinggi_S2'],
                        'pend_s1'    => $array['nama_perguruan_tinggi_S1'],
                        'pendidikan_id'    => $kd_pendidikan,
                        'user_id'    => $kd_prodi
                    );
                }
                DB::table('dosen')->insertOrIgnore($data);
            }
        } else {
            "Data Tidak Sesuai dengan Program Studi";
        }
    }
}
