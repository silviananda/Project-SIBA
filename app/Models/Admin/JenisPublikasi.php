<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class JenisPublikasi extends Model
{
    protected $table = 'jenis_publikasi';

    public function artikel_dosen()
    {
        return $this->hasMany('App\Models\Admin\KaryaIlmiahDsn');
    }
}
