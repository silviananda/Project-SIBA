<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class NonReguler extends Model
{
    protected $table = 'biodata_mhs';
    protected $fillable = ['id', 'npm', 'nama', 'tahun_masuk', 'email', 'dosen_id', 'status', 'asal_id'];


    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }

    public function data_pembimbing_ta()
    {
        return $this->hasMany('App\Models\Admin\PembimbingTa', 'mhs_id');
    }

    public function kategori_status_mhs()
    {
        return $this->belongsTo('App\Models\Admin\KategoriStatus', 'id_status');
    }

    public function kategori_jalur()
    {
        return $this->belongsTo('App\Models\Admin\KategoriJalur', 'jalur_masuk_id');
    }

    public function kategori_asal()
    {
        return $this->belongsTo('App\Models\Admin\KategoriAsal', 'asal_id');
    }
}
