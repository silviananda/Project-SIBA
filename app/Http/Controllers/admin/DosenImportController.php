<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\DosenImport;
use Illuminate\Http\Request;
use App\Models\Admin\Dosen;
use App\User;
use Maatwebsite\Excel\Facades\Excel;

class DosenImportController extends Controller
{
    public function index()
    {
        return view('admin.dosen-tetap.import-dosen');
    }

    public function store(Request $request)
    {
        if ($request->file('file')) {
            $request->validate([
                'file' => 'file|mimes:xlsx'
            ]);

            Excel::import(new DosenImport, $request->file('file'));

            return redirect('/dosen/tetap/')->with(['added' => 'Data Berhasil Diimport']);
        } else {
            return redirect('/dosen/tetap/')->with(['error' => 'Data Gagal Diimport!']);
        }
    }
}
