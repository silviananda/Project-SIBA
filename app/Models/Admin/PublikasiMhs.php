<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PublikasiMhs extends Model
{
    protected $table = 'artikel_mhs';
    protected $fillable = ['judul', 'mhs_id', 'pkm_id', 'id_tingkat', 'jumlah', 'tahun', 'jenis_publikasi'];

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id');
    }
}
