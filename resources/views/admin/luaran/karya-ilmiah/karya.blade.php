@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Karya Ilmiah</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                {{-- <div class="x_panel">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{ route('luaran.karya-ilmiah.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div> --}}

                <div class="x_panel">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class=" " style="color: #778899" href="{{ route('luaran.karya-ilmiah.import.index') }}"> Import <i class="fa fa-long-arrow-down"></i></a></li>
                      &nbsp;
                      <li><a class="" style="color: #778899" href="{{ route('luaran.karya-ilmiah.create') }}"> Add New <i class="fa fa-plus"></i></a></li>
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
                                    <th>Link Google Scholar</th>
                                    <th>Detail</th>
                                    <th>Scraping</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ( $list_dosen as $value )
                                    <tr>
                                    <th scope="row"> {{ $loop->iteration }}</th>
                                    <td>{{ $value->nip}}</td>
                                    <td>{{ $value->nama_dosen}}</td>
                                    <td><a href="{{ $value->link_scholar}}" target="_blank">{{ $value->link_scholar ?? "-" }}</a></td>

                                    <td>
                                        <form action={{ route('luaran.karya-ilmiah.run') }} method="post">
                                            @csrf
                                            <input type="hidden"  name="link" value=" {{ $value->link_scholar ?? '-' }}">
                                            <input type="hidden"  name="dosen_id" value=" {{ $value->dosen_id ?? '-' }}">
                                            <button type="submit" class="btn btn-round btn-info btn-sm">scrap</button>
                                        </form>
                                    </td>

                                    <td><a href="{{ route('luaran.karya-ilmiah.detail', $value->dosen_id) }}">Detail</a></td>
                                    
                                    {{-- <td><a href="{{ route('luaran.karya-ilmiah.run') }}" class="btn btn-round btn-info btn-sm">Scrap</a></td> --}}
                                    
                                    <td style="display: inline-flex;">
                                    <a href="{{ route('luaran.karya-ilmiah.edit', $value->dosen_id) }}" class="btn btn-success btn-sm">Ubah</a>

                                    <a href="#" data-id="{{ $value->dosen_id }}" class="btn btn-danger btn-sm swal-confirm">
                                        <form class="d-inline" action="{{ route('luaran.karya-ilmiah.delete', $value->dosen_id) }}" id="delete{{ $value->dosen_id }}" method="post">
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

                    {{-- <div class="col-sm-12">
                        <div class="card-box table-responsive">
                        <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nip Dosen</th>
                                <th>Nama Dosen</th>
                                <th>Judul artikel yang disitasi (Jurnal, Volume, Tahun, Nomor, Halaman)</th>
                                <th>Kategori Tingkat Publikasi</th>
                                <th>Jumlah artikel yang Mensitasi</th>
                                <th>Jenis Publikasi</th>
                                <th>Tahun Publikasi</th>
                                <th>Status Konfirmasi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $artikel_dosen as $value )
                                <tr>
                                <th scope="row"> {{ $loop->iteration }}</th>
                                <td>{{ $value->dosen['nip']}}</td>
                                <td>{{ $value->dosen['nama_dosen']}}</td>
                                <td>{{ $value->judul }}</td>
                                <td>{{ $value->kategori_tingkat['nama_kategori']}}</td>
                                <td>{{ $value->jumlah }}</td>
                                <td>{{ $value->publikasi['jenis_publikasi']}}</td>
                                <td>{{ $value->tahun }}</td>
                                <td>
                                    <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                                </td>
                                <td style="display: inline-flex;">
                                <a href="{{ route('luaran.karya-ilmiah.edit', $value->id) }}" class="btn btn-success btn-sm">Edit</a>

                                <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                    <form class="d-inline" action="{{ route('luaran.karya-ilmiah.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
                                      @method('delete')
                                      @csrf
                                    </form>
                                Delete</a>
                                </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}


                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /page content -->

@stop
