<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MhsAsing extends Model
{
    protected $table = 'mhs_asing';

    public function dosen(){
        return $this->belongsTo('App\Models\Admin\Dosen','dosen_id');
    }
}
