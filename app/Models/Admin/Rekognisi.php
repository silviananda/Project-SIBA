<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Rekognisi extends Model
{
    protected $table = 'rekognisi';  
    protected $fillable = ['user_id', 'dosen_id', 'bidang_keahlian', 'rekognisi', 'tahun'];
    
    public function dosen(){
        return $this->belongsTo('App\Models\Admin\Dosen','dosen_id');
    }
}
