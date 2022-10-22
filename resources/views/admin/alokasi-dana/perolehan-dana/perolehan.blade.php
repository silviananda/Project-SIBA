@extends('admin.layout.main')
@section('content')

<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Perolehan Dana</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{ route('alokasi-dana.perolehan.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
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
                                <th>Sumber Dana</th>
                                <th>Jenis Dana</th>
                                <th>Jumlah Dana</th>
                                <th>Tahun</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>

                            <tbody>
                              @foreach ( $jenis_dana as $value )
                                <tr>
                                  <th scope="row"> {{ $loop->iteration }} </th>
                                  <td>{{ $value->nama_sumber_dana }}</td>
                                  <td>{{ $value->nama_jenis_dana }}</td>
                                  <td>{{ "Rp " . number_format($value->jumlah_dana,2,',','.') }}</td>
                                  <td>{{ $value->tahun }}</td>
                                  <td style="display: inline-flex;">
                                      <a href="{{ route('alokasi-dana.perolehan.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                      <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                        <form class="d-inline" action="{{ route('alokasi-dana.perolehan.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
