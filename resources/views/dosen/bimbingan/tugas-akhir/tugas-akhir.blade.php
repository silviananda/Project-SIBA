@extends('dosen.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Bimbingan Tugas Akhir</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        {{-- <ul class="nav navbar-right panel_toolbox">
                            <li><a class="" style="color: #778899" href="{{ route('bimbingan.tugas-akhir.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
                        </ul> --}}
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NPM</th>
                                                <th>Nama Mahasiswa</th>
                                                {{-- <th>Jenis Pembimbing</th> --}}
                                                <th>Tahun Masuk</th>
                                                <th>Tahun Mulai Bimbingan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ( $data_pembimbing_ta as $value )
                                            <tr>
                                                <th scope="row"> {{ $loop->iteration }}</th>
                                                <td>{{ $value->biodata_mhs['npm'] }}</td>
                                                <td>{{ $value->biodata_mhs['nama'] }}</td>
                                                <td>{{ date('Y', strtotime($value->biodata_mhs['tahun_masuk'])) }}</td>
                                                <td>{{ $value->tahun }}</td>
                                                <td style="display: inline-flex;">
                                                    <a href="{{ route('bimbingan.tugas-akhir.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
