<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Doktor extends Model
{
    protected $table = 'mahasiswa_s3';
    protected $fillable = ['id', 'npm', 'nama', 'tahun_masuk', 'tahun_lulus', 'email', 'created_at', 'updated_at'];
}
