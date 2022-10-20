<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class DataPkm extends Model
{
    protected $table = 'data_pkm';
    protected $fillable = ['user_id', 'dosen_id', 'sumber_dana_id', 'tema', 'judul_pkm', 'jumlah_dana', 'tahun', 'softcopy', 'is_verification', 'tanggal_create', 'deadline', 'himpunan_id', 'jenis_pkm'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id', 'dosen_id');
    }

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id', 'id');
    }

    public function pkm_mhs()
    {
        return $this->hasMany('App\Models\Admin\DataPkmMhs', 'data_pkm_id');
    }

    public function sumberdana()
    {
        return $this->belongsTo('App\Models\Admin\SumberDana', 'sumber_dana_id');
    }
}
