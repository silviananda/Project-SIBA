<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class DataController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function alumni()
    {
        return view('admin.alumni.halaman-alumni');
    }

    public function daya_saing()
    {
        return view('admin.alumni.daya-saing');
    }

    public function kinerja()
    {
        return view('admin.alumni.kinerja');
    }

    public function kerja()
    {
        return view('admin.alumni.kerja');
    }

    //standar 9 efektivitas
    public function efektivitas()
    {
        return view('admin.efektivitas.halaman-efektivitas');
    }

    //standar 9 luaran penelitian dan pkm
    public function luaran()
    {
        return view('admin.luaran.halaman-luaran');
    }

    public function publikasi()
    {
        return view('admin.luaran.publikasi');
    }
}
