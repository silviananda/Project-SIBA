@extends('admin.layout.main')
@section('content')

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Pengabdian Kepada Masyarakat</h3>
              </div>
            </div>

            <div class="title_right">
                <div class="form-group pull-right top_search">
                  <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Download File
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-pkm-dosen"> Data PKM Dosen</a>
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-pkm-mhs"> Data PKM Mahasiswa</a>
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

                      <div class="col-md-4 col-sm-8  profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Data Kegiatan Pengabdian Masyarakat</i></h4>
                            <div class="left col-sm-7">
                              <p> Jumlah kegiatan pengabdian kepada masyarakat per tahun </p>
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
                            <a href="{{ route('pkm.data.index')}}">
                             <button type="button" class="btn btn-primary btn-sm">
                                <i class=""> </i> Detail
                              </button></a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-8  profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>PKM Mahasiswa</i></h4>
                            <div class="left col-sm-7">
                              <p> Data PKM yang dibuat oleh Mahasiswa</p>
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
                            <a href="{{ route('pkm.mhs.index')}}">
                             <button type="button" class="btn btn-primary btn-sm">
                                <i class=""> </i> Detail
                              </button></a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-8  profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>PKM Dosen</i></h4>
                            <div class="left col-sm-7">
                              <p> Data keterlibatan Mahasiswa dalam PKM Dosen </p>
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
                            <a href="{{ route('pkm.dosen.index')}}">
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
