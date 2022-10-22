@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Data Prasarana Penunjang</h3>
              </div>
                <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{ route('prasarana.prasarana-lain.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">

                              <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                              <thead>
                                <th>No</th>
                                <th>Jenis Prasarana</th>
                                <th>Jumlah Unit</th>
                                <th>Total Luas (m2)</th>
                                <th>Kepemilikan</th>
                                <th>Kondisi</th>
                                <th>Unit Pengelola</th>
                                <th>Aksi</th>
                              </thead>

                              <tbody>
                              @foreach ( $data_prasarana_lain as $value )
                                <tr>
                                  <th scope="row"> {{ $loop->iteration }}</th>
                                  <td>{{ $value->jenis_prasarana }}</td>
                                  <td>{{ $value->jumlah_unit }}</td>
                                  <td>{{ $value->total_luas }}</td>
                                  <td>{{ $value->jenis }}</td>
                                  <td>{{ $value->kondisi }}</td>
                                  <td>{{ $value->unit_pengelola }}</td>
                                  <td style="display: inline-flex;">
                                      <a href="{{ route('prasarana.prasarana-lain.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                      <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                        <form class="d-inline" action="{{ route('prasarana.prasarana-lain.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
