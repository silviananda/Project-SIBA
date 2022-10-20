<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Lainnya extends Model
{
    protected $table = 'produk_lain';
    protected $fillable = ['id', 'user_id', 'pkm_id', 'nama', 'jenis', 'tahun', 'keterangan', 'link', 'jenis_data'];

    // public function jenisproduk()
    // {
    //     return $this->belongsTo('App\Models\Admin\JenisProduk');
    // }

    public function jenis_produk()
    {
        return $this->hasMany('App\Models\Admin\JenisProduk', 'id');
    }
}
