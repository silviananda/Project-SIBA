@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Karya Ilmiah Mahasiswa</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{ route('luaran.publikasi-mhs-terapan.create') }}"> Add New <i class="fa fa-plus"></i></a></li>
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
                                        <th>Npm Mahasiswa</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Judul artikel yang disitasi (Jurnal, Volume, Tahun, Nomor, Halaman)</th>
                                        <th>Kategori Tingkat Publikasi</th>
                                        <th>Jumlah artikel yang Mensitasi</th>
                                        <th>Jenis Publikasi</th>
                                        <th>Tahun Publikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $artikel_mhs_terapan as $value )
                                        <tr>
                                        <th scope="row"> {{ $loop->iteration }}</th>
                                        <td>{{ $value->npm }}</td>
                                        <td>{{ $value->nama }}</td>
                                        <td>{{ $value->judul }}</td>
                                        <td>{{ $value->nama_kategori }}</td>
                                        <td>{{ $value->jumlah }}</td>
                                        <td>{{ $value->jenis_publikasi }}</td>
                                        <td>{{ $value->tahun }}</td>
                                        <td style="display: inline-flex;">
                                            <a href="{{ route('luaran.publikasi-mhs-terapan.edit', $value->id) }}" class="btn btn-success btn-sm">Edit</a>

                                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                            <form class="d-inline" action="{{ route('luaran.publikasi-mhs-terapan.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
                                                @method('delete')
                                                @csrf
                                            </form>
                                            Delete</a>
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
