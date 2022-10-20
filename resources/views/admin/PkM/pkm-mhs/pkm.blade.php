@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Data Pengabdian Kepada Masyarakat Oleh Mahasiswa</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      &nbsp;
                      <li><a class="" style="color: #778899" href="{{ route('pkm.mhs.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
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
                                        <th>Nip Dosen</th>
                                        <th>Nama Dosen</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Tema Pkm sesuai Roadmap</th>
                                        <th>Judul Kegiatan</th>
                                        <th>Sumber Dana</th>
                                        <th>Jumlah Dana</th>
                                        <th>Tahun</th>
                                        <th>Dokumentasi</th>
                                        <th>Aksi</th>
                                      </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $data_pkm as $value)
                                    <tr>
                                        <th scope="row"> {{ $loop->iteration }}</th>
                                        <td>{{ $value->dosen['nip'] }}</td>
                                        <td>{{ $value->dosen['nama_dosen'] }}</td>
                                        <td>{{ $value->biodata_mhs['nama'] }}</td>
                                        <td>{{ $value->tema }}</td>
                                        <td>{{ $value->judul_pkm }}</td>
                                        <td>{{ $value->sumberdana['nama_sumber_dana'] ?? '-' }}</td>
                                        <td>{{ "Rp " . number_format($value->jumlah_dana,2,',','.' ?? '-') }}</td>
                                        <td>{{ $value->tahun }}</td>
                                        <td><a href="{{ asset('file/'.$value->softcopy ) }}" target="_blank">Detail</a></td>
                                        <td style="display: inline-flex;">
                                            <a href="{{ route('pkm.mhs.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                <form class="d-inline" action="{{ route('pkm.mhs.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
<!-- /page content -->

@stop
