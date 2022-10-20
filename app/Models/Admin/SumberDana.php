<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    protected $table = 'sumber_dana';
    protected $fillable = ['id', 'nama_sumber_dana'];

    public function data_penelitian()
    {
        return $this->belongsTo('App\Models\Admin\DataPenelitian', 'id', 'sumber_dana_id');
    }

    public function data_pkm()
    {
        return $this->belongsTo('App\Models\Admin\DataPkm', 'sumber_dana_id');
    }
}
