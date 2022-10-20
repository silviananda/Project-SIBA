@extends('admin.layout.main')
@section('content')

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Data Prasarana</h3>
              </div>
            </div>

            <div class="title_right">
                <div class="form-group pull-right top_search">
                  <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Download File
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-ruang"> Data Ruang Kerja </a>
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-prasarana"> Data Prasarana </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="x_panel">
                  <div class="x_content">
                      <div class="col-md-12 col-sm-12  text-center">
                      </div>

                      <div class="clearfix"></div>

                      <div class="col-md-4 col-sm-4  profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Ruang Kerja</i></h4>
                            <div class="left col-sm-7">
                              <p> Data Ruang Kerja dosen yang digunakan di lingkup program studi</p>
                              <ul class="list-unstyled">
                              </ul>
                            </div>
                            <div class="right col-sm-5 text-center">
                              <img src="images/user.png" alt="" class="img-circle img-fluid">
                            </div>
                          </div>
                          <div class=" bottom text-center">
                            <div class=" col-sm-13 emphasis">
                            </div>
                            <div class=" col-sm-13 emphasis">
                            <a href="{{ route('prasarana.ruangan.index') }}">
                             <button type="button" class="btn btn-primary btn-sm">
                                <i class=""> </i> Detail
                              </button></a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-4  profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Data Prasarana</i></h4>
                            <div class="left col-sm-7">
                              <p> Data Prasarana yang digunakan Program Studi dalam proses pembelajaran</p>
                              <ul class="list-unstyled">
                              </ul>
                            </div>
                            <div class="right col-sm-5 text-center">
                              <img src="images/user.png" alt="" class="img-circle img-fluid">
                            </div>
                          </div>
                          <div class=" bottom text-center">
                            <div class=" col-sm-13 emphasis">
                            </div>
                            <div class=" col-sm-13 emphasis">
                            <a href="{{ route('prasarana.data.index') }}">
                             <button type="button" class="btn btn-primary btn-sm">
                                <i class=""> </i> Detail
                              </button></a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-4  profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Prasarana Lain</i></h4>
                            <div class="left col-sm-7">
                              <p> Data Prasarana penunjang dalam lingkup program studi </p>
                              <ul class="list-unstyled">
                              </ul>
                            </div>
                            <div class="right col-sm-5 text-center">
                              <img src="images/user.png" alt="" class="img-circle img-fluid">
                            </div>
                          </div>
                          <div class=" bottom text-center">
                            <div class=" col-sm-13 emphasis">
                            </div>
                            <div class=" col-sm-13 emphasis">
                            <a href="{{ route('prasarana.prasarana-lain.index') }}">
                             <button type="button" class="btn btn-primary btn-sm">
                                <i class=""> </i> Detail
                              </button></a>
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
