<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class JenisPekerjaan extends Model
{
    protected $table = 'jenis_pekerjaan';
    protected $fillable = ['id', 'jenis'];


    public function alumni()
    {
        return $this->hasMany('App\Models\Admin\Alumni');
    }
}
