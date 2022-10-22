@extends('admin.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Pembimbing Tugas Akhir</h3>
      </div>

      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <ul class="nav navbar-right panel_toolbox">
              {{-- <li><a class="" style="color: #778899" href="{{ route('pembimbing.ta.create') }}"> Add New <i class="fa fa-plus"></i></a></li> --}}
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
                        <td rowspan="3">No</td>
                        <td rowspan="3">Nama</td>
                        <td>Ps Akreditasi</td>
                        <td>Ps Lain</td>
                        <td>Tahun</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($pembimbingTa as $dosen)
                      <tr>
                        <th rowspan="3"> {{ $loop->iteration }}</th>
                        <td rowspan="3">{{ $dosen->nama_dosen }}</td>
                          <?php
                          $totalBimbinganPsSendiri = App\Models\Admin\PembimbingTa::where('jenis_id1', 1)->where('tahun', $tahun[0])->where('doping1', $dosen->dosen_id)->orWhere(function ($query) use ($dosen, $tahun) {
                            $query->where('doping2', $dosen->dosen_id)->where('jenis_id2', 1)->where('tahun', $tahun[0]);
                          })->count();
                          ?>
                        <td>{{$totalBimbinganPsSendiri}}</td>
                          <?php
                          $totalBimbinganPsLain = App\Models\Admin\PembimbingTa::where('jenis_id1', 2)->where('tahun', $tahun[0])->where('doping1', $dosen->dosen_id)->orWhere(function ($query) use ($dosen, $tahun) {
                            $query->where('doping2', $dosen->dosen_id)->where('jenis_id2', 2)->where('tahun', $tahun[0]);
                          })->count();
                          ?>
                        <td>{{$totalBimbinganPsLain}}</td>
                        <td>{{ $tahun[0] }}</td>
                      </tr>
                      @foreach($tahun as $t)
                      @if($loop->iteration != 1)
                      <tr>
                        <?php
                        $totalBimbinganPsSendiri = App\Models\Admin\PembimbingTa::where('jenis_id1', 1)->where('tahun', $t)->where('doping1', $dosen->dosen_id)->orWhere(function ($query) use ($dosen, $t) {
                          $query->where('doping2', $dosen->dosen_id)->where('jenis_id2', 1)->where('tahun', $t);
                        })->count();
                        ?>
                        <td>{{$totalBimbinganPsSendiri}}</td>
                        <?php
                        $totalBimbinganPsLain = App\Models\Admin\PembimbingTa::where('jenis_id1', 2)->where('tahun', $t)->where('doping1', $dosen->dosen_id)->orWhere(function ($query) use ($dosen, $t) {
                          $query->where('doping2', $dosen->dosen_id)->where('jenis_id2', 2)->where('tahun', $t);
                        })->count();
                        ?>
                        <td>{{$totalBimbinganPsLain}}</td>
                        <td>{{ $t }}</td>
                      </tr>
                      @endif
                      @endforeach
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


<!-- /page content -->

@stop