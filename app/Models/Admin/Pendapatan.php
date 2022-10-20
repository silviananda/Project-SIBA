<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $table = 'kategori_pendapatan';
    protected $fillable = ['id', 'pendapatan'];

    public function alumni()
    {
        return $this->hasMany('App\Models\Admin\Alumni');
    }
}
