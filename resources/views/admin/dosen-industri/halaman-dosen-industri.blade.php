@extends('admin.layout.main')
@section('content')

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Data Dosen Industri</h3>
              </div>

              <div class="title_right">
                <div class="col-md-3 col-sm-3  form-group pull-right top_search">
                    <div class="input-group">

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

                      <div class="col-md-4 col-sm-8  profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Dosen Industri</i></h4>
                            <div class="left col-sm-7">
                              <p> Biodata Dosen Industri pada program studi </p>
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
                            <a href="{{ route('dosen.industri.biodata.index') }}">
                             <button type="button" class="btn btn-primary btn-sm">
                                <i class=""> </i> Detail
                              </button></a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-6  profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Aktivitas Dosen Industri</i></h4>
                            <div class="left col-sm-7">
                              <p> Data aktivitas dosen industri pada Program Studi dan diluar Program Studi </p>
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
                            <a href="{{ route('dosen.industri.aktivitas.index') }}">
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
