<?php

namespace App\Models\Admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'dosen';
    protected $guard = 'dosen';

    protected $primaryKey = 'dosen_id';
    protected $fillable = [
        'dosen_id', 'nip', 'nidn', 'nama_dosen', 'jabatan_id', 'pendidikan_id', 'email', 'password', 'role', 'bidang', 'golongan', 'tempat', 'tgl_lahir', 'pend_s1', 'pend_s2', 'pend_s3', 'setifikasi', 'jenis_dosen', 'perusahaan', 'scopus', 'wos', 'sinta', 'sertifikat_pendidik', 'sertifikat_kompetensi', 'user_id'
    ];

    public function data_penelitian()
    {
        return $this->hasMany('App\Models\Admin\DataPenelitian', 'id', 'dosen_id');
    }

    public function jabatan_fungsional()
    {
        return $this->belongsTo('App\Models\Admin\KategoriJabatan', 'jabatan_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function data_pkm()
    {
        return $this->hasMany('App\Models\Admin\DataPkm', 'id', 'dosen_id');
    }

    public function mhs_reguler()
    {
        return $this->hasMany('App\Models\Admin\MhsReguler', 'id', 'dosen_id');
    }

    public function data_pembimbing_ta()
    {
        return $this->hasMany('App\Models\Admin\PembimbingTa', 'id', 'dosen_id');
    }

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\MhsReguler', 'id', 'dosen_id');
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {
        return $this->role->permissions()->where('name', $permission)->first() ?: false;
    }
}
