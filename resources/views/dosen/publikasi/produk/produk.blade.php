@extends('dosen.publikasi.main')
@section('data')

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="col-md-12 col-sm-12">
            <div class="x_title">
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6">
                <h5>Data Produk</h5>
            </div>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="" style="color: #778899" href="{{ route('publikasi.produk.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
            </ul>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">

                            <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Judul Penelitian dan Pengembangan Kepada Masyarakat</th>
                                        <th>Deskripsi</th>
                                        <th>Kesiapan</th>
                                        <th>Status Konfirmasi</th>
                                        <th>Batas Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $produk as $value )
                                    <tr>
                                        <th scope="row"> {{ $loop->iteration }} </th>
                                        <td>{{ $value->nama_produk }}</td>
                                        <td>{{ $value->judul_pkm }} </td>
                                        <td>{{ $value->deskripsi }}h</td>
                                        <td>{{ $value->kesiapan }}</td>
                                        <!-- <td>
                                            <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                                        </td> -->

                                        <td>
                                            <a href="#" data-id="{{ $value->id }}" class="btn btn-sm swal-confirm2 {{ $value->is_verification ? 'btn-success' : 'btn-danger' }}">
                                                <form class="d-inline" action="{{ route('publikasi.produk.confirm', $value->id) }}" id="confirm{{ $value->id }}" method="post">
                                                    @method('patch')
                                                    @csrf
                                                </form>
                                                {{ $value->is_verification ? 'Sudah' : 'Belum' }}
                                            </a>
                                        </td>

                                        <td class="countdown" data-create="{{ $value->tanggal_create }}" data-deadline="{{ $value->deadline }}"></td>

                                        <td style="display: inline-flex;">
                                            <a href="{{ route('publikasi.produk.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                <form class="d-inline" action="{{ route('publikasi.produk.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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