<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PenelitianMhs extends Model
{
    protected $table = 'data_penelitian_mhs';
    protected $fillable = ['id', 'mhs_id', 'data_penelitian_id'];

    public function data_penelitian()
    {
        return $this->belongsTo('App\Models\Admin\DataPenelitian', 'data_penelitian_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id');
    }
}
