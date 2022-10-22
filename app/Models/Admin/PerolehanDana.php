<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PerolehanDana extends Model
{
    protected $table = 'jenis_dana';
    protected $fillable = ['user_id', 'sumber_dana_id', 'nama_jenis_dana', 'jumlah_dana', 'tahun'];
}
