@extends('admin.layout.main')
@section('content')

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Luaran Penelitian dan PkM</h3>
              </div>
            </div>

            <div class="title_right">
                <div class="form-group pull-right top_search">
                  <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Download File
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-publikasi-mhs"> Data Publikasi Mahasiswa</a>
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-publikasi-dosen"> Data Publikasi Dosen</a>
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-produk-mhs"> Data Produk Mahasiswa</a>
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-produk-dosen"> Data Produk Dosen</a>
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-paten-mhs"> Data Paten Mahasiswa</a>
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-paten-dosen"> Data Paten Dosen</a>
                        <a class="dropdown-item"  href="http://127.0.0.1:8000/export-luaran-lainnya"> Data Luaran Lainnya</a>
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
                            <h4 class="brief"><i>Publikasi/Karya Ilmiah Mahasiswa</i></h4>
                            <div class="left col-sm-7">
                              <p>Data Karya Ilmiah yang dihasilkan oleh mahasiswa</p>
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
                            <a href="{{ route('luaran.publikasi-mhs.index')}}">
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
                            <h4 class="brief"><i>Publikasi/Karya Ilmiah Dosen</i></h4>
                            <div class="left col-sm-7">
                              <p> Data Karya Ilmiah yang dihasilkan oleh Dosen</p>
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
                            <a href="{{ route('luaran.karya-ilmiah.index')}}">
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
                            <h4 class="brief"><i>Produk yang dihasilkan oleh Dosen</i></h4>
                            <div class="left col-sm-7">
                              <p>Data Produk/Jasa yang diadopsi oleh Industri/Masyarakat yang dihasilkan Dosen</p>
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
                            <a href="{{ route('luaran.produk.index')}}">
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
                            <h4 class="brief"><i>Produk yang dihasilkan oleh Mahasiswa</i></h4>
                            <div class="left col-sm-7">
                              <p>Data Produk/Jasa yang diadopsi oleh Industri/Masyarakat yang dihasilkan Mahasiswa</p>
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
                            <a href="{{ route('luaran.produk-mhs.index')}}">
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
                            <h4 class="brief"><i>Luaran Lainnya</i></h4>
                            <div class="left col-sm-7">
                              <p>Data luaran penelitian dan PkM lainnya yang dihasilkan</p>
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
                            <a href="{{ route('luaran.lainnya.index')}}">
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
                            <h4 class="brief"><i>Paten Mahasiswa</i></h4>
                            <div class="left col-sm-7">
                              <p>Data Karya Mahasiswa yang dipatenkan</p>
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
                            <a href="{{ route('luaran.paten-mhs.index')}}">
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
                            <h4 class="brief"><i>Paten Dosen </i></h4>
                            <div class="left col-sm-7">
                              <p>Data Karya Dosen yang dipatenkan </p>
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
                            <a href="{{ route('luaran.paten.index')}}">
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
