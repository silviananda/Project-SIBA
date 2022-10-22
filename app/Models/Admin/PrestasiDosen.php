<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PrestasiDosen extends Model
{
    protected $table = 'prestasi_dosen';
    protected $fillable = ['user_id', 'dosen_id', 'judul_prestasi', 'tingkat', 'tahun', 'deadline', 'is_verification', 'softcopy', 'created_at', 'updated_at'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }
}
