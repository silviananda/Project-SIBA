<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    public $table = 'pendaftar';
    protected $fillable = ['id', 'user_id', 'no_ujian', 'nama', 'asal_sekolah', 'jalur_masuk_id', 'tahun_masuk', 'updated_at', 'created_at'];
}
