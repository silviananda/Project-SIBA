@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title" style="float:center;">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>Data Publikasi</h3> 
                    </div>
                   
                        <h5>Nama Dosen : {{ $list_dosen->nama_dosen }} </h5> 
                        <h6>NIP  : {{ $list_dosen->nip }} </h6> 
                </div>
            </div>

            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                        <div class="x_title">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="" style="color: #778899" href="{{ route('luaran.karya-ilmiah.create-detail', $list_dosen->dosen_id) }}"> Tambah <i class="fa fa-plus"></i></a></li>
                            </ul>
                        </div>
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
                                    <th>Judul Artikel</th>
                                    <th>Volume</th>
                                    <th>Page</th>
                                    <th>Issue</th>
                                    <th>Publisher</th>
                                    <th>Kategori Tingkat Publikasi</th>
                                    <th>Jumlah artikel yang Mensitasi</th>
                                    <th>Jenis Publikasi</th>
                                    <th>Tahun Publikasi</th>
                                    <th>Softcopy</th>
                                    <th>Status Konfirmasi</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $artikel_dosen as $value )
                                        <tr>
                                        <th scope="row"> {{ $loop->iteration }}</th>
                                        <td>{{ $value->judul }}</td>
                                        <td>{{ $value->volume }}</td>
                                        <td>{{ $value->page }}</td>
                                        <td>{{ $value->issue }}</td>
                                        <td>{{ $value->publisher }}</td>
                                        <td>{{ $value->kategori_tingkat['nama_kategori']}}</td>
                                        <td>{{ $value->jumlah ?? '0'}}</td>
                                        <td>{{ $value->publikasi['jenis_publikasi']}}</td>
                                        <td>{{ $value->tahun }}</td>
                                        <td><a href="{{ asset('file/'.$value->softcopy) }}" target="_blank">Detail</a></td>
                                        <td>
                                            <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                                        </td>

                                        <td style="display: inline-flex;">
                                            <a href="{{ route('luaran.karya-ilmiah.edit-detail', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                <form class="d-inline" action="{{ route('luaran.karya-ilmiah.delete-detail', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
<!-- /page content -->

@stop
