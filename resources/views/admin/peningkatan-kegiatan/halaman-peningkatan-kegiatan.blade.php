@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Daftar Kegiatan Pelatihan/Workshop</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{URL::to('export-kegiatan')}}"> Download  <i class="fa fa-download"></i></a></li>
                      &nbsp;
                      <li><a class="" style="color: #778899" href="{{ route('kegiatan-akademik.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
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
                            <th rowspan="2">Nip</th>
                            <th rowspan="2">Nama Dosen</th>
                            <th colspan="3">Kegiatan</th>
                            <th rowspan="2">Peran</th>
                            <th rowspan="2">Status Konfirmasi</th>
                            <th rowspan="2">Aksi</th>
                          </tr>
                          <tr>
                            <th colspan="1">Jenis Kegiatan</th>
                            <th colspan="1">Tempat</th>
                            <th colspan="1">Tanggal Kegiatan</th>
                          </tr>
                      </thead>
                      <tbody>
                      @foreach ( $kegiatan as $value )
                        <tr>
                          <th scope="row"> {{ $loop->iteration }}</th>
                          <td>{{ $value->nip }}</td>
                          <td>{{ $value->nama_dosen }}</td>
                          <td>{{ $value->jenis_kegiatan }}</td>
                          <td>{{ $value->tempat }}</td>
                          <td>{{ $value->waktu }}</td>
                          <td>{{ $value->peran }}</td>
                          <td>
                            <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                          </td>
                          <td style="display: inline-flex;">
                            <a href="{{ route('kegiatan-akademik.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                              <form class="d-inline" action="{{ route('kegiatan-akademik.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
