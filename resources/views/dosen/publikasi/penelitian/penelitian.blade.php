@extends('dosen.publikasi.main')
@section('data')

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="col-md-12 col-sm-12">
            <div class="x_title">
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6">
                <h5>Keterlibatan Mhs dalam Penelitian Dosen</h5>
            </div>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="" style="color: #778899" href="{{ route('publikasi.penelitian.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
            </ul>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">

                            <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dosen</th>
                                        <th>Tema Penelitian sesuai Roadmap</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Judul Penelitian</th>
                                        <th>Sumber</th>
                                        <th>Jumlah Dana</th>
                                        <th>Tahun</th>
                                        <th>Bukti</th>
                                        <th>Status Konfirmasi</th>
                                        <th>Batas Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $data_penelitian as $value )
                                    <tr>
                                        <th scope="row"> {{ $loop->iteration }} </th>
                                        <td>{{ $value->dosen['nama_dosen']}}</td>
                                        <td>{{ $value->tema }}</td>
                                        <td>
                                            @foreach ($value->penelitianmhs as $item)
                                            {{ $item->mahasiswa->nama ?? ''}}
                                            <hr>
                                            @endforeach
                                        </td>
                                        <td>{{ $value->judul_penelitian }}</td>
                                        <td>{{ $value->sumberdana['nama_sumber_dana'] ?? '-' }}</td>
                                        <td>{{ "Rp " . number_format($value->jumlah_dana,2,',','.' ?? '-')}}</td>
                                        <td>{{ $value->tahun_penelitian }}</td>
                                        <td><a href="{{ asset('file/'.$value->softcopy ) }}" target="_blank">Detail</a></td>
                                        <!-- <td>
                                            <div class="btn btn-sm {{ $value->is_verification ? 'btn-success' : 'btn-danger' }} ">{{ $value->is_verification ? 'Sudah' : 'Belum' }}</div>
                                        </td> -->

                                        <td>
                                            <a href="#" data-id="{{ $value->id }}" class="btn btn-sm swal-confirm2 {{ $value->is_verification ? 'btn-success' : 'btn-danger' }}">
                                                <form class="d-inline" action="{{ route('publikasi.penelitian.confirm', $value->id) }}" id="confirm{{ $value->id }}" method="post">
                                                    @method('patch')
                                                    @csrf
                                                </form>
                                                {{ $value->is_verification ? 'Sudah' : 'Belum' }}
                                            </a>
                                        </td>

                                        <td class="countdown" data-create="{{ $value->tanggal_create }}" data-deadline="{{ $value->deadline }}"></td>

                                        <td style="display: inline-flex;">
                                            <a href="{{ route('publikasi.penelitian.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                <form class="d-inline" action="{{ route('publikasi.penelitian.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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