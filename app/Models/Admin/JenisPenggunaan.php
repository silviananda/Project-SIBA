<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class JenisPenggunaan extends Model
{
    protected $table = 'jenis_penggunaan';

    public function penggunaan_dana()
    {
        return $this->belongsTo('App\Models\Admin\PenggunaanDana');
    }
}
