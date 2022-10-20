@extends('dosen.layout.main')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <h4>Biodata Dosen</h4>
      <div class="">
        <div class="col-md-12 col-sm-12">
          <div class="x_panel">
            <div class="x_title">

              <h2><i class="fa fa-align-left"></i> Data Pribadi </h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a href="{{ route('biodata.edit') }}"><i class="fa fa-wrench" style="color: #778899"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="">
                <ul class="to_do">
                  <li>
                    <p>
                      <span class="message">
                        Nama Dosen : {{ \Auth::guard('dosen')->user()->nama_dosen }}
                        </pre>
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Tempat/Tanggal Lahir : {{ \Auth::guard('dosen')->user()->tempat }}/{{ \Auth::guard('dosen')->user()->tgl_lahir }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        NIP : {{ \Auth::guard('dosen')->user()->nip }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        NIDN: {{ \Auth::guard('dosen')->user()->nidn }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Nomor Sertifikat Kompetensi : {{ \Auth::guard('dosen')->user()->sertifikat_kompetensi }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Nomor Sertifikat Pendidik : {{ \Auth::guard('dosen')->user()->sertifikat_pendidik }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Email : {{ \Auth::guard('dosen')->user()->email }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Bidang : {{ \Auth::guard('dosen')->user()->bidang }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Jabatan Fungsional : {{ \Auth::guard('dosen')->user()->jabatan_fungsional['nama_jabatan'] }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Golongan : {{ \Auth::guard('dosen')->user()->golongan }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Scopus : {{ \Auth::guard('dosen')->user()->scopus }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        Sinta : {{ \Auth::guard('dosen')->user()->sinta }}
                      </span>
                  </li>
                  <li>
                    <p>
                      <span class="message">
                        WOS : {{ \Auth::guard('dosen')->user()->wos }}
                      </span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_title">

            <h2><i class="fa fa-align-left"></i> Data Pendidikan </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a href="{{ route('biodata.edit') }}"><i class="fa fa-wrench" style="color: #778899"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="">
              <ul class="to_do">
                <li>
                  <p>
                    <span class="message">
                      Pendidikan S1 : {{ \Auth::guard('dosen')->user()->pend_s1 }}
                    </span>
                </li>
                <li>
                  <p>
                    <span class="message">
                      Pendidikan S2 : {{ \Auth::guard('dosen')->user()->pend_s2 }}
                    </span>
                </li>
                <li>
                  <p>
                    <span class="message">
                      Pendidikan S3 : {{ \Auth::guard('dosen')->user()->pend_s3 }}
                    </span>
                </li>
              </ul>
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