@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Struktur Kurikulum</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="" style="color: #778899" onclick="importAction('kurikulum')"> Import <i class="fa fa-arrow-down"></i></a>
                        </li>
                      &nbsp;
                      <li><a class="" style="color: #778899" href="{{ route('kurikulum.struktur.create') }}"> Tambah <i class="fa fa-plus"></i></a>
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
                                <th rowspan="2">No</th>
                                <th rowspan="2">Semester</th>
                                <th rowspan="2">Kode Mata Kuliah</th>
                                <th rowspan="2">Nama Mata Kuliah</th>
                                <th rowspan="2">Bobot Sks</th>
                                <th rowspan="2">Bobot Tugas</th>
                                <th rowspan="2">Bobot Seminar</th>
                                <th rowspan="2">Bobot Praktikum</th>
                                <th colspan="2">Kelengkapan</th>
                                <th rowspan="2">Unit/ Jur/ Fak Penyelenggara</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th colspan="1">Silabus</th>
                                <th colspan="1">RPS</th>
                            </tr>
                      </thead>

                      <tbody>
                      @foreach ( $kurikulum as $value )
                        <tr>
                          <th scope="row"> {{ $loop->iteration }}</th>
                          <td>{{ $value->nama_semester }}</td>
                          <td>{{ $value->kode_mk }}</td>
                          <td>{{ $value->nama_mk }}</td>
                          <td>{{ $value->bobot_sks }}</td>
                          <td>{{ $value->bobot_tugas }}</td>
                          <td>{{ $value->sks_seminar }}</td>
                          <td>{{ $value->sks_praktikum ?? '0' }}</td>
                          <td><a href="{{ asset('file/'.$value->silabus) }}" target="_blank">Detail</a></td>
                          <td><a href="{{ asset('file/'.$value->rps) }}" target="_blank">Detail</a></td>
                          <td>{{ $value->unit }}</td>
                          <td style="display: inline-flex;">
                            <a href="{{ route('kurikulum.struktur.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                <form class="d-inline" action="{{ route('kurikulum.struktur.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
