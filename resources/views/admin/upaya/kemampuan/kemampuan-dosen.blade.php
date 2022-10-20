@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Dosen Tugas Belajar</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{ route('upaya.tugas-belajar.create') }}"> Tambah <i class="fa fa-plus"></i></a>
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
                                    <th>Universitas Tugas Belajar</th>
                                    <th>Tempat</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>

                                <tbody>
                                @foreach ( $kemampuan_dosen as $value )
                                  <tr>
                                    <th scope="row"> {{ $loop->iteration }} </th>
                                    <td>{{ $value->nama_dosen }}</td>
                                    <td>{{ $value->bidang }}</td>
                                    <td>{{ $value->perguruan }}</td>
                                    <td>{{ $value->negara }}</td>
                                    <td>{{ $value->tahun }}</td>
                                    <td style="display: inline-flex;">
                                        <a href="{{ route('upaya.tugas-belajar.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                        <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                            <form class="d-inline" action="{{ route('upaya.tugas-belajar.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
