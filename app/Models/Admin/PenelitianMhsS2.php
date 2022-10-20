<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PenelitianMhsS2 extends Model
{
    protected $table = 'data_penelitian_mhs_s2';
    protected $fillable = ['id', 'mhs_id', 'data_penelitian_id'];

    public function data_penelitian()
    {
        return $this->belongsTo('App\Models\Admin\DataPenelitian', 'data_penelitian_id');
    }

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'mhs_id');
    }
}
