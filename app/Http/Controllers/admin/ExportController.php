<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AktivitasIndustri;
use App\Models\Admin\AktivitasDosen;
use App\Models\Admin\AktivitasTetap;
use App\Models\Admin\AktivitasTdkTetap;
use App\Models\Admin\Kerjasama;
use App\Models\Admin\Dosen;
use App\Models\Admin\KaryaIlmiahDsn;
use App\Models\Admin\DataPenelitian;
use App\Models\Admin\Diploma;
use App\Models\Admin\DataPkm;
use App\Models\Admin\DataPkmMhs;
use App\Models\Admin\MhsReguler;
use App\Models\Admin\DayaTampung;
use App\Models\Admin\DosenIndustri;
use App\Models\Admin\DosenTdkTetap;
use App\Models\Admin\DosenTetap;
use App\Models\Admin\Kurikulum;
use App\Models\Admin\Produk;
use App\Models\Admin\Pendaftar;
use App\Models\Admin\Paten;
use App\Models\Admin\JenisPublikasi;
use App\Models\Admin\PublikasiMhs;
use App\Models\Admin\PublikasiMhsTerapan;
use App\Models\Admin\Lainnya;
use App\Models\Admin\PenelitianMhs;
use App\Models\Admin\Mahasiswa;
use App\Models\Admin\PenggunaanDana;
use App\Models\Admin\SumberDana;
use App\Models\Admin\Capaian;
use App\Models\Admin\PembimbingTa;
use App\Models\Admin\PenelitianMhsS2;
use App\Models\Admin\PrestasiMhs;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Style\TablePosition;
use PhpOffice\PhpWord\ComplexType\FootnoteProperties;
use PhpOffice\PhpWord\SimpleType\NumberFormat;
use Carbon\Carbon;
use Auth;
use DB;
use Illuminate\Support\Facades\Date;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Averages;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\type;

class ExportController extends Controller
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

        // $file = new Spreadsheet();

        $file = new \PhpOffice\PhpWord\PhpWord();
        $file->getSettings()->setUpdateFields(true);
        // $section = $file->addSection();

        $file->addTitleStyle(1, array('size' => 20, 'bold' => true));
        $file->addTitleStyle(2, array('size' => 20, 'color' => '666666'));

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

        //$paragraphStyleName = 'paragraphStyle';

        // //halaman cover
        // $judul = $file->addSection();
        // $judul->addText('LEMBAGA AKREDITASI MANDIRI SAINS DAN ILMU FORMAL', $fontStyleJudul, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // $sectionJudul = $file->addSection();
        // $sectionJudul->addTextBreak(1);

        // $judul = $file->addSection();
        // $judul->addText('Logo PT', $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // $section1 = $file->addSection();
        // $section1->addPageBreak();

        // //halaman 2
        // $judul = $file->addSection();
        // $judul->addText('KATA PENGANTAR', ['bold' => true], array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

        // $section2 = $file->addSection();
        // $section2->addTextBreak(1);

        // //isi
        // $judul = $file->addSection();
        // $judul->addText('Puji syukur kita panjatkan ke hadirat Allah Tuhan Yang Maha Esa, karena atas rahmat dan hidayah-Nya Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT) menyelesaikan Instrumen Akreditasi Perguruan Tinggi versi 3.0 (IAPT 3.0). Instrumen ini disusun guna memenuhi tuntutan peraturan perundangan terkini, dan sekaligus sebagai upaya untuk melakukan perbaikan berkelanjutan dan menyesuaikan dengan praktek baik penjaminan mutu eksternal yang umum berlaku. Tujuan utama pengembangan IAPT 3.0 adalah sebagai upaya membangun budaya mutu di PerguruanTinggi.
        // Panduan Penyusunan Laporan Kinerja Perguruan Tinggi ini merupakan bagian yang tidak terpisahkan dari IAPT 3.0, dan berisi format baku pengisian data Indikator Kinerja yang harus digunakan oleh Perguruan Tinggi di dalam mengajukan permohonan Akreditasi Perguruan Tinggi', ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        // $section1 = $file->addSection();
        // $section1->addPageBreak();

        //halaman 3
        $judul = $file->addSection();
        $judul->addText('BORANG INDIKATOR KINERJA UTAMA', $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $space1 = $file->addSection();
        $space1->addTextBreak(1);

        $judul = $file->addSection();
        $judul->addText('1. VISI, MISI, TUJUAN DAN STRATEGI',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space2 = $file->addSection();
        $space2->addTextBreak(1);

        $judul = $file->addSection();
        $judul->addText('2. TATA PAMONG, TATA KELOLA, DAN KERJASAMA',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $judul2 = $file->addSection();
        $judul2->addText('a. Kerja sama',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan kerja sama bidang tridarma di Unit Pengelola Program Studi (UPPS) dalam 3 tahun terakhir dengan mengikuti format tabel kerja sama tridarma berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space3 = $file->addSection();
        $space3->addTextBreak();

        // Tabel Kerjasama Pendidikan

        $table = $file->addSection();
        $table->addText('1. Kerjasama Tridharma', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan kerja sama bidang tridarma di Unit Pengelola Program Studi (UPPS) dalam 3 tahun terakhir dengan mengikuti format tabel kerja sama tridarma berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 2.1 Kerjasama Pendidikan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

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
        $table_kerjasama->addCell(1, ['bgColor' => 'D3D3D3'])->addText('Internasional', $fontStyle2, $cellHCentered);
        $table_kerjasama->addCell(1, ['bgColor' => 'D3D3D3'])->addText('Nasional', $fontStyle2, $cellHCentered);
        $table_kerjasama->addCell(1, ['bgColor' => 'D3D3D3'])->addText('Lokal/Wilayah', $fontStyle2, $cellHCentered);

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

        $date = Carbon::now()->year;

        $i = 0;
        $years = $this->getYears(3);
        $data = array();
        $nb = 0;

        $kerjasama = DB::table('kerjasama')
            ->join('kategori_tingkat', 'kerjasama.id_kategori_tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_kerjasama', 'kerjasama.id_kategori_kerjasama', '=', 'kategori_kerjasama.id')
            ->select('kerjasama.*', 'kategori_tingkat.nama_kategori', 'kategori_kerjasama.kategori')->where('id_kategori_kerjasama', '=', '1')
            ->whereYEAR('tanggal_kegiatan', '>=', $years[0])->whereYEAR('tanggal_kegiatan', '<=', $years[2])
            ->where('user_id', Auth::user()->kode_ps)->get();

        // dd($kerjasama);
        $i = 0;
        foreach ($kerjasama as $key => $value) {
            $i++;

            $table_kerjasama->addRow(2000);

            $cellNo = $table_kerjasama->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

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

        $space4 = $file->addSection();
        $space4->addTextBreak();

        $table = $file->addSection();
        $table->addText('Tabel 2.2 Kerjasama Penelitian',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(3);
        $data = array();
        $nb = 0;

        $kerjasama = DB::table('kerjasama')
            ->join('kategori_tingkat', 'kerjasama.id_kategori_tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_kerjasama', 'kerjasama.id_kategori_kerjasama', '=', 'kategori_kerjasama.id')
            ->select('kerjasama.*', 'kategori_tingkat.nama_kategori', 'kategori_kerjasama.kategori')->where('id_kategori_kerjasama', '=', '2')
            ->whereYEAR('tanggal_kegiatan', '>=', $years[0])->whereYEAR('tanggal_kegiatan', '<=', $years[2])
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

        $header_judul = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan Kerjasama', $fontStyle2);

        $header_manfaat = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $manfaat = $header_manfaat->addTextRun($cellHCentered);
        $manfaat->addText('Manfaat bagi PS yang Diakreditasi', $fontStyle2);

        $header_waktu = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $waktu = $header_waktu->addTextRun($cellHCentered);
        $waktu->addText('Waktu Pelaksanaan', $fontStyle2);

        $header_bukti = $table_kerjasama_penelitian->addCell(null, $cellRowSpan);
        $bukti = $header_bukti->addTextRun($cellHCentered);
        $bukti->addText('Bukti Kerja sama', $fontStyle2);

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
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

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

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Kerjasama Pengembangan Kegiatan Masyarakat
        $table = $file->addSection();
        $table->addText('Tabel 2.3 Kerjasama Pengembangan Kegiatan Masyarakat',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(3);
        $data = array();
        $nb = 0;

        $kerjasama = DB::table('kerjasama')
            ->join('kategori_tingkat', 'kerjasama.id_kategori_tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_kerjasama', 'kerjasama.id_kategori_kerjasama', '=', 'kategori_kerjasama.id')
            ->select('kerjasama.*', 'kategori_tingkat.nama_kategori', 'kategori_kerjasama.kategori')->where('id_kategori_kerjasama', '=', '3')
            ->whereYEAR('tanggal_kegiatan', '>=', $years[0])->whereYEAR('tanggal_kegiatan', '<=', $years[2])
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

        $header_judul = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Kegiatan Kerjasama', $fontStyle2);

        $header_manfaat = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $manfaat = $header_manfaat->addTextRun($cellHCentered);
        $manfaat->addText('Manfaat bagi PS yang Diakreditasi', $fontStyle2);

        $header_waktu = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $waktu = $header_waktu->addTextRun($cellHCentered);
        $waktu->addText('Waktu Pelaksanaan', $fontStyle2);

        $header_bukti = $table_kerjasama_pkm->addCell(null, $cellRowSpan);
        $bukti = $header_bukti->addTextRun($cellHCentered);
        $bukti->addText('Bukti Kerja sama', $fontStyle2);

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
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

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

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Mahasiswa
        $judul2 = $file->addSection();
        $judul2->addText('3. MAHASISWA',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $judul3 = $file->addSection();
        $judul3->addText('a. Kualitas Input Mahasiswa',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi2 = $file->addSection();
        $isi2->addText('Tuliskan data daya tampung, jumlah calon mahasiswa (pendaftar dan peserta yang lulus seleksi),
        jumlah mahasiswa baru (reguler dan transfer) dan jumlah mahasiswa aktif (reguler dan transfer) dalam 5 tahun terakhir di Program Studi
        yang diakreditasi dengan mengikuti format Tabel 3 berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 3. Seleksi Mahasiswa',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_mahasiswa = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_mahasiswa->addRow(1000);

        $header_tahun = $table_mahasiswa->addCell(1000, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Akademik', $fontStyle2);

        $header_daya_tampung = $table_mahasiswa->addCell(1000, $cellRowSpan);
        $daya_tampung = $header_daya_tampung->addTextRun($cellHCentered);
        $daya_tampung->addText('Daya Tampung', $fontStyle2);

        $header_jumlah_calon = $table_mahasiswa->addCell(2000, $cellColSpan2);
        $jumlah_calon = $header_jumlah_calon->addTextRun($cellHCentered);
        $jumlah_calon->addText('Jumlah Calon Mahasiswa', $fontStyle2);

        $header_jumlah_maba = $table_mahasiswa->addCell(2000, $cellColSpan2);
        $jumlah_maba = $header_jumlah_maba->addTextRun($cellHCentered);
        $jumlah_maba->addText('Jumlah Mahasiswa Baru', $fontStyle2);

        $header_mhs_aktif = $table_mahasiswa->addCell(2000, $cellColSpan4);
        $mhs_aktif = $header_mhs_aktif->addTextRun($cellHCentered);
        $mhs_aktif->addText('Jumlah Mahasiswa Aktif', $fontStyle2);

        $table_mahasiswa->addRow();
        $table_mahasiswa->addCell(null, $cellRowContinue);
        $table_mahasiswa->addCell(null, $cellRowContinue);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Pendaftar', $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Lulus Seleksi', $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Reguler', $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Transfer', $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Reguler', $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Transfer', $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Dari Luar Daerah (Luar Provinsi)', $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Dari Luar Negeri', $fontStyle2, $cellHCentered);

        $table_mahasiswa->addRow();
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_mahasiswa->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(5);
        $data = array();
        $nb = 0;
        foreach ($years as $key => $year) {
            $i++;

            $table_mahasiswa->addRow(2000);

            // $mahasiswa_d3 = DB::table('mahasiswa_d3')->whereYEAR('tahun_masuk', $year)->where('user_id', Auth::user()->kode_ps)->count();

            $cellTahun = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(htmlspecialchars("{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $daya_tampung = DayaTampung::where('tahun', $year)->where('daya_tampung.user_id', Auth::user()->kode_ps)->first();
            $cellTampung = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTampung->addText($daya_tampung['daya_tampung'] ?? '0', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $pendaftar = DB::table('pendaftar')->where('tahun_masuk', $year)->where('pendaftar.user_id', Auth::user()->kode_ps)->count();
            $nb += $pendaftar;
            $cellPendaftar = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPendaftar->addText($pendaftar, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            // dd($pendaftar);

            $mhs_lulus = DB::table('mhs_lulus')->where('tahun_masuk', $year)->where('mhs_lulus.user_id', Auth::user()->kode_ps)->count();
            $nb += $mhs_lulus;
            $cellLulus = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLulus->addText($mhs_lulus, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mhs_reguler = DB::table('biodata_mhs')->where('biodata_mhs.user_id', Auth::user()->kode_ps)->where('id_status', '=', 1)->where('deleted_at', '=', NULL)->whereYEAR('tahun_masuk', $year)->count();
            $nb += $mhs_reguler;
            $cellReguler = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellReguler->addText($mhs_reguler, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mhs_transfer = DB::table('biodata_mhs')->where('biodata_mhs.user_id', Auth::user()->kode_ps)->where('id_status', '=', 2)->where('deleted_at', '=', NULL)->whereYEAR('tahun_masuk', $year)->count();
            $nb += $mhs_transfer;
            $cellTransfer = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTransfer->addText($mhs_transfer, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mhs_reguler = DB::table('biodata_mhs')->where('biodata_mhs.user_id', Auth::user()->kode_ps)->where('id_status', '=', 1)->where('deleted_at', '=', NULL)->whereYEAR('tahun_masuk', $year)->count();
            $nb += $mhs_reguler;
            $cellRegulerAktif = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRegulerAktif->addText($mhs_reguler, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mhs_transfer = DB::table('biodata_mhs')->where('biodata_mhs.user_id', Auth::user()->kode_ps)->where('id_status', '=', 2)->where('deleted_at', '=', NULL)->whereYEAR('tahun_masuk', $year)->count();
            $nb += $mhs_transfer;
            $cellTransferAktif = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTransferAktif->addText($mhs_transfer, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mhs_luar = DB::table('biodata_mhs')->where('asal_id', '=', 1)->where('user_id', Auth::user()->kode_ps)->whereYEAR('tahun_masuk', $year)->where('deleted_at', '=', NULL)->count();
            $cellLuarDaerah = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLuarDaerah->addText($mhs_luar, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mhs_asing = DB::table('biodata_mhs')->where('asal_id', '=', 2)->where('user_id', Auth::user()->kode_ps)->whereYEAR('tahun_masuk', $year)->where('deleted_at', '=', NULL)->count();
            $cellLuarNegeri = $table_mahasiswa->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLuarNegeri->addText($mhs_asing, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }
        // dd($pendaftar);

        $date = Carbon::now()->year;

        $jumlah_pendaftar = DB::table('pendaftar')->where('tahun_masuk', '>=', $years[0])->where('tahun_masuk', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_lulus = DB::table('mhs_lulus')->where('tahun_masuk', '>=', $years[0])->where('tahun_masuk', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_reguler = DB::table('biodata_mhs')->whereYEAR('tahun_masuk', '>=', $years[0])->whereYEAR('tahun_masuk', '<=', $date)->where('id_status', '=', 1)->where('deleted_at', '=', NULL)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_transfer = DB::table('biodata_mhs')->whereYEAR('tahun_masuk', '>=', $years[0])->whereYEAR('tahun_masuk', '<=', $date)->where('id_status', '=', 2)->where('deleted_at', '=', NULL)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_reguler_aktif = DB::table('biodata_mhs')->whereYEAR('tahun_masuk', '>=', $years[0])->whereYEAR('tahun_masuk', '<=', $date)->where('id_status', '=', 1)->where('deleted_at', '=', NULL)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_transfer_aktif = DB::table('biodata_mhs')->whereYEAR('tahun_masuk', '>=', $years[0])->whereYEAR('tahun_masuk', '<=', $date)->where('id_status', '=', 2)->where('deleted_at', '=', NULL)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_mhs_dalam = DB::table('biodata_mhs')->whereYEAR('tahun_masuk', '>=', $years[0])->whereYEAR('tahun_masuk', '<=', $date)->where('asal_id', '=', 1)->where('deleted_at', '=', NULL)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_mhs_luar = DB::table('biodata_mhs')->whereYEAR('tahun_masuk', '>=', $years[0])->whereYEAR('tahun_masuk', '<=', $date)->where('asal_id', '=', 2)->where('deleted_at', '=', NULL)->where('user_id', Auth::user()->kode_ps)->count('id');


        $table_mahasiswa->addRow();
        $table_mahasiswa->addCell(null, array('gridSpan' => '2'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null)->addText($jumlah_pendaftar, $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null)->addText($jumlah_lulus, $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null)->addText($jumlah_reguler, $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null)->addText($jumlah_transfer, $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null)->addText($jumlah_reguler_aktif, $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null)->addText($jumlah_transfer_aktif, $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null)->addText($jumlah_mhs_dalam, $fontStyle2, $cellHCentered);
        $table_mahasiswa->addCell(null)->addText($jumlah_mhs_luar, $fontStyle2, $cellHCentered);

        $isi2 = $file->addSection();
        $isi2->addText('Keterangan:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi2->addText('TS = Tahun akademik penuh terakhir saat pengajuan usulan akreditasi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Sumber Daya Manusia
        $judul2 = $file->addSection();
        $judul2->addText('4. SUMBER DAYA MANUSIA',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //Profil Dosen
        $judul3 = $file->addSection();
        $judul3->addText('a. Profil Dosen',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi2 = $file->addSection();
        $isi2->addText('Tuliskan data Dosen Tetap Perguruan Tinggi yang ditugaskan sebagai pengampu mata kuliah di Program Studi yang Diakreditasi (DTPS) pada saat TS dengan mengikuti format Tabel 4.a.1(i) dan Tabel 4.a.1(ii) berikut ini.
        Nama dosen dan urutannya dibuat sama pada kedua tabel tersebut.
        Saat pemasukan data dalam spreadsheet IAPS, kedua tabel disatukan, melebar ke kanan, sesuai urutan nomor kolom. Lihat Panduan Penyusunan LKPS.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 4.a.1(i) Dosen Tetap Perguruan Tinggi (Data Pertama)',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosen = DosenTetap::with('jenis_dosen', 'jabatan_fungsional', 'kategori_pendidikan')->where('jenis_dosen', '1')->where('user_id', Auth::user()->kode_ps);

        if (request('withtrash') == 1) {
            $dosen = $dosen->whereNotNull('deleted_at')->withTrashed();
        }
        $dosen = $dosen->get();

        $table_sdm = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_sdm->addRow(1000);

        $header_nomor = $table_sdm->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_sdm->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_nidn = $table_sdm->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $nidn = $header_nidn->addTextRun($cellHCentered);
        $nidn->addText('NIDN/NIDK', $fontStyle2);

        $header_pendidikan = $table_sdm->addCell(1000, $cellColSpan2);
        $pendidikan = $header_pendidikan->addTextRun($cellHCentered);
        $pendidikan->addText('Pendidikan Pasca Sarjana', $fontStyle2);

        $header_bidang = $table_sdm->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $bidang = $header_bidang->addTextRun($cellHCentered);
        $bidang->addText('Bidang Keahlian', $fontStyle2);

        $header_kesesuaian = $table_sdm->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $kesesuaian = $header_kesesuaian->addTextRun($cellHCentered);
        $kesesuaian->addText('Kesesuaian dengan Kompetensi Inti PS', $fontStyle2);

        $header_jabatan = $table_sdm->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $jabatan = $header_jabatan->addTextRun($cellHCentered);
        $jabatan->addText('Jabatan Akademik', $fontStyle2);

        $table_sdm->addRow();
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Magistes/Magister Terapan/Spesialis', $fontStyle2, $cellHCentered);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Doktor/Doktor Terapan/Spesialis', $fontStyle2, $cellHCentered);
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, $cellRowContinue);
        $table_sdm->addCell(null, $cellRowContinue);

        $table_sdm->addRow();
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        foreach ($dosen as $key => $value) {
            $i++;

            $table_sdm->addRow(2000);
            $cellNo = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNidn = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNidn->addText($value->nidn, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPendidikan = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPendidikan->addText($value->pend_s2, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPendidikan = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPendidikan->addText($value->pend_s3, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBidang = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBidang->addText($value->bidang, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);


            if ($value->jenis_dosen == 1) {
                $cellKesesuaian = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellKesesuaian->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellKesesuaian = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellKesesuaian->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
            $cellJabatan = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJabatan->addText($value->jabatan_fungsional['nama_jabatan'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $date = Carbon::now()->year;

        $jumlah_dosen = DB::table('dosen')->where('user_id', Auth::user()->kode_ps)->where('jenis_dosen', '1')->where('deleted_at', '=', NULL)->count('dosen_id');

        $table_sdm->addRow();
        $table_sdm->addCell(null, array('gridSpan' => '2'))->addText('NDT =', $fontStyle2, $cellHCentered);
        $table_sdm->addCell(null)->addText($jumlah_dosen, $fontStyle2, $cellHCentered);
        $table_sdm->addCell(null, array('gridSpan' => '3'))->addText('NDTPS =', $fontStyle2, $cellHCentered);
        $table_sdm->addCell(null, array('gridSpan' => '2'))->addText($jumlah_dosen, $fontStyle2, $cellHCentered);

        $keterangan = $file->addSection();
        $keterangan->addText('Keterangan:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $keterangan->addText('NDT = Jumlah Dosen Tetap Perguruan Tinggi yang ditugaskan sebagai pengampu mata kuliah di Program Studi yang diakreditasi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $keterangan->addText('NDTPS = Jumlah Dosen Tetap Perguruan Tinggi yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $table = $file->addSection();
        $table->addText('Tabel 4.a.1(ii) Dosen Tetap Perguruan Tinggi (Data Kedua)',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_sdm = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_sdm->addRow(1000);

        $header_nomor = $table_sdm->addCell(1000, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_sdm->addCell(1000, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_sertifikat_pendidik = $table_sdm->addCell(1000, $cellRowSpan);
        $sertifikat_pendidik = $header_sertifikat_pendidik->addTextRun($cellHCentered);
        $sertifikat_pendidik->addText('Sertifikat Pendidik Profesional', $fontStyle2);

        $header_sertifikat_kompetensi = $table_sdm->addCell(1000, $cellRowSpan);
        $sertifikat_kompetensi = $header_sertifikat_kompetensi->addTextRun($cellHCentered);
        $sertifikat_kompetensi->addText('Sertifikat Kompetensi/Profesi/Industri', $fontStyle2);

        $header_mk = $table_sdm->addCell(1000, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Mata Kuliah yang Diampu pada PS yang Diakreditasi', $fontStyle2);

        $header_kesesuaian = $table_sdm->addCell(1000, $cellRowSpan);
        $kesesuaian = $header_kesesuaian->addTextRun($cellHCentered);
        $kesesuaian->addText('Kesesuaian Bidang Keahlian dengan Mata Kuliah yang Diampu', $fontStyle2);

        $header_mk_pslain = $table_sdm->addCell(1000, $cellRowSpan);
        $mk_pslain = $header_mk_pslain->addTextRun($cellHCentered);
        $mk_pslain->addText('Mata Kuliah yang Diampu pada PS Lain', $fontStyle2);

        $header_scopus = $table_sdm->addCell(1000, $cellRowSpan);
        $scopus = $header_scopus->addTextRun($cellHCentered);
        $scopus->addText('H indeks Scopus', $fontStyle2);

        $header_wos = $table_sdm->addCell(1000, $cellRowSpan);
        $wos = $header_wos->addTextRun($cellHCentered);
        $wos->addText('Impact factor WOS', $fontStyle2);

        $header_sinta = $table_sdm->addCell(1000, $cellRowSpan);
        $sinta = $header_sinta->addTextRun($cellHCentered);
        $sinta->addText('Sinta Score', $fontStyle2);

        $table_sdm->addRow();
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('11', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('12', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('13', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('14', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sdm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('15', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosentetap = DosenTetap::where('jenis_dosen', '=', 1)->where('dosen.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($dosentetap as $key) {
            $i++;

            $table_sdm->addRow(2000);
            $cellNo = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSertifikatP = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSertifikatP->addText($key->sertifikat_pendidik, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSertifikatK = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSertifikatK->addText($key->sertifikat_kompetensi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            // $mk = AktivitasTetap::with(['aktivitas_dosen', 'aktivitas_dosen.kurikulum', 'dosen'])->whereHas('aktivitas_dosen', function ($q) {
            //     $q->where('ket', '=', 'PS Sendiri');
            // })->where('dosen_id', $key->dosen_id)->where('user_id', Auth::user()->kode_ps)->get();

            // dd($mk);

            $status = function ($query) {
                $query->where('ket', '=', 'PS Sendiri');
            };

            $mk = AktivitasTetap::whereHas('aktivitas_dosen', $status)->with(['aktivitas_dosen' => $status])->where('dosen_id', $key->dosen_id)->where('tahun', Carbon::now())->where('user_id', Auth::user()->kode_ps)->get();

            $listmk = [];
            $cellMk = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mk as $item) {
                foreach ($item->aktivitas_dosen as $val) {
                    $listmk[] = $val->kurikulum['nama_mk'];
                }
            }

            $cellMk->addText(implode(', ', $listmk) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($value->jenis_dosen == 1) {
                $cellKesesuaian = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellKesesuaian->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            } else {
                $cellKesesuaian = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellKesesuaian->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $status2 = function ($query) {
                $query->where('ket', '=', 'PS Lain');
            };

            $mk_lain = AktivitasTetap::whereHas('aktivitas_dosen', $status2)->with(['aktivitas_dosen' => $status2])->where('dosen_id', $key->dosen_id)->where('tahun', Carbon::now())->where('user_id', Auth::user()->kode_ps)->get();

            $listmklain = [];
            $cellMkLain = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mk_lain as $item2) {
                foreach ($item2->aktivitas_dosen as $val2) {
                    $listmklain[] = $val2->kurikulum['nama_mk'];
                }
            }

            $cellMkLain->addText(implode(', ', $listmklain) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellScopus = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellScopus->addText($key->scopus, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellWos = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellWos->addText($key->wos, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSinta = $table_sdm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSinta->addText($key->sinta, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $table_sdm->addRow();
        $table_sdm->addCell(null, array('gridSpan' => '8'))->addText('NDT =', $fontStyle2, $cellHCentered);
        $table_sdm->addCell(null, array('gridSpan' => '2'))->addText($jumlah_dosen, $fontStyle2, $cellHCentered);


        $keterangan = $file->addSection();
        $keterangan->addText('Keterangan:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $keterangan->addText('NDT = Jumlah Dosen Tetap Perguruan Tinggi yang ditugaskan sebagai pengampu mata kuliah di Program Studi yang diakreditasi. ',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $isi = $file->addSection();
        $isi->addText('Tuliskan DTPS yang ditugaskan sebagai pembimbing utama tugas akhir mahasiswa (Laporan Akhir/ Skripsi/ Tesis/ Disertasi) 1 dalam 3 tahun terakhir dengan mengikuti format berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //Pembimbing Tugas Akhir
        $table = $file->addSection();
        $table->addText('Tabel 4.a.2 Dosen Pembimbing Utama Tugas Akhir',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_pemb_ta = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_pemb_ta->addRow(1000);

        $header_nomor = $table_pemb_ta->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama_dosen = $table_pemb_ta->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $nama_dosen = $header_nama_dosen->addTextRun($cellHCentered);
        $nama_dosen->addText('Nama Dosen', $fontStyle2);

        $header_jumlah = $table_pemb_ta->addCell(1000, array('gridSpan' => 8, 'bgColor' => 'D3D3D3'));
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah Mahasiswa yang Dibimbing', $fontStyle2);

        $header_rata = $table_pemb_ta->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $rata = $header_rata->addTextRun($cellHCentered);
        $rata->addText('Rata-rata Jumlah Bimbingan di semua Program/Semester', $fontStyle2);


        $table_pemb_ta->addRow();
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(1000, array('gridSpan' => 4, 'bgColor' => 'D3D3D3'))->addText('pada PS yang Diakreditasi', $fontStyle2, $cellHCentered);
        $table_pemb_ta->addCell(1000, array('gridSpan' => 4, 'bgColor' => 'D3D3D3'))->addText('pada PS Lain pada Program yang sama di PT', $fontStyle2, $cellHCentered);


        $table_pemb_ta->addRow();
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, $cellRowContinue);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-2', $fontStyle2, $cellHCentered);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-1', $fontStyle2, $cellHCentered);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS', $fontStyle2, $cellHCentered);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Rata-rata', $fontStyle2, $cellHCentered);

        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-2', $fontStyle2, $cellHCentered);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-1', $fontStyle2, $cellHCentered);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS', $fontStyle2, $cellHCentered);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Rata-rata', $fontStyle2, $cellHCentered);


        $table_pemb_ta->addRow();
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('11', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('12', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('13', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('14', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('15', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pemb_ta->addCell(null, ['bgColor' => 'D3D3D3'])->addText('16', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $date = Carbon::now()->year;

        // $pembimbing_ta = PembimbingTa::select([
        //     'dosen.nama_dosen', 'data_pembimbing_ta.mhs_id', 'biodata_mhs.tahun_masuk',
        //     \DB::raw("(data_pembimbing_ta.doping1) as dosen"),
        //     \DB::raw('COUNT(data_pembimbing_ta.mhs_id) as jumlah'),
        // ])
        //     ->join('dosen', 'data_pembimbing_ta.doping1', '=', 'dosen.dosen_id')
        //     ->join('biodata_mhs', 'data_pembimbing_ta.mhs_id', '=', 'biodata_mhs.id')
        //     ->where('dosen.user_id', Auth::user()->kode_ps)
        //     ->where('biodata_mhs.user_id', Auth::user()->kode_ps)
        //     ->groupBY('data_pembimbing_ta.doping1')
        //     ->orderBy('data_pembimbing_ta.doping1', 'asc')
        //     ->get();


        // $pembimbingTa = Dosen::where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        $years = $this->getYears(3);
        $data = array();
        $nb = 0;

        $dosen_pembimbing = DB::table('data_pembimbing_ta')
            ->join('dosen', 'data_pembimbing_ta.doping1', '=', 'dosen.dosen_id')
            ->select('dosen.dosen_id', 'dosen.nama_dosen')
            ->where('dosen.jenis_dosen', '=', 1)
            ->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)
            ->groupBy('data_pembimbing_ta.doping1')
            ->where('dosen.user_id', Auth::user()->kode_ps)->get();

        // dd($dosen);

        $i = 0;
        $years = $this->getYears(3);
        $data = array();
        $nb = 0;

        foreach ($dosen_pembimbing as $key) {
            $i++;

            $table_pemb_ta->addRow(2000);
            $cellNo = $table_pemb_ta->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_pemb_ta->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            foreach ($years as $keys => $year) {
                $pembimbing_ta = PembimbingTa::where('jenis_id1', 1)->where('tahun', $year)->where('doping1', $key->dosen_id)->where('tahun', $year)->count();

                $cellTS1 = $table_pemb_ta->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTS1->addText($pembimbing_ta, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $count_ps_sendiri = DB::table('data_pembimbing_ta')->where('jenis_id1', '=', 1)->where('doping1', $key->dosen_id)->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->count();

            $avg_ps_sendiri = $count_ps_sendiri / 3;

            $cellRata2 = $table_pemb_ta->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRata2->addText(ceil($avg_ps_sendiri) ?? '0', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            foreach ($years as $keys => $year2) {
                $pembimbing_ta2 = PembimbingTa::where('jenis_id1', 2)->where('tahun', $year2)->where('doping1', $key->dosen_id)->where('tahun', $year2)->count();

                $cellTS2 = $table_pemb_ta->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTS2->addText($pembimbing_ta2, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $count_ps_lain = DB::table('data_pembimbing_ta')->where('jenis_id1', '=', 2)->where('doping1', $key->dosen_id)->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->count();

            $avg_ps_lain = $count_ps_lain / 3;

            $cellRata2 = $table_pemb_ta->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRata2->addText(ceil($avg_ps_lain), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $count = DB::table('data_pembimbing_ta')->where('jenis_id1', '!=', '3')->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->count();

            // dd($count);
            $avg = $count / 6;

            $cellJumlah = $table_pemb_ta->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText(ceil($avg) ?? '0', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $isi = $file->addSection();
        $isi->addText('Tuliskan data Ekuivalen Waktu Mengajar Penuh (EWMP) dari Dosen Tetap Perguruan Tinggi yang ditugaskan di program studi yang diakreditasi (DT) pada saat TS dengan mengikuti format Tabel 4.a.3 berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 4.a.3 Ekuivalen Waktu Mengajar Penuh (EWMP) Dosen Tetap Perguruan Tinggi',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);


        $table_ekuivalen = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_ekuivalen->addRow(1000);

        $header_nomor = $table_ekuivalen->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama_dosen = $table_ekuivalen->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $nama_dosen = $header_nama_dosen->addTextRun($cellHCentered);
        $nama_dosen->addText('Nama Dosen (DT)', $fontStyle2);

        $header_dtps = $table_ekuivalen->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $dtps = $header_dtps->addTextRun($cellHCentered);
        $dtps->addText('DTPS', $fontStyle2);

        $header_ekuivalen = $table_ekuivalen->addCell(1000, array('gridSpan' => 6, 'bgColor' => 'D3D3D3'));
        $ekuivalen = $header_ekuivalen->addTextRun($cellHCentered);
        $ekuivalen->addText('Ekuivalen Waktu Mengajar Penuh (EWMP) pada saat TS dalam satuan kredit semester (sks)', $fontStyle2);

        $header_jumlah = $table_ekuivalen->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah (sks)', $fontStyle2);

        $header_rata = $table_ekuivalen->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'));
        $rata = $header_rata->addTextRun($cellHCentered);
        $rata->addText('Rata-rata per Semester (sks)', $fontStyle2);


        $table_ekuivalen->addRow();
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(1000, array('gridSpan' => 3, 'bgColor' => 'D3D3D3'))->addText('Pendidikan: Pembelajaran dan Pembimbingan', $fontStyle2, $cellHCentered);
        $table_ekuivalen->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'))->addText('Penelitian', $fontStyle2, $cellHCentered);
        $table_ekuivalen->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'))->addText('Pengabdian kepada Masyarakat', $fontStyle2, $cellHCentered);
        $table_ekuivalen->addCell(1000, array('vMerge' => 'restart', 'bgColor' => 'D3D3D3'))->addText('Tugas Tambahan dan/atau Penunjang', $fontStyle2, $cellHCentered);

        $table_ekuivalen->addRow();
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, $cellRowContinue);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('PS yang Diakreditasi', $fontStyle2, $cellHCentered);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('PS Lain di dalam PT', $fontStyle2, $cellHCentered);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('PS Lain di luar PT', $fontStyle2, $cellHCentered);


        $table_ekuivalen->addRow();
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_ekuivalen->addCell(null, ['bgColor' => 'D3D3D3'])->addText('11', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);


        $date = Carbon::now()->year;

        $dosen = DosenTetap::where('jenis_dosen', '=', 1)->where('dosen.user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        $data = array();
        $nb = 0;

        foreach ($dosen as $key) {
            $i++;

            $table_ekuivalen->addRow(2000);
            $cellNo = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellDtps = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDtps->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPs = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            $cellPsLain = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            $cellPtLain = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            $cellPenelitian = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            $cellPkm = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            $cellTugasLain = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            $bobot_sks = DB::table('aktivitas_dosen')->join('aktivitas', 'aktivitas_dosen.aktivitas_id', '=', 'aktivitas.id')->where('aktivitas.dosen_id', $key->dosen_id)->where('aktivitas_dosen.ket', '=', 'PS Sendiri')->sum('bobot_sks');
            $cellPs->addText($bobot_sks ?? 0, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $bobot_sks2 = DB::table('aktivitas_dosen')->join('aktivitas', 'aktivitas_dosen.aktivitas_id', '=', 'aktivitas.id')->where('aktivitas.dosen_id', $key->dosen_id)->where('aktivitas_dosen.ket', '=', 'PS Lain')->sum('bobot_sks');
            $cellPsLain->addText($bobot_sks2 ?? 0, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $bobot_sks3 = DB::table('aktivitas_dosen')->join('aktivitas', 'aktivitas_dosen.aktivitas_id', '=', 'aktivitas.id')->where('aktivitas.dosen_id', $key->dosen_id)->where('aktivitas_dosen.ket', '=', 'PS luar PT')->sum('bobot_sks');
            $cellPtLain->addText($bobot_sks3 ?? 0, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mk1 = DB::table('aktivitas')->select('sks_penelitian')->where('dosen_id', $key->dosen_id)->where('tahun', $date)->sum('sks_penelitian');
            $cellPenelitian->addText($mk1  ?? 0, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mk2 = DB::table('aktivitas')->select('sks_p2m')->where('dosen_id', $key->dosen_id)->where('tahun', $date)->sum('sks_p2m');
            $cellPkm->addText($mk2 ?? 0, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mk3 = DB::table('aktivitas')->select('m_pt_sendiri')->where('dosen_id', $key->dosen_id)->where('tahun', $date)->sum('m_pt_sendiri');
            $cellTugasLain->addText($mk3 ?? 0, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $count = $bobot_sks + $bobot_sks2 + $bobot_sks3 + $mk1 + $mk2 + $mk3;

            $avg = $count / 2;

            $cellJumlah = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($count ?? '0', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellRata = $table_ekuivalen->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRata->addText($avg ?? '0', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Dosen Tidak Tetap
        $isi = $file->addSection();
        $isi->addText('Tuliskan data Dosen Tidak Tetap yang ditugaskan sebagai pengampu mata kuliah di program studi yang Diakreditasi (DTT) pada saat TS dengan mengikuti format Tabel 4.a.4 berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 4.a.4 Dosen Tidak Tetap Program Studi',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_dosen_kontrak = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dosen_kontrak->addRow(1000);

        $header_nomor = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_nidn = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $nidn = $header_nidn->addTextRun($cellHCentered);
        $nidn->addText('NIDN/NIDK', $fontStyle2);

        $header_pasca = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $pasca_sarjana = $header_pasca->addTextRun($cellHCentered);
        $pasca_sarjana->addText('Pendidikan Pasca Sarjana', $fontStyle2);

        $header_bidang = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $bidang = $header_bidang->addTextRun($cellHCentered);
        $bidang->addText('Bidang Keahlian', $fontStyle2);

        $header_jabatan = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $jabatan = $header_jabatan->addTextRun($cellHCentered);
        $jabatan->addText('Jabatan Akademik', $fontStyle2);

        $header_sertifikat = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $profesional = $header_sertifikat->addTextRun($cellHCentered);
        $profesional->addText('Sertifikat Pendidik Profesional', $fontStyle2);

        $header_sertifikat = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $kompetensi = $header_sertifikat->addTextRun($cellHCentered);
        $kompetensi->addText('Sertifikat Profesi/ Kompetensi/ Industri5', $fontStyle2);

        $header_mk = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Mata Kuliah yang Diampu pada PS yang   Diakreditasi', $fontStyle2);

        $header_kesesuaian = $table_dosen_kontrak->addCell(null, $cellRowSpan);
        $kesesuaian = $header_kesesuaian->addTextRun($cellHCentered);
        $kesesuaian->addText('Kesesuaian Bidang Keahlian dengan Mata Kuliah yang Diampu', $fontStyle2);

        $table_dosen_kontrak->addRow();
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_dosen_kontrak->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $dosentidaktetap = DB::table('dosen')
            ->join('kategori_jenis_dosen', 'dosen.jenis_dosen', '=', 'kategori_jenis_dosen.id')
            ->join('jabatan_fungsional', 'dosen.jabatan_id', '=', 'jabatan_fungsional.id')
            ->join('kategori_pendidikan', 'dosen.pendidikan_id', '=', 'kategori_pendidikan.id')
            ->select('dosen.*', 'kategori_jenis_dosen.jenis', 'jabatan_fungsional.nama_jabatan', 'kategori_pendidikan.pendidikan')->where('jenis_dosen', '2')
            ->where('dosen.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($dosentidaktetap as $key) {
            $i++;

            $table_dosen_kontrak->addRow(2000);
            $cellNo = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNidn = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNidn->addText($key->nidn, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPasca = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPasca->addText($key->pend_s2, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellBidang = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBidang->addText($key->bidang, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJabatan = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJabatan->addText($key->nama_jabatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellProfesional = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellProfesional->addText($key->sertifikat_pendidik, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKompetensi = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKompetensi->addText($key->sertifikat_kompetensi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $status = function ($query) {
                $query->where('ket', '=', 'PS Sendiri');
            };

            $mk = AktivitasTdkTetap::whereHas('aktivitas_dosen', $status)->with(['aktivitas_dosen' => $status])->where('dosen_id', $key->dosen_id)->where('tahun', Carbon::now())->where('user_id', Auth::user()->kode_ps)->get();

            $listmk = [];
            $cellMk = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mk as $item) {
                foreach ($item->aktivitas_dosen as $val) {
                    $listmk[] = $val->kurikulum['nama_mk'];
                }
            }

            $cellMk->addText(implode(', ', $listmk) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($value->jenis_dosen = 2) {
                $cellKesesuaian = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellKesesuaian->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellKesesuaian = $table_dosen_kontrak->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellKesesuaian->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }
        }

        $date = Carbon::now()->year;

        $jumlah_dosen2 = DB::table('dosen')->where('user_id', Auth::user()->kode_ps)->where('jenis_dosen', '2')->count('dosen_id');

        $table_dosen_kontrak->addRow();
        $table_dosen_kontrak->addCell(null, array('gridSpan' => '8'))->addText('NDT =', $fontStyle2, $cellHCentered);
        $table_dosen_kontrak->addCell(null, array('gridSpan' => '2'))->addText($jumlah_dosen2, $fontStyle2, $cellHCentered);

        $keterangan = $file->addSection();
        $keterangan->addText('Keterangan:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $keterangan->addText('NDTT = Jumlah Dosen Tidak Tetap yang ditugaskan sebagai pengampu mata kuliah di Program Studi yang diakreditasi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $catatan = $file->addSection();
        $catatan->addText('Catatan:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $catatan->addText('Data dosen industri/praktisi (Tabel 4.a.5) tidak termasuk ke dalam data dosen tidak tetap.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $isi = $file->addSection();
        $isi->addText('Tabel 4.a.5 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi->addText('Tuliskan data dosen industri yang ditugaskan/sebagai pengampu mata kuliah kompetensi di Program Studi yang diakreditasi pada saat TS dengan mengikuti format Tabel 4.a.5 berikut ini. Dosen industri/praktisi direkrut melalui kerja sama dengan perusahaan atau industri yang relevan dengan bidang program studi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Dosen Industri
        $table = $file->addSection();
        $table->addText('Tabel 4.a.5 Dosen Industri/Praktisi Program Studi ',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_dosen_industri = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_dosen_industri->addRow(1000);

        $header_nomor = $table_dosen_industri->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_dosen_industri->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_nidk = $table_dosen_industri->addCell(null, $cellRowSpan);
        $nidk = $header_nidk->addTextRun($cellHCentered);
        $nidk->addText('NIDK', $fontStyle2);

        $header_perusahaan = $table_dosen_industri->addCell(null, $cellRowSpan);
        $perusahaan = $header_perusahaan->addTextRun($cellHCentered);
        $perusahaan->addText('Perusahaan/Industri', $fontStyle2);

        $header_pendidikan = $table_dosen_industri->addCell(null, $cellRowSpan);
        $pendidikan = $header_pendidikan->addTextRun($cellHCentered);
        $pendidikan->addText('Pendidikan Tertinggi', $fontStyle2);

        $header_jabatan = $table_dosen_industri->addCell(null, $cellRowSpan);
        $jabatan = $header_jabatan->addTextRun($cellHCentered);
        $jabatan->addText('Jabatan Akademik', $fontStyle2);

        $header_sertifikat = $table_dosen_industri->addCell(null, $cellRowSpan);
        $kompetensi = $header_sertifikat->addTextRun($cellHCentered);
        $kompetensi->addText('Sertifikat Profesi/ Kompetensi/ Industri', $fontStyle2);

        $header_mk = $table_dosen_industri->addCell(null, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Mata Kuliah yang Diampu', $fontStyle2);

        $header_sks = $table_dosen_industri->addCell(null, $cellRowSpan);
        $sks = $header_sks->addTextRun($cellHCentered);
        $sks->addText('Bobot Kredit (sks)', $fontStyle2);

        $dosenindustri = DB::table('dosen')
            ->join('kategori_jenis_dosen', 'dosen.jenis_dosen', '=', 'kategori_jenis_dosen.id')
            ->join('jabatan_fungsional', 'dosen.jabatan_id', '=', 'jabatan_fungsional.id')
            ->join('kategori_pendidikan', 'dosen.pendidikan_id', '=', 'kategori_pendidikan.id')
            ->select('dosen.*', 'kategori_jenis_dosen.jenis', 'jabatan_fungsional.nama_jabatan', 'kategori_pendidikan.pendidikan')->where('jenis_dosen', '3')
            ->where('dosen.user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($dosenindustri as $key) {
            $i++;

            $table_dosen_industri->addRow(2000);
            $cellNo = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNidk = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNidk->addText($key->nidn, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPerusahaan = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPerusahaan->addText($key->perusahaan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPendidikan = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPendidikan->addText($key->pend_s2, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJabatan = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJabatan->addText($key->nama_jabatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKompetensi = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKompetensi->addText($key->sertifikat_kompetensi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mk = AktivitasIndustri::whereHas('aktivitas_dosen', $status)->with(['aktivitas_dosen' => $status])->where('dosen_id', $key->dosen_id)->where('tahun', Carbon::now())->where('user_id', Auth::user()->kode_ps)->get();

            $listmkindustri = [];
            $listbobot = [];
            $cellMk = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            foreach ($mk as $item) {
                foreach ($item->aktivitas_dosen as $val) {
                    $listmkindustri[] = $val->kurikulum['nama_mk'];
                    $listbobot[] = $val->bobot_sks;
                }
            }
            $cellMk->addText(implode(', ', $listmkindustri) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);


            // $cellMk->addText($listmk[0][0]['nama_mk'] ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            // $jumlahsks = AktivitasIndustri::with('kurikulum')->where('dosen_id', $key->dosen_id)->where('user_id', Auth::user()->kode_ps)->sum('bobot_sks');

            $cellSks = $table_dosen_industri->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSks->addText(implode(', ', $listbobot) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $date = Carbon::now()->year;

        $jumlah_dosen3 = DB::table('dosen')->where('user_id', Auth::user()->kode_ps)->where('jenis_dosen', '3')->count('dosen_id');

        $table_dosen_industri->addRow();
        $table_dosen_industri->addCell(null, array('gridSpan' => '7'))->addText('NDT =', $fontStyle2, $cellHCentered);
        $table_dosen_industri->addCell(null, array('gridSpan' => '2'))->addText($jumlah_dosen3, $fontStyle2, $cellHCentered);

        // dd($dosenindustri);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Kinerja Dosen
        $judul3 = $file->addSection();
        $judul3->addText('b. Kinerja Dosen',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi2 = $file->addSection();
        $isi2->addText('Tabel 4.b.1 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana /Sarjana Terapan /Magister /Magister Terapan /Doktor /Doktor Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi2->addText('Tuliskan jumlah publikasi ilmiah dengan judul yang relevan dengan bidang program studi, yang dihasilkan oleh DTPS mulai TS-2, dengan mengikuti format Tabel 4.b.1 berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //Publikasi Ilmiah
        $table = $file->addSection();
        $table->addText('Tabel 4.b.1  Publikasi Ilmiah DTPS',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_publikasi = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_publikasi->addRow(1000);

        $header_nomor = $table_publikasi->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_jenis = $table_publikasi->addCell(null, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Lembaga Mitra', $fontStyle2);

        $header_judul = $table_publikasi->addCell(null, $cellColSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Jumlah Judul', $fontStyle2);

        $header_jumlah = $table_publikasi->addCell(null, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah', $fontStyle2);

        $table_publikasi->addRow();

        $table_publikasi->addCell(null, $cellRowContinue);
        $table_publikasi->addCell(null, $cellRowContinue);
        $table_publikasi->addCell(null, $cellRowContinue);
        $table_publikasi->addCell(null, $cellRowContinue);
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-2', $fontStyle2, $cellHCentered);
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-1', $fontStyle2, $cellHCentered);
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS', $fontStyle2, $cellHCentered);

        $table_publikasi->addRow();
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $jenis_publikasi = DB::table('jenis_publikasi')->get();
        $i = 0;

        $years = $this->getYears(3);
        $data = array();
        $nb = 0;

        foreach ($jenis_publikasi as $key) {
            $i++;

            $table_publikasi->addRow(2000);
            $cellNo = $table_publikasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_publikasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($key->jenis_publikasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            foreach ($years as $keys => $year) {
                $artikel_dosen1 = KaryaIlmiahDsn::with('jenis_publikasi')->where('jenis_publikasi', $key->id)->where('tahun', $year)->where('user_id', Auth::user()->kode_ps)->count();

                $cellTS1 = $table_publikasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTS1->addText($artikel_dosen1, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $countjudul = DB::table('artikel_dosen')->where('jenis_publikasi', $key->id)->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count();
            $cellJudul = $table_publikasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($countjudul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $date = Carbon::now()->year;

        $jumlah_ts2 = DB::table('artikel_dosen')->where('tahun', '=', $years[0])->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_ts1 = DB::table('artikel_dosen')->where('tahun', '=', $years[1])->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_ts = DB::table('artikel_dosen')->where('tahun', '=', $years[2])->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah = DB::table('artikel_dosen')->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');

        $table_publikasi->addRow();
        $table_publikasi->addCell(null, array('gridSpan' => '2'))->addText('NDT =', $fontStyle2, $cellHCentered);
        $table_publikasi->addCell(null)->addText($jumlah_ts2, $fontStyle2, $cellHCentered);
        $table_publikasi->addCell(null)->addText($jumlah_ts1, $fontStyle2, $cellHCentered);
        $table_publikasi->addCell(null)->addText($jumlah_ts, $fontStyle2, $cellHCentered);
        $table_publikasi->addCell(null)->addText($jumlah, $fontStyle2, $cellHCentered);

        $keterangan = $file->addSection();
        $keterangan->addText('Keterangan:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $keterangan->addText('1). Jurnal internasional bereputaasi adalah jurnal internasional yang mempunyai SJR atau Impact factor',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $keterangan->addText('2). Jurnal nasional  terakreditasi  adalah jurnal yang  mempunyai peringkat di SINTA',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $isi = $file->addSection();
        $isi->addText('Tabel 4.b.2 berikut ini diisi oleh pengusul dari program studi pada program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan/Doktor/Doktor Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi->addText('Tuliskan judul artikel karya ilmiah DTPS yang disitasi TS-2 dengan mengikuti format Tabel 4.b.2 berikut ini. Judul artikel yang disitasi harus relevan dengan bidang program studi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //Sitasi Karya Ilmiah DTPS
        $table = $file->addSection();
        $table->addText('Tabel 4.b.2 Sitasi Karya Ilmiah DTPS',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $artikel_dosen = DB::table('artikel_dosen')
            ->join('dosen', 'artikel_dosen.dosen_id', '=', 'dosen.dosen_id')
            ->join('kategori_tingkat', 'artikel_dosen.id_tingkat', '=', 'kategori_tingkat.id')
            ->select('artikel_dosen.*', 'dosen.nip', 'dosen.nama_dosen', 'dosen.sinta', 'dosen.scopus', 'kategori_tingkat.nama_kategori')
            ->where('artikel_dosen.user_id', Auth::user()->kode_ps)->get();

        $table_sitasi = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_sitasi->addRow(1000);

        $header_nomor = $table_sitasi->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_sitasi->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_judul = $table_sitasi->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Artikel yang Disitasi (Jurnal, Volume, Tahun, Nomor, Halaman) (3 Tahun terakhir)', $fontStyle2);

        $header_jumlah = $table_sitasi->addCell(null, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah Sitasi', $fontStyle2);

        $header_id = $table_sitasi->addCell(null, $cellRowSpan);
        $id = $header_id->addTextRun($cellHCentered);
        $id->addText('Nomor ID Pengindeks  Bereputasi (Misal: Scopus ID)', $fontStyle2);

        $header_sinta = $table_sitasi->addCell(null, $cellRowSpan);
        $sinta = $header_sinta->addTextRun($cellHCentered);
        $sinta->addText('Nomor Sinta ID', $fontStyle2);

        $table_sitasi->addRow();
        $table_sitasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sitasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sitasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sitasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sitasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_sitasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        foreach ($artikel_dosen as $key => $value) {
            $i++;

            $table_sitasi->addRow(2000);
            $cellNo = $table_sitasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_sitasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_dosen, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_sitasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($value->judul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJumlah = $table_sitasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($value->jumlah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellId = $table_sitasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellId->addText($value->scopus, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSinta = $table_sitasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSinta->addText($value->sinta, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $isi = $file->addSection();
        $isi->addText('Tabel 4.b.3 berikut ini diisi oleh pengusul dari program studi pada program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan/Doktor/Doktor Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi->addText('Tuliskan luaran penelitian atau Pengabdian kepada Masyarakat DTPS di luar publikasi ilmiah misalkan paten, paten sederhana, HKI, teknologi tepat guna, produk terstandarisasi, produk tersertifikasi, produk  yang diadopsi industri atau masyarakat, buku ber-ISBN, book chapter, keterang­an/bukti fisik atau link dalam 3 tahun terakhir dengan mengikuti format Tabel 4.b.3 berikut ini. Jenis produk/jasa harus relevan dengan bidang program studi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 4.b.3 Luaran Penelitian atau Pengabdian kepada Masyarakat oleh DTPS selain Publikasi Ilmiah',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_pkm = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_pkm->addRow(1000);

        $header_nomor = $table_pkm->addCell(200, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_pkm->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Luaran Penelitian dan Pengabdian kepada Masyarakat', $fontStyle2);

        $header_tahun = $table_pkm->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun (YYYY)', $fontStyle2);

        $header_jenis = $table_pkm->addCell(null, $cellColSpan6);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis Luaran Selain Publikasi Ilmiah', $fontStyle2);

        $table_pkm->addRow();

        $table_pkm->addCell(200, $cellRowContinue);
        $table_pkm->addCell(200, $cellRowContinue);
        $table_pkm->addCell(200, $cellRowContinue);
        $table_pkm->addCell(200, $cellRowContinue);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Paten / Paten Sederhana', $fontStyle2, $cellHCentered);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('HKI ', $fontStyle2, $cellHCentered);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Teknologi Tepat Guna, Produk Terstandarisasi, Produk Tersertifikasi', $fontStyle2, $cellHCentered);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Produk  yang diadopsi Industri/Masyarakat', $fontStyle2, $cellHCentered);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Buku ber-ISBN, Book Chapter', $fontStyle2, $cellHCentered);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Keterangan / Bukti Fisik / link', $fontStyle2, $cellHCentered);

        $table_pkm->addRow();
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $data_pkm = DataPkm::where('user_id', Auth::user()->kode_ps)->get();
        $i = 0;
        foreach ($data_pkm as $value) {
            $i++;

            $table_pkm->addRow(2000);
            $cellNo = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->judul_pkm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $paten = Paten::where('pkm_id', $value->id)->where('paten.user_id', Auth::user()->kode_ps)->first();
            $cellPaten = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));

            $cellPaten->addText($paten['karya'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellHki = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellHki->addText($paten['no_hki'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $produk_lain = Lainnya::with('jenis_produk')->where('pkm_id', $value->id)->where('jenis', 1)->where('produk_lain.user_id', Auth::user()->kode_ps)->first();
            $cellTeknologi = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTeknologi->addText($produk_lain['nama'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $produk = Produk::where('pkm_id', $value->id)->where('produk.user_id', Auth::user()->kode_ps)->first();
            $cellProdukSertifikasi = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellProdukSertifikasi->addText($produk['nama_produk'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $produk_lain = Lainnya::with('jenis_produk')->where('pkm_id', $value->id)->where('jenis', 2)->where('produk_lain.user_id', Auth::user()->kode_ps)->first();
            $cellBuku = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBuku->addText($produk_lain['nama'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            // // dd($produk_lain);
            $cellBukti = $table_pkm->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBukti->addText($produk_lain['link'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Keuangan, sarana, dan prasarana
        $judul2 = $file->addSection();
        $judul2->addText('5. KEUANGAN, SARANA, DAN PRASARANA',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan data penggunaan dana yang dikelola oleh UPPS dan data penggunaan dana yang dialokasikan ke program studi yang diakreditasi mulai TS-2 dengan mengikuti format Tabel 5.a berikut ini:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 5.a Penggunaan Dana',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_penggunaan_dana = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_penggunaan_dana->addRow(1000);

        $header_nomor = $table_penggunaan_dana->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_jenis = $table_penggunaan_dana->addCell(null, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis Penggunaan', $fontStyle2);

        $header_unit = $table_penggunaan_dana->addCell(null, $cellColSpan4);
        $unit = $header_unit->addTextRun($cellHCentered);
        $unit->addText('Unit Pengelola Program Studi (Rp.)', $fontStyle2);

        $header_ps = $table_penggunaan_dana->addCell(null, $cellColSpan4);
        $ps = $header_ps->addTextRun($cellHCentered);
        $ps->addText('Program Studi (Rp.)', $fontStyle2);

        $table_penggunaan_dana->addRow();

        $table_penggunaan_dana->addCell(null, $cellRowContinue);
        $table_penggunaan_dana->addCell(null, $cellRowContinue);
        $table_penggunaan_dana->addCell(null, $cellRowContinue);
        $table_penggunaan_dana->addCell(null, $cellRowContinue);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-2', $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-1', $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS', $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Rata-rata', $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-2', $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-1', $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS', $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Rata-rata', $fontStyle2, $cellHCentered);

        $table_penggunaan_dana->addRow();
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_penggunaan_dana->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $jenis_penggunaan = DB::table('jenis_penggunaan')->get();

        $i = 0;
        $years = $this->getYears(3);
        $data = array();
        $nb = 0;

        foreach ($jenis_penggunaan as $key) {
            $i++;

            $table_penggunaan_dana->addRow(2000);
            $cellNo = $table_penggunaan_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_penggunaan_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($key->nama_jenis_penggunaan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            foreach ($years as $keys => $year) {
                $penggunaan_dana1 = PenggunaanDana::with('jenis_penggunaan')->where('jenis_penggunaan_id', $key->id)->where('tahun', $year)->where('kategori_pengelola_id', '=', 1)->where('user_id', Auth::user()->kode_ps)->sum('dana');

                $cellTS1 = $table_penggunaan_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTS1->addText("Rp " . number_format($penggunaan_dana1 ?? '0', 2, ',', '.'), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $avg_unit = DB::table('penggunaan_dana')->where('jenis_penggunaan_id', $key->id)->where('kategori_pengelola_id', '=', 1)->where('user_id', Auth::user()->kode_ps)
                ->avg('dana');

            $cellRata2 = $table_penggunaan_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRata2->addText("Rp " . number_format($avg_unit ?? '0', 2, ',', '.'), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            foreach ($years as $keys => $year) {
                $penggunaan_dana2 = PenggunaanDana::with('jenis_penggunaan')->where('jenis_penggunaan_id', $key->id)->where('tahun', $year)->where('kategori_pengelola_id', '=', 2)->where('user_id', Auth::user()->kode_ps)->sum('dana');

                $cellTS2 = $table_penggunaan_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTS2->addText("Rp " . number_format($penggunaan_dana2 ?? '0', 2, ',', '.'), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $avg_ps = DB::table('penggunaan_dana')->where('jenis_penggunaan_id', $key->id)->where('kategori_pengelola_id', '=', 2)->where('user_id', Auth::user()->kode_ps)
                ->avg('dana');

            $cellRata2 = $table_penggunaan_dana->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRata2->addText("Rp " . number_format($avg_ps ?? '0', 2, ',', '.'), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $avg_unit = DB::table('penggunaan_dana')->where('kategori_pengelola_id', '=', 1)->where('user_id', Auth::user()->kode_ps)
            ->avg('dana');

        $avg_ps = DB::table('penggunaan_dana')->where('kategori_pengelola_id', '=', 2)->where('user_id', Auth::user()->kode_ps)
            ->avg('dana');

        $jumlah_ts2 = DB::table('penggunaan_dana')->where('tahun', '=', $years[0])->where('kategori_pengelola_id', '=', 1)->where('user_id', Auth::user()->kode_ps)->sum('dana');
        $jumlah_ts1 = DB::table('penggunaan_dana')->where('tahun', '=', $years[1])->where('kategori_pengelola_id', '=', 1)->where('user_id', Auth::user()->kode_ps)->sum('dana');
        $jumlah_ts = DB::table('penggunaan_dana')->where('tahun', '=', $years[2])->where('kategori_pengelola_id', '=', 1)->where('user_id', Auth::user()->kode_ps)->sum('dana');

        $jumlah_ts2_ps = DB::table('penggunaan_dana')->where('tahun', '=', $years[0])->where('kategori_pengelola_id', '=', 2)->where('user_id', Auth::user()->kode_ps)->sum('dana');
        $jumlah_ts1_ps = DB::table('penggunaan_dana')->where('tahun', '=', $years[1])->where('kategori_pengelola_id', '=', 2)->where('user_id', Auth::user()->kode_ps)->sum('dana');
        $jumlah_ts_ps = DB::table('penggunaan_dana')->where('tahun', '=', $years[2])->where('kategori_pengelola_id', '=', 2)->where('user_id', Auth::user()->kode_ps)->sum('dana');

        $table_penggunaan_dana->addRow();
        $table_penggunaan_dana->addCell(null, array('gridSpan' => '2'))->addText('Jumlah =', $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null)->addText("Rp " . number_format($jumlah_ts2 ?? '0', 2, ',', '.'), $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null)->addText("Rp " . number_format($jumlah_ts1 ?? '0', 2, ',', '.'), $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null)->addText("Rp " . number_format($jumlah_ts ?? '0', 2, ',', '.'), $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null)->addText("Rp " . number_format($avg_unit ?? '0', 2, ',', '.'), $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null)->addText("Rp " . number_format($jumlah_ts2_ps ?? '0', 2, ',', '.'), $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null)->addText("Rp " . number_format($jumlah_ts1_ps ?? '0', 2, ',', '.'), $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null)->addText("Rp " . number_format($jumlah_ts_ps ?? '0', 2, ',', '.'), $fontStyle2, $cellHCentered);
        $table_penggunaan_dana->addCell(null)->addText("Rp " . number_format($avg_ps ?? '0', 2, ',', '.'), $fontStyle2, $cellHCentered);

        //Peralatan lab
        $isi = $file->addSection();
        $isi->addText('Tuliskan data peralatan utama laboratorium yang dikelola oleh UPPS pada saat TS dengan mengikuti format Tabel 5.b.1 berikut ini:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 5.b.1 Peralatan utama laboratorium pada saat TS',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $data_lab = DB::table('data_lab')
            ->where('tahun_pengadaan', '=', Carbon::now())
            ->where('data_lab.user_id', Auth::user()->kode_ps)->get();

        $table_alat_lab = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_alat_lab->addRow(1000);

        $header_nomor = $table_alat_lab->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_alat_lab->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama alat', $fontStyle2);

        $header_tahun = $table_alat_lab->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun pengadaan (YYYY)', $fontStyle2);

        $header_lokasi = $table_alat_lab->addCell(null, $cellRowSpan);
        $lokasi = $header_lokasi->addTextRun($cellHCentered);
        $lokasi->addText('Lokasi', $fontStyle2);

        $header_fungsi = $table_alat_lab->addCell(null, $cellRowSpan);
        $fungsi = $header_fungsi->addTextRun($cellHCentered);
        $fungsi->addText('Fungsi', $fontStyle2);

        $table_alat_lab->addRow();
        $table_alat_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alat_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alat_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alat_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alat_lab->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        foreach ($data_lab as $key => $value) {
            $i++;

            $table_alat_lab->addRow(2000);
            $cellNo = $table_alat_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_alat_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_alat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_alat_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun_pengadaan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellLokasi = $table_alat_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLokasi->addText($value->lokasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellFungsi = $table_alat_lab->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellFungsi->addText($value->fungsi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }


        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Peralatan TS-4
        $isi = $file->addSection();
        $isi->addText('Tuliskan data peralatan utama laboratorium yang dikelola oleh UPPS pada saat TS-4 dengan mengikuti format Tabel 5.b.2 berikut ini:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 5.b.2 Peralatan utama laboratorium pada saat TS-4',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // $data_lab = DB::table('data_lab')
        //     ->where('data_lab.user_id', Auth::user()->kode_ps)->get();

        $table_alat_lab2 = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_alat_lab2->addRow(1000);

        $header_nomor = $table_alat_lab2->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_alat_lab2->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama alat', $fontStyle2);

        $header_tahun = $table_alat_lab2->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun pengadaan (YYYY)', $fontStyle2);

        $header_lokasi = $table_alat_lab2->addCell(null, $cellRowSpan);
        $lokasi = $header_lokasi->addTextRun($cellHCentered);
        $lokasi->addText('Lokasi', $fontStyle2);

        $header_fungsi = $table_alat_lab2->addCell(null, $cellRowSpan);
        $fungsi = $header_fungsi->addTextRun($cellHCentered);
        $fungsi->addText('Fungsi', $fontStyle2);

        $table_alat_lab2->addRow();
        $table_alat_lab2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alat_lab2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alat_lab2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alat_lab2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_alat_lab2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $years = $this->getYears(4);
        $data = array();
        $nb = 0;

        $data_lab = DB::table('data_lab')->where('tahun_pengadaan', $years[0])->where('user_id', Auth::user()->kode_ps)->get();
        // dd($years);
        $i = 0;
        foreach ($data_lab as $key => $value) {
            $i++;

            $table_alat_lab2->addRow(2000);
            $cellNo = $table_alat_lab2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_alat_lab2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_alat, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_alat_lab2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun_pengadaan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellLokasi = $table_alat_lab2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLokasi->addText($value->lokasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellFungsi = $table_alat_lab2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellFungsi->addText($value->fungsi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Pendidikan
        $judul2 = $file->addSection();
        $judul2->addText('6. PENDIDIKAN',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $judul3 = $file->addSection();
        $judul3->addText('a. Kurikulum',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan struktur program dan kelengkapan data mata kuliah sesuai dengan dokumen kurikulum program studi yang berlaku pada saat
        TS dengan mengikuti format Tabel 6.a(i) dan 6.a(ii) berikut ini. Semester, Kode Mata Kuliah, dan urutannya dibuat sama pada kedua tabel tersebut. Saat pemasukan data dalam spreadsheet IAPS, kedua tabel disatukan, melebar ke kanan, sesuai urutan nomor kolom. Lihat Panduan Penyusunan LKPS.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 6.a(i) Kurikulum, Capaian Pembelajaran, dan Rencana Pembelajaran (Data Pertama)',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_kurikulum = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kurikulum->addRow(1000);

        $header_nomor = $table_kurikulum->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_semester = $table_kurikulum->addCell(null, $cellRowSpan);
        $semester = $header_semester->addTextRun($cellHCentered);
        $semester->addText('Semester', $fontStyle2);

        $header_kode = $table_kurikulum->addCell(null, $cellRowSpan);
        $kode = $header_nama->addTextRun($cellHCentered);
        $header_kode->addText('Kode Mata Kuliah', $fontStyle2);

        $header_nama = $table_kurikulum->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Mata Kuliah', $fontStyle2);

        $header_mk = $table_kurikulum->addCell(null, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Mata Kuliah Kompetensi', $fontStyle2);

        $header_kode = $table_kurikulum->addCell(null, $cellColSpan);
        $kode = $header_kode->addTextRun($cellHCentered);
        $kode->addText('Bobot Kredit (sks)', $fontStyle2);

        $header_konversi = $table_kurikulum->addCell(null, $cellRowSpan);
        $konversi = $header_konversi->addTextRun($cellHCentered);
        $konversi->addText('Konversi Kredit ke Jam', $fontStyle2);

        $table_kurikulum->addRow();
        $table_kurikulum->addCell(null, $cellRowContinue);
        $table_kurikulum->addCell(null, $cellRowContinue);
        $table_kurikulum->addCell(null, $cellRowContinue);
        $table_kurikulum->addCell(null, $cellRowContinue);
        $table_kurikulum->addCell(null, $cellRowContinue);
        $table_kurikulum->addCell(null, $cellRowContinue);
        $table_kurikulum->addCell(null, $cellRowContinue);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Kuliah/ Responsi/ Tutorial', $fontStyle2, $cellHCentered);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Seminar', $fontStyle2, $cellHCentered);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Praktikum/ Praktik/ Praktik Lapangan', $fontStyle2, $cellHCentered);

        $table_kurikulum->addRow();
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $kurikulum = Kurikulum::with('semester')->where('user_id', Auth::user()->kode_ps)->orderBy('semester_id', 'ASC')->get();

        $i = 0;
        $total = 0;

        foreach ($kurikulum as $key) {
            $i++;

            $table_kurikulum->addRow(2000);
            $cellNo = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSemester = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSemester->addText($key->semester['nama_semester'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKode = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKode->addText($key->kode_mk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->nama_mk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($key->wajib == 'Y') {
                $cellMk = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellMk->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellMk = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellMk->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            $cellKuliah = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKuliah->addText($key->bobot_sks, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSeminar = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSeminar->addText($key->sks_seminar, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellPraktikum = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPraktikum->addText($key->sks_praktikum, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $jumlah_sks = $key['bobot_sks'] + $key['sks_seminar'] + $key['sks_praktikum'];

            $hours = floor($jumlah_sks * 50);
            $minutes = intdiv($hours, 60) . ':' . ($hours % 60);

            $cellKonversi = $table_kurikulum->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKonversi->addText("$minutes", ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $table = $file->addSection();
        $table->addText('Tabel 6.a(ii) Kurikulum, Capaian Pembelajaran, dan Rencana Pembelajaran (Data Kedua)',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_kurikulum2 = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kurikulum2->addRow(1000);

        $header_nomor = $table_kurikulum2->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_semester = $table_kurikulum2->addCell(null, $cellRowSpan);
        $semester = $header_semester->addTextRun($cellHCentered);
        $semester->addText('Semester', $fontStyle2);

        $header_kode = $table_kurikulum2->addCell(null, $cellRowSpan);
        $kode = $header_kode->addTextRun($cellHCentered);
        $kode->addText('Kode Mata Kuliah', $fontStyle2);

        $header_capaian = $table_kurikulum2->addCell(null, $cellColSpan4);
        $capaian = $header_capaian->addTextRun($cellHCentered);
        $capaian->addText('Capaian Pembelajaran', $fontStyle2);

        $header_dokumen = $table_kurikulum2->addCell(null, $cellRowSpan);
        $dokumen = $header_dokumen->addTextRun($cellHCentered);
        $dokumen->addText('Dokumen Rencana Pembela­jaran', $fontStyle2);

        $header_rps = $table_kurikulum2->addCell(null, $cellRowSpan);
        $rps = $header_rps->addTextRun($cellHCentered);
        $rps->addText('RPS', $fontStyle2);

        $header_modul = $table_kurikulum2->addCell(null, $cellRowSpan);
        $modul = $header_modul->addTextRun($cellHCentered);
        $modul->addText('Modul Praktikum', $fontStyle2);

        $header_unit = $table_kurikulum2->addCell(null, $cellRowSpan);
        $unit = $header_unit->addTextRun($cellHCentered);
        $unit->addText('Unit Penyelenggara', $fontStyle2);

        $table_kurikulum2->addRow();

        $table_kurikulum2->addCell(null, $cellRowContinue);
        $table_kurikulum2->addCell(null, $cellRowContinue);
        $table_kurikulum2->addCell(null, $cellRowContinue);
        $table_kurikulum2->addCell(null, $cellRowContinue);
        $table_kurikulum2->addCell(null, $cellRowContinue);
        $table_kurikulum2->addCell(null, $cellRowContinue);
        $table_kurikulum2->addCell(null, $cellRowContinue);
        $table_kurikulum2->addCell(null, $cellRowContinue);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Sikap', $fontStyle2, $cellHCentered);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Pengetahuan', $fontStyle2, $cellHCentered);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Keterampilan Umum', $fontStyle2, $cellHCentered);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Keterampilan Khusus', $fontStyle2, $cellHCentered);

        $table_kurikulum2->addRow();
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('10', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kurikulum2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('11', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $kurikulum2 = Kurikulum::with('semester')->where('user_id', Auth::user()->kode_ps)->orderBy('semester_id', 'ASC')->get();

        $i = 0;
        foreach ($kurikulum2 as $key) {
            $i++;

            $table_kurikulum2->addRow(2000);
            $cellNo = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSemester = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSemester->addText($key->semester['nama_semester'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellKode = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKode->addText($key->kode_mk, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($key->capaian == 'Sikap') {
                $cellSikap = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellSikap->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellSikap = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellSikap->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            if ($key->capaian == 'Pengetahuan') {
                $cellPengetahuan = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellPengetahuan->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellPengetahuan = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellPengetahuan->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            if ($key->capaian == 'Umum') {
                $cellUmum = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellUmum->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellUmum = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellUmum->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            if ($key->capaian == 'Khusus') {
                $cellKhusus = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellKhusus->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellKhusus = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellKhusus->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            $cellDokumen = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDokumen->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellRps = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRps->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            // $modul = Kurikulum::with('praktikum')->where('kode_mk', $key->kode_mk)->where('user_id', Auth::user()->kode_ps)->get();
            // dd($modul);
            $cellModul = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellModul->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellUnit = $table_kurikulum2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellUnit->addText($key->unit, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //integrasi
        $judul3 = $file->addSection();
        $judul3->addText('c. Integrasi Kegiatan Penelitian/Pengabdian kepada Masyarakat dalam Pembelajaran',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan judul penelitian/Pengabdian kepada Masyarakat DTPS yang terintegrasi ke dalam pembelajaran/ pengembangan mata kuliah mulai TS-2 dengan mengikuti format Tabel 6.b berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 6.b	Integrasi Kegiatan Penelitian/Pengabdian kepada Masyarakat dalam Pembelajaran',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_integrasi = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_integrasi->addRow(1000);

        $header_nomor = $table_integrasi->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_judul = $table_integrasi->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Penelitian/Pengabdian kepada Masyarakat', $fontStyle2);

        $header_nama = $table_integrasi->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Dosen', $fontStyle2);

        $header_mk = $table_integrasi->addCell(null, $cellRowSpan);
        $mk = $header_mk->addTextRun($cellHCentered);
        $mk->addText('Mata Kuliah', $fontStyle2);

        $header_integrasi = $table_integrasi->addCell(null, $cellRowSpan);
        $integrasi = $header_integrasi->addTextRun($cellHCentered);
        $integrasi->addText('Dokumen Rencana Pembela­jaran', $fontStyle2);

        $header_tahun = $table_integrasi->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('RPS', $fontStyle2);

        $table_integrasi->addRow();
        $table_integrasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_integrasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_integrasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_integrasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_integrasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_integrasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        foreach ($dosen as $key => $value) {
            $i++;

            $table_integrasi->addRow(2000);
            $cellNo = $table_integrasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_integrasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_integrasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellMk = $table_integrasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMk->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellIntegrasi = $table_integrasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellIntegrasi->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_integrasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        //kepuasan mahasiswa
        $space6 = $file->addSection();
        $space6->addTextBreak();

        $judul3 = $file->addSection();
        $judul3->addText('d. Kepuasan Mahasiswa',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan hasil pengukuran kepuasan mahasiswa terhadap proses pendidikan dengan mengikuti format Tabel 6.c berikut ini. Data diambil dari hasil studi penelusuran yang dilakukan pada saat TS.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 6.c	Kepuasan Mahasiswa',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_kepuasan = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kepuasan->addRow(1000);

        $header_nomor = $table_kepuasan->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_aspek = $table_kepuasan->addCell(null, $cellRowSpan);
        $aspek = $header_aspek->addTextRun($cellHCentered);
        $aspek->addText('Aspek yang Diukur', $fontStyle2);

        $header_tingkat = $table_kepuasan->addCell(null, $cellColSpan4);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat Kepuasan Mahasiswa (%)', $fontStyle2);

        $header_rencana = $table_kepuasan->addCell(null, $cellRowSpan);
        $rencana = $header_rencana->addTextRun($cellHCentered);
        $rencana->addText('Rencana Tindak Lanjut oleh UPPS/PS', $fontStyle2);

        $header_integrasi = $table_kepuasan->addCell(null, $cellRowSpan);
        $integrasi = $header_integrasi->addTextRun($cellHCentered);
        $integrasi->addText('Dokumen Rencana Pembela­jaran', $fontStyle2);

        $header_tahun = $table_kepuasan->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('RPS', $fontStyle2);

        $table_kepuasan->addRow();
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Sangat Baik', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Baik', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Cukup', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Kurang', $fontStyle2, $cellHCentered);

        $table_kepuasan->addRow();
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        //column 1
        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('1', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellAspek = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellAspek->addText('Keandalan (reliability): kemampuan dosen, tenaga kependidikan, dan pengelola dalam memberikan pelayanan.', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSB = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSB->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellDokumen = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellDokumen->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRps = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRps->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //column 2
        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('2', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellAspek = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellAspek->addText('Daya tanggap (responsiveness): kemauan dari dosen, tenaga kependidikan, dan pengelola dalam membantu mahasiswa dan memberikan jasa dengan cepat.', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSB = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSB->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellDokumen = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellDokumen->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRps = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRps->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //column 3
        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('3', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellAspek = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellAspek->addText('Kepastian (assurance): kemampuan dosen, tenaga kependidikan, dan pengelola untuk memberi keyakinan kepada mahasiswa bahwa pelayanan yang diberikan telah sesuai dengan ketentuan.', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSB = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSB->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellDokumen = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellDokumen->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRps = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRps->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //column 4
        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('4', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellAspek = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellAspek->addText('Empati (empathy): kesediaan/kepedulian dosen, tenaga kependidikan, dan pengelola untuk memberi perhatian kepada mahasiswa.', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSB = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSB->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellDokumen = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellDokumen->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRps = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRps->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //column 5
        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('5', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellAspek = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellAspek->addText('Empati (empathy): kesediaan/kepedulian dosen, tenaga kependidikan, dan pengelola untuk memberi perhatian kepada mahasiswa.', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSB = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSB->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellDokumen = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellDokumen->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRps = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRps->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table_kepuasan->addRow();
        $table_kepuasan->addCell(null, array('gridSpan' => '2'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Penelitian
        $judul2 = $file->addSection();
        $judul2->addText('7. PENELITIAN',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $judul3 = $file->addSection();
        $judul3->addText('a. Penelitian DTPS yang Melibatkan Mahasiswa',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 7.a berikut ini diisi oleh pengusul dari Program Studi pada program Sarjana/Sarjana Terapan/Magister/Magister Terapan/ Doktor/ Doktor Terapan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi->addText('Tuliskan data penelitian DTPS yang dalam pelaksanaannya melibatkan mahasiswa Program Studi pada TS-2 sampai dengan TS dengan mengikuti format Tabel 7.a berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 7.a Penelitian DTPS yang Melibatkan Mahasiswa',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

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

        $years = $this->getYears(3);
        $date = Carbon::now()->year;

        $data_penelitian = DataPenelitian::with(['penelitianmhs', 'dosen', 'penelitianmhs.mahasiswa'])->where('tahun_penelitian', '>=', $years[0])->where('tahun_penelitian', '<=', $date)
            ->where('data_penelitian.jenis_penelitian', '=', 1)
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

        $jumlah_penelitian = DataPenelitian::with(['penelitianmhs', 'dosen', 'penelitianmhs.mahasiswa'])->where('tahun_penelitian', '>=', $years[0])->where('tahun_penelitian', '<=', $date)
            ->where('data_penelitian.jenis_penelitian', '=', 1)
            ->where('user_id', Auth::user()->kode_ps)->count('id');

        $table_penelitian->addRow();
        $table_penelitian->addCell(null, array('gridSpan' => '5'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_penelitian->addCell(null)->addText($jumlah_penelitian, $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $isi = $file->addSection();
        $isi->addText('Tabel 7.b berikut ini diisi oleh pengusul dari Program Studi pada program Magister/Magister Terapan/ Doktor/ Doktor Terapan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi->addText('Tuliskan data penelitian DTPS yang menjadi rujukan tema tesis/disertasi mahasiswa Program Studi pada TS-2 sampai dengan TS dengan mengikuti format Tabel 7.b berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 7.b Penelitian DTPS yang Menjadi Rujukan Tema Tesis/Disertasi',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

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

        $years = $this->getYears(3);
        $date = Carbon::now()->year;

        $data_penelitianmagister = DataPenelitian::with(['penelitianmagister', 'dosen', 'penelitianmagister.biodata_mhs'])->where('tahun_penelitian', '>=', $years[0])->where('tahun_penelitian', '<=', $date)
            ->where('data_penelitian.jenis_penelitian', '=', 2)
            ->where('user_id', Auth::user()->kode_ps)->get();

        if (Auth::user()->tingkat == 's2') {
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
                    $listmhs2[] = $item->magister['nama'];
                }

                $cellMhs->addText(implode(', ', $listmhs2) ?? '', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $cellJudul = $table_penelitian2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJudul->addText($key->judul_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $cellTahun = $table_penelitian2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText($key->tahun_penelitian, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $jumlah = DataPenelitian::with(['penelitianmagister', 'dosen', 'penelitianmagister.magister'])->where('tahun_penelitian', '>=', $years[0])->where('tahun_penelitian', '<=', $date)
                ->where('data_penelitian.jenis_penelitian', '=', 2)
                ->where('user_id', Auth::user()->kode_ps)->count('id');

            $table_penelitian2->addRow();
            $table_penelitian2->addCell(null, array('gridSpan' => '5'))->addText('Jumlah', $fontStyle2, $cellHCentered);
            $table_penelitian2->addCell(null)->addText($jumlah, $fontStyle2, $cellHCentered);
        } else {
            $table_penelitian2->addRow();
            $table_penelitian2->addCell(null, array('gridSpan' => '6'))->addText('Data Tidak Tersedia', $fontStyle2, $cellHCentered);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Pengabdian
        $judul2 = $file->addSection();
        $judul2->addText('8. PENGABDIAN KEPADA MASYARAKAT (PkM) ',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $judul3 = $file->addSection();
        $judul3->addText('a. Pengabdian kepada Masyarakat DTPS yang Melibatkan Mahasiswa',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 8 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi->addText('Tuliskan data Pengabdian kepada Masyarakat DTPS yang dalam pelaksanaannya melibatkan mahasiswa Program Studi pada TS-2 sampai dengan TS dengan mengikuti format Tabel 8 berikut ini.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 8. Pengabdian kepada Masyarakat DTPS yang melibatkan mahasiswa',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

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

        $years = $this->getYears(3);
        $date = Carbon::now()->year;

        $data_pkm = DataPkm::with(['pkm_mhs', 'dosen', 'sumberdana', 'pkm_mhs.biodata_mhs'])->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('jenis_pkm', '=', 1)
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

        $jumlah = DataPkm::with(['pkm_mhs', 'dosen', 'sumberdana', 'pkm_mhs.biodata_mhs'])->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('jenis_pkm', '=', 1)
            ->where('user_id', Auth::user()->kode_ps)->count('id');

        $table_pengabdian->addRow();
        $table_pengabdian->addCell(null, array('gridSpan' => '5'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_pengabdian->addCell(null)->addText($jumlah, $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Luaran Dan Capaian Tridharma
        $judul2 = $file->addSection();
        $judul2->addText('9. LUARAN DAN CAPAIAN TRIDARMA',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $judul3 = $file->addSection();
        $judul3->addText('a. Capaian Pembelajaran',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan data Indeks Prestasi Kumulatif (IPK) lulusan mulai TS-2 dengan mengikuti format Tabel 9.a berikut ini. Data dilengkapi dengan jumlah lulusan pada setiap tahun kelulusan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 9.a IPK Lulusan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_capaian = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_capaian->addRow(1000);

        $header_no = $table_capaian->addCell(null, $cellRowSpan);
        $no = $header_no->addTextRun($cellHCentered);
        $no->addText('No', $fontStyle2);

        $header_tahun = $table_capaian->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Lulus', $fontStyle2);

        $header_lulusan = $table_capaian->addCell(null, $cellRowSpan);
        $lulusan = $header_lulusan->addTextRun($cellHCentered);
        $lulusan->addText('Jumlah Lulusan', $fontStyle2);

        $header_ipk = $table_capaian->addCell(null, $cellColSpan);
        $ipk = $header_ipk->addTextRun($cellHCentered);
        $ipk->addText('Indeks Prestasi Kumulatif (IPK)', $fontStyle2);

        $table_capaian->addRow();
        $table_capaian->addCell(null, $cellRowContinue);
        $table_capaian->addCell(null, $cellRowContinue);
        $table_capaian->addCell(null, $cellRowContinue);
        $table_capaian->addCell(null, $cellRowContinue);
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Minimal', $fontStyle2, $cellHCentered);
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Rata-rata', $fontStyle2, $cellHCentered);
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Maksimal', $fontStyle2, $cellHCentered);

        $table_capaian->addRow();
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_capaian->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(3);
        $data = array();
        $nb = 0;
        foreach ($years as $key => $year) {
            $i++;

            $table_capaian->addRow(2000);

            $cellNo = $table_capaian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellTahun = $table_capaian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(htmlspecialchars("{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $capaian = Capaian::where('tahun', $year)->where('user_id', Auth::user()->kode_ps)->first();
            // dd($capaian);

            $cellLulusan = $table_capaian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLulusan->addText($capaian['jumlah'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $min = Capaian::where('tahun', $year)->where('user_id', Auth::user()->kode_ps)->first();
            $cellMinimal = $table_capaian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMinimal->addText($min['minimum'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $rata = Capaian::where('tahun', $year)->where('user_id', Auth::user()->kode_ps)->first();
            $cellRata = $table_capaian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellRata->addText($rata['rata'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $maks = Capaian::where('tahun', $year)->where('user_id', Auth::user()->kode_ps)->first();
            $cellMaks = $table_capaian->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMaks->addText($maks['maksimum'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $avg_min = DB::table('capaian')->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('user_id', Auth::user()->kode_ps)
            ->avg('minimum');

        $avg_rata = DB::table('capaian')->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('user_id', Auth::user()->kode_ps)
            ->avg('rata');

        $avg_maks = DB::table('capaian')->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('user_id', Auth::user()->kode_ps)
            ->avg('maksimum');


        $table_capaian->addRow();
        $table_capaian->addCell(null, array('gridSpan' => '3'))->addText('Rata-rata', $fontStyle2, $cellHCentered);
        $table_capaian->addCell(null)->addText($avg_min ?? '0', $fontStyle2, $cellHCentered);
        $table_capaian->addCell(null)->addText($avg_rata ?? '0', $fontStyle2, $cellHCentered);
        $table_capaian->addCell(null)->addText($avg_maks ?? '0', $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Prestasi Mahasiswa
        $judul3 = $file->addSection();
        $judul3->addText('e. Prestasi Mahasiswa',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.b.1 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/ Sarjana/ Sarjana Terapan/ Magister/ Magister Terapan/ Doktor/ Doktor Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi->addText('Tuliskan prestasi akademik yang dicapai mahasiswa Program Studi mulai TS-2 dengan mengikuti format Tabel 9.b.1. Data dilengkapi dengan keterangan kegiatan prestasi yang diikuti (nama kegiatan, tahun, tingkat, dan prestasi yang dicapai).',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 9.b.1 Prestasi Akademik Mahasiswa',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_prestasi = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_prestasi->addRow(1000);

        $header_no = $table_prestasi->addCell(null, $cellRowSpan);
        $no = $header_no->addTextRun($cellHCentered);
        $no->addText('No', $fontStyle2);

        $header_nama = $table_prestasi->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Kegiatan', $fontStyle2);

        $header_tahun = $table_prestasi->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Perolehan', $fontStyle2);

        $header_tingkat = $table_prestasi->addCell(null, $cellColSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat', $fontStyle2);

        $header_prestasi = $table_prestasi->addCell(null, $cellRowSpan);
        $prestasi = $header_prestasi->addTextRun($cellHCentered);
        $prestasi->addText('Prestasi yang Dicapai', $fontStyle2);

        $table_prestasi->addRow();
        $table_prestasi->addCell(null, $cellRowContinue);
        $table_prestasi->addCell(null, $cellRowContinue);
        $table_prestasi->addCell(null, $cellRowContinue);
        $table_prestasi->addCell(null, $cellRowContinue);
        $table_prestasi->addCell(null, $cellRowContinue);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Lokal/Wilayah', $fontStyle2, $cellHCentered);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Nasional', $fontStyle2, $cellHCentered);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Internasional', $fontStyle2, $cellHCentered);

        $table_prestasi->addRow();
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(3);

        // $prestasi_mhs = DB::table('prestasi_mhs')
        //     ->join('kategori_tingkat', 'prestasi_mhs.tingkat', '=', 'kategori_tingkat.id')
        //     ->join('kategori_jenis_prestasi', 'prestasi_mhs.jenis_prestasi', '=', 'kategori_jenis_prestasi.id')
        //     ->select('prestasi_mhs.*', 'kategori_tingkat.nama_kategori', 'kategori_jenis_prestasi.jenis')->where('jenis_prestasi', '=', '1')
        //     ->whereYEAR('tahun', '>=', $years[0])->whereYEAR('tahun', '<=', $date)
        //     ->where('user_id', Auth::user()->kode_ps)->get();

        $prestasi_mhs = PrestasiMhs::with(['kategori_tingkat', 'kategori_jenis_prestasi', 'himpunan'])->where('jenis_prestasi', '=', '1')
            ->whereYEAR('tahun', '>=', $years[0])->whereYEAR('tahun', '<=', $date)
            ->where('user_id', Auth::user()->kode_ps)->get();

        // dd($prestasi_mhs);

        foreach ($prestasi_mhs as $key => $value) {
            $i++;

            $table_prestasi->addRow(2000);
            $cellNo = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($value->tingkat == 1) {
                $cellLokal = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellLokal->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellLokal = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellLokal->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            if ($value->tingkat == 2) {
                $cellNasional = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellNasional->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellNasional = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellNasional->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            if ($value->tingkat == 3) {
                $cellInternasional = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellInternasional->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellInternasional = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellInternasional->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            $cellPrestasi = $table_prestasi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPrestasi->addText($value->prestasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $jumlah_prestasi = DB::table('prestasi_mhs')
            ->join('kategori_tingkat', 'prestasi_mhs.tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_jenis_prestasi', 'prestasi_mhs.jenis_prestasi', '=', 'kategori_jenis_prestasi.id')
            ->select('prestasi_mhs.*', 'kategori_tingkat.nama_kategori', 'kategori_jenis_prestasi.jenis')->where('jenis_prestasi', '=', '1')
            ->whereYEAR('tahun', '>=', $years[0])->whereYEAR('tahun', '<=', $date)
            ->where('user_id', Auth::user()->kode_ps)->count('prestasi_mhs.id');

        $table_prestasi->addRow();
        $table_prestasi->addCell(null, array('gridSpan' => '6'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_prestasi->addCell(null)->addText($jumlah_prestasi, $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //prestasi Non akademik
        $isi = $file->addSection();
        $isi->addText('Tabel 9.b.2 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/ Sarjana/ Sarjana Terapan/ Magister/ Magister Terapan/ Doktor/ Doktor Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi->addText('Tuliskan prestasi non-akademik yang dicapai mahasiswa Program Studi mulai TS-2 dengan mengikuti format Tabel 9.b.2. Data dilengkapi dengan keterangan kegiatan prestasi yang diikuti (nama kegiatan, tahun, tingkat, dan prestasi yang dicapai).',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table->addText('Tabel 9.b.2 Prestasi Non-akademik Mahasiswa',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $years = $this->getYears(4);

        $prestasi_mhs = DB::table('prestasi_mhs')
            ->join('kategori_tingkat', 'prestasi_mhs.tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_jenis_prestasi', 'prestasi_mhs.jenis_prestasi', '=', 'kategori_jenis_prestasi.id')
            ->select('prestasi_mhs.*', 'kategori_tingkat.nama_kategori', 'kategori_jenis_prestasi.jenis')->where('jenis_prestasi', '=', '2')
            ->whereYEAR('tahun', '>=', $years[0])->whereYEAR('tahun', '<=', $date)
            ->where('user_id', Auth::user()->kode_ps)->get();

        $table_prestasi_non = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_prestasi_non->addRow(1000);

        $header_no = $table_prestasi_non->addCell(null, $cellRowSpan);
        $no = $header_no->addTextRun($cellHCentered);
        $no->addText('No', $fontStyle2);

        $header_nama = $table_prestasi_non->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Kegiatan', $fontStyle2);

        $header_tahun = $table_prestasi_non->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Perolehan', $fontStyle2);

        $header_tingkat = $table_prestasi_non->addCell(null, $cellColSpan);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat', $fontStyle2);

        $header_prestasi = $table_prestasi_non->addCell(null, $cellRowSpan);
        $prestasi = $header_prestasi->addTextRun($cellHCentered);
        $prestasi->addText('Prestasi yang Dicapai', $fontStyle2);

        $table_prestasi_non->addRow();
        $table_prestasi_non->addCell(null, $cellRowContinue);
        $table_prestasi_non->addCell(null, $cellRowContinue);
        $table_prestasi_non->addCell(null, $cellRowContinue);
        $table_prestasi_non->addCell(null, $cellRowContinue);
        $table_prestasi_non->addCell(null, $cellRowContinue);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Lokal/Wilayah', $fontStyle2, $cellHCentered);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Nasional', $fontStyle2, $cellHCentered);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Internasional', $fontStyle2, $cellHCentered);

        $table_prestasi_non->addRow();
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_prestasi_non->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        foreach ($prestasi_mhs as $key => $value) {
            $i++;

            $table_prestasi_non->addRow(2000);
            $cellNo = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->nama_kegiatan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            if ($value->tingkat == 1) {
                $cellLokal = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellLokal->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellLokal = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellLokal->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            if ($value->tingkat == 2) {
                $cellNasional = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellNasional->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellNasional = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellNasional->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }

            if ($value->tingkat == 3) {
                $cellInternasional = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellInternasional->addText('v', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            } else {
                $cellInternasional = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellInternasional->addText('-', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            }
            $cellPrestasi = $table_prestasi_non->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPrestasi->addText($value->prestasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $jumlah_prestasi_non = DB::table('prestasi_mhs')
            ->join('kategori_tingkat', 'prestasi_mhs.tingkat', '=', 'kategori_tingkat.id')
            ->join('kategori_jenis_prestasi', 'prestasi_mhs.jenis_prestasi', '=', 'kategori_jenis_prestasi.id')
            ->select('prestasi_mhs.*', 'kategori_tingkat.nama_kategori', 'kategori_jenis_prestasi.jenis')->where('jenis_prestasi', '=', '2')
            ->whereYEAR('tahun', '>=', $years[0])->whereYEAR('tahun', '<=', $date)
            ->where('user_id', Auth::user()->kode_ps)->count('prestasi_mhs.id');

        $table_prestasi_non->addRow();
        $table_prestasi_non->addCell(null, array('gridSpan' => '6'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_prestasi_non->addCell(null)->addText($jumlah_prestasi_non, $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Efektivitas dan Produktivitas Pendidikan
        $judul2 = $file->addSection();
        $judul2->addText('f. Efektivitas dan Produktivitas Pendidikan',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan data mahasiswa dan lulusan untuk dengan mengikuti format Tabel 9.c berikut. ',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.c Efektifitas dan Produktifitas Pendidikan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $isi2 = $file->addSection();
        $isi2->addText('Diisi oleh pengusul dari Program Studi pada Program Diploma Tiga',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();

        $table_efektivitas = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_efektivitas->addRow(1000);

        $header_tahun = $table_efektivitas->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_diterima = $table_efektivitas->addCell(null, $cellRowSpan);
        $diterima = $header_diterima->addTextRun($cellHCentered);
        $diterima->addText('Jumlah Mahasiswa Diterima', $fontStyle2);

        $header_lulus = $table_efektivitas->addCell(null, $cellColSpan5);
        $lulus = $header_lulus->addTextRun($cellHCentered);
        $lulus->addText('Jumlah Mahasiswa yang Lulus pada', $fontStyle2);

        $header_jumlah = $table_efektivitas->addCell(null, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah Lulusan s.d. Akhir TS', $fontStyle2);

        $header_rata = $table_efektivitas->addCell(null, $cellRowSpan);
        $rata = $header_rata->addTextRun($cellHCentered);
        $rata->addText('Rata-rata Masa Studi', $fontStyle2);

        $table_efektivitas->addRow();
        $table_efektivitas->addCell(null, $cellRowContinue);
        $table_efektivitas->addCell(null, $cellRowContinue);
        $table_efektivitas->addCell(null, $cellRowContinue);
        $table_efektivitas->addCell(null, $cellRowContinue);
        $table_efektivitas->addCell(null, $cellRowContinue);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-4', $fontStyle2, $cellHCentered);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-3', $fontStyle2, $cellHCentered);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-2', $fontStyle2, $cellHCentered);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-1', $fontStyle2, $cellHCentered);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS', $fontStyle2, $cellHCentered);

        $table_efektivitas->addRow();
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(4);
        $data = array();
        $nb = 0;
        if (Auth::user()->tingkat == '0') {
            foreach ($years as $key => $year) {
                $i++;

                $table_efektivitas->addRow(2000);

                $cellTahun = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

                $mahasiswad3[0] = DB::table('biodata_mhs')->whereYear('tahun_masuk', $year)->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswad3[1] = DB::table('alumni')->whereYear('tahun_masuk', $year)->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswad3['total'] = $mahasiswad3[0] + $mahasiswad3[1];

                $cellJumlah = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlah->addText($mahasiswad3['total'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $i = 0;
                $yearlulus = $this->getYears(5);
                $data = array();
                $nb = 0;

                foreach ($yearlulus as $keys => $tahunlulus) {
                    $mahasiswalulusd3 = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->count();
                    $nb += $mahasiswalulusd3;
                    $cellTS = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                    $cellTS->addText($mahasiswalulusd3, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                }

                $jumlahlulus = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->count();
                $nb += $jumlahlulus;

                $cellJumlahLulusan = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlahLulusan->addText($jumlahlulus, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $datetime1 = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->get();
                $avg = 0;
                $sum = 0;

                foreach ($datetime1 as $key => $data) {

                    $coba1 = json_decode(json_encode($data), true);

                    $date1 = new \DateTime($coba1['tahun_masuk']);
                    $date2 = new \DateTime($coba1['tahun_lulus']);

                    $diff  = $date1->diff($date2);
                    $interval =  $diff->format("%a");

                    $sum += $interval;
                }

                $jumlah = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->whereNotNUll('tahun_lulus')->where('user_id', Auth::user()->kode_ps)->count();

                if ($jumlah != 0) {
                    $avg = $sum / $jumlah;
                } else {
                    "Data Tidak Tersedia";
                }

                $years = ($avg / 365);
                $years = floor($years);

                $month = ($avg % 365) / 30.5;
                $month = floor($month);

                $days = ($avg % 365) % 30;

                $cellhari = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellhari->addText($years . ' Tahun , ' . $month . ' Bulan ', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
        } else {
            foreach ($years as $key => $year) {
                $table_efektivitas->addRow(2000);

                $cellTahun = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

                $cellJumlah = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlah->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $i = 0;
                $yearlulus = $this->getYears(5);
                $data = array();
                $nb = 0;

                foreach ($yearlulus as $keys => $tahunlulus) {
                    $cellTS = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                    $cellTS->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                }

                $cellJumlahLulusan = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlahLulusan->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $cellhari = $table_efektivitas->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellhari->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //efektivitas program sarjana/ sarjana terapan
        $isi2 = $file->addSection();
        $isi2->addText('Diisi oleh pengusul dari Program Studi pada Program Sarjana/Sarjana Terapan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();

        $table_efektivitas2 = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_efektivitas2->addRow(1000);

        $header_tahun = $table_efektivitas2->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_diterima = $table_efektivitas2->addCell(null, $cellRowSpan);
        $diterima = $header_diterima->addTextRun($cellHCentered);
        $diterima->addText('Jumlah Mahasiswa Diterima', $fontStyle2);

        $header_lulus2 = $table_efektivitas2->addCell(null, $cellColSpan5);
        $lulus2 = $header_lulus2->addTextRun($cellHCentered);
        $lulus2->addText('Jumlah Mahasiswa yang Lulus pada', $fontStyle2);

        $header_jumlah = $table_efektivitas2->addCell(null, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah Lulusan s.d. Akhir TS', $fontStyle2);

        $header_rata = $table_efektivitas2->addCell(null, $cellRowSpan);
        $rata = $header_rata->addTextRun($cellHCentered);
        $rata->addText('Rata-rata Masa Studi', $fontStyle2);

        $table_efektivitas2->addRow();
        $table_efektivitas2->addCell(null, $cellRowContinue);
        $table_efektivitas2->addCell(null, $cellRowContinue);
        $table_efektivitas2->addCell(null, $cellRowContinue);
        $table_efektivitas2->addCell(null, $cellRowContinue);
        $table_efektivitas2->addCell(null, $cellRowContinue);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-4', $fontStyle2, $cellHCentered);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-3', $fontStyle2, $cellHCentered);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-2', $fontStyle2, $cellHCentered);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-1', $fontStyle2, $cellHCentered);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS', $fontStyle2, $cellHCentered);

        $table_efektivitas2->addRow();
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas2->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(6);
        $data = array();
        $nb = 0;
        if (Auth::user()->tingkat == '1') {

            foreach ($years as $key => $year) {
                $i++;

                $table_efektivitas2->addRow(2000);

                $cellTahun = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

                // $mahasiswa[0] = DB::table('biodata_mhs')->whereYear('tahun_masuk', $year)->whereNotNull('deleted_at')->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswa[0] = MhsReguler::with('kategori_status_mhs', 'kategori_jalur', 'dosen')->whereYear('tahun_masuk', $year)->where('id_status', '1')->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswa[1] = DB::table('alumni')->whereYear('tahun_masuk', $year)->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswa['total'] = $mahasiswa[0] + $mahasiswa[1];

                $cellJumlah = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlah->addText($mahasiswa['total'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $i = 0;
                $yearlulus = $this->getYears(5);
                $data = array();
                $nb = 0;

                foreach ($yearlulus as $keys => $tahunlulus) {
                    $mahasiswalulus = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->count();
                    $nb += $mahasiswalulus;
                    $cellTS = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                    $cellTS->addText($mahasiswalulus, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                }

                $jumlahlulus = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->whereNotNUll('tahun_lulus')->where('user_id', Auth::user()->kode_ps)->where('user_id', Auth::user()->kode_ps)->count();
                $nb += $jumlahlulus;
                $cellJumlahLulusan = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlahLulusan->addText($jumlahlulus, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $datetime = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->get();
                $avg = 0;
                $sum = 0;

                foreach ($datetime as $key => $data) {

                    $coba1 = json_decode(json_encode($data), true);

                    $date1 = new \DateTime($coba1['tahun_masuk']);
                    $date2 = new \DateTime($coba1['tahun_lulus']);

                    $diff  = $date1->diff($date2);
                    $interval =  $diff->format("%a");

                    $sum += $interval;
                }

                $jumlah = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->whereNotNUll('tahun_lulus')->where('user_id', Auth::user()->kode_ps)->count();

                if ($jumlah != 0) {
                    $avg = $sum / $jumlah;
                } else {
                    "Data Tidak Tersedia";
                }

                $years = ($avg / 365);
                $years = floor($years);

                $month = ($avg % 365) / 30;
                $month = floor($month);

                $days = ($avg % 365) % 30;

                $cellhari = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellhari->addText($years . ' Tahun , ' . $month . ' Bulan ', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
        } else {
            foreach ($years as $key => $year) {
                $table_efektivitas2->addRow(2000);

                $cellTahun = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

                $cellJumlah = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlah->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $i = 0;
                $yearlulus = $this->getYears(5);
                $data = array();
                $nb = 0;

                foreach ($yearlulus as $keys => $tahunlulus) {
                    $cellTS = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                    $cellTS->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                }

                $cellJumlahLulusan = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlahLulusan->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $cellhari = $table_efektivitas2->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellhari->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Magister/Magister Terapan
        $isi2 = $file->addSection();
        $isi2->addText('Diisi oleh pengusul dari Program Studi pada Program Magister/Magister Terapan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();

        $table_efektivitas3 = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_efektivitas3->addRow(1000);

        $header_tahun = $table_efektivitas3->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_diterima = $table_efektivitas3->addCell(null, $cellRowSpan);
        $diterima = $header_diterima->addTextRun($cellHCentered);
        $diterima->addText('Jumlah Mahasiswa Diterima', $fontStyle2);

        $header_lulus = $table_efektivitas3->addCell(null, $cellColSpan4);
        $lulus = $header_lulus->addTextRun($cellHCentered);
        $lulus->addText('Jumlah Mahasiswa yang Lulus pada', $fontStyle2);

        $header_jumlah = $table_efektivitas3->addCell(null, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah Lulusan s.d. Akhir TS', $fontStyle2);

        $header_rata = $table_efektivitas3->addCell(null, $cellRowSpan);
        $rata = $header_rata->addTextRun($cellHCentered);
        $rata->addText('Rata-rata Masa Studi', $fontStyle2);

        $table_efektivitas3->addRow();
        $table_efektivitas3->addCell(null, $cellRowContinue);
        $table_efektivitas3->addCell(null, $cellRowContinue);
        $table_efektivitas3->addCell(null, $cellRowContinue);
        $table_efektivitas3->addCell(null, $cellRowContinue);
        $table_efektivitas3->addCell(null, $cellRowContinue);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-3', $fontStyle2, $cellHCentered);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-2', $fontStyle2, $cellHCentered);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-1', $fontStyle2, $cellHCentered);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS', $fontStyle2, $cellHCentered);

        $table_efektivitas3->addRow();
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas3->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(6);
        $data = array();
        $nb = 0;
        if (Auth::user()->tingkat == '2') {
            foreach ($years as $key => $year) {
                $i++;

                $table_efektivitas3->addRow(2000);

                $cellTahun = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

                $mahasiswas2[0] = DB::table('biodata_mhs')->whereYear('tahun_masuk', $year)->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswas2[1] = DB::table('alumni')->whereYear('tahun_masuk', $year)->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswas2['total'] = $mahasiswas2[0] + $mahasiswas2[1];

                $cellJumlah = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlah->addText($mahasiswas2['total'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $i = 0;
                $yearlulus = $this->getYears(4);
                $data = array();
                $nb = 0;

                foreach ($yearlulus as $keys => $tahunlulus) {
                    $mahasiswalulus = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->count();
                    $nb += $mahasiswalulus;
                    $cellTS = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                    $cellTS->addText($mahasiswalulus, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                }

                $jumlahlulus1 = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->count();
                $nb += $jumlahlulus1;
                $cellJumlahLulusan = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlahLulusan->addText($jumlahlulus1, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $datetime2 = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('tahun_lulus', '!=', NULL)->where('user_id', Auth::user()->kode_ps)->get();
                $avg = 0;
                $sum = 0;

                foreach ($datetime2 as $key => $data) {

                    $coba1 = json_decode(json_encode($data), true);

                    $date1 = new \DateTime($coba1['tahun_masuk']);
                    $date2 = new \DateTime($coba1['tahun_lulus']);

                    $diff  = $date1->diff($date2);
                    $interval =  $diff->format("%a");

                    $sum += $interval;
                }

                $jumlah = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->whereNotNUll('tahun_lulus')->where('user_id', Auth::user()->kode_ps)->count();

                if ($jumlah != 0) {
                    $avg = $sum / $jumlah;
                } else {
                    "Data Tidak Tersedia";
                }

                $years = ($avg / 365);
                $years = floor($years);

                $month = ($avg % 365) / 30.5;
                $month = floor($month);

                $days = ($avg % 365) % 30.5;

                $cellhari = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellhari->addText($years . ' Tahun , ' . $month . ' Bulan ', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
        } else {
            foreach ($years as $key => $year) {
                $table_efektivitas3->addRow(2000);

                $cellTahun = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

                $cellJumlah = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlah->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $i = 0;
                $yearlulus = $this->getYears(4);
                $data = array();
                $nb = 0;

                foreach ($yearlulus as $keys => $tahunlulus) {
                    $cellTS = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                    $cellTS->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                }

                $cellJumlahLulusan = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlahLulusan->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $cellhari = $table_efektivitas3->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellhari->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Doktor/Doktor Terapan
        $isi2 = $file->addSection();
        $isi2->addText('Diisi oleh pengusul dari Program Studi pada Program Doktor/Doktor Terapan ',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();

        $table_efektivitas4 = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_efektivitas4->addRow(1000);

        $header_tahun = $table_efektivitas4->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Masuk', $fontStyle2);

        $header_diterima = $table_efektivitas4->addCell(null, $cellRowSpan);
        $diterima = $header_diterima->addTextRun($cellHCentered);
        $diterima->addText('Jumlah Mahasiswa Diterima', $fontStyle2);

        $header_lulus = $table_efektivitas4->addCell(null, $cellColSpan4);
        $lulus = $header_lulus->addTextRun($cellHCentered);
        $lulus->addText('Jumlah Mahasiswa yang Lulus pada', $fontStyle2);

        $header_jumlah = $table_efektivitas4->addCell(null, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah Lulusan s.d. Akhir TS', $fontStyle2);

        $header_rata = $table_efektivitas4->addCell(null, $cellRowSpan);
        $rata = $header_rata->addTextRun($cellHCentered);
        $rata->addText('Rata-rata Masa Studi', $fontStyle2);

        $table_efektivitas4->addRow();
        $table_efektivitas4->addCell(null, $cellRowContinue);
        $table_efektivitas4->addCell(null, $cellRowContinue);
        $table_efektivitas4->addCell(null, $cellRowContinue);
        $table_efektivitas4->addCell(null, $cellRowContinue);
        $table_efektivitas4->addCell(null, $cellRowContinue);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-3', $fontStyle2, $cellHCentered);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-2', $fontStyle2, $cellHCentered);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS-1', $fontStyle2, $cellHCentered);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Akhir TS', $fontStyle2, $cellHCentered);

        $table_efektivitas4->addRow();
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_efektivitas4->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(6);
        $data = array();
        $nb = 0;

        if (Auth::user()->tingkat == '3') {
            foreach ($years as $key => $year) {
                $i++;

                $table_efektivitas4->addRow(2000);

                $cellTahun = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

                $mahasiswas3[0] = DB::table('biodata_mhs')->whereYear('tahun_masuk', $year)->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswas3[1] = DB::table('alumni')->whereYear('tahun_masuk', $year)->where('user_id', Auth::user()->kode_ps)->count();
                $mahasiswas3['total'] = $mahasiswas3[0] + $mahasiswas3[1];

                $cellJumlah = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlah->addText($mahasiswas3['total'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $i = 0;
                $yearlulus = $this->getYears(4);
                $data = array();
                $nb = 0;

                foreach ($yearlulus as $keys => $tahunlulus) {
                    $mahasiswalulus = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->count();
                    $nb += $mahasiswalulus;
                    $cellTS = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                    $cellTS->addText($mahasiswalulus, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                }

                $jumlahlulus1 = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->count();
                $nb += $jumlahlulus1;
                $cellJumlahLulusan = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlahLulusan->addText($jumlahlulus1, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $datetime3 = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->get();
                $avg = 0;
                $sum = 0;

                foreach ($datetime3 as $key => $data) {

                    $coba1 = json_decode(json_encode($data), true);

                    $date1 = new \DateTime($coba1['tahun_masuk']);
                    $date2 = new \DateTime($coba1['tahun_lulus']);

                    $diff  = $date1->diff($date2);
                    $interval =  $diff->format("%a");

                    $sum += $interval;
                }

                $jumlah = DB::table('alumni')->whereYEAR('tahun_masuk', $year)->whereYEAR('tahun_lulus', $tahunlulus)->where('user_id', Auth::user()->kode_ps)->count();

                if ($jumlah != 0) {
                    $avg = $sum / $jumlah;
                } else {
                    "Data Tidak Tersedia";
                }

                $years = ($avg / 365);
                $years = floor($years);

                $month = ($avg % 365) / 30.5;
                $month = floor($month);

                $days = ($avg % 365) % 30.5;

                $cellhari = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellhari->addText($years . ' Tahun , ' . $month . ' Bulan', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
        } else {
            foreach ($years as $key => $year) {
                $table_efektivitas4->addRow(2000);

                $cellTahun = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

                $cellJumlah = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlah->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $i = 0;
                $yearlulus = $this->getYears(4);
                $data = array();
                $nb = 0;

                foreach ($yearlulus as $keys => $tahunlulus) {
                    $cellTS = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                    $cellTS->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
                }

                $cellJumlahLulusan = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellJumlahLulusan->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

                $cellhari = $table_efektivitas4->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellhari->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Daya Saing Lulusan
        $judul2 = $file->addSection();
        $judul2->addText('g. Daya Saing Lulusan',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.d berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan data masa tunggu lulusan untuk mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 sampai dengan TS-2, dengan mengikuti format Tabel 9.d berikut ini. Data diambil dari hasil studi penelusuran lulusan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.d Waktu Tunggu Lulusan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $isi2 = $file->addSection();
        $isi2->addText('Diisi oleh pengusul dari Program Studi pada Program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table = $file->addSection();
        $table_id_waktu_tunggu = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_id_waktu_tunggu->addRow(1000);

        $header_tahun = $table_id_waktu_tunggu->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Lulus', $fontStyle2);

        $header_lulusan = $table_id_waktu_tunggu->addCell(null, $cellRowSpan);
        $lulusan = $header_lulusan->addTextRun($cellHCentered);
        $lulusan->addText('Jumlah lulusan', $fontStyle2);

        $header_terlacak = $table_id_waktu_tunggu->addCell(null, $cellRowSpan);
        $terlacak = $header_terlacak->addTextRun($cellHCentered);
        $terlacak->addText('Jumlah lulusan yang Terlacak', $fontStyle2);

        $header_dipesan = $table_id_waktu_tunggu->addCell(null, $cellRowSpan);
        $dipesan = $header_dipesan->addTextRun($cellHCentered);
        $dipesan->addText('Jumlah lulusan yang dipesan sebelum lulus', $fontStyle2);

        $header_pekerjaan = $table_id_waktu_tunggu->addCell(null, $cellColSpan);
        $pekerjaan = $header_pekerjaan->addTextRun($cellHCentered);
        $pekerjaan->addText('Jumlah lulusan dengan waktu tunggu mendapatkan pekerjaan', $fontStyle2);

        $table_id_waktu_tunggu->addRow();
        $table_id_waktu_tunggu->addCell(null, $cellRowContinue);
        $table_id_waktu_tunggu->addCell(null, $cellRowContinue);
        $table_id_waktu_tunggu->addCell(null, $cellRowContinue);
        $table_id_waktu_tunggu->addCell(null, $cellRowContinue);
        $table_id_waktu_tunggu->addCell(null, $cellRowContinue);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('WT < 6 bulan', $fontStyle2, $cellHCentered);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6 < WT < 18 bulan', $fontStyle2, $cellHCentered);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('WT > 18 bulan', $fontStyle2, $cellHCentered);

        $table_id_waktu_tunggu->addRow();
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_waktu_tunggu->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(6);
        $data = array();
        $nb = 0;

        foreach ($years as $key => $year) {
            $i++;

            $table_id_waktu_tunggu->addRow(2000);

            $cellTahun = $table_id_waktu_tunggu->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $alumni = DB::table('alumni')->where('tahun_lulus', $year)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $alumni;
            $cellJumlah = $table_id_waktu_tunggu->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($alumni, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $terlacak = DB::table('alumni')->where('tahun_lulus', $year)->where('id_jenis_pekerjaan', '!=', 6)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $terlacak;
            $cellTerlacak = $table_id_waktu_tunggu->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTerlacak->addText($terlacak, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $mulai = DB::table('alumni')->where('tahun_lulus', $year)->where('id_mulai_kerja', '=', 1)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $mulai;
            $cellDipesan = $table_id_waktu_tunggu->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellDipesan->addText($mulai, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $wt1 = DB::table('alumni')->where('tahun_lulus', $year)->where('id_waktu_tunggu', '=', 1)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $wt1;
            $cellJumlah1 = $table_id_waktu_tunggu->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah1->addText($wt1, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $wt2 = DB::table('alumni')->where('tahun_lulus', $year)->where('id_waktu_tunggu', '=', 2)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $wt2;
            $cellJumlah2 = $table_id_waktu_tunggu->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah2->addText($wt2, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $wt3 = DB::table('alumni')->where('tahun_lulus', $year)->where('id_waktu_tunggu', '=', 3)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $wt3;
            $cellJumlah3 = $table_id_waktu_tunggu->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah3->addText($wt3, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $date = Carbon::now()->year;

        $jumlah_lulusan = DB::table('alumni')->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_terlacak = DB::table('alumni')->where('id_jenis_pekerjaan', '!=', 6)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_mulai = DB::table('alumni')->where('id_mulai_kerja', '=', 1)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_wt1 = DB::table('alumni')->where('id_waktu_tunggu', '=', 1)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_wt2 = DB::table('alumni')->where('id_waktu_tunggu', '=', 2)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_wt3 = DB::table('alumni')->where('id_waktu_tunggu', '=', 3)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');

        $table_id_waktu_tunggu->addRow();
        $table_id_waktu_tunggu->addCell(null)->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_id_waktu_tunggu->addCell(null)->addText($jumlah_lulusan, $fontStyle2, $cellHCentered);
        $table_id_waktu_tunggu->addCell(null)->addText($jumlah_terlacak, $fontStyle2, $cellHCentered);
        $table_id_waktu_tunggu->addCell(null)->addText($jumlah_mulai, $fontStyle2, $cellHCentered);
        $table_id_waktu_tunggu->addCell(null)->addText($jumlah_wt1, $fontStyle2, $cellHCentered);
        $table_id_waktu_tunggu->addCell(null)->addText($jumlah_wt2, $fontStyle2, $cellHCentered);
        $table_id_waktu_tunggu->addCell(null)->addText($jumlah_wt3, $fontStyle2, $cellHCentered);

        $isi2 = $file->addSection();
        $isi2->addText('Keterangan:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        $isi2->addText('WT = Waktu Tunggu Lulusan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Kinerja Lulusan
        $judul2 = $file->addSection();
        $judul2->addText('h. Kinerja Lulusan',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.e.1 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/ Sarjana/ Sarjana Terapan/ Magister/ Magister Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan tingkat/ukuran tempat kerja/berwirausaha atau studi lanjut lulusan dalam 3 tahun, mulai TS-4 sampai dengan TS-2, dengan mengikuti format Tabel 9.e.1 berikut ini. Data diambil dari hasil studi penelusuran lulusan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.e.1 Tempat Kerja atau Studi Lanjut Lulusan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table = $file->addSection();
        $table_kinerja = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kinerja->addRow(1000);

        $header_tahun = $table_kinerja->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Lulus', $fontStyle2);

        $header_lulusan = $table_kinerja->addCell(null, $cellRowSpan);
        $lulusan = $header_lulusan->addTextRun($cellHCentered);
        $lulusan->addText('Jumlah lulusan', $fontStyle2);

        $header_terlacak = $table_kinerja->addCell(null, $cellRowSpan);
        $terlacak = $header_terlacak->addTextRun($cellHCentered);
        $terlacak->addText('Jumlah lulusan yang Terlacak', $fontStyle2);

        $header_kolom_jumlah = $table_kinerja->addCell(null, $cellColSpan4);
        $kolom = $header_kolom_jumlah->addTextRun($cellHCentered);
        $kolom->addText('Jumlah Lulusan Terlacak yang Bekerja Berdasarkan Tingkat/Ukuran Tempat Kerja/Berwirausaha/Melanjutkan Studi', $fontStyle2);

        $table_kinerja->addRow();
        $table_kinerja->addCell(null, $cellRowContinue);
        $table_kinerja->addCell(null, $cellRowContinue);
        $table_kinerja->addCell(null, $cellRowContinue);
        $table_kinerja->addCell(null, $cellRowContinue);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Lokal/ Wilayah/ Berwirausaha tidak Berbadan Hukum', $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Nasional/ Berwirausaha Berbadan Hukum', $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Multi­nasional/ Inter­nasional', $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Melanjutkan Studi', $fontStyle2, $cellHCentered);

        $table_kinerja->addRow();
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kinerja->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(6);
        $data = array();
        $nb = 0;

        foreach ($years as $key => $year) {
            $i++;

            $table_kinerja->addRow(2000);

            $cellTahun = $table_kinerja->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $alumni = DB::table('alumni')->where('tahun_lulus', $year)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $alumni;
            $cellJumlah = $table_kinerja->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($alumni, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $terlacak = DB::table('alumni')->where('tahun_lulus', $year)->where('id_jenis_pekerjaan', '!=', 6)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $terlacak;
            $cellTerlacak = $table_kinerja->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTerlacak->addText($terlacak, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $lokal = DB::table('alumni')->where('tahun_lulus', $year)->where('id_jenis_pekerjaan', '=', 1)->where('user_id', Auth::user()->kode_ps)->count();
            $cellLokal = $table_kinerja->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLokal->addText($lokal, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $nasional = DB::table('alumni')->where('tahun_lulus', $year)->where('id_jenis_pekerjaan', '=', 2)->where('user_id', Auth::user()->kode_ps)->count();
            $cellNasional = $table_kinerja->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNasional->addText($nasional, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $multi = DB::table('alumni')->where('tahun_lulus', $year)->where('id_jenis_pekerjaan', '=', 3)->where('user_id', Auth::user()->kode_ps)->count();
            $cellMulti = $table_kinerja->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellMulti->addText($multi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $studi = DB::table('alumni')->where('tahun_lulus', $year)->where('id_jenis_pekerjaan', '=', 4)->where('user_id', Auth::user()->kode_ps)->count();
            $cellStudi = $table_kinerja->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellStudi->addText($studi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $date = Carbon::now()->year;

        $jumlah_lulusan = DB::table('alumni')->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_terlacak = DB::table('alumni')->where('id_jenis_pekerjaan', '!=', 6)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_lokal = DB::table('alumni')->where('id_jenis_pekerjaan', '=', 1)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_nasional = DB::table('alumni')->where('id_jenis_pekerjaan', '=', 2)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_multi = DB::table('alumni')->where('id_jenis_pekerjaan', '=', 3)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_studi = DB::table('alumni')->where('id_jenis_pekerjaan', '=', 4)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');

        $table_kinerja->addRow();
        $table_kinerja->addCell(null, array('gridSpan' => '1'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null)->addText($jumlah_lulusan, $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null)->addText($jumlah_terlacak, $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null)->addText($jumlah_lokal, $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null)->addText($jumlah_nasional, $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null)->addText($jumlah_multi, $fontStyle2, $cellHCentered);
        $table_kinerja->addCell(null)->addText($jumlah_studi, $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $isi = $file->addSection();
        $isi->addText('Tabel 9.e.2 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan id_pendapatan atau penghasilan rata-rata per bulan pada tahun pertama lulusan yang bekerja atau berwirausaha dengan mengikuti format Tabel 9.e.2 berikut ini. Data diambil dari hasil studi penelusuran lulusan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.e.2 id_pendapatan atau Penghasilan rata-rata per bulan pada Tahun Pertama Lulusan yang Bekerja atau Berwirausaha',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table = $file->addSection();
        $table_id_pendapatan = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_id_pendapatan->addRow(1000);

        $header_tahun = $table_id_pendapatan->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Lulus', $fontStyle2);

        $header_lulusan = $table_id_pendapatan->addCell(null, $cellRowSpan);
        $lulusan = $header_lulusan->addTextRun($cellHCentered);
        $lulusan->addText('Jumlah lulusan', $fontStyle2);

        $header_terlacak = $table_id_pendapatan->addCell(null, $cellRowSpan);
        $terlacak = $header_terlacak->addTextRun($cellHCentered);
        $terlacak->addText('Jumlah lulusan yang Terlacak', $fontStyle2);

        $header_id_pendapatan = $table_id_pendapatan->addCell(null, $cellColSpan2);
        $id_pendapatan = $header_id_pendapatan->addTextRun($cellHCentered);
        $id_pendapatan->addText('id_pendapatan / penghasilan rata-rata per bulan pada tahun pertama lulusan yang bekerja atau berwirausaha', $fontStyle2);

        $table_id_pendapatan->addRow();
        $table_id_pendapatan->addCell(null, $cellRowContinue);
        $table_id_pendapatan->addCell(null, $cellRowContinue);
        $table_id_pendapatan->addCell(null, $cellRowContinue);
        $table_id_pendapatan->addCell(null, $cellRowContinue);
        $table_id_pendapatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Kurang dari UMR Setempat', $fontStyle2, $cellHCentered);
        $table_id_pendapatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('> UMR Setempat', $fontStyle2, $cellHCentered);

        $table_id_pendapatan->addRow();
        $table_id_pendapatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_pendapatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_pendapatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_pendapatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_id_pendapatan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(5);
        $data = array();
        $nb = 0;

        foreach ($years as $key => $year) {
            $i++;

            $table_id_pendapatan->addRow(2000);

            $cellTahun = $table_id_pendapatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $alumni = DB::table('alumni')->where('tahun_lulus', $year)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $alumni;
            $cellJumlah = $table_id_pendapatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText($alumni, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $terlacak = DB::table('alumni')->where('tahun_lulus', $year)->where('id_jenis_pekerjaan', '!=', 6)->where('user_id', Auth::user()->kode_ps)->count();
            $nb += $terlacak;
            $cellTerlacak = $table_id_pendapatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTerlacak->addText($terlacak, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $kurang = DB::table('alumni')->where('tahun_lulus', $year)->where('id_pendapatan', '=', 1)->where('user_id', Auth::user()->kode_ps)->count();
            $cellKurang = $table_id_pendapatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellKurang->addText($kurang, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $lebih = DB::table('alumni')->where('tahun_lulus', $year)->where('id_pendapatan', '=', 2)->where('user_id', Auth::user()->kode_ps)->count();
            $cellLebih = $table_id_pendapatan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellLebih->addText($lebih, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $date = Carbon::now()->year;

        $jumlah_lulusan = DB::table('alumni')->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_terlacak = DB::table('alumni')->where('id_jenis_pekerjaan', '!=', 6)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_kurang = DB::table('alumni')->where('id_pendapatan', '=', 1)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');
        $jumlah_lebih = DB::table('alumni')->where('id_pendapatan', '=', 2)->where('tahun_lulus', '>=', $years[0])->where('tahun_lulus', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count('id');

        $table_id_pendapatan->addRow();
        $table_id_pendapatan->addCell(null, array('gridSpan' => '1'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_id_pendapatan->addCell(null)->addText($jumlah_lulusan, $fontStyle2, $cellHCentered);
        $table_id_pendapatan->addCell(null)->addText($jumlah_terlacak, $fontStyle2, $cellHCentered);
        $table_id_pendapatan->addCell(null)->addText($jumlah_kurang, $fontStyle2, $cellHCentered);
        $table_id_pendapatan->addCell(null)->addText($jumlah_lebih, $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $isi = $file->addSection();
        $isi->addText('Tabel Referensi untuk Kelengkapan  Tabel 9.e.3 (File Excel LKPS Tabel Ref  9e3) diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan dengan mengikuti format berikut ini:',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel Ref 9e3 Tabel Referensi untuk  Kelengkapan Tabel 9.e.3 Kepuasan Pengguna Lulusan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table = $file->addSection();
        $table_referensi = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_referensi->addRow(1000);

        $header_tahun = $table_referensi->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun Lulus', $fontStyle2);

        $header_lulusan = $table_referensi->addCell(null, $cellRowSpan);
        $lulusan = $header_lulusan->addTextRun($cellHCentered);
        $lulusan->addText('Jumlah lulusan', $fontStyle2);

        $header_terlacak = $table_referensi->addCell(null, $cellRowSpan);
        $terlacak = $header_terlacak->addTextRun($cellHCentered);
        $terlacak->addText('Jumlah lulusan yang Terlacak', $fontStyle2);

        $table_referensi->addRow();
        $table_referensi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_referensi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_referensi->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $i = 0;
        $years = $this->getYears(4);
        $data = array();
        $nb = 0;

        foreach ($years as $key => $year) {
            $i++;

            $table_referensi->addRow(2000);

            $cellTahun = $table_referensi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText(htmlspecialchars("TS-{$year}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            // $alumni = DB::table('alumni')->where('tahun_lulus', $year)->where('user_id', Auth::user()->kode_ps)->count();
            // $nb += $alumni;
            $cellJumlah = $table_referensi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJumlah->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            // $terlacak = DB::table('alumni')->where('tahun_lulus', $year)->where('jenis_pekerjaan', '!=', 6)->where('user_id', Auth::user()->kode_ps)->count();
            // $nb += $terlacak;
            $cellTerlacak = $table_referensi->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTerlacak->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $table_referensi->addRow();
        $table_referensi->addCell(null)->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_referensi->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_referensi->addCell(null)->addText('', $fontStyle2, $cellHCentered);

        //Kepuasan pengguna
        $isi = $file->addSection();
        $isi->addText('Tabel 9.e.3 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan hasil pengukuran kepuasan pengguna lulusan berdasarkan aspek-aspek: 1) etika, 2) keahlian pada bidang ilmu (kompetensi utama), 3) kemampuan berbahasa asing, 4) penggunaan teknologi informasi, 5) kemampuan berkomunikasi, 6) kerja sama dan 7) pengembangan diri, dengan mengikuti format Tabel 9.e.3 berikut ini. Data diambil dari hasil studi penelusuran lulusan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table = $file->addSection();
        $table->addText('Tabel 9.e.3 Kepuasan Pengguna Lulusan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_kepuasan = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_kepuasan->addRow(1000);

        $header_no = $table_kepuasan->addCell(null, $cellRowSpan);
        $no = $header_no->addTextRun($cellHCentered);
        $no->addText('No', $fontStyle2);

        $header_jenis = $table_kepuasan->addCell(null, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis Kemampuan', $fontStyle2);

        $header_tingkat = $table_kepuasan->addCell(null, $cellColSpan4);
        $tingkat = $header_tingkat->addTextRun($cellHCentered);
        $tingkat->addText('Tingkat', $fontStyle2);

        $header_rencana = $table_kepuasan->addCell(null, $cellRowSpan);
        $rencana = $header_rencana->addTextRun($cellHCentered);
        $rencana->addText('Tahun Perolehan', $fontStyle2);

        $table_kepuasan->addRow();
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, $cellRowContinue);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Sangat Baik', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Baik', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Cukup', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Kurang', $fontStyle2, $cellHCentered);

        $table_kepuasan->addRow();
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_kepuasan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('1', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $cellJenis = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellJenis->addText('Etika', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSb = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSb->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('2', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $cellJenis = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellJenis->addText('Keahlian pada bidang ilmu (kompetensi utama)', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSb = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSb->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('3', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $cellJenis = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellJenis->addText('Kemampuan berbahasa asing', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSb = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSb->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('4', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $cellJenis = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellJenis->addText('Penggunaan teknologi informasi', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSb = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSb->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('5', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $cellJenis = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellJenis->addText('Kemampuan berkomunikasi', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSb = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSb->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('6', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $cellJenis = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellJenis->addText('Kerja sama tim', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSb = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSb->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table_kepuasan->addRow(2000);
        $cellNo = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellNo->addText('7', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $cellJenis = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellJenis->addText('Pengembangan diri', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellSb = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellSb->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellBaik = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellBaik->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellCukup = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellCukup->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellKurang = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellKurang->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $cellRencana = $table_kepuasan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        $cellRencana->addText('', ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $table_kepuasan->addRow();
        $table_kepuasan->addCell(null, array('gridSpan' => '2'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);
        $table_kepuasan->addCell(null)->addText('', $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        //Luaran Penelitian dan Pengabdian kepda masyarakat
        $judul2 = $file->addSection();
        $judul2->addText('i. Luaran Penelitian dan Pengabdian kepada Masyarakat Mahasiswa',  $fontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.f.1 berikut ini diisi oleh pengusul dari Program Studi pada program Diploma Tiga/Sarjana/Sarjana Terapan/Magister/Magister Terapan/Doktor/Doktor Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan jumlah presentasi/publikasi ilmiah mahasiswa yang dihasilkan secara mandiri atau bersama DTPS, mulai TS-2 dengan mengikuti format Tabel 9.f.1 berikut. Tema publikasi harus relevan dengan bidang program studi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.f.1	Publikasi Ilmiah oleh Mahasiswa',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table = $file->addSection();
        $table_publikasi_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_publikasi_mhs->addRow(1000);

        $isi = $file->addSection();
        $isi->addText('Diisi oleh pengusul dari Program Studi pada Program Sarjana/Magister/Doktor',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $header_nomor = $table_publikasi_mhs->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_jenis = $table_publikasi_mhs->addCell(null, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Lembaga Mitra', $fontStyle2);

        $header_judul = $table_publikasi_mhs->addCell(null, $cellColSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Jumlah Judul', $fontStyle2);

        $header_jumlah = $table_publikasi_mhs->addCell(null, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah', $fontStyle2);

        $table_publikasi_mhs->addRow();

        $table_publikasi_mhs->addCell(null, $cellRowContinue);
        $table_publikasi_mhs->addCell(null, $cellRowContinue);
        $table_publikasi_mhs->addCell(null, $cellRowContinue);
        $table_publikasi_mhs->addCell(null, $cellRowContinue);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-2', $fontStyle2, $cellHCentered);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-1', $fontStyle2, $cellHCentered);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS', $fontStyle2, $cellHCentered);

        $table_publikasi_mhs->addRow();
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_publikasi_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $jenis_publikasi_mhs = DB::table('jenis_publikasi')->get();
        $i = 0;

        $years = $this->getYears(3);
        $date = Carbon::now()->year;
        $data = array();
        $nb = 0;

        foreach ($jenis_publikasi_mhs as $key) {
            $i++;

            $table_publikasi_mhs->addRow(2000);
            $cellNo = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJenis = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJenis->addText($key->jenis_publikasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            foreach ($years as $keys => $year) {
                $artikel_mhs = PublikasiMhs::with('jenis_publikasi')->where('jenis_publikasi', $key->id)->where('tahun', $year)->where('user_id', Auth::user()->kode_ps)->count();

                $cellTS1 = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
                $cellTS1->addText($artikel_mhs, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            }

            $countjudul = DB::table('artikel_mhs')->where('jenis_publikasi', $key->id)->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count();
            $cellJudul = $table_publikasi_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($countjudul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $space6 = $file->addSection();
        $space6->addTextBreak();

        // $table = $file->addSection();
        // $table_publikasi_terapan = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        // $table_publikasi_terapan->addRow(1000);

        // $isi = $file->addSection();
        // $isi->addText('Diisi oleh pengusul dari Program Studi pada Program Diploma Tiga/Sarjana Terapan/Magister Terapan/Doktor Terapan',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        // $header_nomor = $table_publikasi_terapan->addCell(null, $cellRowSpan);
        // $nomor = $header_nomor->addTextRun($cellHCentered);
        // $nomor->addText('No', $fontStyle2);

        // $header_jenis = $table_publikasi_terapan->addCell(null, $cellRowSpan);
        // $jenis = $header_jenis->addTextRun($cellHCentered);
        // $jenis->addText('Lembaga Mitra', $fontStyle2);

        // $header_judul = $table_publikasi_terapan->addCell(null, $cellColSpan);
        // $judul = $header_judul->addTextRun($cellHCentered);
        // $judul->addText('Jumlah Judul', $fontStyle2);

        // $header_jumlah = $table_publikasi_terapan->addCell(null, $cellRowSpan);
        // $jumlah = $header_jumlah->addTextRun($cellHCentered);
        // $jumlah->addText('Jumlah', $fontStyle2);

        // $table_publikasi_terapan->addRow();

        // $table_publikasi_terapan->addCell(null, $cellRowContinue);
        // $table_publikasi_terapan->addCell(null, $cellRowContinue);
        // $table_publikasi_terapan->addCell(null, $cellRowContinue);
        // $table_publikasi_terapan->addCell(null, $cellRowContinue);
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-2', $fontStyle2, $cellHCentered);
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS-1', $fontStyle2, $cellHCentered);
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('TS', $fontStyle2, $cellHCentered);

        // $table_publikasi_terapan->addRow();
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        // $table_publikasi_terapan->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // $jenis_publikasi_terapan = DB::table('jenis_publikasi_terapan')->get();
        // $i = 0;

        // $years = $this->getYears(3);
        // $date = Carbon::now()->year;
        // $data = array();
        // $nb = 0;

        // foreach ($jenis_publikasi_terapan as $key) {
        //     $i++;

        //     $table_publikasi_terapan->addRow(2000);
        //     $cellNo = $table_publikasi_terapan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        //     $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //     $cellJenis = $table_publikasi_terapan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        //     $cellJenis->addText($key->jenis_publikasi, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        //     foreach ($years as $keys => $year) {
        //         $artikel_mhs_terapan = PublikasiMhsTerapan::with('jenis_publikasi_terapan')->where('jenis_publikasi', $key->id)->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('tahun', $year)->where('user_id', Auth::user()->kode_ps)->count();

        //         $cellTS1 = $table_publikasi_terapan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        //         $cellTS1->addText($artikel_mhs_terapan, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        //     }

        //     $countjudul = DB::table('artikel_mhs_terapan')->where('jenis_publikasi', $key->id)->where('tahun', '>=', $years[0])->where('tahun', '<=', $date)->where('user_id', Auth::user()->kode_ps)->count();
        //     $cellJudul = $table_publikasi_terapan->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
        //     $cellJudul->addText($countjudul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        // }

        //karya ilmiah disitasi
        $isi = $file->addSection();
        $isi->addText('Tabel 9.f.2 berikut ini diisi oleh pengusul dari Program Studi pada program Magister/ Magister Terapan/Doktor/Doktor Terapan.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tuliskan judul artikel karya ilmiah mahasiswa, yang dihasilkan secara mandiri atau bersama DTPS, yang disitasi dalam 3 tahun terakhir dengan mengikuti format   Tabel 9.f.2 berikut ini. Judul artikel yang disitasi harus relevan dengan bidang program studi.',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

        $isi = $file->addSection();
        $isi->addText('Tabel 9.f.2	Karya Ilmiah Mahasiswa yang Disitasi',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table = $file->addSection();
        $table_karya_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_karya_mhs->addRow(1000);

        $header_nomor = $table_karya_mhs->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_jenis = $table_karya_mhs->addCell(null, $cellRowSpan);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Nama Mahasiswa', $fontStyle2);

        $header_judul = $table_karya_mhs->addCell(null, $cellRowSpan);
        $judul = $header_judul->addTextRun($cellHCentered);
        $judul->addText('Judul Artikel yang Disitasi (Jurnal/Buku, Volume, Tahun, Nomor, Halaman)', $fontStyle2);

        $header_jumlah = $table_karya_mhs->addCell(null, $cellRowSpan);
        $jumlah = $header_jumlah->addTextRun($cellHCentered);
        $jumlah->addText('Jumlah Sitasi', $fontStyle2);

        $table_karya_mhs->addRow();
        $table_karya_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_karya_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_karya_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_karya_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // $artikel_mhs = DB::table('artikel_mhs')->where('user_id', Auth::user()->kode_ps)->get();
        $artikel_mhs = PublikasiMhs::with('biodata_mhs')->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;

        foreach ($artikel_mhs as $key) {
            $i++;

            $table_karya_mhs->addRow(2000);
            $cellNo = $table_karya_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

            $cellNama = $table_karya_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($key->biodata_mhs['nama'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellJudul = $table_karya_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellJudul->addText($key->judul, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellSitasi = $table_karya_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellSitasi->addText($key->jumlah, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        $jumlahjudul = DB::table('artikel_mhs')->where('user_id', Auth::user()->kode_ps)->count();
        $jumlahsitasi = DB::table('artikel_mhs')->where('user_id', Auth::user()->kode_ps)->sum('jumlah');

        $table_karya_mhs->addRow();
        $table_karya_mhs->addCell(null, array('gridSpan' => '2'))->addText('Jumlah', $fontStyle2, $cellHCentered);
        $table_karya_mhs->addCell(null)->addText($jumlahjudul, $fontStyle2, $cellHCentered);
        $table_karya_mhs->addCell(null)->addText($jumlahsitasi, $fontStyle2, $cellHCentered);

        $space6 = $file->addSection();
        $space6->addTextBreak();

        $table = $file->addSection();
        $table->addText('Tabel 9.f.3	Luaran Penelitian atau Pengabdian kepada Masyarakat oleh Mahasiswa selain Publikasi Ilmiah',  $fontStyle1, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $table_pkm_mhs = $table->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 'cellMarginBottom' => 0, 'cellMarginLeft' => 0));
        $table_pkm_mhs->addRow(1000);

        $header_nomor = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $nomor = $header_nomor->addTextRun($cellHCentered);
        $nomor->addText('No', $fontStyle2);

        $header_nama = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $nama = $header_nama->addTextRun($cellHCentered);
        $nama->addText('Nama Luaran Penelitian dan Pengabdian kepada Masyarakat', $fontStyle2);

        $header_tahun = $table_pkm_mhs->addCell(null, $cellRowSpan);
        $tahun = $header_tahun->addTextRun($cellHCentered);
        $tahun->addText('Tahun (YYYY)', $fontStyle2);

        $header_jenis = $table_pkm_mhs->addCell(null, $cellColSpan6);
        $jenis = $header_jenis->addTextRun($cellHCentered);
        $jenis->addText('Jenis Luaran Selain Publikasi Ilmiah', $fontStyle2);

        $table_pkm_mhs->addRow();

        $table_pkm_mhs->addCell(null, $cellRowContinue);
        $table_pkm_mhs->addCell(null, $cellRowContinue);
        $table_pkm_mhs->addCell(null, $cellRowContinue);
        $table_pkm_mhs->addCell(null, $cellRowContinue);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Paten / Paten Sederhana', $fontStyle2, $cellHCentered);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('HKI ', $fontStyle2, $cellHCentered);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Teknologi Tepat Guna, Produk Terstandarisasi, Produk Tersertifikasi', $fontStyle2, $cellHCentered);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Produk  yang diadopsi Industri/Masyarakat', $fontStyle2, $cellHCentered);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Buku ber-ISBN, Book Chapter', $fontStyle2, $cellHCentered);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('Keterangan / Bukti Fisik / link', $fontStyle2, $cellHCentered);

        $table_pkm_mhs->addRow();
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('1', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('2', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('3', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('4', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('5', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('6', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('7', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('8', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $table_pkm_mhs->addCell(null, ['bgColor' => 'D3D3D3'])->addText('9', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        $data_pkm_mhs = DataPkm::where('jenis_pkm', 1)->where('user_id', Auth::user()->kode_ps)->get();

        $i = 0;
        foreach ($data_pkm_mhs as $value) {
            $i++;

            $table_pkm_mhs->addRow(2000);
            $cellNo = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNo->addText(htmlspecialchars("{$i}"), ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellNama = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellNama->addText($value->judul_pkm, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellTahun = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTahun->addText($value->tahun, ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $paten = Paten::where('pkm_id', $value->id)->where('paten.user_id', Auth::user()->kode_ps)->first();
            $cellPaten = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellPaten->addText($paten['karya'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $cellHki = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellHki->addText($paten['no_hki'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $produk_lain = Lainnya::with('jenis_produk')->where('pkm_id', $value->id)->where('jenis', 1)->where('produk_lain.user_id', Auth::user()->kode_ps)->first();
            $cellTeknologi = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellTeknologi->addText($produk_lain['nama'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $produk = Produk::where('pkm_id', $value->id)->where('produk.user_id', Auth::user()->kode_ps)->first();
            $cellProdukSertifikasi = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellProdukSertifikasi->addText($produk['nama_produk'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            $produk_lain = Lainnya::with('jenis_produk')->where('pkm_id', $value->id)->where('jenis', 2)->where('produk_lain.user_id', Auth::user()->kode_ps)->first();
            $cellBuku = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBuku->addText($produk_lain['nama'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);

            // // dd($produk_lain);
            $cellBukti = $table_pkm_mhs->addCell(null, array('valign' => 'top', 'borderSize' => 5, 'borderColor' => 'ff0000'));
            $cellBukti->addText($produk_lain['link'], ['bold' => false], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
        }

        return $file;
    }


    public function word()
    {
        $file = $this->generate();
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($file, 'HTML');
        $objWriter->save('report/borang_akreditasi.docx');

        return response()->download('report/borang_akreditasi.docx');
    }

    public function pdf()
    {
        $file = $this->generate();
        $domPdfPath = realpath(base_path('vendor/dompdf/dompdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($file, 'PDF');
        $objWriter->save('report/borang_akreditasi.pdf');

        return response()->file('report/borang_akreditasi.pdf');
    }
}
