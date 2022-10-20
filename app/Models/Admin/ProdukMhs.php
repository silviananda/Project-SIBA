<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProdukMhs extends Model
{
    protected $table = 'produk';

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id', 'id');
    }
}
