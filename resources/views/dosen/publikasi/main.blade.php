@extends('dosen.layout.main')
@section('content')

<!-- page content -->
        <div class="right_col" role="main">
          <div class="container">
            <div class="page-title">
              <div class="title_left">
                <h3>Penelitian dan Publikasi</h3>
              </div>

            <div class="">
              <div class="col-md-12 col-sm-12">
                <div class="x_panel">

              <div class="x_content">
                    <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" href="{{ route('publikasi.artikel.index') }}" aria-selected="true">Artikel Ilmiah</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="{{ route('publikasi.produk.index') }}" aria-selected="true">Produk</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="{{ route('publikasi.pkm.index') }}" aria-selected="true">Pkm</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="{{ route('publikasi.penelitian.index') }}" aria-selected="true">Penelitian Dosen</a>
                      </li>
                    </ul>
                  </div>

              @yield ('data')

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- /page content -->

{{-- untuk split halaman di publikasi --}}
<script type="text/javascript">
$(document).ready(() => {
  let url = location.href.replace(/\/$/, "");

  if (location.hash) {
    const hash = url.split("#");
    $('#myTab a[href="#'+hash[1]+'"]').tab("show");
    url = location.href.replace(/\/#/, "#");
    history.replaceState(null, null, url);
    setTimeout(() => {
      $(window).scrollTop(0);
    }, 400);
  }

  $('a[data-toggle="tab"]').on("click", function() {
    let newUrl;
    const hash = $(this).attr("href");
    if(hash == "#home") {
      newUrl = url.split("#")[0];
    } else {
      newUrl = url.split("#")[0] + hash;
    }
    newUrl += "/";
    history.replaceState(null, null, newUrl);
  });
});
</script>

{{-- untuk perulangan di data publikasi untuk kolom npm mahasiswa --}}
{{-- <script type="text/javascript">
    $(document).ready(function() {
      $(".add-more").click(function(){
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });

      // saat tombol remove dklik control group akan dihapus
      $("body").on("click",".remove",function(){
          $(this).parents(".control-group").remove();
      });
    });
</script> --}}

@stop

