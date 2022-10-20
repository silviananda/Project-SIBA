@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Rekognisi Dosen</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="" style="color: #778899" href="{{ route('upaya.rekognisi.create') }}"> Tambah <i class="fa fa-plus"></i></a>
                      </li>
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
                          <th>Nama Dosen</th>
                          <th>Bidang Keahlian</th>
                          <th>Rekognisi</th>
                          <th>Tahun</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ( $rekognisi as $value )
                        <tr>
                          <th scope="row"> {{ $loop->iteration }} </th>
                          <td>{{ $value->nama_dosen }}</td>
                          <td>{{ $value->bidang_keahlian }}</td>
                          <td>{{ $value->rekognisi }}</td>
                          <td>{{ $value->tahun }}</td>
                          <td style="display: inline-flex;">
                              <a href="{{ route('upaya.rekognisi.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                              <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                <form class="d-inline" action="{{ route('upaya.rekognisi.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
