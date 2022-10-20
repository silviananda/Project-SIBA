@extends('dosen.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Aktivitas Dosen</h3>
      </div>

      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
          <div class="x_title">
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="" style="color: #778899" href="{{ route('aktivitas.create') }}"> Tambah <i class="fa fa-plus"></i></a>
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
                        <th>NIP</th>
                        <th>Nama Dosen</th>
                        <th>Nama Matakuliah</th>
                        <th>Jumlah Sks</th>
                        <th>Keterangan Matakuliah</th>
                        <th>Sks Penelitian</th>
                        <th>Sks Pengabdian</th>
                        <th>Sks Tugas Tambahan dan/atau Penunjang</th>
                        <th>Tahun</th>
                        <th>Status Konfirmasi</th>
                        <th>Batas Verifikasi</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ( $aktivitas as $value )
                      <tr>
                        <th scope="row"> {{ $loop->iteration }} </th>
                        <td>{{ $value->dosen['nip'] }}</td>
                        <td>{{ $value->dosen['nama_dosen'] }}</td>
                        <td>
                          @foreach ($value->aktivitas_dosen as $item)
                          {{ $item->kurikulum->nama_mk ?? '-' }}
                          <hr>
                          @endforeach
                        </td>
                        <td>
                          @foreach ($value->aktivitas_dosen as $item)
                          {{ $item->kurikulum->bobot_sks ?? '-' }}
                          <hr>
                          @endforeach
                        </td>
                        <td>
                          @foreach ($value->aktivitas_dosen as $item1)
                          {{ $item1->ket ?? '-' }}
                          <hr>
                          @endforeach
                        </td>

                        <td>{{ $value->sks_penelitian }}</td>
                        <td>{{ $value->sks_p2m }}</td>
                        <td>{{ $value->m_pt_sendiri }}</td>
                        <td>{{ $value->tahun }}</td>
                        <!-- <td>
                          <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                        </td> -->

                        <td>
                          <a href="#" data-id="{{ $value->id }}" class="btn btn-sm swal-confirm2 {{ $value->is_verification ? 'btn-success' : 'btn-danger' }}">
                            <form class="d-inline" action="{{ route('aktivitas.confirm', $value->id) }}" id="confirm{{ $value->id }}" method="post">
                              @method('patch')
                              @csrf
                            </form>
                            {{ $value->is_verification ? 'Sudah' : 'Belum' }}
                          </a>
                        </td>

                        <td class="countdown" data-create="{{ $value->tanggal_create }}" data-deadline="{{ $value->deadline }}"></td>

                        <div>
                          <td style="display: inline-flex;">
                            <a href="{{ route('aktivitas.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                              <form class="d-inline" action="{{ route('aktivitas.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
                                @method('delete')
                                @csrf
                              </form>
                              Hapus
                            </a>
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