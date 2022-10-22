@extends('admin.layout.main')
@section('content')

<!-- page content -->

        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="col-md-12 col-sm-12" style="display: inline-table;" >
            <div class="col-md-10" style="display: inline-flex;">
              <h4>Selamat Datang!</h4>
            </div>

            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Download Report</button>

                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                    <li class="nav-item">
                        <a href="{{URL::to('export-to-pdf')}}" ><span><img src="/assets/images/pdf.png"  height="37" width="35" alt="Download with .pdf" /></span>&nbsp</a>

                        <a href="{{URL::to('export-to-word')}}" ><span><img src="/assets/images/doc.png" height="37" width="35" alt="Download with .docs" />  </span>&nbsp</a>
                    </li>
                </ul>
          </div>

          <div class="x_panel" style="display: inline-table;" >
          <div class="tile_count">
            <div class="col-md-2 col-sm-2  tile_stats_count">
              <span class="count_top "><i class=""></i> Mahasiswa Baru </span>
              <div class="count" href="{{URL::to('lulus-seleksi')}}">{{ $count_maba }}</div>
            </div>
            <div class="col-md-2 col-sm-2  tile_stats_count">
              <span class="count_top"><i class=" "></i>Lulusan </span>
              <div class="count green">{{ $count_lulusan }}</div>
            </div>
            <div class="col-md-2 col-sm-2  tile_stats_count">
              <span class="count_top"><i class=""></i> Jumlah Dosen </span>
              <div class="count">{{ $count_dosen }}</div>
            </div>
            <div class="col-md-2 col-sm-2  tile_stats_count">
              <span class="count_top"><i class=""></i> Jumlah PKM </span>
              <div class="count green">{{ $count_pkm }}</div>
            </div>
            <div class="col-md-2 col-sm-2  tile_stats_count">
              <span class="count_top"><i class=""></i> Jumlah Penelitian </span>
              <div class="count">{{ $count_penelitian }}</div>
            </div>
            <div class="col-md-2 col-sm-2  tile_stats_count">
              <span class="count_top"><i class=""></i> Jumlah Kerjasama </span>
              <div class="count green">{{ $count_kerjasama }}</div>
            </div>
          </div>
        </div>
          <!-- /top tiles -->

          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h5>Grafik Pendaftar</h5>
                  </div>

                  <!-- Ganti dengan timestampt yang baru saja -->
                  <!-- <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div> -->
                </div>

                <div class="col-md-8 col-sm-8 ">
                  <div id="chart_pendaftar" class="demo-placeholder"></div>
                </div>

                <!-- <div class="col-md-4 col-sm-4 ">
                  <div id="chart_jalur" class="demo-placeholder"></div>
                </div> -->

                <div class="col-md-4 col-sm-4 ">
                  <div id="pie_jalur" class="demo-placeholder"></div>
                </div>

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

          <div class="row">


            <div class="col-md-6 col-sm-6 ">
              <div class="x_panel tile fixed_height_320">
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">Settings 1</a>
                          <a class="dropdown-item" href="#">Settings 2</a>
                        </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>

                  <div class="col-md-12 col-sm-12 ">
                  <div id="chart_publikasi" class="demo-placeholder"></div>
                </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 ">
              <div class="x_panel tile fixed_height_320">
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">Settings 1</a>
                          <a class="dropdown-item" href="#">Settings 2</a>
                      </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>

                  <div class="col-md-12 col-sm-12 ">
                    <div id="chart_lulusan" class="demo-placeholder"></div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /page content -->

@stop

@section('footer')
  <script src="https://code.highcharts.com/highcharts.js"></script>

  <script>
    var snmptn =  <?php echo json_encode($snmptn) ?>;
    var sbmptn =  <?php echo json_encode($sbmptn) ?>;
    var smmptn =  <?php echo json_encode($smmptn) ?>;
    var afirmasi =  <?php echo json_encode($afirmasi) ?>;

Highcharts.chart('chart_pendaftar', {

title: {
    text: 'Data Pendaftar'
},


yAxis: {
    title: {
        text: 'Jumlah Pendaftar'
    }
},

xAxis: {
    categories: ['2016', '2017', '2018', '2019', '2020', '2021', '2022']
},

legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
},

plotOptions: {
    series: {
                allowPointSelect: true
            }
},

series: [{
    name: 'SNMPTN',
    data: snmptn
}, {
    name: 'SBMPTN',
    data: sbmptn
}, {
    name: 'SMMPTN',
    data: smmptn
}, {
    name: 'AFIRMASI',
    data: afirmasi
}],

responsive: {
    rules: [{
        condition: {
            maxWidth: 500
        },
        chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
        }
    }]
}

});

</script>

  <script>
      Highcharts.chart('chart_publikasi', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'Publikasi Dosen'
          },
          xAxis: {
              categories: {!!json_encode($publikasi['x'] ?? null)!!},
              crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Total (orang)'
              }
          },
          tooltip: {
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0
              }
          },
          series: [{
              name: 'Jumlah Publikasi',
              data: {!!json_encode($publikasi['y'] ?? null)!!}
          }]
      });
  </script>

  <script>
      var pieColors = (function () {
          var colors = [],
              base = Highcharts.getOptions().colors[0],
              i;

          for (i = 0; i < 10; i += 1) {
              colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
          }
          return colors;
      }());

      Highcharts.chart('pie_jalur', {
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
          title: {
              text: 'Jalur Masuk'
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          accessibility: {
              point: {
                  valueSuffix: '%'
              }
          },
          plotOptions: {
              pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  colors: pieColors,
                  dataLabels: {
                      enabled: true,
                      format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                      distance: -50,
                      filter: {
                          property: 'percentage',
                          operator: '>',
                          value: 4
                      }
                  }
              }
          },
          series: [{
              name: 'Jumlah',
              data: {!!json_encode($jalur)!!}
          }]
      });
  </script>

  <script>
      Highcharts.chart('chart_lulusan', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'Lulusan Per Tahun'
          },
          xAxis: {
              categories: {!!json_encode($alumni_array['x'] ?? null)!!},
              crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Total (orang)'
              }
          },
          tooltip: {
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0
              }
          },
          series: [{
              name: 'Jumlah Lulusan',
              data: {!!json_encode($alumni_array['y'] ?? null)!!}
          }]
      });
  </script>


  {{-- {{print_r(json_encode($jalur))}} --}}
@stop
