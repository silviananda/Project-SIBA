@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Capaian Pembelajaran</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="" style="color: #778899" href="{{URL::to('export-capaian')}}"> Download  <i class="fa fa-download"></i></a></li>
                        &nbsp;
                      <li><a class="" style="color: #778899" href="{{ route('capaian.create') }}"> Tambah <i class="fa fa-plus"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="row">

                        <div class="col-sm-12">
                            <!-- <div class="card-box table-responsive"> -->

                            <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Tahun Lulus</th>
                                    <th rowspan="2">Jumlah Lulusan</th>
                                    <th colspan="3">Indeks Prestasi Kumulatif (IPK)</th>
                                    <th rowspan="2">Aksi</th>
                                </tr>
                                <tr>
                                    <th colspan="1">Min.</th>
                                    <th colspan="1">Rata-rata</th>
                                    <th colspan="1">Maks.</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $capaian as $value )
                                        <tr>
                                        <th scope="row"> {{ $loop->iteration }}</th>
                                        <td>{{ $value->tahun }}</td>
                                        <td>{{ $value->jumlah }}</td>
                                        <td>{{ $value->minimum }}</td>
                                        <td>{{ $value->rata }}</td>
                                        <td>{{ $value->maksimum }}</td>
                                        <td style="display: inline-flex;">
                                            <a href="{{ route('capaian.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                            <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                            <form class="d-inline" action="{{ route('capaian.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
