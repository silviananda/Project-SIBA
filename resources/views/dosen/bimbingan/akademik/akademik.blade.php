@extends('dosen.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Bimbingan Akademik</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        
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
                                                <th>NPM</th>
                                                <th>Nama Mahasiswa</th>
                                                <th>Email</th>
                                                <th>Tahun Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ( $data_pembimbing_akademik as $value )
                                            <tr>
                                                <th scope="row"> {{ $loop->iteration }}</th>
                                                <td>{{ $value->npm }}</td>
                                                <td>{{ $value->nama }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>{{ date('Y', strtotime($value->tahun_masuk)) }}</td>
                                                
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