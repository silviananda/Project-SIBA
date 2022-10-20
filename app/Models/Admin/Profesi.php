<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Profesi extends Model
{
    protected $table = 'mahasiswa_profesi';
    protected $fillable = ['id', 'npm', 'nama', 'tahun_masuk', 'tahun_lulus', 'email'];
}
