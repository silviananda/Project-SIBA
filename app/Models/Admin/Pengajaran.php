<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Pengajaran extends Model
{
    protected $table = 'mengajar';

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }

    public function kurikulum()
    {
        return $this->belongsTo('App\Models\Admin\Kurikulum', 'kurikulum_id');
    }
}
