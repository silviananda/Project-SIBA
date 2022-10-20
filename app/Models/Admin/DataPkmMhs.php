<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class DataPkmMhs extends Model
{
    protected $table = 'data_pkm_mhs';
    protected $fillable = ['id', 'mhs_id', 'data_pkm_id'];

    public function data_pkm()
    {
        return $this->belongsTo('App\Models\Admin\DataPkm', 'data_pkm_id');
    }

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id');
    }
}
