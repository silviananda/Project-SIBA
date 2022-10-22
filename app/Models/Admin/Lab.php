<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table = 'data_lab';

    public function tenaga_kependidikan()
    {
        return $this->belongsTo('App\Models\Admin\TenagaKependidikan', 'tenaga_id');
    }
}
