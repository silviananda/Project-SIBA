<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class JenisDosen extends Model
{
    protected $table = 'kategori_jenis_dosen';

    public function aktivitas()
    {
        return $this->belongsTo('App\Models\Admin\AktivitasTdkTetap', 'dosen_id');
    }

    public function aktivitas_tetap()
    {
        return $this->hasMany('App\Models\Admin\AktivitasTetap');
    }

    public function dosen_tetap()
    {
        return $this->hasMany('App\Models\Admin\DosenTetap', 'id');
    }
}
