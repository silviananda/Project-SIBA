@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Kerjasama Tridharma</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{URL::to('export-kerjasama')}}"> Download  <i class="fa fa-download"></i></a></li>
                      &nbsp;
                      <li><a class="" style="color: #778899" href="{{ route('kerjasama.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
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
                                        <th>Lembaga Mitra</th>
                                        <th>Judul Kegiatan Kerjasama</th>
                                        <th>Tingkat</th>
                                        <th>Kategori Kerjasama</th>
                                        <th>Manfaat bagi PS yang diakreditasi</th>
                                        <th>Tingkat Kepuasan Pengguna</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Bukti Kerjasama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ( $kerjasama as $value )
                                        <tr>
                                            <th scope="row"> {{ $loop->iteration }} </th>
                                            <td> {{ $value->nama_instansi }} </td>
                                            <td> {{ $value->judul_kegiatan }} </td>
                                            <td> {{ $value->nama_kategori }} </td>
                                            <td> {{ $value->kategori }} </td>
                                            <td> {{ $value->manfaat ?? '-' }} </td>
                                            <td> {{ $value->kepuasan ?? '-' }} </td>
                                            <td> {{ $value->tanggal_kegiatan }} </td>
                                            <td><a href="{{ asset('file/'.$value->softcopy) }}" target="_blank">Detail</a></td>

                                            <td style="display: inline-flex;">
                                                <a href="{{ route('kerjasama.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                                <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                    <form class="d-inline" action="{{ route('kerjasama.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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