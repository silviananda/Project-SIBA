<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AktivitasDosen extends Model
{
    protected $table = 'aktivitas_dosen';
    protected $fillable = ['aktivitas_id', 'kode_mk', 'ps_lain', 'bobot_sks', 'ket', 'sks_ps_lain', 'tahun'];

    public function aktivitas()
    {
        return $this->belongsTo('App\Models\Admin\AktivitasTetap', 'aktivitas_id', 'id');
    }

    public function kurikulum()
    {
        return $this->belongsTo('App\Models\Admin\Kurikulum', 'kode_mk', 'kode_mk');
    }
}
