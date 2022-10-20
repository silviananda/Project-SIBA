<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PembimbingTa;
use App\Models\Admin\Dosen;
use App\Models\Admin\MhsReguler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Date;

class PembimbingTaController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $now = Date::now()->year;
        $years[] = $now;
        for ($i = 1; $i < 3; $i++) {
            $years[] = Date::now()->subYears($i)->year;
        }
        $tahun = array_reverse($years);
        $pembimbingTa = Dosen::where('user_id', Auth::user()->kode_ps)->get();

        return view('admin.bimbingan.pembimbing-ta.pembimbing-ta', compact('pembimbingTa', 'tahun'));
    }

    public function destroy($id)
    {
        DB::table('data_pembimbing_ta')->where('id', $id)->delete();
        return redirect()->back();
    }
}
