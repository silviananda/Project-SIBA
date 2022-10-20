@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Data Pendaftar</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{ route('mahasiswa.daftar.create') }}"> Tambah <i class="fa fa-plus"></i></a>
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
                          <th>No Ujian</th>
                          <th>Nama</th>
                          <th>Asal Sekolah</th>
                          <th>Jalur Masuk</th>
                          <th>Tahun Masuk</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach ( $pendaftar as $value )
                        <tr>
                          <th scope="row"> {{ $loop->iteration }} </th>
                          <td>{{ $value->no_ujian }}</td>
                          <td>{{ $value->nama }}</td>
                          <td>{{ $value->asal_sekolah }}</td>
                          <td>{{ $value->jalur_masuk }}</td>
                          <td>{{ $value->tahun_masuk }}</td>
                          <td style="display: inline-flex;">
                              <a href="{{ route('mahasiswa.daftar.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                              <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                <form class="d-inline" action="{{ route('mahasiswa.daftar.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
