<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class WaktuTunggu extends Model
{
    protected $table = 'waktu_tunggu';
    protected $fillable = ['id', 'waktu'];

    public function alumni()
    {
        return $this->hasMany('App\Models\Admin\Alumni');
    }
}
