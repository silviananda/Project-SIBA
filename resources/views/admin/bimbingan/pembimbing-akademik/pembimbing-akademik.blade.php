@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Pembimbing Akademik</h3>
              </div>

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      &nbsp;
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
                                        <th>Nama Dosen</th>
                                        <th>Jumlah Mhs</th>
                                        <th>Tahun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ( $data_pembimbing_akademik as $value )
                                    <tr>
                                        <th rowspan="3"> {{ $loop->iteration }}</th>
                                        <td rowspan="3">{{ $value->nama_dosen }}</td>
                                          <?php
                                            $jumlah = App\Models\Admin\MhsReguler::whereYEAR('tahun_masuk', $tahun[0])->where('dosen_id', $value->dosen_id)->count();
                                          ?>
                                          
                                        <td>{{ $jumlah }}</td>
                                        <td>{{ $tahun[0] }}</td>
                                    </tr>
                                    @foreach($tahun as $t)
                                      @if($loop->iteration != 1)
                                        <tr>
                                           <?php
                                            $jumlah = App\Models\Admin\MhsReguler::whereYEAR('tahun_masuk', $t)->where('dosen_id', $value->dosen_id)->count();
                                          ?>
                                          <td>{{ $jumlah }}</td>
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
