<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DanaPkm;
use App\Models\Admin\SumberDana;
use App\Models\Admin\Dosen;
use App\Models\Admin\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Auth;
use Validator;

class DataPkmController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data()
    {
        return view('admin.PkM.data-pkm.data-pkm');
    }

    public function index()
    {
        $now = Date::now()->year;
        $years[] = $now;
        for ($i = 1; $i < 10; $i++) {
            $years[] = Date::now()->subYears($i)->year;
        }
        $tahun = array_reverse($years);

        $sumber = DB::table('sumber_dana')->get();

        // return $sumber;
        return view('admin.PkM.data-pkm.data-pkm', compact('report', 'sumber', 'data_pkm', 'tahun'));
    }

    public function destroy($id)
    {
        DB::table('data_pkm')->where('id', $id)->delete();
        return redirect()->back();
    }
}
