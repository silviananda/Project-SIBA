<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Praktikum extends Model
{
    protected $table = 'praktikum';
    protected $fillable = ['id', 'user_id', 'kode_mk', 'judul', 'jam', 'tempat', 'modul'];

    public function kurikulum()
    {
        return $this->belongsTo('App\Models\Admin\Kurikulum', 'kode_mk', 'kode_mk');
    }
}
