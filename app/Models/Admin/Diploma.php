<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    protected $table = 'mahasiswa_d3';
    protected $fillable = ['id', 'npm', 'nama', 'email', 'tahun_masuk', 'tahun_lulus'];
}
