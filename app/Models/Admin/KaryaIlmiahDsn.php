<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class KaryaIlmiahDsn extends Model
{
    protected $table = 'artikel_dosen';
    protected $fillable = ['user_id', 'judul', 'pkm_id', 'dosen_id', 'jumlah', 'pkm_id', 'jenis_publikasi', 'id_tingkat', 'tahun', 'is_verification', 'deadline', 'tanggal_create', 'softcopy'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id')->withTrashed();
    }

    public function publikasi()
    {
        return $this->belongsTo('App\Models\Admin\JenisPublikasi', 'jenis_publikasi');
    }

    public function kategori_tingkat()
    {
        return $this->belongsTo('App\Models\Admin\KategoriTingkat', 'id_tingkat');
    }

    public function data_pkm()
    {
        return $this->belongsTo('App\Models\Admin\DataPkm', 'pkm_id');
    }
}
