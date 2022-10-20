<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Magister extends Model
{
    protected $table = 'mahasiswa_s2';
    protected $fillable = ['id', 'npm', 'email', 'data_penelitian_id', 'nama', 'tahun_masuk', 'tahun_lulus', 'email'];

    public function data_penelitian()
    {
        return $this->belongsTo('App\Models\Admin\DataPenelitian', 'id');
    }

    public function penelitianmagister()
    {
        return $this->hasMany('App\Models\Admin\PenelitianMhsS2', 'id');
    }
}
