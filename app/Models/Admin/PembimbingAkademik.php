<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PembimbingAkademik extends Model
{
    protected $table = 'data_pembimbing_akademik';
    protected $fillable = ['id', 'user_id', 'dosen_id', 'mhs_id', 'npm'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }
}
