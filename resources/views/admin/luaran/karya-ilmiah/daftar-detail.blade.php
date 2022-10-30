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
                            <p><i>Data yang telah ada di database tidak dapat dipilih</i></p>
                            <form action={{ route('luaran.karya-ilmiah.submit') }} method="post">
                                            @csrf
                                            
                                <div class="card-box table-responsive">
                                <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Title</th>
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
                                    @foreach ( $dict_detail_title ?? '' as $row )
                                        <tr>
                                            @if (!$row->in_db)
                                                <td><input type="checkbox" name="artikel[{{ $loop->iteration }}]"></td>
                                            @else
                                                <td></td>
                                            @endif
                                            <th scope="row"> {{ $loop->iteration }}</th>
                                            <td><input type="hidden" name="nama[]" value="{{ $row->nama }}">{{ $row->nama }}</td>
                                            <td><input type="hidden" name="judul[]" value="{{ $row->judul }}">{{ $row->judul }}</td>
                                            <td><input type="hidden" name="tahun[]" value="{{ $row->tahun }}">{{ $row->tahun }}</td>
                                            <td><input type="hidden" name="doc_type[]" value="{{ $row->doc_type }}">{{ $row->doc_type }}</td>
                                            <td><input type="hidden" name="authors[]" value="{{ $row->authors }}">{{ $row->authors }}</td>
                                            <td><input type="hidden" name="name_of_doctype[]" value="{{ $row->name_of_doctype }}">{{ $row->name_of_doctype }}</td> 
                                            <td><input type="hidden" name="volume[]" value="{{ $row->volume }}">{{ $row->volume }}</td> 
                                            <td><input type="hidden" name="issue[]" value="{{ $row->issue }}">{{ $row->issue }}</td> 
                                            <td><input type="hidden" name="pages[]" value="{{ $row->pages }}">{{ $row->pages }}</td> 
                                            <td><input type="hidden" name="publisher[]" value="{{ $row->publisher }}">{{ $row->publisher }}</td> 
                                            <td><input type="hidden" name="description[]" value="{{ $row->description }}">{{ $row->description }}</td> 
                                            <td><input type="hidden" name="total_citation[]" value="{{ $row->total_citation }}">{{ $row->total_citation }}</td> 
                                        <tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <input type="hidden" name="dosen_id" value="{{ $dosen_id }}">
                                <button type="submit" class="btn btn-round btn-info btn-sm">SUBMIT</button>
                            </form>
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
