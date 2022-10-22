<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class DataPenelitian extends Model
{
    protected $table = 'data_penelitian';
    protected $fillable = ['id', 'user_id', 'dosen_id', 'jenis_penelitian', 'judul_penelitian', 'tema', 'tahun_penelitian', 'sumber_dana_id', 'jumlah_dana', 'softcopy', 'is_verification'];


    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }

    public function penelitianmhs()
    {
        return $this->hasMany('App\Models\Admin\PenelitianMhs', 'data_penelitian_id');
    }

    public function penelitianmagister()
    {
        return $this->hasMany('App\Models\Admin\PenelitianMhsS2', 'data_penelitian_id');
    }

    public function sumberdana()
    {
        return $this->belongsTo('App\Models\Admin\SumberDana', 'sumber_dana_id', 'id');
    }
}
