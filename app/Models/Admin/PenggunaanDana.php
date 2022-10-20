<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PenggunaanDana extends Model
{
    protected $table = 'penggunaan_dana';
    protected $fillable = ['id, user_id, kategori_pengelola_id, jenis_penggunaan_id, dana, tahun'];

    public function jenis_penggunaan()
    {
        return $this->hasMany('App\Models\Admin\JenisPenggunaan', 'id');
    }
}
