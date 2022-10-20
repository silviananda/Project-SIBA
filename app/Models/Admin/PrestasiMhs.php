<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PrestasiMhs extends Model
{
    protected $table = 'prestasi_mhs';
    protected $fillable = ['user_id', 'mhs_id', 'himpunan_id', 'nama_kegiatan', 'prestasi', 'jenis_prestasi', 'tahun', 'softcopy', 'tingkat'];


    public function kategori_tingkat()
    {
        return $this->belongsTo('App\Models\Admin\KategoriTingkat', 'tingkat');
    }

    public function kategori_jenis_prestasi()
    {
        return $this->belongsTo('App\Models\Admin\KategoriPrestasi', 'jenis_prestasi');
    }

    public function himpunan()
    {
        return $this->belongsTo('App\Models\Himpunan', 'himpunan_id');
    }
}
