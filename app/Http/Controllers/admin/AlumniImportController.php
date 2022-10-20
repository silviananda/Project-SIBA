<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\AlumniImport;
use App\Models\Admin\Alumni;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AlumniImportController extends Controller
{
    public function index()
    {
        return view('admin.alumni.import-alumni');
    }

    public function store(Request $request)
    {
        if ($request->file('file')) {
            $request->validate([
                'file' => 'file|mimes:xlsx'
            ]);

            Excel::import(new AlumniImport, $request->file('file'));

            return redirect('/alumni')->with(['added' => 'Data Berhasil Diimport']);
        } else {
            return redirect('/alumni')->with(['error' => 'Data Gagal Diimport!']);
        }
    }
}
