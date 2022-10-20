<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class KategoriStatus extends Model
{
    protected $table = 'kategori_status_mhs';

    public function mhs_reguler()
    {
        return $this->hasMany('App\Models\Admin\MhsReguler');
    }
}
