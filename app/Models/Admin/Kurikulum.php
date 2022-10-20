<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $table = 'kurikulum';
    protected $fillable = ['id', 'user_id', 'semester_id', 'tahun', 'kode_mk', 'nama_mk', 'bobot_sks', 'sks_praktikum', 'bobot_tugas', 'sks_seminar', 'wajib', 'unit', 'capaian', 'rps', 'silabus'];

    public function Dosen()
    {
        return $this->hasMany('App\Models\Admin\Dosen');
    }

    public function AktivitasTetap()
    {
        return $this->hasMany('App\Models\Admin\AktivitasTetap', 'kode_mk', 'ps_sendiri');
    }

    public function AktivitasDosen()
    {
        return $this->hasMany('App\Models\Admin\AktivitasDosen', 'kode_mk', 'ps_sendiri');
    }

    public function AktivitasTdkTetap()
    {
        return $this->hasMany('App\Models\Admin\AktivitasTdkTetap');
    }

    public function AktivitasIndustri()
    {
        return $this->hasMany('App\Models\Admin\AktivitasIndustri');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\Admin\Semester');
    }

    public function praktikum()
    {
        return $this->hasMany('App\Models\Admin\Praktikum', 'kode_mk', 'kode_mk');
    }

    public function mengajar()
    {
        return $this->hasMany('App\Models\Admin\Pengajaran');
    }
}
