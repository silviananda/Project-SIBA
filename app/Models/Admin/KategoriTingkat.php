<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class KategoriTingkat extends Model
{
    protected $table = 'kategori_tingkat';
    protected $fillable = ['id', 'nama_kategori'];

    public function artikel_dosen()
    {
        return $this->hasMany('App\Models\Admin\KaryaIlmiahDsn');
    }
}
