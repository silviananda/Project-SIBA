<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Style\TablePosition;
use PhpOffice\PhpWord\ComplexType\FootnoteProperties;
use PhpOffice\PhpWord\SimpleType\NumberFormat;
use App\Models\Admin\MhsReguler;
use App\Models\Admin\DosenTetap;
use App\Models\Admin\AktivitasTetap;
use App\Models\Admin\Kurikulum;
use App\Models\Admin\PembimbingAkademik;
use App\Models\Admin\PembimbingTa;
use App\Models\Admin\DataPenelitian;
use App\Models\Admin\PenelitianMhs;
use App\Models\Admin\PenelitianMhsS2;
use App\Models\Admin\Alumni;
use App\Models\Admin\DataPkm;
use App\Models\Admin\DataPkmMhs;
use App\Models\Admin\KaryaIlmiahDsn;
use App\Models\Admin\AktivitasTdkTetap;
use App\Models\Admin\AktivitasDosen;
use App\Models\Admin\AktivitasIndustri;
use App\Models\Admin\Dosen;
use App\Models\Admin\DosenTdkTetap;
use Carbon\Carbon;
use Auth;
use DB;
use Illuminate\Support\Facades\Date;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Averages;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\type;

class ExportFileController extends Controller
{

    private function getYears($n)
    {
        $now = Date::now()->year;
        $years[] = $now;
        for ($i = 1; $i < $n; $i++) {
            $years[] = Date::now()->subYears($i)->year;
        }
        return array_reverse($years);
    }

    private function generate()
    {
        $data_kerjasama = new \PhpOffice\PhpWord\PhpWord();
        $data_kerjasama->getSettings()->setUpdateFields(true);
        // $section = $file->addSection();

        $data_kerjasama->addTitleStyle(1, array('size' => 20, 'bold' => true));
        $data_kerjasama->addTitleStyle(2, array('size' => 20, 'color' => '666666'));

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        //halaman 3
        $judul = $data_kerjasama->addSection();
        $judul->addText('DATA KERJASAMA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_kerjasama->addSection();
        $space1->addTextBreak(1);

        $judul2 = $data_kerjasama->addSection();
        $judul2->addText('1. Kerjasama Pendidikan',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        // Tabel Kerjasama Pendidikan
        $table = $data_kerjasama->addSection();

        $isi = $data_kerjasama->addSection();

        $table_kerjasama = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kerjasama->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellColSpan4 = array('gridSpan' => 4, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellColSpan5 = array('gridSpan' => 5, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellColSpan6 = array('gridSpan' => 6, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellColSpan7 = array('gridSpan' => 7, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $header_nomor = $table_kerjasama->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama_instansi = $table_kerjasama->addCell(1000, $cellRowSpan);
        $nama_instansi = $header_nama_instansi->addTextRun($cellHCentered);
        $nama_instansi->addText('Lembaga Mitra', $fontStyle2);

        $header_tingkat = $table_kerjasama->addCell(3000, $cellColSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat', $fontStyle2);

        $header_judul = $table_kerjasama->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan Kerjasama', $fontStyle2);

        $header_manfaat = $table_kerjasama->addCell(1000, $cellRowSpan);
        $manfaat = $header_manfaat->addTextRun($cellHCentered);
        $manfaat->addText('Manfaat bagi PS yang Diakreditasi', $fontStyle2);

        $header_waktu = $table_kerjasama->addCell(1000, $cellRowSpan);
        $waktu = $header_waktu->addTextRun($cellHCentered);
        $waktu->addText('Waktu Pelaksanaan', $fontStyle2);

        $header_bukti = $table_kerjasama->addCell(1000, $cellRowSpan);
        $bukti = $header_bukti->addTextRun($cellHCentered);
        $bukti->addText('Bukti Kerja sama', $fontStyle2);

        $header_kepuasan = $table_kerjasama->addCell(1000, $cellRowSpan);
        $kepuasan = $header_kepuasan->addTextRun($cellHCentered);
        $kepuasan->addText('Kepuasan Mitra Kerjasama', $fontStyle2);

        $table_kerjasama->addRow();

        $table_kerjasama->addCell(null, $cellRowContinue);
        $table_kerjasama->addCell(null, $cellRowContinue);
        $table_kerjasama->addCell(null, $cellRowContinue);
        $table_kerjasama->addCell(null, $cellRowContinue);
        $table_kerjasama->addCell(null, $cellRowContinue);
        $table_kerjasama->addCell(null, $cellRowContinue);
        $table_kerjasama->addCell(null, $cellRowContinue);
        $table_kerjasama->addCell(null, $cellRowContinue);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Internasional', $fontStyle2, $cellHCentered);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Nasional', $fontStyle2, $cellHCentered);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Lokal/Wilayah', $fontStyle2, $cellHCentered);

        $table_kerjasama->addRow();
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $kerjasama = DB::table('kerjasama')
            ->join('kategori_tingkat', 'kerjasama.id_kategori_tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_kerjasama', 'kerjasama.id_kategori_kerjasama', '=', 'kategori_kerjasama.id')
            ->select('kerjasama.*', 'kategori_tingkat.nama_kategori', 'kategori_kerjasama.kategori')->where('id_kategori_kerjasama', '=', '1')
            ->where('user_id', Auth::user()->kode_ps)->get();


        $i = 0;
        foreach ($kerjasama as $key => $value) {
            $i++;

            $table_kerjasama->addRow(2000);

            $cellNo = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellLembaga = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLembaga->addText($value->nama_instansi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($value->id_kategori_tingkat == 1) {
                $cellTingkat = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            if ($value->id_kategori_tingkat == 2) {
                $cellTingkat2 = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat2->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat2 = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat2->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            if ($value->id_kategori_tingkat == 3) {
                $cellTingkat3 = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat3->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat3 = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat3->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $cellJudul = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->judul_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellManfaat = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellManfaat->addText($value->manfaat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTanggal = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTanggal->addText($value->tanggal_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBukti = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBukti->addText($value->softcopy, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKepuasan = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKepuasan->addText($value->kepuasan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        //Kerjasama Penelitian

        $space4 = $data_kerjasama->addSection();
        $space4->addTextBreak();

        $judul2 = $data_kerjasama->addSection();
        $judul2->addText('2. Kerjasama Penelitian',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $data_kerjasama->addSection();
        $kerjasama = DB::table('kerjasama')
            ->join('kategori_tingkat', 'kerjasama.id_kategori_tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_kerjasama', 'kerjasama.id_kategori_kerjasama', '=', 'kategori_kerjasama.id')
            ->select('kerjasama.*', 'kategori_tingkat.nama_kategori', 'kategori_kerjasama.kategori')->where('id_kategori_kerjasama', '=', '2')
            ->where('user_id', Auth::user()->kode_ps)->get();


        $table_kerjasama_penelitian = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kerjasama_penelitian->addRow(1000);

        $header_nomor = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama_instansi = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $nama_instansi = $header_nama_instansi->addTextRun($cellHCentered);
        $nama_instansi->addText('Lembaga Mitra', $fontStyle2);

        $header_tingkat = $table_kerjasama_penelitian->addCell(null, $cellColSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat', $fontStyle2);
        $tingkat->addFootnote();

        $header_judul = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan Kerjasama', $fontStyle2);
        $judul->addFootnote();

        $header_manfaat = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $manfaat = $header_manfaat->addTextRun($cellHCentered);
        $manfaat->addText('Manfaat bagi PS yang Diakreditasi', $fontStyle2);

        $header_waktu = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $waktu = $header_waktu->addTextRun($cellHCentered);
        $waktu->addText('Waktu Pelaksanaan', $fontStyle2);

        $header_bukti = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $bukti = $header_bukti->addTextRun($cellHCentered);
        $bukti->addText('Bukti Kerja sama', $fontStyle2);
        $bukti->addFootnote();

        $header_kepuasan = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $kepuasan = $header_kepuasan->addTextRun($cellHCentered);
        $kepuasan->addText('Kepuasan Mitra Kerjasama', $fontStyle2);

        $table_kerjasama_penelitian->addRow();

        $table_kerjasama_penelitian->addCell(null, $cellRowContinue);
        $table_kerjasama_penelitian->addCell(null, $cellRowContinue);
        $table_kerjasama_penelitian->addCell(null, $cellRowContinue);
        $table_kerjasama_penelitian->addCell(null, $cellRowContinue);
        $table_kerjasama_penelitian->addCell(null, $cellRowContinue);
        $table_kerjasama_penelitian->addCell(null, $cellRowContinue);
        $table_kerjasama_penelitian->addCell(null, $cellRowContinue);
        $table_kerjasama_penelitian->addCell(null, $cellRowContinue);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Internasional', $fontStyle2, $cellHCentered);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Nasional', $fontStyle2, $cellHCentered);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Lokal/Wilayah', $fontStyle2, $cellHCentered);

        $table_kerjasama_penelitian->addRow();
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        foreach ($kerjasama as $key => $value) {
            $i++;

            $table_kerjasama_penelitian->addRow(2000);

            $cellNo = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellLembaga = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLembaga->addText($value->nama_instansi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($value->id_kategori_tingkat == 1) {
                $cellTingkat = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            if ($value->id_kategori_tingkat == 2) {
                $cellTingkat2 = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat2->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat2 = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat2->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            if ($value->id_kategori_tingkat == 3) {
                $cellTingkat3 = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat3->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat3 = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat3->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $cellJudul = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->judul_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellManfaat = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellManfaat->addText($value->manfaat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTanggal = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTanggal->addText($value->tanggal_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBukti = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBukti->addText($value->softcopy, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKepuasan = $table_kerjasama_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKepuasan->addText($value->kepuasan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $data_kerjasama->addSection();
        $space6->addTextBreak();

        //Kerjasama Pengembangan Kegiatan Masyarakat

        $judul2 = $data_kerjasama->addSection();
        $judul2->addText('3. Kerjasama Pengembangan Kegiatan Masyarakat',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $data_kerjasama->addSection();
        $kerjasama = DB::table('kerjasama')
            ->join('kategori_tingkat', 'kerjasama.id_kategori_tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_kerjasama', 'kerjasama.id_kategori_kerjasama', '=', 'kategori_kerjasama.id')
            ->select('kerjasama.*', 'kategori_tingkat.nama_kategori', 'kategori_kerjasama.kategori')->where('id_kategori_kerjasama', '=', '3')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $table_kerjasama_pkm = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kerjasama_pkm->addRow(1000);

        $header_nomor = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama_instansi = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $nama_instansi = $header_nama_instansi->addTextRun($cellHCentered);
        $nama_instansi->addText('Lembaga Mitra', $fontStyle2);

        $header_tingkat = $table_kerjasama_pkm->addCell(null, $cellColSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat', $fontStyle2);
        $tingkat->addFootnote();

        $header_judul = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan Kerjasama', $fontStyle2);
        $judul->addFootnote();

        $header_manfaat = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $manfaat = $header_manfaat->addTextRun($cellHCentered);
        $manfaat->addText('Manfaat bagi PS yang Diakreditasi', $fontStyle2);

        $header_waktu = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $waktu = $header_waktu->addTextRun($cellHCentered);
        $waktu->addText('Waktu Pelaksanaan', $fontStyle2);

        $header_bukti = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $bukti = $header_bukti->addTextRun($cellHCentered);
        $bukti->addText('Bukti Kerja sama', $fontStyle2);
        $bukti->addFootnote();

        $header_kepuasan = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $kepuasan = $header_kepuasan->addTextRun($cellHCentered);
        $kepuasan->addText('Kepuasan Mitra Kerjasama', $fontStyle2);

        $table_kerjasama_pkm->addRow();

        $table_kerjasama_pkm->addCell(null, $cellRowContinue);
        $table_kerjasama_pkm->addCell(null, $cellRowContinue);
        $table_kerjasama_pkm->addCell(null, $cellRowContinue);
        $table_kerjasama_pkm->addCell(null, $cellRowContinue);
        $table_kerjasama_pkm->addCell(null, $cellRowContinue);
        $table_kerjasama_pkm->addCell(null, $cellRowContinue);
        $table_kerjasama_pkm->addCell(null, $cellRowContinue);
        $table_kerjasama_pkm->addCell(null, $cellRowContinue);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Internasional', $fontStyle2, $cellHCentered);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Nasional', $fontStyle2, $cellHCentered);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Lokal/Wilayah', $fontStyle2, $cellHCentered);

        $table_kerjasama_pkm->addRow();
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kerjasama_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        foreach ($kerjasama as $key => $value) {
            $i++;

            $table_kerjasama_pkm->addRow(2000);
            $cellNo = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellLembaga = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLembaga->addText($value->nama_instansi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($value->id_kategori_tingkat == 1) {
                $cellTingkat = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            if ($value->id_kategori_tingkat == 2) {
                $cellTingkat2 = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat2->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat2 = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat2->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            if ($value->id_kategori_tingkat == 3) {
                $cellTingkat3 = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat3->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellTingkat3 = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTingkat3->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $cellJudul = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->judul_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellManfaat = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellManfaat->addText($value->manfaat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTanggal = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTanggal->addText($value->tanggal_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBukti = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBukti->addText($value->softcopy, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKepuasan = $table_kerjasama_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKepuasan->addText($value->kepuasan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_kerjasama;
    }

    private function generate_mhs()
    {
        //Mahasiswa Reguler
        $data_mhs_reg = new \PhpOffice\PhpWord\PhpWord();
        $data_mhs_reg->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_mhs_reg->addSection();
        $judul->addText('DATA MAHASISWA REGULER', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_mhs_reg->addSection();
        $space1->addTextBreak(1);

        $table = $data_mhs_reg->addSection();

        $table_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_mhs->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_mhs->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_mhs->addCell(1000, $cellRowSpan);
        $nama_instansi = $header_npm->addTextRun($cellHCentered);
        $nama_instansi->addText('NPM', $fontStyle2);

        $header_nama = $table_mhs->addCell(3000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama', $fontStyle2);

        $header_tahun = $table_mhs->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_email = $table_mhs->addCell(1000, $cellRowSpan);
        $email = $header_email->addTextRun($cellHCentered);
        $email->addText('Email', $fontStyle2);

        $header_dosen = $table_mhs->addCell(1000, $cellRowSpan);
        $dosen = $header_dosen->addTextRun($cellHCentered);
        $dosen->addText('Dosen Wali', $fontStyle2);

        $header_jalur = $table_mhs->addCell(1000, $cellRowSpan);
        $jalur = $header_jalur->addTextRun($cellHCentered);
        $jalur->addText('Jalur Masuk', $fontStyle2);

        $table_mhs->addRow();
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $biodata_mhs = MhsReguler::with('kategori_status_mhs', 'kategori_jalur', 'dosen')->where('id_status', '1')->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($biodata_mhs as $key => $value) {
            $i++;

            $table_mhs->addRow(2000);
            $cellNo = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->npm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(date('Y', strtotime($value->tahun_masuk)), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellEmail = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellEmail->addText($value->email, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellDosen = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDosen->addText($value->dosen['nama_dosen'] ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJalur = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJalur->addText($value->kategori_jalur_masuk['jalur_masuk'] ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_mhs_reg;
    }

    private function generate_mhs_non()
    {
        //Mahasiswa Reguler
        $data_mhs_non = new \PhpOffice\PhpWord\PhpWord();
        $data_mhs_non->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_mhs_non->addSection();
        $judul->addText('DATA MAHASISWA NON REGULER', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_mhs_non->addSection();
        $space1->addTextBreak(1);

        $table = $data_mhs_non->addSection();

        $table_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_mhs->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_mhs->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_mhs->addCell(1000, $cellRowSpan);
        $nama_instansi = $header_npm->addTextRun($cellHCentered);
        $nama_instansi->addText('NPM', $fontStyle2);

        $header_nama = $table_mhs->addCell(3000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama', $fontStyle2);

        $header_tahun = $table_mhs->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_email = $table_mhs->addCell(1000, $cellRowSpan);
        $email = $header_email->addTextRun($cellHCentered);
        $email->addText('Email', $fontStyle2);

        $header_dosen = $table_mhs->addCell(1000, $cellRowSpan);
        $dosen = $header_dosen->addTextRun($cellHCentered);
        $dosen->addText('Dosen Wali', $fontStyle2);

        $header_jalur = $table_mhs->addCell(1000, $cellRowSpan);
        $jalur = $header_jalur->addTextRun($cellHCentered);
        $jalur->addText('Jalur Masuk', $fontStyle2);

        $table_mhs->addRow();
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $biodata_mhs = DB::table('biodata_mhs')
            ->join('kategori_status_mhs', 'biodata_mhs.id_status', '=', 'kategori_status_mhs.id')
            ->join('kategori_jalur', 'biodata_mhs.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->join('dosen', 'biodata_mhs.dosen_id', '=', 'dosen.dosen_id')
            ->select('biodata_mhs.*', 'kategori_jalur.jalur_masuk', 'kategori_status_mhs.status', 'dosen.nama_dosen')
            ->where('biodata_mhs.id_status', '2')->where('biodata_mhs.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($biodata_mhs as $key => $value) {
            $i++;

            $table_mhs->addRow(2000);
            $cellNo = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->npm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(date('Y', strtotime($value->tahun_masuk)), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellEmail = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellEmail->addText($value->email, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellDosen = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDosen->addText($value->dosen['nama_dosen'] ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJalur = $table_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJalur->addText($value->kategori_jalur_masuk['jalur_masuk'] ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_mhs_non;
    }

    private function generate_daya_tampung()
    {
        //Data Daya Tampung
        $data_daya_tampung = new \PhpOffice\PhpWord\PhpWord();
        $data_daya_tampung->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_daya_tampung->addSection();
        $judul->addText('DATA DAYA TAMPUNG', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_daya_tampung->addSection();
        $space1->addTextBreak(1);

        $table = $data_daya_tampung->addSection();

        $table_tampung = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_tampung->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_tampung->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_tahun = $table_tampung->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_jumlah = $table_tampung->addCell(1000, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah Daya Tampung', $fontStyle2);

        $table_tampung->addRow();
        $table_tampung->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_tampung->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_tampung->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $daya_tampung = DB::table('daya_tampung')->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($daya_tampung as $key => $value) {
            $i++;

            $table_tampung->addRow(2000);
            $cellNo = $table_tampung->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_tampung->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_tampung->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->daya_tampung, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_daya_tampung;
    }

    private function generate_pendaftar()
    {
        //Data Daya Tampung
        $data_pendaftar = new \PhpOffice\PhpWord\PhpWord();
        $data_pendaftar->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_pendaftar->addSection();
        $judul->addText('DATA PENDAFTAR', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_pendaftar->addSection();
        $space1->addTextBreak(1);

        $table = $data_pendaftar->addSection();

        $table_pendaftar = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_pendaftar->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_pendaftar->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_ujian = $table_pendaftar->addCell(1000, $cellRowSpan);
        $ujian = $header_ujian->addTextRun($cellHCentered);
        $ujian->addText('Nomor Ujian', $fontStyle2);

        $header_nama = $table_pendaftar->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama', $fontStyle2);

        $header_asal = $table_pendaftar->addCell(1000, $cellRowSpan);
        $asal = $header_asal->addTextRun($cellHCentered);
        $asal->addText('Asal Sekolah', $fontStyle2);

        $header_jalur = $table_pendaftar->addCell(1000, $cellRowSpan);
        $jalur = $header_jalur->addTextRun($cellHCentered);
        $jalur->addText('Jalur Masuk', $fontStyle2);

        $header_tahun = $table_pendaftar->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $table_pendaftar->addRow();
        $table_pendaftar->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pendaftar->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pendaftar->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pendaftar->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pendaftar->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pendaftar->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $pendaftar = DB::table('pendaftar')
            ->join('kategori_jalur', 'pendaftar.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->select('pendaftar.*', 'kategori_jalur.jalur_masuk')
            ->orderBy('tahun_masuk', 'ASC')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($pendaftar as $key => $value) {
            $i++;

            $table_pendaftar->addRow(2000);
            $cellNo = $table_pendaftar->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellUjian = $table_pendaftar->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellUjian->addText($value->no_ujian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_pendaftar->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellAsal = $table_pendaftar->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellAsal->addText($value->asal_sekolah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJalur = $table_pendaftar->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJalur->addText($value->jalur_masuk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_pendaftar->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun_masuk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_pendaftar;
    }


    private function generate_lulus()
    {
        //Data lulus seleksi
        $data_lulus = new \PhpOffice\PhpWord\PhpWord();
        $data_lulus->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_lulus->addSection();
        $judul->addText('DATA LULUS SELEKSI', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_lulus->addSection();
        $space1->addTextBreak(1);

        $table = $data_lulus->addSection();

        $table_lulus = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_lulus->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_lulus->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_ujian = $table_lulus->addCell(1000, $cellRowSpan);
        $ujian = $header_ujian->addTextRun($cellHCentered);
        $ujian->addText('Nomor Ujian', $fontStyle2);

        $header_nama = $table_lulus->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama', $fontStyle2);

        $header_asal = $table_lulus->addCell(1000, $cellRowSpan);
        $asal = $header_asal->addTextRun($cellHCentered);
        $asal->addText('Asal Sekolah', $fontStyle2);

        $header_jalur = $table_lulus->addCell(1000, $cellRowSpan);
        $jalur = $header_jalur->addTextRun($cellHCentered);
        $jalur->addText('Jalur Masuk', $fontStyle2);

        $header_tahun = $table_lulus->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $table_lulus->addRow();
        $table_lulus->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lulus->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lulus->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lulus->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lulus->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lulus->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $mhs_lulus = DB::table('mhs_lulus')
            ->join('kategori_jalur', 'mhs_lulus.jalur_masuk_id', '=', 'kategori_jalur.id')
            ->select('mhs_lulus.*', 'kategori_jalur.jalur_masuk')
            ->orderBy('tahun_masuk', 'ASC')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($mhs_lulus as $key => $value) {
            $i++;

            $table_lulus->addRow(2000);
            $cellNo = $table_lulus->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellUjian = $table_lulus->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellUjian->addText($value->no_ujian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_lulus->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellAsal = $table_lulus->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellAsal->addText($value->asal_sekolah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJalur = $table_lulus->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJalur->addText($value->jalur_masuk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_lulus->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun_masuk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_lulus;
    }

    private function generate_mhs_asing()
    {
        //Data Daya Tampung
        $data_mhs_asing = new \PhpOffice\PhpWord\PhpWord();
        $data_mhs_asing->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_mhs_asing->addSection();
        $judul->addText('DATA MAHASISWA ASING', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_mhs_asing->addSection();
        $space1->addTextBreak(1);

        $table = $data_mhs_asing->addSection();

        $table_mhs_asing = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_mhs_asing->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_mhs_asing->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_mhs_asing->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('NPM', $fontStyle2);

        $header_nama = $table_mhs_asing->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama', $fontStyle2);

        $header_asal = $table_mhs_asing->addCell(1000, $cellRowSpan);
        $asal = $header_asal->addTextRun($cellHCentered);
        $asal->addText('Asal', $fontStyle2);

        $header_jenis = $table_mhs_asing->addCell(1000, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jalur Masuk', $fontStyle2);

        $header_tahun = $table_mhs_asing->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_email = $table_mhs_asing->addCell(1000, $cellRowSpan);
        $email = $header_email->addTextRun($cellHCentered);
        $email->addText('Email', $fontStyle2);

        $header_nama_dosen = $table_mhs_asing->addCell(1000, $cellRowSpan);
        $nama_dosen = $header_nama_dosen->addTextRun($cellHCentered);
        $nama_dosen->addText('Nama Dosen Wali', $fontStyle2);


        $table_mhs_asing->addRow();
        $table_mhs_asing->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs_asing->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs_asing->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs_asing->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs_asing->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs_asing->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs_asing->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mhs_asing->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $mhs_asing = MhsReguler::with(['data_pembimbing_ta', 'kategori_jalur', 'data_pembimbing_ta.dosen'])->where('asal_id', '2')->where('user_id', Auth::user()->kode_ps);
        if (request('withtrash') == 1) {
            $mhs_asing = $mhs_asing->whereNotNull('deleted_at')->withTrashed();
        }
        $mhs_asing = $mhs_asing->get();

        $i = 0;
        foreach ($mhs_asing as $key => $value) {
            $i++;

            $table_mhs_asing->addRow(2000);
            $cellNo = $table_mhs_asing->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_mhs_asing->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->npm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_mhs_asing->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellAsal = $table_mhs_asing->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellAsal->addText($value->kategori_asal['asal'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_mhs_asing->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->kategori_jalur['jalur_masuk'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_mhs_asing->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(date('Y', strtotime($value->tahun_masuk)), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellEmail = $table_mhs_asing->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellEmail->addText($value->email, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNamaDosen = $table_mhs_asing->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNamaDosen->addText($value->dosen['nama_dosen'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_mhs_asing;
    }

    private function generate_dosen()
    {
        //Data Daya Tampung
        $data_dosen = new \PhpOffice\PhpWord\PhpWord();
        $data_dosen->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_dosen->addSection();
        $judul->addText('DATA DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_dosen->addSection();
        $space1->addTextBreak(1);

        $judul2 = $data_dosen->addSection();
        $judul2->addText('1. Data Dosen Tetap',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $data_dosen->addSection();

        $table_dosen_tetap = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dosen_tetap->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_tgl = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Tanggal Lahir', $fontStyle2);

        $header_tempat = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $tempat = $header_tempat->addTextRun($cellHCentered);
        $tempat->addText('Tempat Lahir', $fontStyle2);

        $header_pendidikan = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $pendidikan = $header_pendidikan->addTextRun($cellHCentered);
        $pendidikan->addText('Pendidikan', $fontStyle2);

        $header_bidang = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $bidang = $header_bidang->addTextRun($cellHCentered);
        $bidang->addText('Bidang', $fontStyle2);

        $header_jabatan = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $nama_jabatan = $header_jabatan->addTextRun($cellHCentered);
        $nama_jabatan->addText('Jabatan', $fontStyle2);

        $header_golongan = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $golongan = $header_golongan->addTextRun($cellHCentered);
        $golongan->addText('Golongan', $fontStyle2);

        $header_scopus = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $scopus = $header_scopus->addTextRun($cellHCentered);
        $scopus->addText('Scopus', $fontStyle2);

        $header_sinta = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $sinta = $header_sinta->addTextRun($cellHCentered);
        $sinta->addText('Sinta', $fontStyle2);

        $header_sertif = $table_dosen_tetap->addCell(1000, $cellRowSpan);
        $sertif = $header_sertif->addTextRun($cellHCentered);
        $sertif->addText('Sertifikat Pendidik', $fontStyle2);

        $table_dosen_tetap->addRow();
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('11', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('12', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosen = DosenTetap::with('jenis_dosen', 'jabatan_fungsional', 'kategori_pendidikan')->where('jenis_dosen', '1')->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($dosen as $key => $value) {
            $i++;

            $table_dosen_tetap->addRow(2000);
            $cellNo = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTgl = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTgl->addText($value->tgl_lahir, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTempat = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTempat->addText($value->tempat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPend = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPend->addText($value->kategori_pendidikan['pendidikan'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBidang = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBidang->addText($value->bidang, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJabatan = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJabatan->addText($value->jabatan_fungsional['nama_jabatan'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellGol = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellGol->addText($value->golongan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellScopus = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellScopus->addText($value->scopus ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSinta = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSinta->addText($value->sinta ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSertif = $table_dosen_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSertif->addText($value->sertifikat_pendidik ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space1 = $data_dosen->addSection();
        $space1->addTextBreak(1);

        $judul2 = $data_dosen->addSection();
        $judul2->addText('2. Data Dosen Tidak Tetap',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $data_dosen->addSection();

        $table_dosen_tetap_tdk = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dosen_tetap_tdk->addRow(1000);

        $header_nomor = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_tgl = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Tanggal Lahir', $fontStyle2);

        $header_tempat = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $tempat = $header_tempat->addTextRun($cellHCentered);
        $tempat->addText('Tempat Lahir', $fontStyle2);

        $header_pendidikan = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $pendidikan = $header_pendidikan->addTextRun($cellHCentered);
        $pendidikan->addText('Pendidikan', $fontStyle2);

        $header_bidang = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $bidang = $header_bidang->addTextRun($cellHCentered);
        $bidang->addText('Bidang', $fontStyle2);

        $header_jabatan = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $nama_jabatan = $header_jabatan->addTextRun($cellHCentered);
        $nama_jabatan->addText('Jabatan', $fontStyle2);

        $header_golongan = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $golongan = $header_golongan->addTextRun($cellHCentered);
        $golongan->addText('Golongan', $fontStyle2);

        $header_scopus = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $scopus = $header_scopus->addTextRun($cellHCentered);
        $scopus->addText('Scopus', $fontStyle2);

        $header_sinta = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $sinta = $header_sinta->addTextRun($cellHCentered);
        $sinta->addText('Sinta', $fontStyle2);

        $header_sertif = $table_dosen_tetap_tdk->addCell(1000, $cellRowSpan);
        $sertif = $header_sertif->addTextRun($cellHCentered);
        $sertif->addText('Sertifikat Pendidik', $fontStyle2);

        $table_dosen_tetap_tdk->addRow();
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('11', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_tetap_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('12', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosen_tdk_tetap = DB::table('dosen')
            ->join('kategori_jenis_dosen', 'dosen.jenis_dosen', '=', 'kategori_jenis_dosen.id')
            ->join('jabatan_fungsional', 'dosen.jabatan_id', '=', 'jabatan_fungsional.id')
            ->join('kategori_pendidikan', 'dosen.pendidikan_id', '=', 'kategori_pendidikan.id')
            ->select('dosen.*', 'kategori_jenis_dosen.jenis', 'jabatan_fungsional.nama_jabatan', 'kategori_pendidikan.pendidikan')->where('jenis_dosen', '2')
            ->where('dosen.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($dosen_tdk_tetap as $key => $value) {
            $i++;

            $table_dosen_tetap_tdk->addRow(2000);
            $cellNo = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTgl = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTgl->addText($value->tgl_lahir, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTempat = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTempat->addText($value->tempat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPend = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPend->addText($value->pendidikan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBidang = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBidang->addText($value->bidang, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJabatan = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJabatan->addText($value->nama_jabatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellGol = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellGol->addText($value->golongan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellScopus = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellScopus->addText($value->scopus ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSinta = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSinta->addText($value->sinta ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSertif = $table_dosen_tetap_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSertif->addText($value->sertifikat_pendidik ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space1 = $data_dosen->addSection();
        $space1->addTextBreak(1);

        $judul2 = $data_dosen->addSection();
        $judul2->addText('3. Data Dosen Indutri',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $data_dosen->addSection();

        $table_dosen_industri = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dosen_industri->addRow(1000);

        $header_nomor = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_tgl = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Tanggal Lahir', $fontStyle2);

        $header_tempat = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $tempat = $header_tempat->addTextRun($cellHCentered);
        $tempat->addText('Tempat Lahir', $fontStyle2);

        $header_pendidikan = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $pendidikan = $header_pendidikan->addTextRun($cellHCentered);
        $pendidikan->addText('Pendidikan', $fontStyle2);

        $header_bidang = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $bidang = $header_bidang->addTextRun($cellHCentered);
        $bidang->addText('Bidang', $fontStyle2);

        $header_jabatan = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $nama_jabatan = $header_jabatan->addTextRun($cellHCentered);
        $nama_jabatan->addText('Jabatan', $fontStyle2);

        $header_golongan = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $golongan = $header_golongan->addTextRun($cellHCentered);
        $golongan->addText('Golongan', $fontStyle2);

        $header_scopus = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $scopus = $header_scopus->addTextRun($cellHCentered);
        $scopus->addText('Scopus', $fontStyle2);

        $header_sinta = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $sinta = $header_sinta->addTextRun($cellHCentered);
        $sinta->addText('Sinta', $fontStyle2);

        $header_sertif = $table_dosen_industri->addCell(1000, $cellRowSpan);
        $sertif = $header_sertif->addTextRun($cellHCentered);
        $sertif->addText('Sertifikat Pendidik', $fontStyle2);

        $table_dosen_industri->addRow();
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('11', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('12', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosen_industri = DB::table('dosen')
            ->join('kategori_jenis_dosen', 'dosen.jenis_dosen', '=', 'kategori_jenis_dosen.id')
            ->join('jabatan_fungsional', 'dosen.jabatan_id', '=', 'jabatan_fungsional.id')
            ->join('kategori_pendidikan', 'dosen.pendidikan_id', '=', 'kategori_pendidikan.id')
            ->select('dosen.*', 'kategori_jenis_dosen.jenis', 'jabatan_fungsional.nama_jabatan', 'kategori_pendidikan.pendidikan')->where('jenis_dosen', '3')
            ->where('dosen.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($dosen_industri as $key => $value) {
            $i++;

            $table_dosen_industri->addRow(2000);
            $cellNo = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTgl = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTgl->addText($value->tgl_lahir, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTempat = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTempat->addText($value->tempat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPend = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPend->addText($value->pendidikan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBidang = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBidang->addText($value->bidang, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJabatan = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJabatan->addText($value->nama_jabatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellGol = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellGol->addText($value->golongan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellScopus = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellScopus->addText($value->scopus ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSinta = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSinta->addText($value->sinta ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSertif = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSertif->addText($value->sertifikat_pendidik ?? '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_dosen;
    }

    private function generate_aktivitas()
    {
        //Data lulus seleksi
        $data_aktivitas = new \PhpOffice\PhpWord\PhpWord();
        $data_aktivitas->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_aktivitas->addSection();
        $judul->addText('DATA AKTIVITAS DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_aktivitas->addSection();
        $space1->addTextBreak(1);

        $judul2 = $data_aktivitas->addSection();
        $judul2->addText('1. Data Aktivitas Dosen Tetap',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $data_aktivitas->addSection();

        $table_aktivitas_tetap = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_aktivitas_tetap->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_ps_sendiri = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $ps_sendiri = $header_ps_sendiri->addTextRun($cellHCentered);
        $ps_sendiri->addText('Matakuliah PS Sendiri', $fontStyle2);

        $header_sks_sendiri = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $sks_sendiri = $header_sks_sendiri->addTextRun($cellHCentered);
        $sks_sendiri->addText('SKS Matakuliah PS Sendiri', $fontStyle2);

        $header_ps_lain = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $ps_lain = $header_ps_lain->addTextRun($cellHCentered);
        $ps_lain->addText('Matakuliah PS Lain', $fontStyle2);

        $header_sks_lain = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $sks_lain = $header_sks_lain->addTextRun($cellHCentered);
        $sks_lain->addText('SKS Matakuliah PS Lain', $fontStyle2);

        $header_penelitian = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $penelitian = $header_penelitian->addTextRun($cellHCentered);
        $penelitian->addText('Sks Penelitian', $fontStyle2);

        $header_pengabdian = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $pengabdian = $header_pengabdian->addTextRun($cellHCentered);
        $pengabdian->addText('Sks Pengabdian', $fontStyle2);

        $header_m_sendiri = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $m_sendiri = $header_m_sendiri->addTextRun($cellHCentered);
        $m_sendiri->addText('Sks Manajemen PT Sendiri', $fontStyle2);

        $header_tahun = $table_aktivitas_tetap->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_aktivitas_tetap->addRow();
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tetap->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosentetap = DB::table('aktivitas')->join('dosen', 'aktivitas.dosen_id', '=', 'dosen.dosen_id')->where('dosen.jenis_dosen', '=', 1)->where('aktivitas.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($dosentetap as $key) {
            $i++;

            $table_aktivitas_tetap->addRow(2000);
            $cellNo = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($key->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $status = function ($query) {
                $query->where('ket', '=', 'PS Sendiri');
            };

            $mk = AktivitasTetap::whereHas('aktivitas_dosen', $status)->with(['aktivitas_dosen' => $status])->where('dosen_id', $key->dosen_id)->where('user_id', Auth::user()->kode_ps)->get();

            $listmk = [];
            $listsks = [];
            $cellMk = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mk as $item) {
                foreach ($item->aktivitas_dosen as $val) {
                    $listmk[] = $val->kurikulum['nama_mk'];
                    $listsks[] = $val->bobot_sks;
                }
            }

            $cellMk->addText(implode(', ', $listmk) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSks = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSks->addText(implode(', ', $listsks) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $status2 = function ($query2) {
                $query2->where('ket', '=', 'PS Lain');
            };

            $mk2 = AktivitasTetap::whereHas('aktivitas_dosen', $status2)->with(['aktivitas_dosen' => $status2])->where('dosen_id', $key->dosen_id)->where('user_id', Auth::user()->kode_ps)->get();

            $listmk2 = [];
            $listsks2 = [];
            $cellMklain = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mk2 as $item2) {
                foreach ($item2->aktivitas_dosen as $val2) {
                    $listmk2[] = $val2->kurikulum['nama_mk'];
                    $listsks2[] = $val2->bobot_sks;
                }
            }

            $cellMklain->addText(implode(', ', $listmk2) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSkslain = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSkslain->addText(implode(', ', $listsks2) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellPenelitian = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPenelitian->addText($key->sks_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPkm = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPkm->addText($key->sks_p2m, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMSendiri = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMSendiri->addText($key->m_pt_sendiri, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_aktivitas_tetap->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($key->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space1 = $data_aktivitas->addSection();
        $space1->addTextBreak(1);

        $judul2 = $data_aktivitas->addSection();
        $judul2->addText('2. Data Aktivitas Dosen Tidak Tetap',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $data_aktivitas->addSection();

        $table_aktivitas_tdk = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_aktivitas_tdk->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_ps_sendiri = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $ps_sendiri = $header_ps_sendiri->addTextRun($cellHCentered);
        $ps_sendiri->addText('Matakuliah PS Sendiri', $fontStyle2);

        $header_sks_sendiri = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $sks_sendiri = $header_sks_sendiri->addTextRun($cellHCentered);
        $sks_sendiri->addText('SKS Matakuliah PS Sendiri', $fontStyle2);

        $header_ps_lain = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $ps_lain = $header_ps_lain->addTextRun($cellHCentered);
        $ps_lain->addText('Matakuliah PS Lain', $fontStyle2);

        $header_sks_lain = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $sks_lain = $header_sks_lain->addTextRun($cellHCentered);
        $sks_lain->addText('SKS Matakuliah PS Lain', $fontStyle2);

        $header_penelitian = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $penelitian = $header_penelitian->addTextRun($cellHCentered);
        $penelitian->addText('Sks Penelitian', $fontStyle2);

        $header_pengabdian = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $pengabdian = $header_pengabdian->addTextRun($cellHCentered);
        $pengabdian->addText('Sks Pengabdian', $fontStyle2);

        $header_m_sendiri = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $m_sendiri = $header_m_sendiri->addTextRun($cellHCentered);
        $m_sendiri->addText('Sks Manajemen PT Sendiri', $fontStyle2);

        $header_tahun = $table_aktivitas_tdk->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_aktivitas_tdk->addRow();
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_tdk->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosentdktetap =  DB::table('aktivitas')->join('dosen', 'aktivitas.dosen_id', '=', 'dosen.dosen_id')->where('dosen.jenis_dosen', '=', 2)->where('aktivitas.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($dosentdktetap as $key) {
            $i++;

            $table_aktivitas_tdk->addRow(2000);
            $cellNo = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($key->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $statustdk = function ($query3) {
                $query3->where('ket', '=', 'PS Sendiri');
            };

            $mkkontrak = AktivitasTdkTetap::whereHas('aktivitas_dosen', $statustdk)->with(['aktivitas_dosen' => $statustdk])->where('dosen_id', $key->dosen_id)->where('user_id', Auth::user()->kode_ps)->get();

            $listmkkontrak = [];
            $listskskontrak = [];
            $cellMk = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mkkontrak as $item3) {
                foreach ($item3->aktivitas_dosen as $val3) {
                    $listmkkontrak[] = $val3->kurikulum['nama_mk'];
                    $listskskontrak[] = $val3->bobot_sks;
                }
            }

            $cellMk->addText(implode(', ', $listmkkontrak) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSks = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSks->addText(implode(', ', $listskskontrak) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $statustdk2 = function ($query4) {
                $query4->where('ket', '=', 'PS Lain');
            };

            $mkkontrak2 = AktivitasTdkTetap::whereHas('aktivitas_dosen', $statustdk2)->with(['aktivitas_dosen' => $statustdk2])->where('dosen_id', $key->dosen_id)->where('user_id', Auth::user()->kode_ps)->get();

            $listmkkontrak2 = [];
            $listskskontrak2 = [];
            $cellMk2 = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mkkontrak2 as $item4) {
                foreach ($item4->aktivitas_dosen as $val4) {
                    $listmkkontrak2[] = $val4->kurikulum['nama_mk'];
                    $listskskontrak2[] = $val4->bobot_sks;
                }
            }

            $cellMk2->addText(implode(', ', $listmkkontrak2) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSks2 = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSks2->addText(implode(', ', $listskskontrak2) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellPenelitian = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPenelitian->addText($key->sks_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPkm = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPkm->addText($key->sks_p2m, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMSendiri = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMSendiri->addText($key->m_pt_sendiri, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_aktivitas_tdk->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($key->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space1 = $data_aktivitas->addSection();
        $space1->addTextBreak(1);

        $judul2 = $data_aktivitas->addSection();
        $judul2->addText('3. Data Aktivitas Dosen Industri',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $data_aktivitas->addSection();

        $table_aktivitas_industri = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_aktivitas_industri->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_ps_sendiri = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $ps_sendiri = $header_ps_sendiri->addTextRun($cellHCentered);
        $ps_sendiri->addText('Matakuliah PS Sendiri', $fontStyle2);

        $header_sks_sendiri = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $sks_sendiri = $header_sks_sendiri->addTextRun($cellHCentered);
        $sks_sendiri->addText('SKS Matakuliah PS Sendiri', $fontStyle2);

        $header_ps_lain = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $ps_lain = $header_ps_lain->addTextRun($cellHCentered);
        $ps_lain->addText('Matakuliah PS Lain', $fontStyle2);

        $header_sks_lain = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $sks_lain = $header_sks_lain->addTextRun($cellHCentered);
        $sks_lain->addText('SKS Matakuliah PS Lain', $fontStyle2);

        $header_penelitian = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $penelitian = $header_penelitian->addTextRun($cellHCentered);
        $penelitian->addText('Sks Penelitian', $fontStyle2);

        $header_pengabdian = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $pengabdian = $header_pengabdian->addTextRun($cellHCentered);
        $pengabdian->addText('Sks Pengabdian', $fontStyle2);

        $header_m_sendiri = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $m_sendiri = $header_m_sendiri->addTextRun($cellHCentered);
        $m_sendiri->addText('Sks Manajemen PT Sendiri', $fontStyle2);

        $header_tahun = $table_aktivitas_industri->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_aktivitas_industri->addRow();
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_aktivitas_industri->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosenindustri = DB::table('aktivitas')->join('dosen', 'aktivitas.dosen_id', '=', 'dosen.dosen_id')->where('dosen.jenis_dosen', '=', 3)->where('aktivitas.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($dosenindustri as $key) {
            $i++;

            $table_aktivitas_industri->addRow(2000);
            $cellNo = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($key->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $statusinds = function ($query3) {
                $query3->where('ket', '=', 'PS Sendiri');
            };

            $mkindustri = AktivitasIndustri::whereHas('aktivitas_dosen', $statusinds)->with(['aktivitas_dosen' => $statusinds])->where('dosen_id', $key->dosen_id)->where('user_id', Auth::user()->kode_ps)->get();

            $listmkindustri = [];
            $listsksindustri = [];
            $cellMk = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mkindustri as $item) {
                foreach ($item->aktivitas_dosen as $val3) {
                    $listmkindustri[] = $val3->kurikulum['nama_mk'];
                    $listsksindustri[] = $val3->bobot_sks;
                }
            }

            $cellMk->addText(implode(', ', $listmkindustri) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSks = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSks->addText(implode(', ', $listsksindustri) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $statusinds2 = function ($query3) {
                $query3->where('ket', '=', 'PS Lain');
            };

            $mkindustri2 = AktivitasIndustri::whereHas('aktivitas_dosen', $statusinds2)->with(['aktivitas_dosen' => $statusinds2])->where('dosen_id', $key->dosen_id)->where('user_id', Auth::user()->kode_ps)->get();

            $listmkindustri2 = [];
            $listsksindustri2 = [];
            $cellMk2 = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mkindustri2 as $item) {
                foreach ($item->aktivitas_dosen as $val3) {
                    $listmkindustri2[] = $val3->kurikulum['nama_mk'];
                    $listsksindustri2[] = $val3->bobot_sks;
                }
            }
            $cellMk2->addText(implode(', ', $listmkindustri2) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSks2 = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSks2->addText(implode(', ', $listsksindustri) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellPenelitian = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPenelitian->addText($key->sks_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPkm = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPkm->addText($key->sks_p2m, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMSendiri = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMSendiri->addText($key->m_pt_sendiri, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_aktivitas_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($key->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_aktivitas;
    }

    private function generate_pengajaran()
    {
        //Data lulus seleksi
        $data_pengajaran = new \PhpOffice\PhpWord\PhpWord();
        $data_pengajaran->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_pengajaran->addSection();
        $judul->addText('DATA PENGAJARAN DOSEN TETAP', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_pengajaran->addSection();
        $space1->addTextBreak(1);

        $table = $data_pengajaran->addSection();

        $table_pengajaran = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_pengajaran->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_pengajaran->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_pengajaran->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_pengajaran->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_mk = $table_pengajaran->addCell(1000, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Nama MK', $fontStyle2);

        $header_kelas = $table_pengajaran->addCell(1000, $cellRowSpan);
        $jlh_kelas = $header_kelas->addTextRun($cellHCentered);
        $jlh_kelas->addText('Jumlah Kelas', $fontStyle2);

        $header_rencana = $table_pengajaran->addCell(1000, $cellRowSpan);
        $rencana = $header_rencana->addTextRun($cellHCentered);
        $rencana->addText('Jumlah Direncanakan', $fontStyle2);

        $header_laksana = $table_pengajaran->addCell(1000, $cellRowSpan);
        $laksana = $header_laksana->addTextRun($cellHCentered);
        $laksana->addText('Jumlah Dilaksanakan', $fontStyle2);

        $table_pengajaran->addRow();
        $table_pengajaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengajaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengajaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengajaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengajaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengajaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengajaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $mengajar = DB::table('mengajar')
            ->join('dosen', 'mengajar.dosen_id', '=', 'dosen.dosen_id')
            ->join('kurikulum', 'mengajar.kurikulum_id', '=', 'kurikulum.id')
            ->select('mengajar.*', 'dosen.nama_dosen', 'dosen.nip', 'kurikulum.nama_mk')
            ->where('mengajar.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($mengajar as $key => $value) {
            $i++;

            $table_pengajaran->addRow(2000);
            $cellNo = $table_pengajaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_pengajaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_pengajaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMk = $table_pengajaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMk->addText($value->nama_mk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKelas = $table_pengajaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKelas->addText($value->jumlah_kelas, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellDirencanakan = $table_pengajaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDirencanakan->addText($value->rencana, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellDilaksanakan = $table_pengajaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDilaksanakan->addText($value->laksana, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_pengajaran;
    }

    private function generate_rekognisi()
    {
        //rekognisi
        $data_rekognisi = new \PhpOffice\PhpWord\PhpWord();
        $data_rekognisi->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_rekognisi->addSection();
        $judul->addText('DATA REKOGNISI DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_rekognisi->addSection();
        $space1->addTextBreak(1);

        $table = $data_rekognisi->addSection();

        $table_rekognisi = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_rekognisi->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_rekognisi->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_rekognisi->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_rekognisi->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_bidang = $table_rekognisi->addCell(1000, $cellRowSpan);
        $bidang = $header_bidang->addTextRun($cellHCentered);
        $bidang->addText('Bidang Keahlian', $fontStyle2);

        $header_rekognisi = $table_rekognisi->addCell(1000, $cellRowSpan);
        $rekognisi = $header_rekognisi->addTextRun($cellHCentered);
        $rekognisi->addText('Rekognisi', $fontStyle2);

        $header_tahun = $table_rekognisi->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_rekognisi->addRow();
        $table_rekognisi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_rekognisi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_rekognisi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_rekognisi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_rekognisi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_rekognisi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $rekognisi = DB::table('rekognisi')
            ->join('dosen', 'rekognisi.dosen_id', '=', 'dosen.dosen_id')
            ->select('rekognisi.*', 'dosen.nama_dosen', 'dosen.nip')
            ->where('rekognisi.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($rekognisi as $key => $value) {
            $i++;

            $table_rekognisi->addRow(2000);
            $cellNo = $table_rekognisi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_rekognisi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_rekognisi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBidang = $table_rekognisi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBidang->addText($value->bidang_keahlian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellRekognisi = $table_rekognisi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRekognisi->addText($value->rekognisi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_rekognisi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_rekognisi;
    }

    private function generate_prestasi()
    {
        //rekognisi
        $data_prestasi = new \PhpOffice\PhpWord\PhpWord();
        $data_prestasi->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_prestasi->addSection();
        $judul->addText('DATA PRESTASI DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_prestasi->addSection();
        $space1->addTextBreak(1);

        $table = $data_prestasi->addSection();

        $table_prestasi = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_prestasi->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_prestasi->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_prestasi->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIP', $fontStyle2);

        $header_nama = $table_prestasi->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_prestasi = $table_prestasi->addCell(1000, $cellRowSpan);
        $prestasi = $header_prestasi->addTextRun($cellHCentered);
        $prestasi->addText('Prestasi', $fontStyle2);

        $header_tingkat = $table_prestasi->addCell(1000, $cellRowSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat', $fontStyle2);

        $header_tahun = $table_prestasi->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_prestasi->addRow();
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $prestasi_dosen = DB::table('prestasi_dosen')
            ->join('dosen', 'prestasi_dosen.dosen_id', '=', 'dosen.dosen_id')
            ->join('kategori_tingkat', 'prestasi_dosen.tingkat', '=', 'kategori_tingkat.id')
            ->select('prestasi_dosen.*', 'kategori_tingkat.nama_kategori', 'dosen.nip', 'dosen.nama_dosen')
            ->orderBy('tahun', 'asc')
            ->where('prestasi_dosen.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($prestasi_dosen as $key => $value) {
            $i++;

            $table_prestasi->addRow(2000);
            $cellNo = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPrestasi = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPrestasi->addText($value->judul_prestasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTingkat = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTingkat->addText($value->nama_kategori, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_prestasi;
    }

    private function generate_kependidikan()
    {
        //rekognisi
        $data_kependidikan = new \PhpOffice\PhpWord\PhpWord();
        $data_kependidikan->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_kependidikan->addSection();
        $judul->addText('DATA TENAGA KEPENDIDIKAN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_kependidikan->addSection();
        $space1->addTextBreak(1);

        $table = $data_kependidikan->addSection();

        $table_kependidikan = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kependidikan->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_kependidikan->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_kependidikan->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('NIDN', $fontStyle2);

        $header_nama = $table_kependidikan->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Tenaga Kependidikan', $fontStyle2);

        $header_tgl = $table_kependidikan->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Tanggal Lahir', $fontStyle2);

        $header_tgl = $table_kependidikan->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Alamat', $fontStyle2);

        $header_unit = $table_kependidikan->addCell(1000, $cellRowSpan);
        $unit = $header_unit->addTextRun($cellHCentered);
        $unit->addText('Unit Kerja', $fontStyle2);

        $header_profesi = $table_kependidikan->addCell(1000, $cellRowSpan);
        $profesi = $header_profesi->addTextRun($cellHCentered);
        $profesi->addText('Profesi', $fontStyle2);

        $table_kependidikan->addRow();
        $table_kependidikan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kependidikan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kependidikan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kependidikan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kependidikan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kependidikan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kependidikan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $tenaga_kependidikan = DB::table('tenaga_kependidikan')
            ->join('data_unit_kerja', 'tenaga_kependidikan.unit_kerja_id', '=', 'data_unit_kerja.id')
            ->join('data_tenaga_kependidikan', 'tenaga_kependidikan.data_tenaga_kependidikan_id', '=', 'data_tenaga_kependidikan.id')
            ->join('daftar_pendidikan', 'tenaga_kependidikan.pendidikan_id', '=', 'daftar_pendidikan.id')
            ->select('tenaga_kependidikan.*', 'data_tenaga_kependidikan.posisi', 'daftar_pendidikan.nama_pendidikan', 'data_unit_kerja.unit')
            ->where('tenaga_kependidikan.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($tenaga_kependidikan as $key => $value) {
            $i++;

            $table_kependidikan->addRow(2000);
            $cellNo = $table_kependidikan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_kependidikan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($value->nidn, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_kependidikan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBidang = $table_kependidikan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBidang->addText($value->tgl_lahir, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellRekognisi = $table_kependidikan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRekognisi->addText($value->alamat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_kependidikan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->unit, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellRekognisi = $table_kependidikan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRekognisi->addText($value->posisi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_kependidikan;
    }


    private function generate_perolehan_dana()
    {
        //rekognisi
        $perolehan_dana = new \PhpOffice\PhpWord\PhpWord();
        $perolehan_dana->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $perolehan_dana->addSection();
        $judul->addText('DATA PEROLEHAN DANA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $perolehan_dana->addSection();
        $space1->addTextBreak(1);

        $table = $perolehan_dana->addSection();

        $table_dana = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dana->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_dana->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_dana->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('Sumber Dana', $fontStyle2);

        $header_nama = $table_dana->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Jenis Dana', $fontStyle2);

        $header_tgl = $table_dana->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Dana [Rp.]', $fontStyle2);

        $header_tgl = $table_dana->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Tahun', $fontStyle2);

        $table_dana->addRow();
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $perolehan = DB::table('jenis_dana')
            ->join('sumber_dana', 'jenis_dana.sumber_dana_id', '=', 'sumber_dana.id')
            ->select('jenis_dana.*', 'sumber_dana.nama_sumber_dana')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($perolehan as $key => $value) {
            $i++;

            $table_dana->addRow(2000);
            $cellNo = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_jenis_dana, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPengelola = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPengelola->addText($value->nama_sumber_dana, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellDana = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDana->addText("Rp " . number_format($value->jumlah_dana, 2, ',', '.'), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $perolehan_dana;
    }


    private function generate_penggunaan_dana()
    {
        //rekognisi
        $penggunaan_dana = new \PhpOffice\PhpWord\PhpWord();
        $penggunaan_dana->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $penggunaan_dana->addSection();
        $judul->addText('DATA PENGGUNAAN DANA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $penggunaan_dana->addSection();
        $space1->addTextBreak(1);

        $table = $penggunaan_dana->addSection();

        $table_dana = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dana->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_dana->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nip = $table_dana->addCell(1000, $cellRowSpan);
        $nip = $header_nip->addTextRun($cellHCentered);
        $nip->addText('Jenis Penggunaan', $fontStyle2);

        $header_nama = $table_dana->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Jenis Pengelola', $fontStyle2);

        $header_tgl = $table_dana->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Dana [Rp.]', $fontStyle2);

        $header_tgl = $table_dana->addCell(1000, $cellRowSpan);
        $tgl = $header_tgl->addTextRun($cellHCentered);
        $tgl->addText('Tahun', $fontStyle2);

        $table_dana->addRow();
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dana = DB::table('penggunaan_dana')
            ->join('jenis_penggunaan', 'penggunaan_dana.jenis_penggunaan_id', '=', 'jenis_penggunaan.id')
            ->join('kategori_pengelola', 'penggunaan_dana.kategori_pengelola_id', '=', 'kategori_pengelola.id')
            ->select('penggunaan_dana.*', 'jenis_penggunaan.nama_jenis_penggunaan', 'kategori_pengelola.pengelola')
            ->where('penggunaan_dana.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($dana as $key => $value) {
            $i++;

            $table_dana->addRow(2000);
            $cellNo = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_jenis_penggunaan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPengelola = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPengelola->addText($value->pengelola, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellDana = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDana->addText("Rp " . number_format($value->dana, 2, ',', '.'), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $penggunaan_dana;
    }


    private function generate_dana_penelitian()
    {
        //rekognisi
        $dana_penelitian = new \PhpOffice\PhpWord\PhpWord();
        $dana_penelitian->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $dana_penelitian->addSection();
        $judul->addText('DATA DANA PENELITIAN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $dana_penelitian->addSection();
        $space1->addTextBreak(1);

        $table = $dana_penelitian->addSection();

        $table_dana_penelitian = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dana_penelitian->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_dana_penelitian->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_judul = $table_dana_penelitian->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Penelitian', $fontStyle2);

        $header_sumber = $table_dana_penelitian->addCell(1000, $cellRowSpan);
        $sumber = $header_sumber->addTextRun($cellHCentered);
        $sumber->addText('Sumber', $fontStyle2);

        $header_jlh = $table_dana_penelitian->addCell(1000, $cellRowSpan);
        $jlh = $header_jlh->addTextRun($cellHCentered);
        $jlh->addText('Jumlah [Rp.]', $fontStyle2);

        $header_tahun = $table_dana_penelitian->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_dana_penelitian->addRow();
        $table_dana_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $data_penelitian = DB::table('data_penelitian')
            ->join('sumber_dana', 'data_penelitian.sumber_dana_id', '=', 'sumber_dana.id')
            ->select('data_penelitian.*', 'sumber_dana.nama_sumber_dana')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($data_penelitian as $key => $value) {
            $i++;

            $table_dana_penelitian->addRow(2000);
            $cellNo = $table_dana_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellJudul = $table_dana_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->judul_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSumber = $table_dana_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSumber->addText($value->nama_sumber_dana, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_dana_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText("Rp " . number_format($value->jumlah_dana, 2, ',', '.'), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_dana_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $dana_penelitian;
    }

    private function generate_dana_pkm()
    {
        //rekognisi
        $dana_pkm = new \PhpOffice\PhpWord\PhpWord();
        $dana_pkm->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $dana_pkm->addSection();
        $judul->addText('DATA DANA PKM', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $dana_pkm->addSection();
        $space1->addTextBreak(1);

        $table = $dana_pkm->addSection();

        $table_dana_pkm = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dana_pkm->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_dana_pkm->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_judul = $table_dana_pkm->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Penelitian', $fontStyle2);

        $header_sumber = $table_dana_pkm->addCell(1000, $cellRowSpan);
        $sumber = $header_sumber->addTextRun($cellHCentered);
        $sumber->addText('Sumber', $fontStyle2);

        $header_jlh = $table_dana_pkm->addCell(1000, $cellRowSpan);
        $jlh = $header_jlh->addTextRun($cellHCentered);
        $jlh->addText('Jumlah [Rp.]', $fontStyle2);

        $header_tahun = $table_dana_pkm->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_dana_pkm->addRow();
        $table_dana_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dana_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $data_pkm = DB::table('data_pkm')
            ->join('sumber_dana', 'data_pkm.sumber_dana_id', '=', 'sumber_dana.id')
            ->select('data_pkm.*', 'sumber_dana.nama_sumber_dana')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($data_pkm as $key => $value) {
            $i++;

            $table_dana_pkm->addRow(2000);
            $cellNo = $table_dana_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellJudul = $table_dana_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->judul_pkm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSumber = $table_dana_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSumber->addText($value->nama_sumber_dana, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_dana_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText("Rp " . number_format($value->jumlah_dana, 2, ',', '.'), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_dana_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $dana_pkm;
    }

    private function generate_ruang()
    {
        //rekognisi
        $data_ruang = new \PhpOffice\PhpWord\PhpWord();
        $data_ruang->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_ruang->addSection();
        $judul->addText('DATA RUANG KERJA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_ruang->addSection();
        $space1->addTextBreak(1);

        $table = $data_ruang->addSection();

        $table_data_ruang = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_data_ruang->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_data_ruang->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_judul = $table_data_ruang->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Ruang Kerja', $fontStyle2);

        $header_ruang = $table_data_ruang->addCell(1000, $cellRowSpan);
        $ruang = $header_ruang->addTextRun($cellHCentered);
        $ruang->addText('Jumlah Ruang', $fontStyle2);

        $header_jlh = $table_data_ruang->addCell(1000, $cellRowSpan);
        $jlh = $header_jlh->addTextRun($cellHCentered);
        $jlh->addText('Jumlah Luas (m2)', $fontStyle2);

        $table_data_ruang->addRow();
        $table_data_ruang->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_data_ruang->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_data_ruang->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_data_ruang->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $ruang = DB::table('data_ruang')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($ruang as $key => $value) {
            $i++;

            $table_data_ruang->addRow(2000);
            $cellNo = $table_data_ruang->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellRuang = $table_data_ruang->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRuang->addText($value->ruang_kerja, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_data_ruang->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->jumlah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellLuas = $table_data_ruang->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLuas->addText($value->luas, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_ruang;
    }

    private function generate_pustaka()
    {
        //rekognisi
        $data_pustaka = new \PhpOffice\PhpWord\PhpWord();
        $data_pustaka->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_pustaka->addSection();
        $judul->addText('DATA REKAP PUSTAKA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_pustaka->addSection();
        $space1->addTextBreak(1);

        $table = $data_pustaka->addSection();

        $table_pustaka = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_pustaka->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_pustaka->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_judul = $table_pustaka->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Jenis Buku', $fontStyle2);

        $header_jlh1 = $table_pustaka->addCell(1000, $cellRowSpan);
        $jlh1 = $header_jlh1->addTextRun($cellHCentered);
        $jlh1->addText('Jumlah Judul', $fontStyle2);

        $header_jlh = $table_pustaka->addCell(1000, $cellRowSpan);
        $jlh = $header_jlh->addTextRun($cellHCentered);
        $jlh->addText('Jumlah Copy', $fontStyle2);

        $table_pustaka->addRow();
        $table_pustaka->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pustaka->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pustaka->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pustaka->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $pustaka = DB::table('pustaka')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($pustaka as $key => $value) {
            $i++;

            $table_pustaka->addRow(2000);
            $cellNo = $table_pustaka->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellRuang = $table_pustaka->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRuang->addText($value->jenis_pustaka, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_pustaka->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->jumlah_judul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellLuas = $table_pustaka->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLuas->addText($value->jumlah_copy, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_pustaka;
    }

    private function generate_prasarana()
    {
        //rekognisi
        $data_prasarana = new \PhpOffice\PhpWord\PhpWord();
        $data_prasarana->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_prasarana->addSection();
        $judul->addText('DATA PRASARANA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_prasarana->addSection();
        $space1->addTextBreak(1);

        $table = $data_prasarana->addSection();

        $table_prasarana = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_prasarana->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_prasarana->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_judul = $table_prasarana->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Jenis Prasarana', $fontStyle2);

        $header_ruang = $table_prasarana->addCell(1000, $cellRowSpan);
        $ruang = $header_ruang->addTextRun($cellHCentered);
        $ruang->addText('Jumlah Unit', $fontStyle2);

        $header_jlh = $table_prasarana->addCell(1000, $cellRowSpan);
        $jlh = $header_jlh->addTextRun($cellHCentered);
        $jlh->addText('Total Luas', $fontStyle2);

        $header_jlh = $table_prasarana->addCell(1000, $cellRowSpan);
        $jlh = $header_jlh->addTextRun($cellHCentered);
        $jlh->addText('Kepemilikan', $fontStyle2);

        $header_jlh = $table_prasarana->addCell(1000, $cellRowSpan);
        $jlh = $header_jlh->addTextRun($cellHCentered);
        $jlh->addText('Kondisi', $fontStyle2);

        $table_prasarana->addRow();
        $table_prasarana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prasarana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prasarana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prasarana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prasarana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prasarana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $prasarana = DB::table('data_prasarana')
            ->join('kategori_kondisi', 'data_prasarana.kondisi', '=', 'kategori_kondisi.id')
            ->join('kategori_kepemilikan', 'data_prasarana.kepemilikan', '=', 'kategori_kepemilikan.id')
            ->select('data_prasarana.*', 'kategori_kondisi.kondisi', 'kategori_kepemilikan.jenis')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($prasarana as $key => $value) {
            $i++;

            $table_prasarana->addRow(2000);
            $cellNo = $table_prasarana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellRuang = $table_prasarana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRuang->addText($value->jenis_prasarana, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_prasarana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->jumlah_unit, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellLuas = $table_prasarana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLuas->addText($value->total_luas, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_prasarana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->jenis, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKondisi = $table_prasarana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKondisi->addText($value->kondisi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_prasarana;
    }


    private function generate_data_lab()
    {
        //rekognisi
        $data_lab = new \PhpOffice\PhpWord\PhpWord();
        $data_lab->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_lab->addSection();
        $judul->addText('DATA REKAP LABORATORIUM', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_lab->addSection();
        $space1->addTextBreak(1);

        $table = $data_lab->addSection();

        $table_lab = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_lab->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_lab->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_judul = $table_lab->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Nama Alat', $fontStyle2);

        $header_jlh1 = $table_lab->addCell(1000, $cellRowSpan);
        $jlh1 = $header_jlh1->addTextRun($cellHCentered);
        $jlh1->addText('Jumlah Alat', $fontStyle2);

        $header_thn = $table_lab->addCell(1000, $cellRowSpan);
        $thn = $header_thn->addTextRun($cellHCentered);
        $thn->addText('Tahun Pengadaan', $fontStyle2);

        $header_fungsi = $table_lab->addCell(1000, $cellRowSpan);
        $fungsi = $header_fungsi->addTextRun($cellHCentered);
        $fungsi->addText('Fungsi', $fontStyle2);

        $table_lab->addRow();
        $table_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $lab = DB::table('data_lab')
            ->where('data_lab.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($lab as $key => $value) {
            $i++;


            $table_lab->addRow(2000);
            $cellNo1 = $table_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo1->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama1 = $table_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama1->addText($value->nama_alat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah1 = $table_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah1->addText($value->jumlah_alat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun1 = $table_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun1->addText($value->tahun_pengadaan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellFungsi1 = $table_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellFungsi1->addText($value->fungsi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_lab;
    }

    private function generate_kurikulum()
    {
        //rekognisi
        $data_kurikulum = new \PhpOffice\PhpWord\PhpWord();
        $data_kurikulum->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_kurikulum->addSection();
        $judul->addText('DATA  KURIKULUM', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_kurikulum->addSection();
        $space1->addTextBreak(1);

        $table = $data_kurikulum->addSection();

        $table_kurikulum = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kurikulum->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_kurikulum->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_sm = $table_kurikulum->addCell(1000, $cellRowSpan);
        $sm = $header_sm->addTextRun($cellHCentered);
        $sm->addText('Semester', $fontStyle2);

        $header_mk = $table_kurikulum->addCell(1000, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Nama Mata Kuliah', $fontStyle2);

        $header_sks = $table_kurikulum->addCell(1000, $cellRowSpan);
        $sks = $header_sks->addTextRun($cellHCentered);
        $sks->addText('Bobot Sks', $fontStyle2);

        $header_tugas = $table_kurikulum->addCell(1000, $cellRowSpan);
        $tugas = $header_tugas->addTextRun($cellHCentered);
        $tugas->addText('Bobot Tugas', $fontStyle2);

        $header_seminar = $table_kurikulum->addCell(1000, $cellRowSpan);
        $seminar = $header_seminar->addTextRun($cellHCentered);
        $seminar->addText('Bobot Seminar', $fontStyle2);

        $header_capaian = $table_kurikulum->addCell(1000, $cellRowSpan);
        $capaian = $header_capaian->addTextRun($cellHCentered);
        $capaian->addText('Capaian', $fontStyle2);

        $header_unit = $table_kurikulum->addCell(1000, $cellRowSpan);
        $unit = $header_unit->addTextRun($cellHCentered);
        $unit->addText('Unit/ Jur/ Fak Penyelenggara', $fontStyle2);

        $table_kurikulum->addRow();
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $kurikulum = DB::table('kurikulum')
            ->join('semester', 'kurikulum.semester_id', '=', 'semester.id')
            ->select('kurikulum.*', 'semester.nama_semester')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($kurikulum as $key => $value) {
            $i++;

            $table_kurikulum->addRow(2000);
            $cellNo = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_semester, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMk = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMk->addText($value->nama_mk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSks = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSks->addText($value->bobot_sks, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTugas = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTugas->addText($value->bobot_tugas, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSeminar = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSeminar->addText($value->sks_seminar, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellCapaian = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellCapaian->addText($value->capaian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellUnit = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellUnit->addText($value->unit, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_kurikulum;
    }

    private function generate_mk_pilihan()
    {
        //rekognisi
        $data_mk_pilihan = new \PhpOffice\PhpWord\PhpWord();
        $data_mk_pilihan->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_mk_pilihan->addSection();
        $judul->addText('DATA MATAKULIAH PILIHAN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_mk_pilihan->addSection();
        $space1->addTextBreak(1);

        $table = $data_mk_pilihan->addSection();

        $table_mk_pilihan = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_mk_pilihan->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_mk_pilihan->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_sm = $table_mk_pilihan->addCell(1000, $cellRowSpan);
        $sm = $header_sm->addTextRun($cellHCentered);
        $sm->addText('Semester', $fontStyle2);

        $header_mk = $table_mk_pilihan->addCell(1000, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Nama Mata Kuliah', $fontStyle2);

        $header_sks = $table_mk_pilihan->addCell(1000, $cellRowSpan);
        $sks = $header_sks->addTextRun($cellHCentered);
        $sks->addText('Bobot Sks', $fontStyle2);

        $header_tugas = $table_mk_pilihan->addCell(1000, $cellRowSpan);
        $tugas = $header_tugas->addTextRun($cellHCentered);
        $tugas->addText('Bobot Tugas', $fontStyle2);

        $header_unit = $table_mk_pilihan->addCell(1000, $cellRowSpan);
        $unit = $header_unit->addTextRun($cellHCentered);
        $unit->addText('Unit/ Jur/ Fak Penyelenggara', $fontStyle2);

        $table_mk_pilihan->addRow();
        $table_mk_pilihan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mk_pilihan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mk_pilihan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mk_pilihan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mk_pilihan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mk_pilihan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $mk_pilihan = DB::table('mk_pilihan')
            ->join('data_mk_pilihan', 'mk_pilihan.data_mk_pilihan_id', '=', 'data_mk_pilihan.id')
            ->select('mk_pilihan.*', 'data_mk_pilihan.semester')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($mk_pilihan as $key => $value) {
            $i++;

            $table_mk_pilihan->addRow(2000);
            $cellNo = $table_mk_pilihan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_mk_pilihan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->semester, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMk = $table_mk_pilihan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMk->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSks = $table_mk_pilihan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSks->addText($value->bobot_sks, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTugas = $table_mk_pilihan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTugas->addText($value->bobot_tugas, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellUnit = $table_mk_pilihan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellUnit->addText($value->unit, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_mk_pilihan;
    }

    private function generate_praktikum()
    {
        //rekognisi
        $data_praktikum = new \PhpOffice\PhpWord\PhpWord();
        $data_praktikum->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_praktikum->addSection();
        $judul->addText('DATA PRAKTIKUM', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_praktikum->addSection();
        $space1->addTextBreak(1);

        $table = $data_praktikum->addSection();

        $table_praktikum = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_praktikum->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_praktikum->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_mk = $table_praktikum->addCell(1000, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Nama Matakuliah', $fontStyle2);

        $header_judul = $table_praktikum->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul', $fontStyle2);

        $header_tempat = $table_praktikum->addCell(1000, $cellRowSpan);
        $tempat = $header_tempat->addTextRun($cellHCentered);
        $tempat->addText('Tempat/Lokasi Praktikum/Praktek', $fontStyle2);

        $table_praktikum->addRow();
        $table_praktikum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_praktikum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_praktikum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_praktikum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $praktikum = DB::table('praktikum')
            ->join('kurikulum', 'praktikum.kode_mk', '=', 'kurikulum.kode_mk')
            ->select('praktikum.*', 'kurikulum.nama_mk')
            ->where('praktikum.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($praktikum as $key => $value) {
            $i++;

            $table_praktikum->addRow(2000);
            $cellNo = $table_praktikum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_praktikum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_mk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMk = $table_praktikum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMk->addText($value->judul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellUnit = $table_praktikum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellUnit->addText($value->tempat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_praktikum;
    }

    private function generate_akademik()
    {
        //rekognisi
        $data_akademik = new \PhpOffice\PhpWord\PhpWord();
        $data_akademik->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_akademik->addSection();
        $judul->addText('DATA PEMBIMBING AKADEMIK', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_akademik->addSection();
        $space1->addTextBreak(1);

        $table = $data_akademik->addSection();

        $table_akademik = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_akademik->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_akademik->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_mk = $table_akademik->addCell(1000, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Nama Dosen', $fontStyle2);

        $header_judul = $table_akademik->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Jumlah Mahasiswa Bimbingan', $fontStyle2);

        $header_tempat = $table_akademik->addCell(1000, $cellRowSpan);
        $tempat = $header_tempat->addTextRun($cellHCentered);
        $tempat->addText('Tahun Masuk', $fontStyle2);

        $table_akademik->addRow();
        $table_akademik->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_akademik->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_akademik->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_akademik->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $akademik = MhsReguler::select([
            'dosen.nama_dosen', 'biodata_mhs.tahun_masuk', 'biodata_mhs.id',
            \DB::raw("(biodata_mhs.dosen_id) as dosen"),
            \DB::raw('COUNT(biodata_mhs.id) as jumlah'),
        ])
            ->join('dosen', 'biodata_mhs.dosen_id', '=', 'dosen.dosen_id')
            ->where('biodata_mhs.user_id', Auth::user()->kode_ps)
            ->groupBY('biodata_mhs.dosen_id')
            ->groupBY('biodata_mhs.tahun_masuk')
            ->orderBy('biodata_mhs.tahun_masuk', 'asc')
            ->get();

        $i = 0;

        foreach ($akademik as $key => $value) {
            $i++;

            $table_akademik->addRow(2000);
            $cellNo = $table_akademik->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_akademik->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_akademik->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->jumlah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_akademik->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(date('Y', strtotime($value->tahun_masuk)), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_akademik;
    }

    private function generate_tugas_akhir()
    {
        //rekognisi
        $data_tugas_akhir = new \PhpOffice\PhpWord\PhpWord();
        $data_tugas_akhir->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_tugas_akhir->addSection();
        $judul->addText('DATA PEMBIMBING TUGAS AKHIR', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_tugas_akhir->addSection();
        $space1->addTextBreak(1);

        $table = $data_tugas_akhir->addSection();

        $table_tugas_akhir = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_tugas_akhir->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_tugas_akhir->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_mk = $table_tugas_akhir->addCell(1000, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Nama Dosen', $fontStyle2);

        $header_judul = $table_tugas_akhir->addCell(1000, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Jumlah Mahasiswa Bimbingan', $fontStyle2);

        $table_tugas_akhir->addRow();
        $table_tugas_akhir->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_tugas_akhir->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_tugas_akhir->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $pembimbingTa = Dosen::where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($pembimbingTa as $key => $value) {
            $i++;

            $data_pembimbing_ta = PembimbingTa::where('doping1', $value->dosen_id)->orWhere(function ($query) use ($value) {
                $query->where('doping2', $value->dosen_id);
            })->count();

            $table_tugas_akhir->addRow(2000);
            $cellNo = $table_tugas_akhir->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_tugas_akhir->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_tugas_akhir->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($data_pembimbing_ta, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        }

        return $data_tugas_akhir;
    }

    private function generate_kegiatan()
    {
        //rekognisi
        $data_kegiatan = new \PhpOffice\PhpWord\PhpWord();
        $data_kegiatan->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_kegiatan->addSection();
        $judul->addText('DATA KEGIATAN PELATIHAN/WORKSHOP', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_kegiatan->addSection();
        $space1->addTextBreak(1);

        $table = $data_kegiatan->addSection();

        $table_kegiatan = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kegiatan->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_kegiatan->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_mk = $table_kegiatan->addCell(1000, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Nip', $fontStyle2);

        $header_nama = $table_kegiatan->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_jenis = $table_kegiatan->addCell(1000, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis Kegiatan', $fontStyle2);

        $header_tempat = $table_kegiatan->addCell(1000, $cellRowSpan);
        $tempat = $header_tempat->addTextRun($cellHCentered);
        $tempat->addText('Tempat', $fontStyle2);

        $header_waktu = $table_kegiatan->addCell(1000, $cellRowSpan);
        $waktu = $header_waktu->addTextRun($cellHCentered);
        $waktu->addText('Waktu', $fontStyle2);

        $header_peran = $table_kegiatan->addCell(1000, $cellRowSpan);
        $peran = $header_peran->addTextRun($cellHCentered);
        $peran->addText('Peran', $fontStyle2);

        $table_kegiatan->addRow();
        $table_kegiatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kegiatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kegiatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kegiatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kegiatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kegiatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kegiatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $kegiatan = DB::table('kegiatan')
            ->join('kategori_peran', 'kegiatan.peran_id', '=', 'kategori_peran.id')
            ->join('dosen', 'kegiatan.dosen_id', '=', 'dosen.dosen_id')
            ->select('kegiatan.*', 'kategori_peran.peran', 'dosen.nip', 'dosen.nama_dosen')
            ->where('kegiatan.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($kegiatan as $key => $value) {
            $i++;

            $table_kegiatan->addRow(2000);
            $cellNo = $table_kegiatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNip = $table_kegiatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNip->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_kegiatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_kegiatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->jenis_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTempat = $table_kegiatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTempat->addText($value->tempat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_kegiatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->waktu, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPeran = $table_kegiatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPeran->addText($value->peran, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_kegiatan;
    }

    private function generate_penelitian_dosen()
    {
        //rekognisi
        $data_penelitian_dosen = new \PhpOffice\PhpWord\PhpWord();
        $data_penelitian_dosen->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_penelitian_dosen->addSection();
        $judul->addText('DATA PENELITIAN DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_penelitian_dosen->addSection();
        $space1->addTextBreak(1);

        $table = $data_penelitian_dosen->addSection();

        $table_penelitian = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_penelitian->addRow(1000);

        $header_nomor = $table_penelitian->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_penelitian->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_tema = $table_penelitian->addCell(null, $cellRowSpan);
        $tema = $header_tema->addTextRun($cellHCentered);
        $tema->addText('Tema Penelitian sesuai Roadmap', $fontStyle2);

        $header_mhs = $table_penelitian->addCell(null, $cellRowSpan);
        $mhs = $header_mhs->addTextRun($cellHCentered);
        $mhs->addText('Nama Mahasiswa', $fontStyle2);

        $header_judul = $table_penelitian->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan ', $fontStyle2);

        $header_tahun = $table_penelitian->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_penelitian->addRow();
        $table_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $data_penelitian = DataPenelitian::with(['penelitianmhs', 'dosen', 'penelitianmhs.mahasiswa'])
            ->where('data_penelitian.jenis_penelitian', '=', 1)
            ->orderBy('tahun_penelitian', 'asc')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($data_penelitian as $key) {
            $i++;

            $table_penelitian->addRow(2000);
            $cellNo = $table_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->dosen['nama_dosen'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTema = $table_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTema->addText($key->tema, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $data_penelitian_nama = PenelitianMhs::with('mahasiswa')->where('data_penelitian_id', $key->id)->get();
            // $penelitians2 = DB::table('mahasiswa_s2')->where('data_penelitian_id', $key->id)->where('user_id', Auth::user()->kode_ps)->get();

            $listmhs = [];
            $cellMhs = $table_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($data_penelitian_nama as $item) {
                $listmhs[] = $item->mahasiswa['nama'];
            }

            $cellMhs->addText(implode(', ', $listmhs) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($key->judul_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_penelitian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($key->tahun_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_penelitian_dosen;
    }


    private function generate_penelitian_mhs()
    {
        //rekognisi
        $data_penelitian_mhs = new \PhpOffice\PhpWord\PhpWord();
        $data_penelitian_mhs->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_penelitian_mhs->addSection();
        $judul->addText('DATA PENELITIAN MAHASISWA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_penelitian_mhs->addSection();
        $space1->addTextBreak(1);

        $table = $data_penelitian_mhs->addSection();

        $table_penelitian2 = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_penelitian2->addRow(1000);


        $header_nomor = $table_penelitian2->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_penelitian2->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_tema = $table_penelitian2->addCell(null, $cellRowSpan);
        $tema = $header_tema->addTextRun($cellHCentered);
        $tema->addText('Tema Penelitian sesuai Roadmap', $fontStyle2);

        $header_mhs = $table_penelitian2->addCell(null, $cellRowSpan);
        $mhs = $header_mhs->addTextRun($cellHCentered);
        $mhs->addText('Nama Mahasiswa', $fontStyle2);

        $header_judul = $table_penelitian2->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan ', $fontStyle2);

        $header_tahun = $table_penelitian2->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_penelitian2->addRow();
        $table_penelitian2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penelitian2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);


        $data_penelitianmagister = DataPenelitian::with(['penelitianmagister', 'dosen', 'penelitianmagister.biodata_mhs'])
            ->where('data_penelitian.jenis_penelitian', '=', 2)
            ->orderBy('tahun_penelitian', 'asc')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($data_penelitianmagister as $key) {
            $i++;

            $table_penelitian2->addRow(2000);
            $cellNo = $table_penelitian2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_penelitian2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->dosen['nama_dosen'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTema = $table_penelitian2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTema->addText($key->tema, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $penelitians2 = PenelitianMhsS2::with('biodata_mhs')->where('data_penelitian_id', $key->id)->get();

            $listmhs2 = [];
            $cellMhs = $table_penelitian2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($penelitians2 as $item) {
                $listmhs2[] = $item->biodata_mhs['nama'];
            }

            $cellMhs->addText(implode(', ', $listmhs2) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_penelitian2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($key->judul_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_penelitian2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($key->tahun_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_penelitian_mhs;
    }

    private function generate_pkm_dosen()
    {
        //rekognisi
        $data_pkm_dosen = new \PhpOffice\PhpWord\PhpWord();
        $data_pkm_dosen->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_pkm_dosen->addSection();
        $judul->addText('DATA PKM DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_pkm_dosen->addSection();
        $space1->addTextBreak(1);

        $table = $data_pkm_dosen->addSection();

        $table_pengabdian = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_pengabdian->addRow(1000);

        $header_nomor = $table_pengabdian->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_pengabdian->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_tema = $table_pengabdian->addCell(null, $cellRowSpan);
        $tema = $header_tema->addTextRun($cellHCentered);
        $tema->addText('Tema Penelitian sesuai Roadmap', $fontStyle2);

        $header_mhs = $table_pengabdian->addCell(null, $cellRowSpan);
        $mhs = $header_mhs->addTextRun($cellHCentered);
        $mhs->addText('Nama Mahasiswa', $fontStyle2);

        $header_judul = $table_pengabdian->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan ', $fontStyle2);

        $header_tahun = $table_pengabdian->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_pengabdian->addRow();
        $table_pengabdian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengabdian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengabdian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengabdian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengabdian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pengabdian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $data_pkm = DataPkm::with(['pkm_mhs', 'dosen', 'sumberdana', 'pkm_mhs.biodata_mhs'])->where('jenis_pkm', '=', 2)
            ->orderBy('tahun', 'asc')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($data_pkm as $key) {
            $i++;

            $table_pengabdian->addRow(2000);
            $cellNo = $table_pengabdian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_pengabdian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->dosen['nama_dosen'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTema = $table_pengabdian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTema->addText($key->tema, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $pkm_mhs = DataPkmMhs::with('biodata_mhs')->where('data_pkm_id', $key->id)->get();

            $listmhs = [];
            $cellMhs = $table_pengabdian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($pkm_mhs as $item) {
                $listmhs[] = $item->biodata_mhs['nama'];
            }

            $cellMhs->addText(implode(', ', $listmhs) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_pengabdian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($key->judul_pkm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_pengabdian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($key->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_pkm_dosen;
    }

    private function generate_pkm_mhs()
    {
        //rekognisi
        $data_pkm_mhs = new \PhpOffice\PhpWord\PhpWord();
        $data_pkm_mhs->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_pkm_mhs->addSection();
        $judul->addText('DATA PKM MAHASISWA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_pkm_mhs->addSection();
        $space1->addTextBreak(1);

        $table = $data_pkm_mhs->addSection();

        $table_pkm_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_pkm_mhs->addRow(1000);

        $header_nomor = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_tema = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $tema = $header_tema->addTextRun($cellHCentered);
        $tema->addText('Tema Penelitian sesuai Roadmap', $fontStyle2);

        $header_mhs = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $mhs = $header_mhs->addTextRun($cellHCentered);
        $mhs->addText('Nama Mahasiswa', $fontStyle2);

        $header_judul = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan ', $fontStyle2);

        $header_tahun = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_pkm_mhs->addRow();
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $data_pkm = DataPkm::with(['biodata_mhs', 'dosen', 'sumberdana'])->where('jenis_pkm', '=', 1)->where('data_pkm.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($data_pkm as $key) {
            $i++;

            $table_pkm_mhs->addRow(2000);
            $cellNo = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->dosen['nama_dosen'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTema = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTema->addText($key->tema, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMhs = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMhs->addText($key->biodata_mhs['nama'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($key->judul_pkm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($key->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_pkm_mhs;
    }


    private function generate_alumni()
    {
        //rekognisi
        $data_alumni = new \PhpOffice\PhpWord\PhpWord();
        $data_alumni->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_alumni->addSection();
        $judul->addText('DATA ALUMNI', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_alumni->addSection();
        $space1->addTextBreak(1);

        $table = $data_alumni->addSection();

        $table_alumni = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_alumni->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_alumni->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_alumni->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Alumni', $fontStyle2);

        $header_ipk = $table_alumni->addCell(1000, $cellRowSpan);
        $ipk = $header_ipk->addTextRun($cellHCentered);
        $ipk->addText('Ipk', $fontStyle2);

        $header_lulus = $table_alumni->addCell(1000, $cellRowSpan);
        $lulus = $header_lulus->addTextRun($cellHCentered);
        $lulus->addText('Tahun Lulus', $fontStyle2);

        $header_jenis = $table_alumni->addCell(1000, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis Pekerjaan Lulusan', $fontStyle2);

        $header_pendapatan = $table_alumni->addCell(1000, $cellRowSpan);
        $pendapatan = $header_pendapatan->addTextRun($cellHCentered);
        $pendapatan->addText('Pendapatan/Penghasilan', $fontStyle2);

        $header_tunggu = $table_alumni->addCell(1000, $cellRowSpan);
        $tunggu = $header_tunggu->addTextRun($cellHCentered);
        $tunggu->addText('Waktu Tunggu Lulusan', $fontStyle2);

        $table_alumni->addRow();
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $alumni = Alumni::with('waktu_tunggu', 'jenis_pekerjaan', 'kategori_pendapatan')->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($alumni as $key => $value) {
            $i++;

            $table_alumni->addRow(2000);
            $cellNo = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellIpk = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellIpk->addText($value->ipk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun_lulus != null ? date('Y', strtotime($value->tahun_lulus)) : '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->jenis_pekerjaan['jenis'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->kategori_pendapatan['pendapatan'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellWaktu = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellWaktu->addText($value->waktu_tunggu['waktu'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_alumni;
    }

    private function generate_capaian()
    {
        //rekognisi
        $data_capaian = new \PhpOffice\PhpWord\PhpWord();
        $data_capaian->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_capaian->addSection();
        $judul->addText('DATA CAPAIAN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_capaian->addSection();
        $space1->addTextBreak(1);

        $table = $data_capaian->addSection();

        $table_alumni = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_alumni->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_alumni->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_alumni->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Tahun Lulus', $fontStyle2);

        $header_ipk = $table_alumni->addCell(1000, $cellRowSpan);
        $ipk = $header_ipk->addTextRun($cellHCentered);
        $ipk->addText('Jumlah Lulusan', $fontStyle2);

        $header_studi = $table_alumni->addCell(1000, $cellColSpan);
        $studi = $header_studi->addTextRun($cellHCentered);
        $studi->addText('Indeks Prestasi Kumulatif (IPK)', $fontStyle2);

        $table_alumni->addRow();
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alumni->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $capaian = DB::table('capaian')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($capaian as $key => $value) {
            $i++;

            $table_alumni->addRow(2000);
            $cellNo = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellIpk = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellIpk->addText($value->jumlah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellStudi = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellStudi->addText($value->minimum, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->rata, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_alumni->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->maksimum, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_capaian;
    }

    private function generate_prestasi_mhs()
    {
        //rekognisi
        $data_prestasi_mhs = new \PhpOffice\PhpWord\PhpWord();
        $data_prestasi_mhs->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_prestasi_mhs->addSection();
        $judul->addText('DATA PRESTASI MAHASISWA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_prestasi_mhs->addSection();
        $space1->addTextBreak(1);

        $table = $data_prestasi_mhs->addSection();

        $table_prestasi_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_prestasi_mhs->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Kegiatan', $fontStyle2);

        $header_ipk = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $ipk = $header_ipk->addTextRun($cellHCentered);
        $ipk->addText('Waktu Penyelenggaraan/Tahun', $fontStyle2);

        $header_studi = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $studi = $header_studi->addTextRun($cellHCentered);
        $studi->addText('Tingkat', $fontStyle2);

        $header_studi = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $studi = $header_studi->addTextRun($cellHCentered);
        $studi->addText('Prestasi yang Dicapai', $fontStyle2);

        $header_studi = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $studi = $header_studi->addTextRun($cellHCentered);
        $studi->addText('Kategori Prestasi', $fontStyle2);

        $table_prestasi_mhs->addRow();
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $prestasi_mhs = DB::table('prestasi_mhs')
            ->join('kategori_tingkat', 'prestasi_mhs.tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_jenis_prestasi', 'prestasi_mhs.jenis_prestasi', '=', 'kategori_jenis_prestasi.id')
            ->select('prestasi_mhs.*', 'kategori_tingkat.nama_kategori', 'kategori_jenis_prestasi.jenis')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($prestasi_mhs as $key => $value) {
            $i++;

            $table_prestasi_mhs->addRow(2000);
            $cellNo = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellIpk = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellIpk->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellStudi = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellStudi->addText($value->nama_kategori, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->prestasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->jenis, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $data_prestasi_mhs;
    }

    private function generate_efektivitas()
    {
        //rekognisi
        $data_efektivitas = new \PhpOffice\PhpWord\PhpWord();
        $data_efektivitas->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_efektivitas->addSection();
        $judul->addText('DATA EFEKTIVITAS MAHASISWA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_efektivitas->addSection();
        $space1->addTextBreak(1);

        $table = $data_efektivitas->addSection();

        $table_prestasi_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_prestasi_mhs->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('NPM', $fontStyle2);

        $header_nama = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama', $fontStyle2);

        $header_tahun = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_tahun = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Lulus', $fontStyle2);

        $header_masa = $table_prestasi_mhs->addCell(1000, $cellRowSpan);
        $masa = $header_masa->addTextRun($cellHCentered);
        $masa->addText('Masa Studi', $fontStyle2);

        $table_prestasi_mhs->addRow();
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $biodata_mhs = DB::table('alumni')
            ->orderBy('tahun_masuk', 'asc')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($biodata_mhs as $key => $value) {
            $i++;

            $table_prestasi_mhs->addRow(2000);
            $cellNo = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->npm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun_masuk != null ? date('Y', strtotime($value->tahun_masuk)) : '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun_lulus != null ? date('Y', strtotime($value->tahun_lulus)) : '-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $avg = 0;
            $sum = 0;

            $coba1 = json_decode(json_encode($value), true);

            $date1 = new \DateTime($coba1['tahun_masuk']);
            $date2 = new \DateTime($coba1['tahun_lulus']);

            $diff  = $date1->diff($date2);
            $interval =  $diff->format("%a");

            $sum += $interval;

            $years = ($interval / 365);
            $years = floor($years);

            $month = ($interval % 365) / 30.5;
            $month = floor($month);

            $cellMasa = $table_prestasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMasa->addText($years . ' Tahun , ' . $month . ' Bulan ', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_efektivitas;
    }


    private function generate_publikasi_mhs()
    {
        //rekognisi
        $data_publikasi_mhs = new \PhpOffice\PhpWord\PhpWord();
        $data_publikasi_mhs->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_publikasi_mhs->addSection();
        $judul->addText('DATA PUBLIKASI MAHASISWA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_publikasi_mhs->addSection();
        $space1->addTextBreak(1);

        $table = $data_publikasi_mhs->addSection();

        $table_publikasi_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_publikasi_mhs->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_publikasi_mhs->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_publikasi_mhs->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('NPM', $fontStyle2);

        $header_nama = $table_publikasi_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama', $fontStyle2);

        $header_nama = $table_publikasi_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Judul artikel yang disitasi (Jurnal, Volume, Tahun, Nomor, Halaman)', $fontStyle2);

        $header_tingkat = $table_publikasi_mhs->addCell(1000, $cellRowSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Kategori Tingkat Publikasi', $fontStyle2);

        $header_jumlah = $table_publikasi_mhs->addCell(1000, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah artikel yang Mensitasi', $fontStyle2);

        $header_jenis = $table_publikasi_mhs->addCell(1000, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis Publikasi', $fontStyle2);

        $header_tahun = $table_publikasi_mhs->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Publikasi', $fontStyle2);

        $table_publikasi_mhs->addRow();
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $artikel_mhs = DB::table('artikel_mhs')
            ->join('biodata_mhs', 'artikel_mhs.mhs_id', '=', 'biodata_mhs.id')
            ->join('kategori_tingkat', 'artikel_mhs.id_tingkat', '=', 'kategori_tingkat.id')
            ->join('jenis_publikasi', 'artikel_mhs.jenis_publikasi', '=', 'jenis_publikasi.id')
            ->select('artikel_mhs.*', 'biodata_mhs.npm', 'biodata_mhs.nama', 'kategori_tingkat.nama_kategori', 'jenis_publikasi.jenis_publikasi')
            ->where('artikel_mhs.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($artikel_mhs as $key => $value) {
            $i++;

            $table_publikasi_mhs->addRow(2000);
            $cellNo = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->npm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->judul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_kategori, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->jumlah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->jenis_publikasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_publikasi_mhs;
    }

    private function generate_publikasi_dosen()
    {
        //rekognisi
        $data_publikasi_dosen = new \PhpOffice\PhpWord\PhpWord();
        $data_publikasi_dosen->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_publikasi_dosen->addSection();
        $judul->addText('DATA PUBLIKASI DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_publikasi_dosen->addSection();
        $space1->addTextBreak(1);

        $table = $data_publikasi_dosen->addSection();

        $table_publikasi_dosen = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_publikasi_dosen->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_publikasi_dosen->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_publikasi_dosen->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('NIP', $fontStyle2);

        $header_nama = $table_publikasi_dosen->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama', $fontStyle2);

        $header_nama = $table_publikasi_dosen->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Judul artikel yang disitasi (Jurnal, Volume, Tahun, Nomor, Halaman)', $fontStyle2);

        $header_tingkat = $table_publikasi_dosen->addCell(1000, $cellRowSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Kategori Tingkat Publikasi', $fontStyle2);

        $header_jumlah = $table_publikasi_dosen->addCell(1000, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah artikel yang Mensitasi', $fontStyle2);

        $header_jenis = $table_publikasi_dosen->addCell(1000, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis Publikasi', $fontStyle2);

        $header_tahun = $table_publikasi_dosen->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Publikasi', $fontStyle2);

        $table_publikasi_dosen->addRow();
        $table_publikasi_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $artikel_dosen = KaryaIlmiahDsn::with('dosen', 'kategori_tingkat', 'publikasi')->orderBy('tahun', 'asc')->where('artikel_dosen.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($artikel_dosen as $key => $value) {
            $i++;

            $table_publikasi_dosen->addRow(2000);
            $cellNo = $table_publikasi_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_publikasi_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->dosen['nip'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_publikasi_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->dosen['nama_dosen'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_publikasi_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->judul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_publikasi_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->kategori_tingkat['nama_kategori'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_publikasi_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->jumlah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_publikasi_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->publikasi['jenis_publikasi'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_publikasi_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_publikasi_dosen;
    }

    private function generate_produk_mhs()
    {

        $data_produk_mhs = new \PhpOffice\PhpWord\PhpWord();
        $data_produk_mhs->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_produk_mhs->addSection();
        $judul->addText('DATA PRODUK MAHASISWA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_produk_mhs->addSection();
        $space1->addTextBreak(1);

        $table = $data_produk_mhs->addSection();

        $table_produk_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_produk_mhs->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_produk_mhs->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_produk_mhs->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('NPM', $fontStyle2);

        $header_nama = $table_produk_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Mahasiswa', $fontStyle2);

        $header_nama = $table_produk_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Produk', $fontStyle2);

        $header_nama = $table_produk_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Deskripsi Produk/Jasa', $fontStyle2);

        $header_tingkat = $table_produk_mhs->addCell(1000, $cellRowSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat Kesiapterapan Teknologi', $fontStyle2);

        $table_produk_mhs->addRow();
        $table_produk_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $produk = DB::table('produk')
            ->join('biodata_mhs', 'produk.mhs_id', '=', 'biodata_mhs.id')
            ->select('produk.*', 'biodata_mhs.npm', 'biodata_mhs.nama')
            ->where('jenis_produk', '=', 2)
            ->where('produk.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($produk as $key => $value) {
            $i++;

            $table_produk_mhs->addRow(2000);
            $cellNo = $table_produk_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_produk_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->npm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_produk_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_produk_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->nama_produk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_produk_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->deskripsi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_produk_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->kesiapan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_produk_mhs;
    }

    private function generate_produk_dosen()
    {

        $data_produk_dosen = new \PhpOffice\PhpWord\PhpWord();
        $data_produk_dosen->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_produk_dosen->addSection();
        $judul->addText('DATA PRODUK DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_produk_dosen->addSection();
        $space1->addTextBreak(1);

        $table = $data_produk_dosen->addSection();

        $table_produk_dosen = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_produk_dosen->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_produk_dosen->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_produk_dosen->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('NIP', $fontStyle2);

        $header_nama = $table_produk_dosen->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_nama = $table_produk_dosen->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Produk', $fontStyle2);

        $header_nama = $table_produk_dosen->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Deskripsi Produk/Jasa', $fontStyle2);

        $header_tingkat = $table_produk_dosen->addCell(1000, $cellRowSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat Kesiapterapan Teknologi', $fontStyle2);

        $table_produk_dosen->addRow();
        $table_produk_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_produk_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $produk = DB::table('produk')
            ->join('dosen', 'produk.dosen_id', '=', 'dosen.dosen_id')
            ->select('produk.*', 'dosen.nip', 'dosen.nama_dosen')
            ->where('produk.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($produk as $key => $value) {
            $i++;

            $table_produk_dosen->addRow(2000);
            $cellNo = $table_produk_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_produk_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_produk_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_produk_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->nama_produk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_produk_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->deskripsi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_produk_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->kesiapan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_produk_dosen;
    }

    private function generate_paten_mhs()
    {

        $data_paten_mhs = new \PhpOffice\PhpWord\PhpWord();
        $data_paten_mhs->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_paten_mhs->addSection();
        $judul->addText('DATA PATEN MAHASISWA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_paten_mhs->addSection();
        $space1->addTextBreak(1);

        $table = $data_paten_mhs->addSection();

        $table_paten_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_paten_mhs->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_paten_mhs->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_paten_mhs->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('NPM', $fontStyle2);

        $header_nama = $table_paten_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Mahasiswa', $fontStyle2);

        $header_nama = $table_paten_mhs->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Produk', $fontStyle2);

        $header_nomor = $table_paten_mhs->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('Nomor HKI', $fontStyle2);

        $header_tahun = $table_paten_mhs->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_paten_mhs->addRow();
        $table_paten_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $paten = DB::table('paten')
            ->join('biodata_mhs', 'paten.mhs_id', '=', 'biodata_mhs.id')
            ->select('paten.*', 'biodata_mhs.npm', 'biodata_mhs.nama')
            ->where('jenis_paten', '=', 2)
            ->where('paten.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($paten as $key => $value) {
            $i++;

            $table_paten_mhs->addRow(2000);
            $cellNo = $table_paten_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_paten_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->npm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_paten_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_paten_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->karya, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellHki = $table_paten_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellHki->addText($value->no_hki, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_paten_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_paten_mhs;
    }

    private function generate_paten_dosen()
    {

        $data_paten_dosen = new \PhpOffice\PhpWord\PhpWord();
        $data_paten_dosen->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_paten_dosen->addSection();
        $judul->addText('DATA PATEN DOSEN', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_paten_dosen->addSection();
        $space1->addTextBreak(1);

        $table = $data_paten_dosen->addSection();

        $table_paten_dosen = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_paten_dosen->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_paten_dosen->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_paten_dosen->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('NPM', $fontStyle2);

        $header_nama = $table_paten_dosen->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Mahasiswa', $fontStyle2);

        $header_nama = $table_paten_dosen->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Produk', $fontStyle2);

        $header_nomor = $table_paten_dosen->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('Nomor HKI', $fontStyle2);

        $header_tahun = $table_paten_dosen->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_paten_dosen->addRow();
        $table_paten_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_paten_dosen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $paten = DB::table('paten')
            ->join('dosen', 'paten.dosen_id', '=', 'dosen.dosen_id')
            ->select('paten.*', 'dosen.nip', 'dosen.nama_dosen')
            ->where('paten.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($paten as $key => $value) {
            $i++;

            $table_paten_dosen->addRow(2000);
            $cellNo = $table_paten_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNpm = $table_paten_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNpm->addText($value->nip, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_paten_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_paten_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->karya, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellHki = $table_paten_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellHki->addText($value->no_hki, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_paten_dosen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_paten_dosen;
    }


    private function generate_luaran()
    {
        $data_luaran = new \PhpOffice\PhpWord\PhpWord();
        $data_luaran->getSettings()->setUpdateFields(true);

        //font untuk judul
        $fontStyleJudul['name'] = 'Arial';
        $fontStyleJudul['size'] = 20;
        $fontStyleJudul['bold'] = true;

        //font untuk sub judul
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 11;
        $fontStyle['bold'] = true;

        //font untuk isi
        $fontStyle1['name'] = 'Arial';
        $fontStyle1['size'] = 11;
        $fontStyle1['bold'] = false;

        //font untuk isi
        $fontStyle2['name'] = 'Arial';
        $fontStyle2['size'] = 10;
        $fontStyle2['bold'] = true;

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'D3D3D3', 'borderSize' => 20, 'border' => 000000);
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center', 'borderSize' => 5, 'bgColor' => 'D3D3D3', 'border' => 000000);
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

        $judul = $data_luaran->addSection();
        $judul->addText('DATA LUARAN LAINNYA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $data_luaran->addSection();
        $space1->addTextBreak(1);

        $table = $data_luaran->addSection();

        $table_luaran = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_luaran->addRow(1000);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );

        $header_nomor = $table_luaran->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_npm = $table_luaran->addCell(1000, $cellRowSpan);
        $npm = $header_npm->addTextRun($cellHCentered);
        $npm->addText('Judul Luaran', $fontStyle2);

        $header_jenis = $table_luaran->addCell(1000, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis', $fontStyle2);

        $header_ket = $table_luaran->addCell(1000, $cellRowSpan);
        $ket = $header_ket->addTextRun($cellHCentered);
        $ket->addText('Keterangan', $fontStyle2);

        $header_tahun = $table_luaran->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun', $fontStyle2);

        $table_luaran->addRow();
        $table_luaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_luaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_luaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_luaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_luaran->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $produk_lain = DB::table('produk_lain')
            ->join('jenis_produk', 'produk_lain.jenis', '=', 'jenis_produk.id')
            ->select('produk_lain.*', 'jenis_produk.jenis')
            ->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($produk_lain as $key => $value) {
            $i++;

            $table_luaran->addRow(2000);
            $cellNo = $table_luaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_luaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_luaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($value->jenis, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKet = $table_luaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKet->addText($value->keterangan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_luaran->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        return $data_luaran;
    }

    public function pdf_kerjasama()
    {
        $data_kerjasama = $this->generate();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_kerjasama, 'PDF');
        $objWriter->save('report/kerjasama.pdf');

        return response()->file('report/kerjasama.pdf');
    }

    public function pdf_mhs()
    {
        $data_mhs_reg = $this->generate_mhs();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_mhs_reg, 'PDF');
        $objWriter->save('report/mahasiswa.pdf');

        return response()->file('report/mahasiswa.pdf');
    }

    public function pdf_mhs_non()
    {
        $data_mhs_non = $this->generate_mhs_non();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_mhs_non, 'PDF');
        $objWriter->save('report/mahasiswa.pdf');

        return response()->file('report/mahasiswa.pdf');
    }

    public function pdf_daya_tampung()
    {
        $data_daya_tampung = $this->generate_daya_tampung();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_daya_tampung, 'PDF');
        $objWriter->save('report/daya_tampung.pdf');

        return response()->file('report/daya_tampung.pdf');
    }

    public function pdf_pendaftar()
    {
        $data_pendaftar = $this->generate_pendaftar();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_pendaftar, 'PDF');
        $objWriter->save('report/pendaftar.pdf');

        return response()->file('report/pendaftar.pdf');
    }

    public function pdf_lulus()
    {
        $data_lulus = $this->generate_lulus();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_lulus, 'PDF');
        $objWriter->save('report/lulus_seleksi.pdf');

        return response()->file('report/lulus_seleksi.pdf');
    }

    public function pdf_mhs_asing()
    {
        $data_mhs_asing = $this->generate_mhs_asing();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_mhs_asing, 'PDF');
        $objWriter->save('report/mahasiswa_asing.pdf');

        return response()->file('report/mahasiswa_asing.pdf');
    }

    public function pdf_dosen()
    {
        $data_dosen = $this->generate_dosen();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_dosen, 'PDF');
        $objWriter->save('report/dosen.pdf');

        return response()->file('report/dosen.pdf');
    }

    public function pdf_aktivitas()
    {
        $data_aktivitas = $this->generate_aktivitas();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_aktivitas, 'PDF');
        $objWriter->save('report/aktivitas.pdf');

        return response()->file('report/aktivitas.pdf');
    }

    public function pdf_pengajaran()
    {
        $data_pengajaran = $this->generate_pengajaran();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_pengajaran, 'PDF');
        $objWriter->save('report/pengajaran.pdf');

        return response()->file('report/pengajaran.pdf');
    }

    public function pdf_rekognisi()
    {
        $data_rekognisi = $this->generate_rekognisi();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_rekognisi, 'PDF');
        $objWriter->save('report/rekognisi.pdf');

        return response()->file('report/rekognisi.pdf');
    }

    public function pdf_prestasi()
    {
        $data_prestasi = $this->generate_prestasi();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_prestasi, 'PDF');
        $objWriter->save('report/prestasi.pdf');

        return response()->file('report/prestasi.pdf');
    }

    public function pdf_kependidikan()
    {
        $data_kependidikan = $this->generate_kependidikan();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_kependidikan, 'PDF');
        $objWriter->save('report/kependidikan.pdf');

        return response()->file('report/kependidikan.pdf');
    }

    public function pdf_perolehan_dana()
    {
        $perolehan_dana = $this->generate_perolehan_dana();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($perolehan_dana, 'PDF');
        $objWriter->save('report/perolehan_dana.pdf');

        return response()->file('report/perolehan_dana.pdf');
    }

    public function pdf_penggunaan_dana()
    {
        $penggunaan_dana = $this->generate_penggunaan_dana();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($penggunaan_dana, 'PDF');
        $objWriter->save('report/penggunaan_dana.pdf');

        return response()->file('report/penggunaan_dana.pdf');
    }

    public function pdf_dana_penelitian()
    {
        $dana_penelitian = $this->generate_dana_penelitian();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($dana_penelitian, 'PDF');
        $objWriter->save('report/dana_penelitian.pdf');

        return response()->file('report/dana_penelitian.pdf');
    }

    public function pdf_dana_pkm()
    {
        $dana_pkm = $this->generate_dana_pkm();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($dana_pkm, 'PDF');
        $objWriter->save('report/dana_pkm.pdf');

        return response()->file('report/dana_pkm.pdf');
    }

    public function pdf_ruang()
    {
        $data_ruang = $this->generate_ruang();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_ruang, 'PDF');
        $objWriter->save('report/data_ruang.pdf');

        return response()->file('report/data_ruang.pdf');
    }

    public function pdf_prasarana()
    {
        $data_prasarana = $this->generate_prasarana();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_prasarana, 'PDF');
        $objWriter->save('report/data_prasarana.pdf');

        return response()->file('report/data_prasarana.pdf');
    }

    public function pdf_pustaka()
    {
        $data_pustaka = $this->generate_pustaka();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_pustaka, 'PDF');
        $objWriter->save('report/data_pustaka.pdf');

        return response()->file('report/data_pustaka.pdf');
    }

    public function pdf_lab()
    {
        $data_lab = $this->generate_data_lab();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_lab, 'PDF');
        $objWriter->save('report/data_lab.pdf');

        return response()->file('report/data_lab.pdf');
    }

    public function pdf_kurikulum()
    {
        $data_kurikulum = $this->generate_kurikulum();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_kurikulum, 'PDF');
        $objWriter->save('report/data_kurikulum.pdf');

        return response()->file('report/data_kurikulum.pdf');
    }

    public function pdf_mk_pilihan()
    {
        $data_mk_pilihan = $this->generate_mk_pilihan();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_mk_pilihan, 'PDF');
        $objWriter->save('report/data_mk_pilihan.pdf');

        return response()->file('report/data_mk_pilihan.pdf');
    }

    public function pdf_praktikum()
    {
        $data_praktikum = $this->generate_praktikum();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_praktikum, 'PDF');
        $objWriter->save('report/data_praktikum.pdf');

        return response()->file('report/data_praktikum.pdf');
    }

    public function pdf_akademik()
    {
        $data_akademik = $this->generate_akademik();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_akademik, 'PDF');
        $objWriter->save('report/data_akademik.pdf');

        return response()->file('report/data_akademik.pdf');
    }

    public function pdf_tugas_akhir()
    {
        $data_tugas_akhir = $this->generate_tugas_akhir();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_tugas_akhir, 'PDF');
        $objWriter->save('report/data_tugas_akhir.pdf');

        return response()->file('report/data_tugas_akhir.pdf');
    }

    public function pdf_kegiatan()
    {
        $data_kegiatan = $this->generate_kegiatan();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_kegiatan, 'PDF');
        $objWriter->save('report/data_kegiatan.pdf');

        return response()->file('report/data_kegiatan.pdf');
    }

    public function pdf_penelitian_dosen()
    {
        $data_penelitian_dosen = $this->generate_penelitian_dosen();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_penelitian_dosen, 'PDF');
        $objWriter->save('report/data_penelitian_dosen.pdf');

        return response()->file('report/data_penelitian_dosen.pdf');
    }

    public function pdf_penelitian_mhs()
    {
        $data_penelitian_mhs = $this->generate_penelitian_mhs();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_penelitian_mhs, 'PDF');
        $objWriter->save('report/data_penelitian_mhs.pdf');

        return response()->file('report/data_penelitian_mhs.pdf');
    }

    public function pdf_pkm_dosen()
    {
        $data_pkm_dosen = $this->generate_pkm_dosen();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_pkm_dosen, 'PDF');
        $objWriter->save('report/data_pkm_dosen.pdf');

        return response()->file('report/data_pkm_dosen.pdf');
    }

    public function pdf_pkm_mhs()
    {
        $data_pkm_mhs = $this->generate_pkm_mhs();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_pkm_mhs, 'PDF');
        $objWriter->save('report/data_pkm_mhs.pdf');

        return response()->file('report/data_pkm_mhs.pdf');
    }

    public function pdf_alumni()
    {
        $data_alumni = $this->generate_alumni();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_alumni, 'PDF');
        $objWriter->save('report/data_alumni.pdf');

        return response()->file('report/data_alumni.pdf');
    }

    public function pdf_capaian()
    {
        $data_capaian = $this->generate_capaian();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_capaian, 'PDF');
        $objWriter->save('report/data_capaian.pdf');

        return response()->file('report/data_capaian.pdf');
    }


    public function pdf_prestasi_mhs()
    {
        $data_prestasi_mhs = $this->generate_prestasi_mhs();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_prestasi_mhs, 'PDF');
        $objWriter->save('report/data_prestasi_mhs.pdf');

        return response()->file('report/data_prestasi_mhs.pdf');
    }

    public function pdf_efektivitas()
    {
        $data_efektivitas = $this->generate_efektivitas();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_efektivitas, 'PDF');
        $objWriter->save('report/data_efektivitas.pdf');

        return response()->file('report/data_efektivitas.pdf');
    }

    public function pdf_publikasi_mhs()
    {
        $data_publikasi_mhs = $this->generate_publikasi_mhs();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_publikasi_mhs, 'PDF');
        $objWriter->save('report/data_publikasi_mhs.pdf');

        return response()->file('report/data_publikasi_mhs.pdf');
    }

    public function pdf_publikasi_dosen()
    {
        $data_publikasi_dosen = $this->generate_publikasi_dosen();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_publikasi_dosen, 'PDF');
        $objWriter->save('report/data_publikasi_dosen.pdf');

        return response()->file('report/data_publikasi_dosen.pdf');
    }

    public function pdf_produk_mhs()
    {
        $data_produk_mhs = $this->generate_produk_mhs();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_produk_mhs, 'PDF');
        $objWriter->save('report/data_produk_mhs.pdf');

        return response()->file('report/data_produk_mhs.pdf');
    }

    public function pdf_produk_dosen()
    {
        $data_produk_dosen = $this->generate_produk_dosen();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_produk_dosen, 'PDF');
        $objWriter->save('report/data_produk_dosen.pdf');

        return response()->file('report/data_produk_dosen.pdf');
    }

    public function pdf_paten_mhs()
    {
        $data_paten_mhs = $this->generate_paten_mhs();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_paten_mhs, 'PDF');
        $objWriter->save('report/data_paten_mhs.pdf');

        return response()->file('report/data_paten_mhs.pdf');
    }

    public function pdf_paten_dosen()
    {
        $data_paten_dosen = $this->generate_paten_dosen();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_paten_dosen, 'PDF');
        $objWriter->save('report/data_paten_dosen.pdf');

        return response()->file('report/data_paten_dosen.pdf');
    }

    public function pdf_luaran()
    {
        $data_luaran = $this->generate_luaran();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($data_luaran, 'PDF');
        $objWriter->save('report/data_luaran.pdf');

        return response()->file('report/data_luaran.pdf');
    }
}
