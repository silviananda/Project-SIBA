@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Data Rekapitulasi Pengabdian Kepada Masyarakat</h3>
            </div>

            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                    <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      &nbsp;
                      {{-- <li><a class="" style="color: #778899" href="{{ route('pkm.data.create') }}"> Add New <i class="fa fa-plus"></i></a></li> --}}
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
                                    <th rowspan="2">Tahun PkM</th>
                                    <th colspan="5">Jumlah Judul/Sumber Pembiayaan</th>
                                </tr>
                                <tr>
                                    <th colspan="1">Pembiayaan Mandiri</th>
                                    <th colspan="1">PT Sendiri</th>
                                    <th colspan="1">Direktorat Riset dan Pengabdian Kepada Masyarakat Dikti</th>
                                    <th colspan="1">Institusi Luar Negri</th>
                                    <th colspan="1">Institusi Dalam Negri diluar Kemendikbudristek</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tahun as $t)
                                        <tr>
                                        <th scope="row"> {{ $loop->iteration }}</th>
                                            <td>{{ $t }}</td>
                                            @foreach ($sumber as $value)
                                                    <?php
                                                        $jumlah1 = App\Models\Admin\DataPkm::where('tahun', $t)->where('sumber_dana_id', '1')->count();
                                                    ?>
                                            @endforeach
                                            <td>{{ $jumlah1 }}</td>

                                            @foreach ($sumber as $value)
                                                    <?php
                                                        $jumlah2 = App\Models\Admin\DataPkm::where('tahun', $t)->where('sumber_dana_id', '2')->count();
                                                    ?>
                                            @endforeach
                                            <td>{{ $jumlah2 }}</td>

                                            @foreach ($sumber as $value)
                                                    <?php
                                                        $jumlah3 = App\Models\Admin\DataPkm::where('tahun', $t)->where('sumber_dana_id', '3')->count();
                                                    ?>
                                            @endforeach
                                            <td>{{ $jumlah3 }}</td>

                                            @foreach ($sumber as $value)
                                                    <?php
                                                        $jumlah4 = App\Models\Admin\DataPkm::where('tahun', $t)->where('sumber_dana_id', '4')->count();
                                                    ?>
                                            @endforeach
                                            <td>{{ $jumlah4 }}</td>

                                            @foreach ($sumber as $value)
                                                    <?php
                                                        $jumlah5 = App\Models\Admin\DataPkm::where('tahun', $t)->where('sumber_dana_id', '5')->count();
                                                    ?>
                                            @endforeach
                                            <td>{{ $jumlah5 }}</td>
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
<!-- /page content -->

@stop
