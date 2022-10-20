@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Mata Kuliah Pilihan</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="" style="color: #778899" href="{{ route('kurikulum.mk-pilihan.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
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
                            <th>Semester</th>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Bobot sks</th>
                            <th>Bobot Tugas</th>
                            <th>Unit/ Jur/ Fak Pengelola</th>
                            <th>Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach ( $mk_pilihan as $value )
                        <tr>
                          <th scope="row"> {{ $loop->iteration }}</th>
                          <td>{{ $value->nama_semester }}</td>
                          <td>{{ $value->kode_mk }}</td>
                          <td>{{ $value->nama }}</td>
                          <td>{{ $value->bobot_sks }}</td>
                          <td>{{ $value->bobot_tugas ?? '0' }}</td>
                          <td>{{ $value->unit ?? '-'}}</td>
                          <td style="display: inline-flex;">
                            <a href="{{ route('kurikulum.mk-pilihan.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                              <form class="d-inline" action="{{ route('kurikulum.mk-pilihan.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
