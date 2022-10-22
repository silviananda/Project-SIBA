@extends('admin.layout.main')
@section('content')

  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Masa Studi Lulusan</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="" style="color: #778899" href="{{URL::to('export-efektivitas')}}"> Download  <i class="fa fa-download"></i></a></li>
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
                                        <th>NPM</th>
                                        <th>Nama</th>
                                        <th>Tahun Masuk</th>
                                        <th>Tahun Lulus</th>
                                        <th>Masa Studi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach ( $efektivitas as $value )
                                        <tr>
                                            <th scope="row"> {{ $loop->iteration }} </th>
                                            <td>{{ $value->npm }}</td>
                                            <td>{{ $value->nama }}</td>
                                            <td>{{ $value->tahun_masuk != null ? date('Y', strtotime($value->tahun_masuk)) : '-' }}</td>
                                            <td>{{ $value->tahun_lulus != null ? date('Y', strtotime($value->tahun_lulus)) : '-' }}</td>

                                            <?php
                                                $avg = 0;
                                                $sum = 0;

                                                $coba1 = json_decode(json_encode($value), true);

                                                $date1 = new \DateTime($coba1['tahun_masuk']);
                                                $date2 = new \DateTime($coba1['tahun_lulus']);

                                                $diff  = $date1->diff($date2);
                                                $interval =  $diff->format("%a");

                                                $sum += $interval;

                                                $years = ($interval / 365);
                                                $years = floor($years);

                                                $month = ($interval % 365) / 30.5;
                                                $month = floor($month);
                                            ?>

                                            <td>
                                            {{ $years . ' Tahun , ' . $month . ' Bulan ' }}
                                            </td>

                                            <td style="display: inline-flex;">
                                                <a href="{{ route('efektivitas.pendidikan.edit', $value->id) }}" class="btn btn-success btn-sm">Ubah</a>

                                                <a href="#" data-id="{{ $value->id }}" class="btn btn-danger btn-sm swal-confirm">
                                                    <form class="d-inline" action="{{ route('efektivitas.pendidikan.delete', $value->id) }}" id="delete{{ $value->id }}" method="post">
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
    </div>
</div>

@stop
