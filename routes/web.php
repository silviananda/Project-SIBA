<?php

use App\Http\Controllers\admin\VisiMisiController;
use App\Models\Admin\Dashboard;
use Illuminate\Support\Facades\Route;


// login
Route::get('/', function () {
    return view('auth/login');
})->name('login');

Route::post('postlogin', 'Auth\LoginController@postlogin')->name('postlogin');

//logout
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


Route::get('view-data', 'AuthorizationController@viewData');
Route::get('create-data', 'AuthorizationController@createData');
Route::get('edit-data', 'AuthorizationController@editData');
Route::get('update-data', 'AuthorizationController@updateData');
Route::get('delete-data', 'AuthorizationController@deleteData');

Route::get('/pesan', 'FlashMessageController@index');
Route::get('/get-pesan', 'FlashMessageController@pesan');

Route::get('/read-notification/{id}/{guard}', 'NotificationController@read')->name('readnotif');
Route::get('/read-deadline/{id}/{guard}', 'NotificationController@deadline')->name('readdeadline');


//SUPER ADMIN
Route::group(['middleware' => ['auth:super_admin']], function () {
    Route::prefix('/data-admin')->name('data-admin.')->group(function () {
        Route::get('/', 'super_admin\AdminController@index');
        Route::get('/create', 'super_admin\AdminController@create')->name('create');
        Route::post('/store', 'super_admin\AdminController@store')->name('store');
        Route::get('/{id_adm}/edit', 'super_admin\AdminController@edit')->name('edit');
        Route::patch('/update/{id_adm}', 'super_admin\AdminController@update')->name('update');
        Route::delete('/delete/{id_adm}', 'super_admin\AdminController@destroy')->name('delete');
    });

    Route::prefix('data-dosen')->name('data-dosen.')->group(function () {
        Route::get('/', 'super_admin\DosenController@index');
        Route::get('/create', 'super_admin\DosenController@create')->name('create');
        Route::post('/store', 'super_admin\DosenController@store')->name('store');
        Route::get('/{dosen_id}/edit', 'super_admin\DosenController@edit')->name('edit');
        Route::patch('/update/{dosen_id}', 'super_admin\DosenController@update')->name('update');
        Route::delete('/delete/{dosen_id}', 'super_admin\DosenController@destroy')->name('delete');
    });

    Route::prefix('data-himpunan')->name('data-himpunan.')->group(function () {
        Route::get('/', 'super_admin\HimpunanController@index');
        Route::get('/create', 'super_admin\HimpunanController@create')->name('create');
        Route::post('/store', 'super_admin\HimpunanController@store')->name('store');
        Route::get('/{id}/edit', 'super_admin\HimpunanController@edit')->name('edit');
        Route::patch('/update/{id}', 'super_admin\HimpunanController@update')->name('update');
        Route::delete('/delete/{id}', 'super_admin\HimpunanController@destroy')->name('delete');
    });
});

//ADMIN
Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/dashboard', 'admin\DashboardController@index');

    Route::get('/export-to-word', 'admin\ExportController@word');
    Route::get('/export-to-pdf', 'admin\ExportController@pdf');

    Route::get('/export-kerjasama', 'admin\ExportFileController@pdf_kerjasama');

    Route::get('/export-mhs-reg', 'admin\ExportFileController@pdf_mhs');
    Route::get('/export-mhs-non', 'admin\ExportFileController@pdf_mhs_non');
    Route::get('/export-pendaftar', 'admin\ExportFileController@pdf_pendaftar');
    Route::get('/export-lulus', 'admin\ExportFileController@pdf_lulus');
    Route::get('/export-tampung', 'admin\ExportFileController@pdf_daya_tampung');

    Route::get('/export-mhs-asing', 'admin\ExportFileController@pdf_mhs_asing');

    Route::get('/export-dosen', 'admin\ExportFileController@pdf_dosen');
    Route::get('/export-aktivitas', 'admin\ExportFileController@pdf_aktivitas');
    Route::get('/export-pengajaran', 'admin\ExportFileController@pdf_pengajaran');


    Route::get('/export-rekognisi', 'admin\ExportFileController@pdf_rekognisi');
    Route::get('/export-prestasi', 'admin\ExportFileController@pdf_prestasi');

    Route::get('/export-kependidikan', 'admin\ExportFileController@pdf_kependidikan');

    Route::get('/export-perolehan-dana', 'admin\ExportFileController@pdf_perolehan_dana');
    Route::get('/export-penggunaan-dana', 'admin\ExportFileController@pdf_penggunaan_dana');
    Route::get('/export-dana-penelitian', 'admin\ExportFileController@pdf_dana_penelitian');
    Route::get('/export-dana-pkm', 'admin\ExportFileController@pdf_dana_pkm');

    Route::get('/export-ruang', 'admin\ExportFileController@pdf_ruang');
    Route::get('/export-prasarana', 'admin\ExportFileController@pdf_prasarana');

    Route::get('/export-pustaka', 'admin\ExportFileController@pdf_pustaka');
    Route::get('/export-data-lab', 'admin\ExportFileController@pdf_lab');

    Route::get('/export-kurikulum', 'admin\ExportFileController@pdf_kurikulum');
    Route::get('/export-mk-pilihan', 'admin\ExportFileController@pdf_mk_pilihan');
    Route::get('/export-praktikum', 'admin\ExportFileController@pdf_praktikum');

    Route::get('/export-akademik', 'admin\ExportFileController@pdf_akademik');
    Route::get('/export-tugas-akhir', 'admin\ExportFileController@pdf_tugas_akhir');

    Route::get('/export-kegiatan', 'admin\ExportFileController@pdf_kegiatan');

    Route::get('/export-penelitian-dosen', 'admin\ExportFileController@pdf_penelitian_dosen');
    Route::get('/export-penelitian-mhs', 'admin\ExportFileController@pdf_penelitian_mhs');

    Route::get('/export-pkm-dosen', 'admin\ExportFileController@pdf_pkm_dosen');
    Route::get('/export-pkm-mhs', 'admin\ExportFileController@pdf_pkm_mhs');

    Route::get('/export-alumni', 'admin\ExportFileController@pdf_alumni');

    Route::get('/export-capaian', 'admin\ExportFileController@pdf_capaian');

    Route::get('/export-prestasi-mhs', 'admin\ExportFileController@pdf_prestasi_mhs');

    Route::get('/export-efektivitas', 'admin\ExportFileController@pdf_efektivitas');

    Route::get('/export-publikasi-mhs', 'admin\ExportFileController@pdf_publikasi_mhs');
    Route::get('/export-publikasi-dosen', 'admin\ExportFileController@pdf_publikasi_dosen');
    Route::get('/export-produk-mhs', 'admin\ExportFileController@pdf_produk_mhs');
    Route::get('/export-produk-dosen', 'admin\ExportFileController@pdf_produk_dosen');
    Route::get('/export-paten-mhs', 'admin\ExportFileController@pdf_paten_mhs');
    Route::get('/export-paten-dosen', 'admin\ExportFileController@pdf_paten_dosen');
    Route::get('/export-luaran-lainnya', 'admin\ExportFileController@pdf_luaran');

    Route::prefix('/visi-misi')->name('visi-misi.')->group(function () {
        Route::get('/', 'admin\VisiMisiController@index')->name('index');
        Route::get('/create', 'VisiMisiController@create')->name('create');
    });

    Route::prefix('/kerjasama')->name('kerjasama.')->group(function () {
        Route::get('/', 'admin\KerjasamaController@index')->name('index');
        Route::get('/create', 'admin\KerjasamaController@create')->name('create');
        Route::post('/store', 'admin\KerjasamaController@store')->name('store');
        Route::get('/{id}/edit', 'admin\KerjasamaController@edit')->name('edit');
        Route::patch('/update/{id}', 'admin\KerjasamaController@update')->name('update');
        Route::delete('/delete/{id}', 'admin\KerjasamaController@destroy')->name('delete');
    });

    // Data Mahasiswa
    Route::prefix('/mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/', 'admin\MhsRegController@mahasiswa')->name('mahasiswa');

        Route::prefix('import')->name('import.')->group(function () {
            Route::get('/', 'admin\MahasiswaImportController@index')->name('index');
            Route::post('/store', 'admin\MahasiswaImportController@store')->name('store');
        });

        Route::prefix('/reguler')->name('reguler.')->group(function () {
            Route::get('/', 'admin\MhsRegController@index')->name('index');
            Route::get('/{id}/detail', 'admin\MhsRegController@detail')->name('detail');
            Route::get('/create', 'admin\MhsRegController@create')->name('create');
            Route::post('/store', 'admin\MhsRegController@store')->name('store');
            Route::get('/{id}/edit', 'admin\MhsRegController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\MhsRegController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\MhsRegController@destroy')->name('delete');
        });

        Route::prefix('/non-reguler')->name('non-reguler.')->group(function () {
            Route::get('/', 'admin\NonRegulerController@index')->name('index');
            Route::get('/{id}/detail', 'admin\NonRegulerController@detail')->name('detail');
            Route::get('/create', 'admin\NonRegulerController@create')->name('create');
            Route::post('/store', 'admin\NonRegulerController@store')->name('store');
            Route::get('/{id}/edit', 'admin\NonRegulerController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\NonRegulerController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\NonRegulerController@destroy')->name('delete');
        });

        Route::prefix('/daftar')->name('daftar.')->group(function () {
            Route::get('/', 'admin\PendaftarController@index')->name('index');
            Route::get('/create', 'admin\PendaftarController@create')->name('create');
            Route::post('/store', 'admin\PendaftarController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PendaftarController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PendaftarController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PendaftarController@destroy')->name('delete');
        });

        Route::prefix('/lulus-seleksi')->name('lulus-seleksi.')->group(function () {
            Route::get('/', 'admin\LulusSeleksiController@index')->name('index');
            Route::get('/create', 'admin\LulusSeleksiController@create')->name('create');
            Route::post('/store', 'admin\LulusSeleksiController@store')->name('store');
            Route::get('/{id}/edit', 'admin\LulusSeleksiController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\LulusSeleksiController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\LulusSeleksiController@destroy')->name('delete');
        });

        //prestasi-mhs
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', 'admin\PrestasiMhsController@index')->name('index');
            Route::get('/create', 'admin\PrestasiMhsController@create')->name('create');
            Route::post('/store', 'admin\PrestasiMhsController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PrestasiMhsController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PrestasiMhsController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PrestasiMhsController@destroy')->name('delete');
        });

        Route::prefix('daya-tampung')->name('daya-tampung.')->group(function () {
            Route::get('/', 'admin\DayaTampungController@index')->name('index');
            Route::get('/create', 'admin\DayaTampungController@create')->name('create');
            Route::post('/store', 'admin\DayaTampungController@store')->name('store');
            Route::get('/{id}/edit', 'admin\DayaTampungController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\DayaTampungController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\DayaTampungController@destroy')->name('delete');
        });
    });

    // Data Mahasiswa Asing
    Route::prefix('mahasiswa-asing')->name('mahasiswa-asing.')->group(function () {
        Route::get('/', 'admin\MhsAsingController@mahasiswa_asing')->name('mahasiswa-asing');

        Route::prefix('biodata')->name('biodata.')->group(function () {
            Route::get('/', 'admin\MhsAsingController@index')->name('index');
            Route::get('/create', 'admin\MhsAsingController@create')->name('create');
            Route::get('/{id}/detail', 'admin\MhsAsingController@detail')->name('detail');
            Route::post('/store', 'admin\MhsAsingController@store')->name('store');
            Route::get('/{id}/edit', 'admin\MhsAsingController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\MhsAsingController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\MhsAsingController@destroy')->name('delete');
        });

        Route::prefix('rekap')->name('rekap.')->group(function () {
            Route::get('/', 'admin\RekapController@index')->name('index');
        });
    });

    //Data Dosen
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::prefix('tetap')->name('tetap.')->group(function () {
            Route::get('/', 'admin\DosenTetapController@dosen_tetap')->name('dosen-tetap');

            Route::prefix('import')->name('import.')->group(function () {
                Route::get('/', 'admin\DosenImportController@index')->name('index');
                Route::post('/store', 'admin\DosenImportController@store')->name('store');
            });

            Route::prefix('biodata')->name('biodata.')->group(function () {
                Route::get('/', 'admin\DosenTetapController@index')->name('index');
                Route::get('/create', 'admin\DosenTetapController@create')->name('create');
                Route::post('/store', 'admin\DosenTetapController@store')->name('store');
                Route::get('/{dosen_id}/edit', 'admin\DosenTetapController@edit')->name('edit');
                Route::patch('/update/{dosen_id}', 'admin\DosenTetapController@update')->name('update');
                Route::delete('/delete/{dosen_id}', 'admin\DosenTetapController@destroy')->name('delete');
            });

            Route::prefix('aktivitas')->name('aktivitas.')->group(function () {
                Route::get('/', 'admin\AktivitasTetapController@index')->name('index');
                Route::get('/create', 'admin\AktivitasTetapController@create')->name('create');
                Route::post('/store', 'admin\AktivitasTetapController@store')->name('store');
                Route::get('/{id}/edit', 'admin\AktivitasTetapController@edit')->name('edit');
                Route::patch('/update/{id}', 'admin\AktivitasTetapController@update')->name('update');
                Route::delete('/delete/{id}', 'admin\AktivitasTetapController@destroy')->name('delete');
            });

            Route::prefix('pengajaran')->name('pengajaran.')->group(function () {
                Route::get('/', 'admin\PengajaranController@index')->name('index');
                Route::get('/create', 'admin\PengajaranController@create')->name('create');
                Route::post('/store', 'admin\PengajaranController@store')->name('store');
                Route::get('/{id}/edit', 'admin\PengajaranController@edit')->name('edit');
                Route::patch('/update/{id}', 'admin\PengajaranController@update')->name('update');
                Route::delete('/delete/{id}', 'admin\PengajaranController@destroy')->name('delete');
            });
        });

        Route::prefix('tidak-tetap')->name('tidak-tetap.')->group(function () {
            Route::get('/', 'admin\DosenTdkTetapController@tidak_tetap')->name('tidak-tetap');

            Route::prefix('biodata')->name('biodata.')->group(function () {
                Route::get('/', 'admin\DosenTdkTetapController@index')->name('index');
                Route::get('/create', 'admin\DosenTdkTetapController@create')->name('create');
                Route::post('/store', 'admin\DosenTdkTetapController@store')->name('store');
                Route::get('/{dosen_id}/edit', 'admin\DosenTdkTetapController@edit')->name('edit');
                Route::patch('/update/{dosen_id}', 'admin\DosenTdkTetapController@update')->name('update');
                Route::delete('/delete/{dosen_id}', 'admin\DosenTdkTetapController@destroy')->name('delete');
            });

            Route::prefix('aktivitas')->name('aktivitas.')->group(function () {
                Route::get('/', 'admin\AktivitasTdkTetapController@index')->name('index');
                Route::get('/create', 'admin\AktivitasTdkTetapController@create')->name('create');
                Route::post('/store', 'admin\AktivitasTdkTetapController@store')->name('store');
                Route::get('/{id}/edit', 'admin\AktivitasTdkTetapController@edit')->name('edit');
                Route::patch('/update/{id}', 'admin\AktivitasTdkTetapController@update')->name('update');
                Route::delete('/delete/{id}', 'admin\AktivitasTdkTetapController@destroy')->name('delete');
            });
        });

        Route::prefix('industri')->name('industri.')->group(function () {
            Route::get('/', 'admin\DosenIndustriController@industri')->name('industri');

            Route::prefix('biodata')->name('biodata.')->group(function () {
                Route::get('/', 'admin\DosenIndustriController@index')->name('index');
                Route::get('/create', 'admin\DosenIndustriController@create')->name('create');
                Route::post('/store', 'admin\DosenIndustriController@store')->name('store');
                Route::get('/{dosen_id}/edit', 'admin\DosenIndustriController@edit')->name('edit');
                Route::patch('/update/{dosen_id}', 'admin\DosenIndustriController@update')->name('update');
                Route::delete('/delete/{dosen_id}', 'admin\DosenIndustriController@destroy')->name('delete');
            });

            Route::prefix('aktivitas')->name('aktivitas.')->group(function () {
                Route::get('/', 'admin\AktivitasIndustriController@index')->name('index');
                Route::get('/create', 'admin\AktivitasIndustriController@create')->name('create');
                Route::post('/store', 'admin\AktivitasIndustriController@store')->name('store');
                Route::get('/{id}/edit', 'admin\AktivitasIndustriController@edit')->name('edit');
                Route::patch('/update/{id}', 'admin\AktivitasIndustriController@update')->name('update');
                Route::delete('/delete/{id}', 'admin\AktivitasIndustriController@destroy')->name('delete');
            });
        });
    });

    Route::prefix('upaya')->name('upaya.')->group(function () {
        Route::get('/', 'admin\RekognisiController@upaya')->name('upaya');

        Route::prefix('rekognisi')->name('rekognisi.')->group(function () {
            Route::get('/', 'admin\RekognisiController@index')->name('index');
            Route::get('/create', 'admin\RekognisiController@create')->name('create');
            Route::post('/store', 'admin\RekognisiController@store')->name('store');
            Route::get('/{id}/edit', 'admin\RekognisiController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\RekognisiController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\RekognisiController@destroy')->name('delete');
        });

        Route::prefix('tugas-belajar')->name('tugas-belajar.')->group(function () {
            Route::get('/', 'admin\KemampuanDosenController@index')->name('index');
            Route::get('/create', 'admin\KemampuanDosenController@create')->name('create');
            Route::post('/store', 'admin\KemampuanDosenController@store')->name('store');
            Route::get('/{id}/edit', 'admin\KemampuanDosenController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\KemampuanDosenController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\KemampuanDosenController@destroy')->name('delete');
        });

        //prestasi dosen
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', 'admin\PrestasiDosenController@index')->name('index');
            Route::get('/create', 'admin\PrestasiDosenController@create')->name('create');
            Route::post('/store', 'admin\PrestasiDosenController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PrestasiDosenController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PrestasiDosenController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PrestasiDosenController@destroy')->name('delete');
        });

        //organisasi keilmuan dosen
        Route::prefix('organisasi')->name('organisasi.')->group(function () {
            Route::get('/', 'admin\OrganisasiKeilmuanController@index')->name('index');
            Route::get('/create', 'admin\OrganisasiKeilmuanController@create')->name('create');
            Route::post('/store', 'admin\OrganisasiKeilmuanController@store')->name('store');
            Route::get('/{id}/edit', 'admin\OrganisasiKeilmuanController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\OrganisasiKeilmuanController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\OrganisasiKeilmuanController@destroy')->name('delete');
        });
    });

    Route::prefix('alokasi-dana')->name('alokasi-dana.')->group(function () {
        Route::get('/', 'admin\PerolehanDanaController@alokasi')->name('alokasi');

        Route::prefix('perolehan')->name('perolehan.')->group(function () {
            Route::get('/', 'admin\PerolehanDanaController@index')->name('index');
            Route::get('/create', 'admin\PerolehanDanaController@create')->name('create');
            Route::post('/store', 'admin\PerolehanDanaController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PerolehanDanaController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PerolehanDanaController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PerolehanDanaController@destroy')->name('delete');
        });

        Route::prefix('penggunaan')->name('penggunaan.')->group(function () {
            Route::get('/', 'admin\PenggunaanDanaController@index')->name('index');
            Route::get('/create', 'admin\PenggunaanDanaController@create')->name('create');
            Route::post('/store', 'admin\PenggunaanDanaController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PenggunaanDanaController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PenggunaanDanaController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PenggunaanDanaController@destroy')->name('delete');
        });

        Route::prefix('penelitian')->name('penelitian.')->group(function () {
            Route::get('/', 'admin\DanaPenelitianController@index')->name('index');
            Route::get('/create', 'admin\DanaPenelitianController@create')->name('create');
            Route::post('/store', 'admin\DanaPenelitianController@store')->name('store');
            Route::get('/{id}/edit', 'admin\DanaPenelitianController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\DanaPenelitianController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\DanaPenelitianController@destroy')->name('delete');
        });

        Route::prefix('pkm')->name('pkm.')->group(function () {
            Route::get('/', 'admin\DanaPkmController@index')->name('index');
            Route::get('/create', 'admin\DanaPkmController@create')->name('create');
            Route::post('/store', 'admin\DanaPkmController@store')->name('store');
            Route::get('/{id}/edit', 'admin\DanaPkmController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\DanaPkmController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\DanaPkmController@destroy')->name('delete');
        });
    });

    Route::prefix('prasarana')->name('prasarana.')->group(function () {
        Route::get('/', 'admin\PrasaranaController@prasarana')->name('prasarana');

        Route::prefix('ruangan')->name('ruangan.')->group(function () {
            Route::get('/', 'admin\RuangController@index')->name('index');
            Route::get('/create', 'admin\RuangController@create')->name('create');
            Route::post('/store', 'admin\RuangController@store')->name('store');
            Route::get('/{id}/edit', 'admin\RuangController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\RuangController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\RuangController@destroy')->name('delete');
        });

        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/', 'admin\PrasaranaController@index')->name('index');
            Route::get('/create', 'admin\PrasaranaController@create')->name('create');
            Route::post('/store', 'admin\PrasaranaController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PrasaranaController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PrasaranaController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PrasaranaController@destroy')->name('delete');
        });

        Route::prefix('prasarana-lain')->name('prasarana-lain.')->group(function () {
            Route::get('/', 'admin\PrasaranaLainController@index')->name('index');
            Route::get('/create', 'admin\PrasaranaLainController@create')->name('create');
            Route::post('/store', 'admin\PrasaranaLainController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PrasaranaLainController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PrasaranaLainController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PrasaranaLainController@destroy')->name('delete');
        });
    });

    Route::prefix('sarana')->name('sarana.')->group(function () {
        Route::get('/', 'admin\PustakaController@sarana')->name('sarana');

        Route::prefix('pustaka')->name('pustaka.')->group(function () {
            Route::get('/', 'admin\PustakaController@index')->name('index');
            Route::get('/create', 'admin\PustakaController@create')->name('create');
            Route::post('/store', 'admin\PustakaController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PustakaController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PustakaController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PustakaController@destroy')->name('delete');
        });

        Route::prefix('lab')->name('lab.')->group(function () {
            Route::get('/', 'admin\LabController@index')->name('index');
            Route::get('/create', 'admin\LabController@create')->name('create');
            Route::post('/store', 'admin\LabController@store')->name('store');
            Route::get('/{id}/edit', 'admin\LabController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\LabController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\LabController@destroy')->name('delete');
        });
    });

    Route::get('aksebilitas', function () {
        return view('admin/sarana/aksebilitas');
    });


    Route::prefix('api/import')->name('api/import.')->group(function () {
        Route::post('/kurikulum', 'admin\KurikulumImportController@kurikulum');
    });

    Route::prefix('kurikulum')->name('kurikulum.')->group(function () {
        Route::get('/', 'admin\SksController@kurikulum')->name('kurikulum');

        Route::prefix('import')->name('import.')->group(function () {
            Route::get('/', 'admin\KurikulumImportController@index')->name('index');
            Route::post('/store', 'admin\KurikulumImportController@store')->name('store');
        });

        Route::prefix('jumlah-sks')->name('jumlah-sks.')->group(function () {
            Route::get('/', 'admin\SksController@index')->name('index');
            Route::get('/create', 'admin\SksController@create')->name('create');
            Route::post('/store', 'admin\SksController@store')->name('store');
            Route::get('/{id}/edit', 'admin\SksController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\SksController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\SksController@destroy')->name('delete');
        });

        Route::prefix('struktur')->name('struktur.')->group(function () {
            Route::get('/', 'admin\StrukturKurikulumController@index')->name('index');
            Route::get('/create', 'admin\StrukturKurikulumController@create')->name('create');
            Route::post('/store', 'admin\StrukturKurikulumController@store')->name('store');
            Route::get('/{id}/edit', 'admin\StrukturKurikulumController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\StrukturKurikulumController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\StrukturKurikulumController@destroy')->name('delete');
        });

        Route::prefix('peninjauan')->name('peninjauan.')->group(function () {
            Route::get('/', 'admin\StrukturKurikulumController@peninjauan')->name('peninjauan');
        });

        Route::prefix('mk-pilihan')->name('mk-pilihan.')->group(function () {
            Route::get('/', 'admin\MkPilihanController@index')->name('index');
            Route::get('/create', 'admin\MkPilihanController@create')->name('create');
            Route::post('/store', 'admin\MkPilihanController@store')->name('store');
            Route::get('/{id}/edit', 'admin\MkPilihanController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\MkPilihanController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\MkPilihanController@destroy')->name('delete');
        });

        Route::prefix('praktikum')->name('praktikum.')->group(function () {
            Route::get('/', 'admin\PraktikumController@index')->name('index');
            Route::get('/create', 'admin\PraktikumController@create')->name('create');
            Route::post('/store', 'admin\PraktikumController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PraktikumController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PraktikumController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PraktikumController@destroy')->name('delete');
        });
    });

    Route::prefix('pembimbing')->name('pembimbing.')->group(function () {
        Route::get('/', 'admin\PembimbingAkademikController@bimbingan')->name('bimbingan');

        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/', 'admin\PembimbingAkademikController@index')->name('index');
            Route::get('/create', 'admin\PembimbingAkademikController@create')->name('create');
            Route::post('/store', 'admin\PembimbingAkademikController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PembimbingAkademikController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PembimbingAkademikController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PembimbingAkademikController@destroy')->name('delete');
        });

        Route::prefix('ta')->name('ta.')->group(function () {
            Route::get('/', 'admin\PembimbingTaController@index')->name('index');
            Route::delete('/delete/{id}', 'admin\PembimbingTaController@destroy')->name('delete');
        });
    });

    Route::prefix('kegiatan-akademik')->name('kegiatan-akademik.')->group(function () {
        Route::get('/', 'admin\PeningkatanKegiatanController@index')->name('index');
        Route::get('/create', 'admin\PeningkatanKegiatanController@create')->name('create');
        Route::post('/store', 'admin\PeningkatanKegiatanController@store')->name('store');
        Route::get('/{id}/edit', 'admin\PeningkatanKegiatanController@edit')->name('edit');
        Route::patch('/update/{id}', 'admin\PeningkatanKegiatanController@update')->name('update');
        Route::delete('/delete/{id}', 'admin\PeningkatanKegiatanController@destroy')->name('delete');
    });

    //Penelitian Dosen
    Route::prefix('penelitian')->name('penelitian.')->group(function () {
        Route::get('/', 'admin\PenelitianDosenController@penelitian')->name('penelitian');

        Route::prefix('dosen')->name('dosen.')->group(function () {
            Route::get('/', 'admin\PenelitianDosenController@index')->name('index');
            Route::get('create', 'admin\PenelitianDosenController@create')->name('create');
            Route::post('/store', 'admin\PenelitianDosenController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PenelitianDosenController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PenelitianDosenController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PenelitianDosenController@destroy')->name('delete');
        });

        Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
            Route::get('/', 'admin\PenelitianMhsS2Controller@index')->name('index');
            Route::get('create', 'admin\PenelitianMhsS2Controller@create')->name('create');
            Route::post('/store', 'admin\PenelitianMhsS2Controller@store')->name('store');
            Route::get('/{id}/edit', 'admin\PenelitianMhsS2Controller@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PenelitianMhsS2Controller@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PenelitianMhsS2Controller@destroy')->name('delete');
        });
    });

    Route::get('upaya-perbaikan', function () {
        return view('admin/bimbingan/upaya-perbaikan');
    });

    Route::prefix('pkm')->name('pkm.')->group(function () {
        Route::get('/', 'admin\PkmController@pkm')->name('pkm');

        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/', 'admin\DataPkmController@index')->name('index');
            Route::get('/create', 'admin\DataPkmController@create')->name('create');
            Route::delete('/delete/{id}', 'admin\DataPkmController@destroy')->name('delete');
        });

        Route::prefix('dosen')->name('dosen.')->group(function () {
            Route::get('/', 'admin\PkmController@index')->name('index');
            Route::get('/create', 'admin\PkmController@create')->name('create');
            Route::post('/store', 'admin\PkmController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PkmController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PkmController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PkmController@destroy')->name('delete');
        });

        Route::prefix('mhs')->name('mhs.')->group(function () {
            Route::get('/', 'admin\PkmMhsController@index')->name('index');
            Route::get('/create', 'admin\PkmMhsController@create')->name('create');
            Route::post('/store', 'admin\PkmMhsController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PkmMhsController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PkmMhsController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PkmMhsController@destroy')->name('delete');
        });
    });

    Route::prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/', 'admin\AlumniController@index')->name('index');
        Route::get('create', 'admin\AlumniController@create')->name('create');
        Route::post('/store', 'admin\AlumniController@store')->name('store');
        Route::get('/{id}/edit', 'admin\AlumniController@edit')->name('edit');
        Route::patch('/update/{id}', 'admin\AlumniController@update')->name('update');
        Route::delete('/delete/{id}', 'admin\AlumniController@destroy')->name('delete');

        Route::prefix('import')->name('import.')->group(function () {
            Route::get('/', 'admin\AlumniImportController@index')->name('index');
            Route::post('/store', 'admin\AlumniImportController@store')->name('store');
        });
    });

    Route::prefix('capaian')->name('capaian.')->group(function () {
        Route::get('/', 'admin\CapaianController@index')->name('index');
        Route::get('create', 'admin\CapaianController@create')->name('create');
        Route::post('/store', 'admin\CapaianController@store')->name('store');
        Route::get('/{id}/edit', 'admin\CapaianController@edit')->name('edit');
        Route::patch('/update/{id}', 'admin\CapaianController@update')->name('update');
        Route::delete('/delete/{id}', 'admin\CapaianController@destroy')->name('delete');
    });

    Route::prefix('efektivitas')->name('efektivitas.')->group(function () {
        Route::get('/', 'admin\DataController@efektivitas')->name('efektivitas');

        Route::prefix('pendidikan')->name('pendidikan.')->group(function () {
            Route::get('/', 'admin\EfektivitasController@index')->name('index');
            Route::get('/{id}/edit', 'admin\EfektivitasController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\EfektivitasController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\EfektivitasController@destroy')->name('delete');
        });
    });

    Route::prefix('luaran')->name('luaran.')->group(function () {
        Route::get('/', 'admin\DataController@luaran')->name('luaran');

        Route::prefix('publikasi-mhs')->name('publikasi-mhs.')->group(function () {
            Route::get('/', 'admin\PublikasiMhsController@index')->name('index');
            Route::get('create', 'admin\PublikasiMhsController@create')->name('create');
            Route::post('/store', 'admin\PublikasiMhsController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PublikasiMhsController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PublikasiMhsController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PublikasiMhsController@destroy')->name('delete');
        });

        Route::prefix('publikasi-mhs-terapan')->name('publikasi-mhs-terapan.')->group(function () {
            Route::get('/', 'admin\PublikasiMhsTerapanController@index')->name('index');
            Route::get('create', 'admin\PublikasiMhsTerapanController@create')->name('create');
            Route::post('/store', 'admin\PublikasiMhsTerapanController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PublikasiMhsTerapanController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PublikasiMhsTerapanController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PublikasiMhsTerapanController@destroy')->name('delete');
        });

        Route::prefix('karya-ilmiah')->name('karya-ilmiah.')->group(function () {
            Route::get('/', 'admin\KaryaIlmiahController@index')->name('index');
            Route::get('create', 'admin\KaryaIlmiahController@create')->name('create');
            // Route::post('/store', 'admin\KaryaIlmiahController@store')->name('store');
            Route::get('/{dosen_id}/edit', 'admin\KaryaIlmiahController@edit')->name('edit');
            Route::patch('/update/{dosen_id}', 'admin\KaryaIlmiahController@update')->name('update');
            Route::delete('/delete/{dosen_id}', 'admin\KaryaIlmiahController@destroy')->name('delete');
            Route::post('/run', 'admin\KaryaIlmiahController@run')->name('run');
            Route::post('/save', 'admin\KaryaIlmiahController@save')->name('save');
            Route::get('/{dosen_id}/detail', 'admin\KaryaIlmiahController@detail')->name('detail');
            Route::get('/{dosen_id}/create-detail', 'admin\KaryaIlmiahController@create_detail')->name('create-detail');
            Route::post('/store-detail', 'admin\KaryaIlmiahController@store_detail')->name('store-detail');
            Route::get('/{id}/edit-detail', 'admin\KaryaIlmiahController@edit_detail')->name('edit-detail');
            Route::patch('/update-detail/{id}', 'admin\KaryaIlmiahController@update_detail')->name('update-detail');
            Route::delete('/delete-detail/{id}', 'admin\KaryaIlmiahController@destroy_detail')->name('delete-detail');
            Route::post('/submit', 'admin\KaryaIlmiahController@submit')->name('submit');

            Route::prefix('import')->name('import.')->group(function () {
                Route::get('/', 'admin\PublikasiImportController@index')->name('index');
                Route::post('/store', 'admin\PublikasiImportController@store')->name('store');
            });
        });

        Route::prefix('produk')->name('produk.')->group(function () {
            Route::get('/', 'admin\ProdukController@index')->name('index');
            Route::get('create', 'admin\ProdukController@create')->name('create');
            Route::post('/store', 'admin\ProdukController@store')->name('store');
            Route::get('/{id}/edit', 'admin\ProdukController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\ProdukController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\ProdukController@destroy')->name('delete');
        });

        Route::prefix('produk-mhs')->name('produk-mhs.')->group(function () {
            Route::get('/', 'admin\ProdukMhsController@index')->name('index');
            Route::get('create', 'admin\ProdukMhsController@create')->name('create');
            Route::post('/store', 'admin\ProdukMhsController@store')->name('store');
            Route::get('/{id}/edit', 'admin\ProdukMhsController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\ProdukMhsController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\ProdukMhsController@destroy')->name('delete');
        });

        Route::prefix('lainnya')->name('lainnya.')->group(function () {
            Route::get('/', 'admin\LainnyaController@index')->name('index');
            Route::get('create', 'admin\LainnyaController@create')->name('create');
            Route::post('/store', 'admin\LainnyaController@store')->name('store');
            Route::get('/{id}/edit', 'admin\LainnyaController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\LainnyaController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\LainnyaController@destroy')->name('delete');
        });

        Route::prefix('paten')->name('paten.')->group(function () {
            Route::get('/', 'admin\PatenController@index')->name('index');
            Route::get('create', 'admin\PatenController@create')->name('create');
            Route::post('/store', 'admin\PatenController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PatenController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PatenController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PatenController@destroy')->name('delete');
        });

        Route::prefix('paten-mhs')->name('paten-mhs.')->group(function () {
            Route::get('/', 'admin\PatenMhsController@index')->name('index');
            Route::get('create', 'admin\PatenMhsController@create')->name('create');
            Route::post('/store', 'admin\PatenMhsController@store')->name('store');
            Route::get('/{id}/edit', 'admin\PatenMhsController@edit')->name('edit');
            Route::patch('/update/{id}', 'admin\PatenMhsController@update')->name('update');
            Route::delete('/delete/{id}', 'admin\PatenMhsController@destroy')->name('delete');
        });
    });

    //tenaga kependidikan
    Route::prefix('tenaga-kependidikan')->name('tenaga-kependidikan.')->group(function () {
        Route::get('/', 'admin\KependidikanController@index')->name('index');
        Route::get('create', 'admin\KependidikanController@create')->name('create');
        Route::post('/store', 'admin\KependidikanController@store')->name('store');
        Route::get('/{id}/edit', 'admin\KependidikanController@edit')->name('edit');
        Route::patch('/update/{id}', 'admin\KependidikanController@update')->name('update');
        Route::delete('/delete/{id}', 'admin\KependidikanController@destroy')->name('delete');
    });
});

//DOSEN
Route::group(['middleware' => ['auth:dosen']], function () {

    Route::get('notifikasi', function () {
        return view('dosen/notifikasi/notifikasi');
    });

    Route::prefix('dashboard-dosen')->name('dashboard-dosen.')->group(function () {
        Route::get('/', 'dosen\BiodataController@dashboard')->name('dashboard');
    });

    //Data aktivitas dosen
    Route::prefix('aktivitas')->name('aktivitas.')->group(function () {
        Route::get('/', 'dosen\AktivitasDosenController@index')->name('index');
        Route::get('create', 'dosen\AktivitasDosenController@create')->name('create');
        Route::post('/store', 'dosen\AktivitasDosenController@store')->name('store');
        Route::get('/{id}/edit', 'dosen\AktivitasDosenController@edit')->name('edit');
        Route::patch('/update/{id}', 'dosen\AktivitasDosenController@update')->name('update'); //belum coba tes
        Route::delete('/delete/{id}', 'dosen\AktivitasDosenController@destroy')->name('delete');
        Route::patch('/confirm/{id}', 'dosen\AktivitasDosenController@confirm')->name('confirm');
    });

    //Data kegiatan dosen
    Route::prefix('kegiatan-dosen')->name('kegiatan-dosen.')->group(function () {
        Route::get('/', 'dosen\KegiatanController@index')->name('index');
        Route::get('create', 'dosen\KegiatanController@create')->name('create');
        Route::post('/store', 'dosen\KegiatanController@store')->name('store');
        Route::get('/{id}/edit', 'dosen\KegiatanController@edit')->name('edit');
        Route::patch('/update/{id}', 'dosen\KegiatanController@update')->name('update');
        Route::delete('/delete/{id}', 'dosen\KegiatanController@destroy')->name('delete');
        Route::patch('/confirm/{id}', 'dosen\KegiatanController@confirm')->name('confirm');
    });

    //Data penelitian dan publikasi
    Route::prefix('publikasi')->name('publikasi.')->group(function () {
        Route::prefix('artikel')->name('artikel.')->group(function () {
            Route::get('/', 'dosen\PublikasiController@index')->name('index');
            Route::get('create', 'dosen\PublikasiController@create')->name('create');
            Route::post('/store', 'dosen\PublikasiController@store')->name('store');
            Route::get('/{id}/edit', 'dosen\PublikasiController@edit')->name('edit');
            Route::patch('/update/{id}', 'dosen\PublikasiController@update')->name('update');
            Route::delete('/delete/{id}', 'dosen\PublikasiController@destroy')->name('delete');
            Route::patch('/confirm/{id}', 'dosen\PublikasiController@confirm')->name('confirm');
        });

        Route::prefix('produk')->name('produk.')->group(function () {
            Route::get('/', 'dosen\ProdukController@index')->name('index');
            Route::get('create', 'dosen\ProdukController@create')->name('create');
            Route::post('/store', 'dosen\ProdukController@store')->name('store');
            Route::get('/{id}/edit', 'dosen\ProdukController@edit')->name('edit');
            Route::patch('/update/{id}', 'dosen\ProdukController@update')->name('update');
            Route::delete('/delete/{id}', 'dosen\ProdukController@destroy')->name('delete');
            Route::patch('/confirm/{id}', 'dosen\ProdukController@confirm')->name('confirm');
        });

        Route::prefix('pkm')->name('pkm.')->group(function () {
            Route::get('/', 'dosen\PkmController@index')->name('index');
            Route::get('create', 'dosen\PkmController@create')->name('create');
            Route::post('/store', 'dosen\PkmController@store')->name('store');
            Route::get('{id}/edit', 'dosen\PkmController@edit')->name('edit');
            Route::patch('/update/{id}', 'dosen\PkmController@update')->name('update');
            Route::delete('/delete/{id}', 'dosen\PkmController@destroy')->name('delete');
            Route::patch('/confirm/{id}', 'dosen\PkmController@confirm')->name('confirm');
        });

        Route::prefix('penelitian')->name('penelitian.')->group(function () {
            Route::get('/', 'dosen\PenelitianController@index')->name('index');
            Route::get('create', 'dosen\PenelitianController@create')->name('create');
            Route::post('/store', 'dosen\PenelitianController@store')->name('store');
            Route::get('{id}/edit', 'dosen\PenelitianController@edit')->name('edit');
            Route::patch('/update/{id}', 'dosen\PenelitianController@update')->name('update');
            Route::delete('/delete/{id}', 'dosen\PenelitianController@destroy')->name('delete');
            Route::patch('/confirm/{id}', 'dosen\PenelitianController@confirm')->name('confirm');
        });
    });

    //Data prestasi dosen
    Route::prefix('prestasi-dosen')->name('prestasi-dosen.')->group(function () {
        Route::get('/', 'dosen\PrestasiController@index')->name('index');
        Route::get('create', 'dosen\PrestasiController@create')->name('create');
        Route::post('/store', 'dosen\PrestasiController@store')->name('store');
        Route::get('/{dosen_id}/edit', 'dosen\PrestasiController@edit')->name('edit');
        Route::patch('/update/{id}', 'dosen\PrestasiController@update')->name('update');
        Route::delete('/delete/{id}', 'dosen\PrestasiController@destroy')->name('delete');
        Route::patch('/confirm/{id}', 'dosen\PrestasiController@confirm')->name('confirm');
    });

    //Data biodata dosen
    Route::prefix('biodata')->name('biodata.')->group(function () {
        Route::get('/', 'dosen\BiodataController@index')->name('index');
        Route::get('/edit', 'dosen\BiodataController@edit')->name('edit');
        Route::patch('/update', 'dosen\BiodataController@update')->name('update');
    });

    //Data bimbingan
    Route::prefix('bimbingan')->name('bimbingan.')->group(function () {

        //bimbingan akademik (dosen wali)
        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/', 'dosen\PembimbingAkademikController@index')->name('index');
            Route::get('/create', 'dosen\PembimbingAkademikController@create')->name('create');
            Route::post('/store', 'dosen\PembimbingAkademikController@store')->name('store');
            Route::delete('/delete/{id}', 'dosen\PembimbingAkademikController@destroy')->name('delete');
        });

        //bimbingan tugas akhir
        Route::prefix('tugas-akhir')->name('tugas-akhir.')->group(function () {
            Route::get('/', 'dosen\PembimbingTaController@index')->name('index');
            Route::get('/create', 'dosen\PembimbingTaController@create')->name('create');
            Route::post('/store', 'dosen\PembimbingTaController@store')->name('store');
            Route::get('/{id}/edit', 'dosen\PembimbingTaController@edit')->name('edit');
            Route::patch('/update/{id}', 'dosen\PembimbingTaController@update')->name('update');
            Route::delete('/delete/{id}', 'dosen\PembimbingTaController@destroy')->name('delete');
        });
    });
});


// MAHASISWA
Route::group(['middleware' => ['auth:himpunan']], function () {

    Route::get('main', function () {
        return view('himpunan/layout/main');
    });

    Route::get('dashboard-mhs', function () {
        return view('himpunan/layout/dashboard-mhs');
    });

    //Data profil himpunan
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::prefix('himpunan')->name('himpunan.')->group(function () {
            Route::get('/', 'himpunan\ProfilHimpunanController@index')->name('index');
        });

        Route::prefix('pengurus')->name('pengurus.')->group(function () {
            Route::get('/', 'himpunan\ProfilKepengurusanController@index')->name('index');
        });
    });

    //Data profil kepengurusan
    Route::get('profil-kepengurusan', function () {
        return view('mahasiswa/profil/profil-kepengurusan');
    });

    //Data prestasi mahasiswa
    Route::prefix('prestasi')->name('prestasi.')->group(function () {
        Route::get('/', 'himpunan\PrestasiMhsController@index')->name('index');
        Route::get('/create', 'himpunan\PrestasiMhsController@create')->name('create');
        Route::post('/store', 'himpunan\PrestasiMhsController@store')->name('store');
        Route::get('/{id}/edit', 'himpunan\PrestasiMhsController@edit')->name('edit');
        Route::patch('/update/{id}', 'himpunan\PrestasiMhsController@update')->name('update');
        Route::delete('/delete/{id}', 'himpunan\PrestasiMhsController@destroy')->name('delete');
    });

    //Data kegiatan mahasiswa
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/', 'himpunan\KegiatanController@index')->name('index');
        Route::get('/create', 'himpunan\KegiatanController@create')->name('create');
        Route::post('/store', 'himpunan\KegiatanController@store')->name('store');
        Route::get('/{id}/edit', 'himpunan\KegiatanController@edit')->name('edit');
        Route::patch('/update/{id}', 'himpunan\KegiatanController@update')->name('update');
        Route::delete('/delete/{id}', 'himpunan\KegiatanController@destroy')->name('delete');
    });
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


///// API DOSEN-------------------------------------------------------------------

Route::get('/api/dosen/{nip}', function ($nip) {
    $dosen = DB::table('dosen')->where('nip', $nip)->first();
    if ($dosen) {
        return response()->json(['dosen_id' => $dosen->dosen_id, 'nama_dosen' => $dosen->nama_dosen]);
    } else {
        return response(404);
    }
});

///// END API -------------------------------------------------------------------

///// API MK-------------------------------------------------------------------

Route::get('/api/mk/{kode_mk}', function ($kode_mk) {
    $kurikulum = DB::table('kurikulum')->where('kode_mk', $kode_mk)->first();
    if ($kurikulum) {
        return response()->json(['kurikulum_id' => $kurikulum->id, 'nama_mk' => $kurikulum->nama_mk, 'bobot_sks' => $kurikulum->bobot_sks]);
    } else {
        return response(404);
    }
});

///// END API -------------------------------------------------------------------

Route::get('/api/mhs/{npm}', function ($npm) {
    $biodata_mhs = DB::table('biodata_mhs')->where('npm', $npm)->first();
    if ($biodata_mhs) {
        return response()->json(['id' => $biodata_mhs->id, 'nama' => $biodata_mhs->nama, 'tahun_masuk' => $biodata_mhs->tahun_masuk]);
    } else {
        return response(404);
    }
});

Route::get('/api/mhss2/{npm}', function ($npm) {
    $mahasiswa_s2 = DB::table('mahasiswa_s2')->where('npm', $npm)->first();
    if ($mahasiswa_s2) {
        return response()->json(['id' => $mahasiswa_s2->id, 'nama' => $mahasiswa_s2->nama]);
    } else {
        return response(404);
    }
});

////// API TENAGA KEPENDIDIKAN-------------------------------------------------------

Route::get('/api/tenaga/{nidn}', function ($nidn) {
    $tenaga_kependidikan = DB::table('tenaga_kependidikan')->where('nidn', $nidn)->first();
    if ($tenaga_kependidikan) {
        return response()->json(['id' => $tenaga_kependidikan->id, 'nama' => $tenaga_kependidikan->nama]);
    } else {
        return response(404);
    }
});

////// API KAB NEGARA PROV-------------------------------------------------------
Route::get('/api/mk/{id}', function ($id) {
    $kab = DB::table('kab')->where('id', $id)->first();
    if ($kab) {
        return response()->json(['id' => $kab->id, 'prov_id' => $kab->prov_id, 'nama_kab' => $kab->nama_kab]);
    } else {
        return response(404);
    }
});



Route::prefix('api/import')->name('api/import')->group(function () {
    Route::post('/mahasiswa/reguler', 'admin\ImportController@mahasiswa_reguler');
});
