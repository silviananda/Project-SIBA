<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PembimbingTa extends Model
{
    protected $table = 'data_pembimbing_ta';
    protected $fillable = ['id', 'user_id', 'doping1', 'mhs_id', 'npm', 'kategori_id', 'jumlah_mhs', 'tahun', 'jenis_id1', 'jenis_id2'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'doping1', 'dosen_id');
    }

    public function jenis_bimbingan()
    {
        return $this->belongsTo('App\Models\Admin\JenisBimbingan', 'jenis_id1', 'id');
    }

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\MhsReguler', 'mhs_id', 'id');
    }

    public function kategori_pembimbing()
    {
        return $this->belongsTo('App\Models\Admin\KategoriPembimbing', 'kategori_id');
    }
}
