<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PatenMhs extends Model
{

    protected $table = 'paten';
    protected $fillable = ['id', 'user_id', 'mhs_id', 'pkm_id', 'karya', 'tahun'];

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id', 'id');
    }
}
