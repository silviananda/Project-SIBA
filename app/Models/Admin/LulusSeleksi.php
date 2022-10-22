<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class LulusSeleksi extends Model
{
    public $table = 'mhs_lulus';
    protected $fillable = ['id', 'user_id', 'no_ujian', 'nama', 'asal_sekolah', 'jalur_masuk_id'];
}
