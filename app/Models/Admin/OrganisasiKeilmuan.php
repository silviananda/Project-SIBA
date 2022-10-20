<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OrganisasiKeilmuan extends Model
{
    protected $table = 'organisasi';
    protected $fillable = ['user_id', 'dosen_id', 'nama_organisasi', 'tingkat', 'mulai'];

    public function dosen(){
        return $this->belongsTo('App\Models\Admin\Dosen','dosen_id');
    }
}
