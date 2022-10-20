<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class DayaTampung extends Model
{
    protected $table = 'daya_tampung';
    protected $fillable = ['id', 'user_id', 'tahun', 'daya_tampung'];
}
