<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AktivitasTdkTetap extends Model
{
    protected $table = 'aktivitas';
    protected $fillable = ['user_id', 'dosen_id', 'ps_sendiri', 'ps_lain', 'pt_lain', 'sks_penelitian', 'sks_p2m', 'm_pt_sendiri', 'm_pt_lain', 'is_verification', 'deadline', 'tahun'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\DosenTdkTetap', 'dosen_id', 'dosen_id');
    }

    public function kurikulum()
    {
        return $this->belongsTo('App\Models\Admin\Kurikulum', 'ps_sendiri', 'kode_mk');
    }

    public function aktivitas_dosen()
    {
        return $this->hasMany('App\Models\Admin\AktivitasDosen', 'aktivitas_id');
    }
}
