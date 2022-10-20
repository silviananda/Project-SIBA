@extends('admin.layout.main')
@section('content')

<style type="text/css">
    .noBorder {
        border: none !important;
    }

    textarea.form-control.komentar-class {
        width: 100%;
        height: 100%;
        border-color: Transparent;
    }
</style>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">

                            <h2><i class="fa fa-align-left"></i> Data Biodata Mahasiswa Asing</h2>
                            @if($mhs_asing->deleted_at != NULL)
                                <ul class="nav navbar-right panel_toolbox"></ul>
                            @else
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a href="{{ route('mahasiswa-asing.biodata.edit', $mhs_asing->id) }}"><i class="fa fa-wrench" style="color: #778899"></i></a>
                                    </li>
                                </ul>
                            @endif
                            <div class="clearfix"></div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table full-primary-table">
                                            <tbody>
                                                <tr>
                                                    <td class="noBorder" width="20%">NPM Mahasiswa</td>
                                                    <td class="noBorder" width="45%"><a id="inline-username" data-type="text" data-pk="1"></a>{{ $mhs_asing['npm'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Nama Mahasiswa</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right"></a>{{ $mhs_asing['nama'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">NIP Dosen Wali</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->dosen['nip'] ?? '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Nama Dosen Wali</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->dosen['nama_dosen'] ?? '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Jenis Kelamin</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing['jenis_kelamin'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder"> Tempat Tinggal Asal</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->kategori_asal['asal'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Asal Sekolah</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing['asal_sekolah'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Tahun Masuk</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ date('Y', strtotime($mhs_asing->tahun_masuk)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Email</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->email }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Ipk</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->ipk ?? '-' }}
                                                    </td>
                                                </tr>

                                                {{-- @foreach ( $mhs_asing->data_pembimbing_ta as $value ) --}}
                                                 {{-- <tr>
                                                    <td class="noBorder">Tanggal Mulai Bimbingan</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $data_pembimbing_ta }}
                                                    </td>
                                                </tr> --}}
                                                <tr>

                                                <tr>
                                                    <td class="noBorder">Dosen Pembimbing I</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" {{-- data-title="Enter your firstname"></a>{{ $dosen['doping1']->nama_dosen ?? '-'}} --}} data-title="Enter your firstname"></a>{{ $listdoping1[0][0]['nama_dosen'] ?? '-' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="noBorder">Dosen Pembimbing II</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" {{-- data-title="Enter your firstname"></a>{{ $dosen['doping2']->nama_dosen ?? '-'}} --}} data-title="Enter your firstname"></a>{{ $listdoping2[0][0]['nama_dosen'] ?? '-'}}
                                                    </td>
                                                </tr>
                                                {{-- @endforeach --}}

                                                <tr>
                                                    <td class="noBorder">Dosen Penguji I</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $dosen['penguji1']->nama_dosen ?? '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Dosen Penguji II</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $dosen['penguji2']->nama_dosen ?? '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Dosen Penguji III</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $dosen['penguji3']->nama_dosen ?? '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Tanggal Seminar Proposal</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->proposal ?? '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Tanggal Seminar Hasil</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->hasil ?? '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Tanggal Seminar Sidang</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->sidang ?? '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="noBorder">Tanggal Lulus</td>
                                                    <td class="noBorder">
                                                        <a id="inline-firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a>{{ $mhs_asing->tahun_keluar != null ? date('Y', strtotime($mhs_asing->tahun_keluar)) : '-' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- <div class="x_content">
                    <div class="">

                      <ul class="to_do">
                        <li>
                            <p>
                                <span class="message">
                                    Npm Mahasiswa  :
                                </span>
                        </li>
                              <span class="message">
                                    Nama Mahasiswa  :
                              </span>
                        </li>

                      </ul>
                    </div>
                </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /page content -->
@stop