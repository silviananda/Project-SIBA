@extends('dosen.publikasi.main')
@section('data')

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_title">
        <div class="clearfix"></div>
      </div>

      <div class="col-md-6 col-sm-6">
        <h5>Data Artikel</h5>
      </div>

      <ul class="nav navbar-right panel_toolbox">
        <li><a class="" style="color: #778899" href="{{ route('publikasi.artikel.create') }}"> Tambah <i class="fa fa-plus"></i></a>
        </li>
      </ul>

      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">

              <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Judul Artikel</th>
                    <th>Jenis artikel</th>
                    <th>Judul Penelitian dan Pengembangan Kepada Masyarakat</th>
                    <th>Jumlah artikel yang Mensitasi</th>
                    <th>Tahun Terbit</th>
                    <th>Bukti</th>
                    <th>Status Konfirmasi</th>
                    <th>Batas Verifikasi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $artikel_dosen as $value)
                  <tr>
                    <th scope="row"> {{ $loop->iteration }}</th>
                    <td> {{ $value->judul }} </td>
                    <td> {{ $value->nama_kategori }} </td>
                    <td> {{ $value->data_pkm['judul_pkm'] }} </td>
                    <td> {{ $value->jumlah }} </td>
                    <td> {{ $value->tahun }} </td>
                    <td><a href="{{ asset('file/'.$value->softcopy) }}" target="_blank">Detail</a></td>
                    <!-- <td>
                      <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                    </td> -->

                    <td>
                      <a href="#" data-id="{{ $value->id }}" class="btn btn-sm swal-confirm2 {{ $value->is_verification ? 'btn-success' : 'btn-danger' }}">
                        <form class="d-inline" action="{{ route('publikasi.artikel.confirm', $value->id) }}" id="confirm{{ $value->id }}" method="post">
                          @method('patch')
                          @csrf
                        </form>
                        {{ $value->is_verification ? 'Sudah' : 'Belum' }}
                      </a>
                    </td>

                    <td class="countdown" data-create="{{ $value->tanggal_create }}" data-deadline="{{ $value->deadline }}"></td>

                    <td style="display: inline-flex;">
                      <a href="{{ route('publikasi.artikel.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                      <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                        <form class="d-inline" action="{{ route('publikasi.artikel.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
@stop