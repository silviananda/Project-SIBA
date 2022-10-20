<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PenelitianDosen extends Model
{
    public $table = 'data_penelitian';
    protected $fillable = ['id', 'data_penelitian_id', 'dosen_id', 'mhs_id', 'deadline', 'is_verification', 'softcopy'];

    public function data_penelitian()
    {
        return $this->belongsTo('App\Models\Admin\DanaPenelitian', 'data_penelitian_id');
    }

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id');
    }
}
