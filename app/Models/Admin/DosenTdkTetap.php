<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenTdkTetap extends Model
{
    use SoftDeletes;
    protected $table = 'dosen';
    protected $primaryKey = 'dosen_id';
    protected $fillable = ['nidn', 'nip', 'jabatan_id', 'pendidikan_id', 'bidang', 'sertifikasi', 'sertifikat_pendidik', 'sertifikat_kompetensi', 'sinta', 'scopus', 'wos', 'pend_s1', 'pend_s2', 'pend_s3', 'golongan', 'tempat', 'tgl_lahir', 'jenis_dosen'];

    public function AktivitasTdkTetap()
    {
        return $this->hasMany('App\Models\Admin\AktivitasTdkTetap');
    }

    public function jenis_dosen()
    {
        return $this->belongsTo('App\Models\Admin\JenisDosen', 'jenis_dosen');
    }

    public function jabatan_fungsional()
    {
        return $this->belongsTo('App\Models\Admin\KategoriJabatan', 'jabatan_id');
    }

    public function kategori_pendidikan()
    {
        return $this->belongsTo('App\Models\Admin\KategoriPendidikan', 'pendidikan_id');
    }
}
