<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="../images/favicon.ico" type="image/ico" />

    <title>SIBA | Sistem Informasi Borang Akreditasi</title>

    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- bootstrap-wysiwyg -->
    <link href="/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="/vendors/starrr/dist/starrr.css" rel="stylesheet">

    <!-- Datatables -->

    <link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
                <a href="{{URL::to('data-admin')}}" class="site_title"><img width="50px" height="50px" src="/assets/images/logo3.png"><span><img width="160px" height="60px" src="/assets/images/logo2.png"></span></a>
              </div>

            <div class="clearfix"></div>

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  </br>
                  <li><a href="{{ URL::to('data-admin') }}"><i class="fa fa-folder-open-o"></i> Data Admin <span class=""></span></a></li>
                  <li><a href="{{ URL::to('data-dosen') }}"><i class="fa fa-folder-open-o"></i> Data Dosen <span class=""></span></a></li>
                  <li><a href="{{ URL::to('data-himpunan') }}"><i class="fa fa-folder-open-o"></i> Data Himpunan <span class=""></span></a></li>
                  <li><a href="{{URL::to('logout')}}"><i class="fa fa-sign-out"></i> Log Out <span
                    class=" "></span></a>
                </ul>
              </div>
            </div>
          <br/>
          </div>
        </div>

        <div class="top_nav">
          <div class="nav_menu">

              <div class="nav toggle">
                <a href="{{URL::to('data-admin')}}"><i class="fa fa-chevron-left"></i></a>
              </div>

              <div class="nav toggle">
                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                    <li class="nav-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                    </li>
                  </ul>
              </div>

              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="/assets/images/img.jpg" alt="">{!! Auth::user()->name !!}
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="javascript:;"> Profile</a>
                      <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                  <a class="dropdown-item"  href="javascript:;">Help</a>
                    <a class="dropdown-item"  href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

@yield ('content')

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <!-- Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a> -->
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="/vendors/Flot/jquery.flot.js"></script>
    <script src="/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="/vendors/Flot/jquery.flot.time.js"></script>
    <script src="/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="/vendors/moment/min/moment.min.js"></script>
    <script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Datatables -->
    <script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="/vendors/jszip/dist/jszip.min.js"></script>
    <script src="/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="/vendors/pdfmake/build/vfs_fonts.js"></script>


    <!-- bootstrap-wysiwyg -->

    <script src="/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="/vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="/vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="/vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="/vendors/starrr/dist/starrr.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="/build/js/custom.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <!-- tambah -->
        @if(Session::has('added'))
        <script>
            swal("Selesai!", "{!!Session::get('added')!!}", "success", {
                button: "OK",
            });

        </script>
        @endif

        <!-- edit -->
        @if(Session::has('edit'))
        <script>
            swal("Selesai!", "{!!Session::get('edit')!!}", "success", {
                button: "OK",
            });
        </script>
        @endif

        <!-- delete -->
        <script>
            $(".swal-confirm").click(function (e) {
                id = e.target.dataset.id;
                swal({
                        title: "Yakin hapus data?",
                        text: "Data yang sudah dihapus tidak bisa di kembalikan!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            // swal("Data Berhasil Dihapus!", {
                            //   icon: "success",
                            // });
                            $(`#delete${id}`).submit();
                        } else {
                            swal("Data Tidak Terhapus!");
                        }
                    });
            })

        </script>

        <!-- javascript untuk cari npm untuk mahasiswa -->
        <script type="text/javascript">
            function autofillmhs(className) {
                var npm = $("." + className + "#npm").val();

                $.ajax({
                    type: "GET",
                    url: '/api/mhs/' + npm,
                    data: 'npm=' + npm,
                }).success(function (data) {
                    $("." + className + '#input-id').val(data.id);
                    $("." + className + '#nama').val(data.nama);
                });
            }
        </script>

        <!-- javascript untuk cari nip untuk dosen -->
        <script type="text/javascript">
            function autofill(className){
              var nip = $("."+className+"#nip").val();
              $.ajax({
                type: "GET",
                url : '/api/dosen/'+nip,
                data : 'nip='+nip,
              }).success(function(data){
                // response( data );
                console.log(data);
                      $("."+className+'#dosen_id').val(data.dosen_id);
                      $("."+className+'#nama_dosen').val(data.nama_dosen);
              });
            }
        </script>

        {{-- tampil form untuk kategori adm jurusan/dosen --}}
        <script>
            $("#seeAnotherFieldGroup").change(function() {
                if ($(this).val() == "1") {
                    $('#otherFieldGroupDiv1').hide();
                    $('#otherField3').removeAttr('required');
                    $('#otherField3').removeAttr('data-error');
                    $('#otherField4').removeAttr('required');
                    $('#otherField4').removeAttr('data-error');

                    $('#otherFieldGroupDiv').show();
                    $('#otherField1').attr('required', '');
                    $('#otherField1').attr('data-error', 'This field is required.');
                    $('#otherField2').attr('required', '');
                    $('#otherField2').attr('data-error', 'This field is required.');

                    } else {

                    $('#otherFieldGroupDiv1').show();
                    $('#otherField3').attr('required', '');
                    $('#otherField3').attr('data-error', 'This field is required.');
                    $('#otherField4').attr('required', '');
                    $('#otherField4').attr('data-error', 'This field is required.');

                    $('#otherFieldGroupDiv').hide();
                    $('#otherField1').removeAttr('required');
                    $('#otherField1').removeAttr('data-error');
                    $('#otherField2').removeAttr('required');
                    $('#otherField2').removeAttr('data-error');

                    }
                });

            $("#seeAnotherFieldGroup").trigger("change");
        </script>

  </body>
</html>
