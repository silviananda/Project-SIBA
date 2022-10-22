@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Prestasi Dosen</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{ route('upaya.prestasi.create') }}"> Tambah <i class="fa fa-plus"></i></a>
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
                                    <th>Nip</th>
                                    <th>Nama Dosen</th>
                                    <th>Prestasi</th>
                                    <th>Tingkat</th>
                                    <th>Tahun</th>
                                    <th>Bukti Prestasi</th>
                                    <th>Status Konfirmasi</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>

                                <tbody>
                                @foreach ( $prestasi_dosen as $value )
                                  <tr>
                                    <th scope="row"> {{ $loop->iteration }} </th>
                                    <td>{{ $value->nip }}</td>
                                    <td>{{ $value->nama_dosen }}</td>
                                    <td>{{ $value->judul_prestasi }}</td>
                                    <td>{{ $value->nama_kategori }}</td>
                                    <td>{{ $value->tahun }}</td>
                                    <td><a href="{{ asset('file/'.$value->softcopy) }}" target="_blank">Detail</a></td>

                                    <td>
                                        <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                                    </td>
                                    <td style="display: inline-flex;">
                                        <a href="{{ route('upaya.prestasi.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                        <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                            <form class="d-inline" action="{{ route('upaya.prestasi.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
