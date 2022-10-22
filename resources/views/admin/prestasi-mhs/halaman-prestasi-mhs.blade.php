@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Prestasi Akademik dan Non Akademik Mahasiswa</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="" style="color: #778899" href="{{URL::to('export-prestasi-mhs')}}"> Download  <i class="fa fa-download"></i></a></li>
                          &nbsp;
                        <li><a class="" style="color: #778899" href="{{ route('mahasiswa.prestasi.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
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
                                    <th>Nama Kegiatan</th>
                                    <th>Waktu Penyelenggaraan/Tahun</th>
                                    <th>Tingkat</th>
                                    <th>Prestasi yang Dicapai</th>
                                    <th>Kategori Prestasi</th>
                                    <th>Bukti Prestasi</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ( $prestasi_mhs as $value )
                                    <tr>
                                    <th scope="row"> {{ $loop->iteration }}</th>
                                    <td>{{ $value->nama_kegiatan}}</td>
                                    <td>{{ $value->tahun }}</td>
                                    <td>{{ $value->nama_kategori }}</td>
                                    <td>{{ $value->prestasi }}</td>
                                    <td>{{ $value->jenis }}</td>
                                    <td><a href="{{ asset('file/'.$value->softcopy) }}" target="_blank">Detail</a></td>
                                    <td style="display: inline-flex;">
                                    <a href="{{ route('mahasiswa.prestasi.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                      <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                        <form class="d-inline" action="{{ route('mahasiswa.prestasi.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
</div>
</div>
<!-- /page content -->

@stop
