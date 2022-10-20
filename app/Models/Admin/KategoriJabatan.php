<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class KategoriJabatan extends Model
{
    protected $table = 'jabatan_fungsional';
    protected $fillable = ['id', 'nama_jabatan'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'id');
    }

    public function dosen_tetap()
    {
        return $this->hasMany('App\Models\Admin\DosenTetap', 'id');
    }
}
