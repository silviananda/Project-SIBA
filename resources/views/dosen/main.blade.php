<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/images/favicon.ico" type="image/ico" />

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
    <link href="/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
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


    <link rel="stylesheet" type="text/css" href="/vendors/datetimepicker/jquery.datetimepicker.css">
</head>


<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="">
                        <img class="site_title_logo image-responsive" src="/assets/images/logo.png">
                    </div>

                    <div class="clearfix"></div>


                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a href="{{ route('dashboard-dosen.dashboard') }}"><i class="fa fa-home"></i>
                                        Dashboard <span class=" "></span></a>
                                </li>
                                <li><a><i class="fa fa-user"></i> Profil <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('biodata.index') }}">Data Pribadi</a></li>
                                        <li><a href="{{ route('bimbingan.akademik.index') }}">Data Bimbingan
                                                Akademik</a>
                                        </li>
                                        <li><a href="{{ route('bimbingan.tugas-akhir.index') }}">Data Bimbingan
                                                Tugas Akhir</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{URL::to('logout')}}"><i class="fa fa-sign-out"></i> Log Out <span class=" "></span></a>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a href="{{ url()->previous() }}"><i class="fa fa-chevron-left"></i></a>
                    </div>

                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">

                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="/assets/images/img.jpg" alt="">{{ \Auth::guard('dosen')->user()->nama_dosen }}
                                </a>
                            </li>
                            <!-- untuk notifikasi -->
                            <li role="presentation" class="nav-item dropdown open">
                                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell-o"></i><span class="badge bg-green">{{count(Auth::user()->unreadNotifications)}}</span></a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                                    @if (count(Auth::user()->unreadNotifications) == 0)
                                    <li class="nav-item"><a class="dropdown-item"><span>Tidak ada notifikasi</span></a></li>
                                    @else
                                    @foreach (Auth::user()->unreadNotifications as $notif)
                                    <li class="nav-item">
                                        <a class="dropdown-item" href="{{route('readnotif', ['id' => $notif->id, 'guard' => 'dosen'])}}">
                                            <span>
                                                <span>{{$notif->data['dosen_name']}}</span>
                                            </span>
                                            <span class="message">
                                                {{$notif->data['pesan']}}
                                            </span>
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
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
                    SIBA - Sistem Informasi Borang Akreditasi
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

    <script src="/vendors/datetimepicker/build/jquery.datetimepicker.full.js"></script>

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
        $(".swal-confirm").click(function(e) {
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
                        // swal("Data Tidak Terhapus!");
                    }
                });
        })
    </script>

    <script type="text/javascript">
        function autofillmhs(className) {
            // console.log("update here", className);
            var npm = $("." + className + "#npm").val();

            $.ajax({
                type: "GET",
                url: '/api/mhs/' + npm,
                data: 'npm=' + npm,
            }).success(function(data) {
                $("." + className + '#input-id').val(data.id);
                $("." + className + '#nama').val(data.nama);
            });
        }
    </script>

    <!-- untuk form inputan dinamis data pkm dosen -->
    <script type="text/javascript">
        let room = 1;

        function mahasiswa_fields() {

            room++;
            var objTo = document.getElementById('mahasiswa_fields')
            var divtest = document.createElement("div");

            divtest.setAttribute("class", "form-group removeclass" + room);
            var rdiv = 'removeclass' + room;

            let optionHtml = '<div class="input-mahasiswa form-group">'

            optionHtml +=
                '<div class="form-group"><label for="exampleFormControlInput1">Nama Mahasiswa yang berpartisipasi</label><input type="text" oninput=autofillmhs("mahasiswa' +
                room + '") class="mahasiswa' + room +
                ' form-control @error("npm") is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm"></div>'

            optionHtml +=
                '<div class="form-group form-material row"><input type="hidden" class="mahasiswa' + room + ' form-control @error("mhs_id") is-invalid @enderror" id="input-id" placeholder="" name="mhs_id[' +
                room + ']"></div>'

            optionHtml +=
                '<div class="form-group"><label for="exampleFormControlInput1">Nama Mahasiswa</label><input type="text"  disabled="disabled" class="mahasiswa' + room + ' form-control" id="nama" name="nama"></div>'

            optionHtml +=
                '</select></div><div class="mahasiswa' + room + ' input-group-append"> <button class="btn btn-danger" type="button" onclick="remove_mahasiswa_fields(' +
                room +
                ');"> <i class="fa fa-minus"></i> </button></div></div></div></div><div class="clear"></div></row>'


            divtest.innerHTML = optionHtml


            objTo.appendChild(divtest)
        }

        function remove_mahasiswa_fields(rid) {
            $('.removeclass' + rid).remove();
        }
    </script>

</body>

</html>