<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PublikasiMhsTerapan extends Model
{
    protected $table = 'artikel_mhs_terapan';

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id');
    }
}
