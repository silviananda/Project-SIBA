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


    <link rel="stylesheet" type="text/css" href="/vendors/datetimepicker/jquery.datetimepicker.css">
    

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
                <a href="{{URL::to('dashboard')}}" class="site_title"><img width="50px" height="50px" src="/assets/images/logo3.png"><span><img width="150px" height="50px" src="/assets/images/fix.jpeg"></span></a>
              </div>
              {{-- <div class="navbar nav_title" style="border: 0;">&nbsp;
                <a href="{{URL::to('dashboard')}}" class="site_title"><img width="160px" height="55px" src="/assets/images/logo.png"></a>
              </div> --}}

            <div class="clearfix"></div>

            <br/>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-home"></i> Dashboard <span class=" "></span></a>
                  </li>
                  <li><a><i class="fa fa-desktop"></i> Standar 2 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('kerjasama.index') }}">Kerjasama Tridharma</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> Standar 3 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('mahasiswa.mahasiswa') }}">Data Mahasiswa</a></li>
                      <li><a href="{{ route('mahasiswa-asing.biodata.index') }}">Data Mahasiswa Asing</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Standar 4 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('dosen.tetap.dosen-tetap') }}">Data Dosen Tetap</a></li>
                      <li><a href="{{ route('dosen.tidak-tetap.tidak-tetap') }}">Data Dosen Tidak Tetap</a></li>
                      <li><a href="{{ route('dosen.industri.industri') }}">Data Dosen Industri</a></li>
                      <li><a href="{{ route('upaya.upaya') }}">Upaya Peningkatan SDM</a></li>
                      <li><a href="{{ route('tenaga-kependidikan.index') }}">Tenaga Kependidikan</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-building-o"></i>Standar 5 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('alokasi-dana.alokasi') }}">Perolehan Alokasi Dana</a></li>
                      <li><a href="{{ route('prasarana.prasarana') }}">Prasarana</a></li>
                      <li><a href="{{ route('sarana.sarana') }}">Sarana Kegiatan Akademik</a></li>
                    </ul>
                  </li>
                   <li><a><i class="fa fa-clone"></i> Standar 6 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('kurikulum.kurikulum') }}">Kurikulum</a></li>
                      <li><a href="{{ route('pembimbing.bimbingan')}}">Bimbingan</a></li>
                      <li><a href="{{ route('kegiatan-akademik.index')}}">Peningkatan Kegiatan Akademik</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-file-o"></i> Standar 7 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('penelitian.dosen.index')}}">Penelitian Dosen</a></li>
                      <li><a href="{{ route('penelitian.mahasiswa.index')}}">Penelitian Mahasiswa</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-crosshairs"></i>Standar 8 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('pkm.pkm')}}">Kegiatan PKM</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-folder-open-o"></i>Standar 9 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('alumni.index')}}">Data Alumni</a></li>
                      <li><a href="{{ route('capaian.index')}}">Capaian Pembelajaran</a></li>
                      <li><a href="{{ route('mahasiswa.prestasi.index')}}">Prestasi Mahasiswa</a></li>
                      <li><a href="{{ route('efektivitas.pendidikan.index')}}">Efektivitas dan Produktivitas Pendidikan</a></li>
                      <li><a href="{{ route('luaran.luaran')}}">Luaran Penelitian dan PkM</a></li>
                    </ul>
                  </li>

                  <li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Log Out <span
                    class=" "></span></a></li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" >
                <span class="" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" >
                <span class="" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" >
                <span class="" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" >
                <span class="" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="/assets/images/img.jpg" alt="">{!! Auth::user()->name !!}
                  </a>
                </li>

                <!-- untuk notifikasi -->
                <li role="presentation" class="nav-item dropdown open" id="menu_toggle" class="close" style="display: inline-flex;">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell-o" style="font-size: 1.5em;"></i><span class="badge bg-green">{{count(Auth::user()->unreadNotifications)}}</span></a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                        @if (count(Auth::user()->unreadNotifications) == 0)
                        <li class="nav-item"><a class="dropdown-item"><span>Tidak ada notifikasi</span></a></li>
                        @else
                        @foreach (Auth::user()->unreadNotifications as $notif)
                        <li class="nav-item">
                            <a class="dropdown-item" href="{{route('readnotif', ['id' => $notif->id, 'guard' => 'admin'])}}">
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
        swal("Selesai!", "{!!Session::get('added')!!}", "success",{
          button:"OK",
        });
    </script>
    @endif

<!-- error -->
    @if(Session::has('error'))
    <script>
        swal("Input Ulang!", "{!!Session::get('error')!!}", "error",{
          button:"OK",
        });
    </script>
    @endif

<!-- edit -->
    @if(Session::has('edit'))
    <script>
        swal("Selesai!", "{!!Session::get('edit')!!}", "success",{
          button:"OK",
        });
    </script>
    @endif

<!-- delete -->
      <script>
        $(".swal-confirm").click(function(e){
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
                $(`#delete${id}`).submit();
              } else {
              }
            });
          })
        </script>

{{-- input --}}
<script>
  $(".swal-input").click(function(e){
    id = e.target.dataset.id;
      swal({
        text: 'Input link google scholar dosen',
        content: "input",
        button: {
          text: "Search!",
          closeModal: false,
        },
      })
      .then(name => {
        if (!name) throw null;
      
        return fetch(`https://itunes.apple.com/search?term=${name}&entity=movie`);
      })
      .then(results => {
        return results.json();
      })
      .then(json => {
        const movie = json.results[0];
      
        if (!movie) {
          return swal("No movie was found!");
        }
      
        const name = movie.trackName;
        const imageURL = movie.artworkUrl100;
      
        swal({
          title: "Top result:",
          text: name,
          icon: imageURL,
        });
      })
      .catch(err => {
        if (err) {
          swal("Oh noes!", "The AJAX request failed!", "error");
        } else {
          swal.stopLoading();
          swal.close();
        }
      });
  })
</script>

{{-- delete dosen --}}
        <script>
        $(".swal-confirm-delete-dosen").click(function(e){
          id = e.target.dataset.id;
            swal({
              title: "Yakin hapus data?",
              text: "Data yang sudah dihapus dapat di kembalikan!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $(`#delete${id}`).submit();
              } else {
              }
            });
          })
        </script>

        <!-- restore -->
      <script>
        $(".swal-confirm-restore").click(function(e){
          id = e.target.dataset.id;
            swal({
              title: "Yakin pulihkan data?",
              text: "Data akan ditampilkan kembali!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willRestored) => {
              if (willRestored) {
                $(`#restore${id}`).submit();
              } else {
              }
            });
          })
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
               if(data == "404"){
                      $("."+className+'#ShowError').show().text("Data dosen tidak di temukan, masukkan kembali!");
                      $("."+className+'#dosen_id').val("");
                      $("."+className+'#nama_dosen').val("");
               }else{
                  console.log(data);
                      $("."+className+'#dosen_id').val(data.dosen_id);
                      $("."+className+'#nama_dosen').val(data.nama_dosen);
                      $("."+className+'#ShowError').hide();
               }
            }) 
          }
        </script>

    <script type="text/javascript">
        function autofillmhs(className) {
            var npm = $("." + className + "#npm").val();
            $.ajax({
                type: "GET",
                url: '/api/mhs/' + npm,
                data: 'npm=' + npm,
            }).success(function (data) {
               if(data == "404"){
                      $("."+className+'#ErrorVal').show().text("Data mahasiswa tidak di temukan, masukkan kembali!");
                      $("." + className + '#input-id').val("");
                      $("."+className+'#nama').val("");
               }else{
                      $("." + className + '#input-id').val(data.id);
                      $("." + className + '#nama').val(data.nama);
                      $("."+className+'#ErrorVal').hide();
               }
            });
        }
    </script>

    <script type="text/javascript">
        function autofillmhss2(className) {
            var npm = $("." + className + "#npm").val();

            $.ajax({
                type: "GET",
                url: '/api/mhss2/' + npm,
                data: 'npm=' + npm,
            }).success(function (data) {
                $("." + className + '#input-id').val(data.id);
                $("." + className + '#nama').val(data.nama);
            });
        }
    </script>

        <!-- javascript untuk kode mk -->
        <script type="text/javascript">
            function autofillmk(className){
              var kode_mk = $("." + className + "#kode_mk").val();
              $.ajax({
                type: "GET",
                url : '/api/mk/'+ kode_mk,
                data : 'kode_mk='+ kode_mk,
              }).success(function(data){
                if(data == "404"){
                      $("."+className+'#ErrorMk').show().text("Data matakuliah tidak di temukan, masukkan kembali!");
                      $("."+className+'#kurikulum_id').val("");
                      $("."+className+'#nama_mk').val("");
                      $("."+className+'#bobot_sks').val("");
                }else{
                      $("." + className + '#kurikulum_id').val(data.kurikulum_id);
                      $("." + className + '#nama_mk').val(data.nama_mk);
                      $("." + className + '#bobot_sks').val(data.bobot_sks);
                      $("."+className+'#ErrorMk').hide();
                }
              });
            }
        </script>



        {{-- javascript untuk nama tenaga kependidikan --}}
        <script type="text/javascript">
            function autofilltenaga(){
              var nidn = $("#nidn").val();
              $.ajax({
                type: "GET",
                url : '/api/tenaga/'+nidn,
                data : 'nidn='+nidn,
              }).success(function(data){
                      $('#id').val(data.id);
                      $('#nama').val(data.nama);
              });
            }
        </script>

        <script>
          $('#datetimepicker').datetimepicker();

          $('#datatable-fixed-header').ready(function() {
            $('#datatable-fixed-header_filter label input[type=search]').val('{{Request::input('tablesearch')}}').trigger($.Event("keyup", {keyCode: 13}));

          })
        </script>


{{-- date range --}}
        {{-- <input type="text" name="datetimes" /> --}}

        <script>
            $(function() {
                $('input[id="datetimes"]').daterangepicker({
                    timePicker: true,
                    startDate: moment().startOf('hour'),
                    endDate: moment().startOf('hour').add(32, 'hour'),
                    locale: {
                    format: 'M/DD hh:mm A'
                    }
                });
            });
        </script>


        {{-- untuk form inputan dinamis data pkm dosen --}}
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
                    '<div class="form-group"><label for="exampleFormControlInput1">Nama Mahasiswa yang berpartisipasi</label><div class="input-group"><input type="text" oninput=autofillmhs("mahasiswa' +
                    room + '") class="mahasiswa' + room +
                    ' form-control @error("npm") is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="remove_mahasiswa_fields(' +
                    room +
                    ');"> <i class="fa fa-minus"></i></span></button></div></div>'
                
                optionHtml +=
                    '<span class="mahasiswa' + room + ' danger" style="color: #DC143C;" id="ErrorVal"></span>'

                optionHtml +=
                    '<div class="form-group form-material row"><input type="hidden" class="mahasiswa'+ room +' form-control @error("mhs_id") is-invalid @enderror" id="input-id" placeholder="" name="mhs_id[' +
                    room + ']"></div>'

                optionHtml +=
                    '<div class="form-group"><label for="exampleFormControlInput1">Nama Mahasiswa</label><input type="text"  disabled="disabled" class="mahasiswa'+room+' form-control" id="nama" name="nama"></div>'


                divtest.innerHTML = optionHtml


                objTo.appendChild(divtest)
            }

            function remove_mahasiswa_fields(rid) {
                console.log("update",rid);

                if (rid>0){
                    $('.removeclass' + rid).remove();
                }
                else{
                    document.getElementById("#mhs_id").remove();
                }
            }

            function remove_mahasiswa_fields_edit(mhsid) {
                console.log("update",mhsid);

                $('.mhs-' + mhsid).remove();
            }
        </script>

        {{-- untuk form inputan dinamis data kode mk --}}
        <script type="text/javascript">
            let room1 = 1;

            function ps_sendiri_fields() {

                room1++;
                var objTo = document.getElementById('ps_sendiri_fields')
                var divtest = document.createElement("div");

                divtest.setAttribute("class", "form-group removeclass1" + room1);
                var rdiv = 'removeclass1' + room1;

                let optionHtml = '<div class="input-ps-sendiri form-group">'

                optionHtml +=
                    '<div class="form-group"><label for="exampleFormControlInput1">Jenis Mata Kuliah</label><select class="form-control" name="ket[' + room1 + ']"><option>Pilih</option><option value="PS Sendiri">Program Studi Sendiri</option><option value="PS Lain">Program Studi Lain</option><option value="PS Lain di luar PT">Program Studi Lain di Luar PT</option></select></div>'

                optionHtml +=
                    '<div class="form-group"><label for="exampleFormControlInput1">Kode Mata Kuliah</label><div class="input-group"><input type="text" oninput=autofillmk("kode_mk' +
                    room1 + '") class="kode_mk' + room1 +
                    ' form-control @error("kode_mk") is-invalid @enderror" id="kode_mk" placeholder="Masukkan Kode MK" name="kode_mk[' + room1 + ']"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="remove_sendiri_fields(' +
                    room1 +
                    ');"> <i class="fa fa-minus"></i></span></button></div></div>'
                
                optionHtml +=
                    '<span class="kode_mk' + room1 + ' danger" style="color: #DC143C;" id="ErrorMk"></span>'

                optionHtml +=
                    '<div class="form-group"><label for="exampleFormControlInput1">Nama Mata Kuliah</label><input type="text" disabled="disabled" class="kode_mk'+ room1 +' form-control" id="nama_mk" name="nama_mk"></div>'
                
                optionHtml +=
                    '<div class="form-group"><label for="exampleFormControlInput1">SKS Pengajaran</label><input type="text" class="kode_mk' + room1 +
                    ' form-control @error("kode_mk") is-invalid @enderror" id="bobot_sks" placeholder="" name="bobot_sks[' + room1 + ']">'

                divtest.innerHTML = optionHtml

                objTo.appendChild(divtest)
            }

            function remove_sendiri_fields(rid) {
                console.log("update",rid);

                if (rid>0){
                    $('.removeclass1' + rid).remove();
                }
                else{
                    document.getElementById("#kode_mk").remove();
                }
            }

            function remove_sendiri_fields_edit(kodeid) {
                console.log("update",kodeid);

                $('.kode-' + kodeid).remove();
            }
        </script>

        <script>
            function importAction(kategoriWebservice){
                console.log (kategoriWebservice);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    type: "POST",
                    url: '/api/import/' + kategoriWebservice,
                    data: '',
                }).success(function (data) {
                    console.log("data berhasil di import", data);
                });
            }
        </script>

        {{-- tampil form untuk nama universitas --}}
        <script>
            $("#seeAnotherFieldGroup").change(function() {
                if ($(this).val() == "4" || $(this).val() == "3") {
                    $('#otherFieldGroupDiv').show();
                    $('#otherField1').attr('required', '');
                    $('#otherField1').attr('data-error', 'Pendidikan S2 tidak boleh kosong');
                    $('#otherField2').attr('', '');
                    $('#otherField2').attr('data-error', 'This field is required.');
                    } else {
                    $('#otherFieldGroupDiv').hide();
                    $('#otherField1').removeAttr('required');
                    $('#otherField1').removeAttr('data-error');
                    $('#otherField2').removeAttr('');
                    $('#otherField2').removeAttr('data-error');
                    }
                });

            $("#seeAnotherFieldGroup").trigger("change");
        </script>

        {{-- tampil form untuk nama perusahaan --}}
        <script>
            $("#seeAnotherFieldGroupPerusahaan").change(function() {
                if ($(this).val() == "3") {
                    $('#otherFieldGroupDivPerusahaan').show();
                    $('#otherFieldPerusahaan').attr('', '');
                    $('#otherFieldPerusahaan').attr('data-error', 'This field is required.');
                    } else {
                    $('#otherFieldGroupDivPerusahaan').hide();
                    $('#otherFieldPerusahaan').removeAttr('');
                    $('#otherFieldPerusahaan').removeAttr('data-error');
                    }
                });
            $("#seeAnotherFieldGroupPerusahaan").trigger("change");
        </script>

        {{-- untuk kode kab --}}
        <script type="text/javascript">
          function autofillkab(){
            var id = $("#id").val();
            $.ajax({
              type: "GET",
              url : '/api/mk/'+id,
              data : 'id='+id,
            }).success(function(data){
                    $('#id').val(data.id);
                    $('#prov_id').val(data.prov_id);
                    $('#nama_kab').val(data.nama_kab);
            });
          }
        </script>

        <script  type="text/javascript">
          $(function () {
                        $('#myDatepicker').datetimepicker();
                    });
            
            $('#myDatepicker2').datetimepicker({
                format: 'DD.MM.YYYY'
            });
            
            $('#tesaja').datetimepicker({
                format: 'hh:mm A'
            });
            
            $('#myDatepicker4').datetimepicker({
                ignoreReadonly: true,
                allowInputToggle: true
            });

            $('#datetimepicker6').datetimepicker();
            
            $('#datetimepicker7').datetimepicker({
                useCurrent: false
            });
            
            $("#datetimepicker6").on("dp.change", function(e) {
                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            
            $("#datetimepicker7").on("dp.change", function(e) {
                $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });
        </script>


@yield('footer')

  </body>

</html>


