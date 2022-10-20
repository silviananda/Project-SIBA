<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'biodata_mhs';
    protected $fillable = ['id', 'data_penelitian_id', 'dosen_id', 'mhs_id', 'nama', 'ipk', 'jenis_kelamin', 'email', 'npm', 'user_id', 'tahun_keluar'];

    public function data_penelitian()
    {
        return $this->belongsTo('App\Models\Admin\DataPenelitian', 'id');
    }

    public function penelitianmagister()
    {
        return $this->hasMany('App\Models\Admin\PenelitianMhsS2', 'id');
    }

    public function kategori_jalur()
    {
        return $this->hasMany('App\Models\Admin\KategoriJalur', 'id');
    }

    public function penelitianmhs()
    {
        return $this->hasMany('App\Models\Admin\PenelitianMhs', 'id');
    }

    public function paten()
    {
        return $this->hasMany('App\Models\Admin\Paten');
    }

    public function data_pkm()
    {
        return $this->belongsTo('App\Models\Admin\DataPkm', 'id');
    }

    public function pkm_mhs()
    {
        return $this->hasMany('App\Models\Admin\DataPkmMhs', 'id');
    }
}
