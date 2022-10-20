<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = ['user_id', 'jenis_produk', 'dosen_id', 'mhs_id', 'pkm_id', 'nama_produk', 'deskripsi', 'kesiapan', 'tanggal_create', 'deadline', 'is_verification', 'created_at', 'updated_at'];

    public function dosen()
    {
        return $this->belongsTo('App\Models\Admin\Dosen', 'dosen_id');
    }

    public function data_pkm()
    {
        return $this->belongsTo('App\Models\Admin\DataPkm', 'pkm_id');
    }
}
