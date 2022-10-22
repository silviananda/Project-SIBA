@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Biodata Dosen Tidak Tetap</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      @if(request('withtrash') == 1)
                      <li><a class="" style="color: #778899" href="{{ route('dosen.tidak-tetap.biodata.index') }}"> Kembali <i class="fa fa-mail-reply"></i></a>
                        </li>
                      &nbsp;
                        @else
                        <li><a class="" style="color: #778899" href="{{ route('dosen.tidak-tetap.biodata.index', ['withtrash' => 1]) }}"> Tidak Aktif <i class="fa fa-trash"></i></a>
                        </li>
                      &nbsp;
                        @endif
                      <li><a class="" style="color: #778899" href="{{ route('dosen.tidak-tetap.biodata.create') }}"> Tambah <i class="fa fa-plus"></i></a>
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
                                    <th>NIDN</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>TTL</th>
                                    <th>Tempat Tinggal</th>
                                    <th>Pendidikan</th>
                                    <th>Bidang</th>
                                    <th>Jabatan</th>
                                    <th>Golongan</th>
                                    <th>Email</th>
                                    <th>Sertifikasi</th>
                                    <th>Sinta</th>
                                    <th>WOS</th>
                                    <th>Scopus</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>

                                <tbody>
                                  @foreach ( $dosen as $value )
                                  <tr>
                                    <th scope="row"> {{ $loop->iteration }} </th>
                                    <td>{{ $value->nidn ?? '0' }}</td>
                                    <td>{{ $value->nip }}</td>
                                    <td>{{ $value->nama_dosen }}</td>
                                    <td>{{ $value->tgl_lahir ??'-'}}</td>
                                    <td>{{ $value->tempat ??'-'}}</td>
                                    <td>{{ $value->kategori_pendidikan['pendidikan'] ??'-'}}</td>
                                    <td>{{ $value->bidang ??'-'}}</td>
                                    <td>{{ $value->jabatan_fungsional['nama_jabatan'] ??'-'}}</td>
                                    <td>{{ $value->golongan ??'-'}}</td>
                                    <td>{{ $value->email ??'-'}}</td>
                                    <td>{{ $value->sertifikasi ??'-'}}</td>
                                    <td>{{ $value->sinta ??'-'}}</td>
                                    <td>{{ $value->wos ??'-'}}</td>
                                    <td>{{ $value->scopus ??'-'}}</td>
                                    <td style="display: inline-flex;">
                                    @if(request('withtrash') != 1)
                                        <a href="{{ route('dosen.tidak-tetap.biodata.edit', $value->dosen_id) }}" class="btn btn-success btn-sm" style="width: 60%;">Ubah</a>

                                        <a href="#" data-id="{{ $value->dosen_id }}" class="btn btn-danger btn-sm swal-confirm-delete-dosen">
                                            <form class="d-inline" action="{{ route('dosen.tidak-tetap.biodata.delete', $value->dosen_id) }}" id="delete{{ $value->dosen_id }}" method="post">
                                              @method('delete')
                                              @csrf
                                            </form>
                                        Hapus</a>
                                    </td>
                                    @else
                                      <a href="#" data-id="{{ $value->dosen_id }}" class="btn btn-danger btn-sm swal-confirm-restore">
                                          <form class="d-inline" action="{{ route('dosen.tidak-tetap.biodata.delete', $value->dosen_id) }}" id="restore{{ $value->dosen_id }}" method="post">
                                              @method('delete')
                                              @csrf
                                          </form>
                                        Pulihkan</a>
                                    @endif
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
<!-- page content -->

@stop
