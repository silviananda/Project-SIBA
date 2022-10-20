<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Kerjasama extends Model
{
    protected $table = 'kerjasama';
    protected $fillable = ['id', 'user_id', 'nama_instansi', 'id_kategori_kerjasama', 'id_kategori_tingkat', 'judul_kegiatan', 'manfaat', 'tanggal_kegiatan', 'kepuasan', 'softcopy'];
}
