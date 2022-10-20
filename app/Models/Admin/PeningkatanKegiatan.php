<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PeningkatanKegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $fillable = ['dosen_id', 'jenis_kegiatan', 'tempat', 'waktu', 'peran_id', 'softcopy', 'tanggal_create', 'deadline', 'is_verification'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }
}
