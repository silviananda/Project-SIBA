@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Data Alumni</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="" style="color: #778899" href="{{URL::to('export-alumni')}}"> Download  <i class="fa fa-download"></i></a></li>
                      &nbsp;
                        <li><a class="" style="color: #778899" href="{{ route('alumni.import.index') }}"> Import <i class="fa fa-arrow-down"></i></a>
                        </li>
                        &nbsp;
                      <li><a class="" style="color: #778899" href="{{ route('alumni.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
                    </ul>
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
                                        <th>Npm Alumni</th>
                                        <th>Nama Alumni</th>
                                        <th>Ipk</th>
                                        <th>Tahun Masuk</th>
                                        <th>Tahun Lulus</th>
                                        <th>Status Mulai Kerja</th>
                                        <th>Jenis Pekerjaan Lulusan</th>
                                        <th>Pendapatan/Penghasilan</th>
                                        <th>Waktu Tunggu Lulusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $alumni as $value )
                                            <tr>
                                            <th scope="row"> {{ $loop->iteration }}</th>
                                            <td>{{ $value->npm }}</td>
                                            <td>{{ $value->nama }}</td>
                                            <td>{{ $value->ipk }}</td>
                                            <td>{{ $value->tahun_masuk != null ? date('Y', strtotime($value->tahun_masuk)) : '-' }}</td>
                                            <td>{{ $value->tahun_lulus != null ? date('Y', strtotime($value->tahun_lulus)) : '-' }}</td>
                                            <td>{{ $value->mulai_kerja['waktu_kerja'] ?? '-' }}</td>
                                            <td>{{ $value->jenis_pekerjaan['jenis'] ?? '-' }}</td>
                                            <td>{{ $value->kategori_pendapatan['pendapatan'] ?? '-'}}</td>
                                            <td>{{ $value->waktu_tunggu['waktu'] ?? '-'}}</td>
                                            <td style="display: inline-flex;">
                                                <a href="{{ route('alumni.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                                <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                <form class="d-inline" action="{{ route('alumni.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                                Hapus</a>
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
