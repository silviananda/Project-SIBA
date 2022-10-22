@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Keterlibatan Mhs dalam Penelitian Dosen</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="" style="color: #778899" href="{{URL::to('export-penelitian-dosen')}}"> Download  <i class="fa fa-download"></i></a></li>
                            &nbsp;
                            <li><a class="" style="color: #778899" href="{{ route('penelitian.dosen.create') }}"> Tambah <i class="fa fa-plus"></i></a>
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
                                    <th>Nip Dosen</th>
                                    <th>Nama Dosen</th>
                                    <th>Tema Penelitian sesuai Roadmap</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Judul Kegiatan</th>
                                    <th>Sumber</th>
                                    <th>Jumlah Dana</th>
                                    <th>Tahun</th>
                                    <th>Bukti</th>
                                    <th>Status Konfirmasi</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $data_penelitian as $value )
                                        <tr>
                                            <th scope="row"> {{ $loop->iteration }} </th>
                                            <td>{{ $value->dosen['nip'] ?? '-'}}</td>
                                            <td>{{ $value->dosen['nama_dosen'] ?? '-'}}</td>
                                            <td>{{ $value->tema }}</td>
                                            <td>
                                                @foreach ($value->penelitianmhs as $item)
                                                    {{ $item->mahasiswa->nama ?? ''}} <hr>
                                                @endforeach
                                            </td>
                                            <td>{{ $value->judul_penelitian }}</td>
                                            <td>{{ $value->sumberdana['nama_sumber_dana'] ?? '-' }}</td>
                                            <td>{{ "Rp " . number_format($value->jumlah_dana,2,',','.' ?? '-')}}</td>
                                            <td>{{ $value->tahun_penelitian }}</td>
                                            <td><a href="{{ asset('file/'.$value->softcopy ) }}" target="_blank">Detail</a></td>
                                            <td>
                                                <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                                            </td>
                                            <td style="display: inline-flex;">
                                                <a href="{{ route('penelitian.dosen.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                                <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                    <form class="d-inline" action="{{ route('penelitian.dosen.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
