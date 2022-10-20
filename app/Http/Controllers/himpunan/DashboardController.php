<?php

namespace App\Http\Controllers\himpunan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('himpunan.layout.dashboard-mhs');
    }
}
