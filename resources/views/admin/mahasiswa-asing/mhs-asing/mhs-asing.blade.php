@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Mahasiswa Asing</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                     @if(request('withtrash') == 1)
                        <li><a class="" style="color: #778899" href="{{ route('mahasiswa-asing.biodata.index') }}"> Kembali <i class="fa fa-mail-reply"></i></a>
                          </li>
                        &nbsp;
                        @else
                        <li><a class="" style="color: #778899" href="{{ route('mahasiswa-asing.biodata.index', ['withtrash' => 1]) }}"> Tidak Aktif <i class="fa fa-trash"></i></a>
                          </li>
                        &nbsp;
                        @endif
                        <li><a class="" style="color: #778899" href="{{URL::to('export-mhs-asing')}}"> Download   <i class="fa fa-download"></i></a></li>
                            &nbsp;
                        <li><a class="" style="color: #778899" href="{{ route('mahasiswa-asing.biodata.create') }}"> Tambah <i class="fa fa-plus"></i></a>
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
                                    <th>NPM</th>
                                    <th>Nama</th>
                                    <th>Tahun Masuk</th>
                                    <th>Email</th>
                                    <th>Dosen Wali</th>
                                    <th>Jalur Masuk</th>
                                    <th>Tanggal Update</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                  </tr>
                              </thead>

                                <tbody>
                                @foreach ( $mhs_asing as $value )
                                  <tr>
                                    <th scope="row"> {{ $loop->iteration }} </th>
                                    <td>{{ $value->npm }}</td>
                                    <td>{{ $value->nama }}</td>
                                    <td>{{ date('Y', strtotime($value->tahun_masuk)) }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->dosen['nama_dosen'] ?? '-' }}</td>
                                    <td>{{ $value->kategori_jalur['jalur_masuk'] }}</td>
                                    <td>{{ $value->updated_at }}</td>

                                    @if(request('withtrash') != 1)
                                    <td><a href="{{ route('mahasiswa-asing.biodata.detail', $value->id) }}">Detail</a></td>
                                    <td style="display: inline-flex;">
                                      <a href="{{ route('mahasiswa-asing.biodata.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                          <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm-delete-dosen">
                                            <form class="d-inline" action="{{ route('mahasiswa-asing.biodata.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
                                                @method('delete')
                                                @csrf
                                            </form>
                                          Hapus</a>
                                    </td>
                                    @else
                                    <td><a href="{{ route('mahasiswa-asing.biodata.detail', $value->id) }}">Detail</a></td>
                                    <td>
                                     <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm-restore">
                                          <form class="d-inline" action="{{ route('mahasiswa-asing.biodata.delete', $value->id) }}" id="restore{{ $value->id }}" method="post">
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
<!-- /page content -->

@stop
