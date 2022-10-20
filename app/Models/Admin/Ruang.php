<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = 'data_ruang';
    protected $fillable = ['ruang_kerja', 'jumlah', 'luas'];
}
