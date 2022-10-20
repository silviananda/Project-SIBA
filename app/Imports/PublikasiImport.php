<?php

namespace App\Imports;

use App\Models\Admin\KaryaIlmiahDsn;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PublikasiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {

        $login = Auth::user()->kode_ps;

        $dosen = DB::table('dosen')->where('user_id', $login)->get();

        $dosen_id = [];
        $nip = [];

        foreach ($dosen as $dsn) {
            $dosen_id[] = $dsn->dosen_id;
            $nip[] = $dsn->nip;
        }

        $array_dosen = array_combine($dosen_id, $nip);
        $kd_dosen = array_search($row['nip'], $array_dosen);

        $data_nip[] = $kd_dosen;
        $data_judul[] = $row['judul'];
        $data_tahun[] = $row['tahun'];

        $list[] = $data_nip && $data_judul && $data_tahun;

        if ($login == $row['kode_jurusan']) {
            if ($kd_dosen == NULL) {
                '-';
            } else {
                if (count($data_judul) > 0) {
                    foreach ($data_judul as $value) {
                        $data[] = array(
                            'user_id'   => $row['kode_jurusan'],
                            'dosen_id'   => $kd_dosen,
                            'judul'     => $value,
                            'tahun'     => $row['tahun'],
                            // 'jumlah'     => $row['total_citations'],
                        );
                    }
                    DB::table('artikel_dosen')->insertOrIgnore($data);
                }
            }
        } else {
            'Data Publikasi tidak tersedia';
        }
    }
}
