<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class JenisProduk extends Model
{
    protected $table = 'jenis_produk';

    // public function produklain()
    // {
    //     return $this->hasMany('App\Models\Admin\Lainnya');
    // }
    public function produklain()
    {
        return $this->belongsTo('App\Models\Admin\Lainnya');
    }
}
