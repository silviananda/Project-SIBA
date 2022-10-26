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
                                    <th>Name</th>
                                    <th>Publication Date</th>
                                    <th>Document Type</th>
                                    <th>Authors</th>
                                    <th>Name of Document Type</th>
                                    <th>Volume</th>
                                    <th>Issue</th>
                                    <th>Pages</th>
                                    <th>Publisher</th>
                                    <th>Description</th>
                                    <th>Total Citations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ( $dict_detail_title as $row )
                                    <tr>
                                        <th scope="row"> {{ $loop->iteration }}</th>
                                        
                                        @foreach ($row as $key => $val)
                                            <td>
                                            @if (is_array($val))
                                                @foreach($val as $v)
                                                    {{ $v }}
                                                @endforeach
                                            @else
                                                {{ $val }}
                                            @endif
                                            </td>
                                        @endforeach
                                    <tr>
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
                            @foreach ( $artikel_dosen as $value ?? '' )
                                <tr>
                                <th scope="row"> {{ $loop->iteration }}</th>
                                <td>{{ $value ?? ''->dosen['nip']}}</td>
                                <td>{{ $value ?? ''->dosen['nama_dosen']}}</td>
                                <td>{{ $value ?? ''->judul }}</td>
                                <td>{{ $value ?? ''->kategori_tingkat['nama_kategori']}}</td>
                                <td>{{ $value ?? ''->jumlah }}</td>
                                <td>{{ $value ?? ''->publikasi['jenis_publikasi']}}</td>
                                <td>{{ $value ?? ''->tahun }}</td>
                                <td>
                                    <div class="btn btn-sm {{ $value ?? ''->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value ?? ''->is_verification ? 'Sudah' : 'Belum' }}</div>
                                </td>
                                <td style="display: inline-flex;">
                                <a href="{{ route('luaran.karya-ilmiah.edit', $value ?? ''->id) }}" class="btn btn-success btn-sm">Edit</a>

                                <a href="#" data-id="{{ $value ?? ''->id }}" class="btn btn-danger btn-sm swal-confirm">
                                    <form class="d-inline" action="{{ route('luaran.karya-ilmiah.delete', $value ?? ''->id) }}" id="delete{{ $value ?? ''->id }}" method="post">
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
