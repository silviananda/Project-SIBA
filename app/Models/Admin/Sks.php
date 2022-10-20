<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Sks extends Model
{
    protected $table = 'kurikulum';
    protected $fillable = ['id', 'nama_mk', 'bobot_sks', 'sks_seminar', 'sks_praktikum'];
}
