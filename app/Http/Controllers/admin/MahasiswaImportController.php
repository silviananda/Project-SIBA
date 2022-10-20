<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use Illuminate\Http\Request;
use App\User;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaImportController extends Controller
{
    public function index()
    {
        return view('admin.mahasiswa.import-mhs');
    }

    public function store(Request $request)
    {
        if ($request->file('file')) {
            $request->validate([
                'file' => 'file|mimes:xlsx'
            ]);

            Excel::import(new MahasiswaImport, $request->file('file'));

            return redirect('/mahasiswa')->with(['added' => 'Data Berhasil Diimport']);
        } else {
            return redirect('/mahasiswa')->with(['error' => 'Data Gagal Diimport!']);
        }
    }
}
