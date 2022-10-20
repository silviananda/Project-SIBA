@extends('admin.layout.main')
@section('content')

<!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Peninjauan Silabus/SAP</h3>
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
                                <th rowspan="2">Kode MK</th>
                                <th rowspan="2">Nama Mata Kuliah</th>
                                <th rowspan="2">MK Lama/Baru/Hapus</th>
                                <th colspan="2">Perubahan Pada</th>
                                <th rowspan="2">Alasan Peninjauan</th>
                                <th rowspan="2">Atas Usulah/Masukan dari</th>
                                <th rowspan="2">Berlaku mulai sem/th</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th colspan="1">Silabus/SAP</th>
                                <th colspan="1">Buku Ajar</th>
                            </tr>
                      </thead>

                      <tbody>
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
