<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\PublikasiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PublikasiImportController extends Controller
{
    public function index()
    {
        return view('admin.luaran.karya-ilmiah.import-publikasi');
    }

    public function store(Request $request)
    {
        if ($request->file('file')) {
            $request->validate([
                'file' => 'file|mimes:xlsx'
            ]);

            Excel::import(new PublikasiImport, $request->file('file'));

            return redirect('/luaran/karya-ilmiah')->with(['added' => 'Data Berhasil Diimport']);
        } else {
            return redirect('/luaran/karya-ilmiah')->with(['error' => 'Data Gagal Diimport!']);
        }
    }
}
