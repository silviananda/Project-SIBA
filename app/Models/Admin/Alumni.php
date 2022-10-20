<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';
    protected $fillable = ['id', 'user_id', 'npm', 'nama', 'ipk', 'masa_studi', 'id_mulai_kerja', 'id_waktu_tunggu', 'id_pendapatan', 'id_jenis_pekerjaan', 'tahun_masuk', 'tahun_lulus'];

    public function waktu_tunggu()
    {
        return $this->belongsTo('App\Models\Admin\WaktuTunggu', 'id_waktu_tunggu');
    }

    public function jenis_pekerjaan()
    {
        return $this->belongsTo('App\Models\Admin\JenisPekerjaan', 'id_jenis_pekerjaan');
    }

    public function kategori_pendapatan()
    {
        return $this->belongsTo('App\Models\Admin\Pendapatan', 'id_pendapatan');
    }

    public function mulai_kerja()
    {
        return $this->belongsTo('App\Models\Admin\MulaiKerja', 'id_mulai_kerja');
    }
}
