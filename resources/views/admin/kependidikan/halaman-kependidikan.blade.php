@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Tenaga Kependidikan</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="" style="color: #778899" href="{{URL::to('export-kependidikan')}}"> Download  <i class="fa fa-download"></i></a></li>
                      &nbsp;
                      <li><a class="" style="color: #778899" href="{{ route('tenaga-kependidikan.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
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
                                    <th>NIP/NIPK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Unit Kerja</th>
                                    <th>Profesi</th>
                                    <th>Pendidikan Terakhir</th>
                                    <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach ( $tenaga_kependidikan as $value )
                                    <tr>
                                    <th scope="row"> {{ $loop->iteration }} </th>
                                    <td>{{ $value->nidn }}</td>
                                    <td>{{ $value->nama }}</td>
                                    <td>{{ $value->tgl_lahir }}</td>
                                    <td>{{ $value->alamat }}</td>
                                    <td>{{ $value->unit }}</td>
                                    <td>{{ $value->posisi }}</td>
                                    <td>{{ $value->nama_pendidikan }}</td>
                                    <td style="display: inline-flex;">
                                        <a href="{{ route('tenaga-kependidikan.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                        <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                            <form class="d-inline" action="{{ route('tenaga-kependidikan.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
