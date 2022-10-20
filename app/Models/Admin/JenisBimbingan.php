<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class JenisBimbingan extends Model
{
    protected $table = 'jenis_bimbingan';
    protected $fillable = ['id', 'jenis'];


    public function data_pembimbing_ta()
    {
        return $this->hasMany('App\Models\Admin\PembimbingTa', 'jenis_id1', 'id');
    }
}
