<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    public function Kurikulum()
    {
        return $this->hasMany('App\Models\Admin\Kurikulum');
    }
}
