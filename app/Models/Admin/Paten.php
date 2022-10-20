<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Paten extends Model
{
    protected $table = 'paten';
    protected $fillable = ['id', 'dosen_id', 'pkm_id', 'user_id', 'karya', 'tahun', 'deadline', 'is_verification', 'tanggal_create'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }
}
