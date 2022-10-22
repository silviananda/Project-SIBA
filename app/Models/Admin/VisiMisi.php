<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    protected $table = 'visi_misi';    
    protected $fillable = ['desc_visi', 'desc_misi', 'update_at', 'created_at'];

}
