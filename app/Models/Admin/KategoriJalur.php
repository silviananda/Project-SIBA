<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class KategoriJalur extends Model
{
    protected $table = 'kategori_jalur';
    protected $fillable = ['id, jalur_masuk'];

    public function biodata_mhs()
    {
        return $this->belongsTo('App\Models\Admin\Mahasiswa', 'jalur_masuk_id')->withPivot(['jalur_masuk'])->withTimeStamps();
    }

    public function pendaftar()
    {
        return $this->belongsTo('App\Models\Admin\Pendaftar');
    }

    public function mhs_reguler()
    {
        return $this->hasMany('App\Models\Admin\MhsReguler');
    }
}
