<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MulaiKerja extends Model
{
    protected $table = 'mulai_kerja';
    protected $fillable = ['id', 'waktu_kerja'];

    public function alumni()
    {
        return $this->hasMany('App\Models\Admin\Alumni');
    }
}
