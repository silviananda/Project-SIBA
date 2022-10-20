@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Penelitian Mahasiswa</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="" style="color: #778899" href="{{URL::to('export-penelitian-mhs')}}"> Download  <i class="fa fa-download"></i></a></li>
                        &nbsp;
                      <li><a class="" href="{{ route('penelitian.mahasiswa.create') }}" style="color: #778899"> Tambah <i class="fa fa-plus"></i></a>
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
                                    <th>Sumber Dana</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $data_penelitian as $value )
                                        <tr>
                                            <th scope="row"> {{ $loop->iteration }} </th>
                                            <td>{{ $value->dosen['nip']}}</td>
                                            <td>{{ $value->dosen['nama_dosen']}}</td>
                                            <td>{{ $value->tema }}</td>
                                            <td>
                                                @foreach ($value->penelitianmagister as $item)
                                                    {{ $item->biodata_mhs->nama ?? ''}} <hr>
                                                @endforeach
                                            </td>
                                            <td>{{ $value->judul_penelitian }}</td>
                                            <td>{{ $value->sumberdana->nama_sumber_dana ?? '-' }}</td>
                                            <td>{{ $value->tahun_penelitian }}</td>
                                            
                                            <td style="display: inline-flex;">
                                                <a href="{{ route('penelitian.mahasiswa.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                                <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                    <form class="d-inline" action="{{ route('penelitian.mahasiswa.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
