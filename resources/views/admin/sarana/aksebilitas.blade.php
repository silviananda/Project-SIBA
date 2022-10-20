@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Aksebilitas</h3>
              </div>
                <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class=" "> Import <i class="fa fa-long-arrow-down"></i></a>
                      </li>
                      &nbsp;
                      <li><a class=""> Add New <i class="fa fa-plus"></i></a>
                      </li>
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
                                <th rowspan="2">No</th>
                                <th rowspan="2">Jenis Data</th>
                                <th colspan="4">Sistem Pengelolaan Data</th>
                              </tr>
                              <tr>
                                <th colspan="1">Secara Manual</th>
                                <th colspan="1">Dengan Komputer Tanpa Jaringan</th>
                                <th colspan="1">Dengan Komputer Jaringan Lokal (LAN)</th>
                                <th colspan="1">Dengan Komputer Jaringan Luas (WAN)</th>
                              </tr>
                            </thead>


                      <tbody>
                        <tr>
                          <td>Tiger Nixon</td>
                          <td>System Architect</td>
                          <td>Edinburgh</td>
                          <td>61</td>
                          <td>2011/04/25</td>
                          <td>$320,800</td>
                        </tr>
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
