<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class KategoriPendidikan extends Model
{
    protected $table = 'kategori_pendidikan';

    public function dosen_tetap()
    {
        return $this->hasMany('App\Models\Admin\DosenTetap', 'id');
    }
}
