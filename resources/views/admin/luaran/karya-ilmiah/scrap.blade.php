@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Data Publikasi Ilmiah dari Google Scholar</h3>
            </div>

            <form role="form" action="{{ route('luaran.karya-ilmiah.save') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12 col-sm-12 ">
                <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title">No </th>
                            <th class="column-title">Judul </th>
                            <th class="column-title">Volume</th>
                            <th class="column-title">Page</th>
                            <th class="column-title">Issue</th>
                            <th class="column-title">Publisher</th>
                            <th class="column-title">Tingkat Publikasi</th>
                            <th class="column-title">Jumlah Sitasi </th>
                            <th class="column-title">Jenis Publikasi </th>
                            <th class="column-title">Tahun </th>
                            </th>
                            <th class="bulk-actions" colspan="10">
                              <a class="antoo" style="color:#fff; font-weight:500;">Total Ditandai ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr class="even pointer">
                            <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>
                            <td class=" " name="judul">1</td>
                            <td class=" " name="judul">121000040</td>
                            <td class=" " name="volumen">May 23, 2014 11:47:56 PM </td>
                            <td class=" " name="page">121000210</td>
                            <td class=" " name="issue">John Blank L</td>
                            <td class=" " name="publisher">Paid</td>
                            <td class=" " name="id_tingkat">John Blank L</td>
                            <td class=" " name="jumlah">$7.45</td>
                            <td class=" " name="jenis_publikasi">$7.45</td>
                            <td class=" " name="tahun">2018</td>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>	
                </div>
            </form>
                
                <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                <a href="{{ route('luaran.karya-ilmiah.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

            </div>
        </div>
    </div>
</div>
<!-- /page content -->

@stop
