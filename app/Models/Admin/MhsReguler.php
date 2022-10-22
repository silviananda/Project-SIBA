<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MhsReguler extends Model
{
    use SoftDeletes;
    protected $table = 'biodata_mhs';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'dosen_id', 'npm', 'nama', 'tahun_masuk', 'tahun_keluar', 'email', 'id_status', 'asal_id', 'jalur_masuk_id', 'ipk'];

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
