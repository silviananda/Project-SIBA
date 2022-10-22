@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Substansi Praktikum/Praktek</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="" style="color: #778899" href="{{ route('kurikulum.praktikum.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
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
                              <th rowspan="2">No</th>
                              <th rowspan="2">Nama Praktikum/Praktek</th>
                              <th colspan="2">Isi Praktikum/Praktek</th>
                              <th rowspan="2">Tempat/Lokasi Praktikum/Praktek</th>
                              <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                              <th colspan="1">Judul/Modul</th>
                              <th colspan="1">Jam Pelaksanaan</th>
                            </tr>
                          </thead>

                          <tbody>
                          @foreach ( $praktikum as $value )
                            <tr>
                              <th scope="row"> {{ $loop->iteration }}</th>
                              <td>{{ $value->nama_mk }}</td>
                              <td>{{ $value->judul }}</td>
                              <td>{{ $value->jam }}</td>
                              <td>{{ $value->tempat ?? '-' }}</td>
                              <td style="display: inline-flex;">
                                <a href="{{ route('kurikulum.praktikum.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                  <form class="d-inline" action="{{ route('kurikulum.praktikum.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
