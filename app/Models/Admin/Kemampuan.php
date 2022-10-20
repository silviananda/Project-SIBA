<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Kemampuan extends Model
{
    protected $table = 'kemampuan_dosen';
    protected $fillable = ['user_id', 'dosen_id', 'bidang', 'perguruan', 'negara', 'tahun'];

    public function dosen(){
        return $this->belongsTo('App\Models\Admin\Dosen','dosen_id');
    }
}
