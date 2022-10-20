@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                <div class="x_title">
                    <h2>Form Ubah Data Aktivitas Dosen</h2>
                    <ul class="nav navbar-right panel_toolbox"></ul>
                    <div class="clearfix"></div>
                </div>

                <form role="form" action="{{ route('dosen.tetap.aktivitas.update', $aktivitas->id) }}" method="post">
                    @method('patch')
                    @csrf

                    <div class="x_panel">
                        <div class="x_title">

                            <h6><i class="fa fa-align-left">&nbsp;&nbsp; </i>Data Aktivitas Pengajaran Dosen</h6>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="row">

                                <div class="x_content">

                                    <div class="form-group">
                                        <input type="hidden" class="form-control" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

                                        @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
                                        <input type="text" oninput="autofill('dosen-tetap')" class="dosen-tetap form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" required="required" value="{{ $aktivitas->dosen['nip'] }}">

                                        @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
						            <span class="dosen-tetap danger" style="color: #DC143C;" id="ShowError"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
                                        <input type="text" disabled="disable" class="dosen-tetap form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen" value="{{ $aktivitas->dosen['nama_dosen'] }}">
                                    </div>

                                    <div class="form-group form-material row">
                                        <input type="hidden" class="dosen-tetap form-control @error('dosen_id') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="dosen_id" value="{{ $aktivitas->dosen_id }}">
                                    </div>

                                    @if ($aktivitas->aktivitas_dosen != null)
                                    <div id="ps_sendiri_fields">
                                        @foreach ($aktivitas->aktivitas_dosen as $item)

                                        <div class="form-group kode-{{$item->kurikulum->id ?? null}}">
                                            <div class="input-ps-sendiri form-group">

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Jenis Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
                                                    <select class="form-control @error('ket') is-invalid @enderror" name="ket[]" required>
                                                        <option value="">Pilih</option>
                                                        <option value="PS Sendiri" {{$item['ket'] == 'PS Sendiri'? 'selected' : ''}}>Program Studi Sendiri</option>
                                                        <option value="PS Lain" {{$item['ket'] == 'PS Lain'? 'selected' : ''}}>Program Studi Lain</option>
                                                        <option value="PS luar PT" {{$item['ket'] == 'PS luar PT'? 'selected' : ''}}>Program Studi Lain di Luar PT</option>
                                                    </select>

                                                    @error('ket')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Kode Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>

                                                    <div class="input-group">
                                                        <input type="text" oninput="autofillmk('kode_mk')" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="kode_mk" placeholder="Masukkan Kode MK" name="kode_mk[]" value="{{ $item->kurikulum->kode_mk ?? null }}">

                                                        <span class="input-group-btn">
                                                            <button data-room="{{ $aktivitas->id ?? null }}" data-kode_mk="{{ $item->kurikulum->id ?? null }}" class="btn btn-danger" type="button" onclick="remove_sendiri_fields_edit({{$item->kurikulum->id ?? null}});">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </span>

                                                        @error('kode_mk')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
						                            <span class="kode_mk danger" style="color: #DC143C;" id="ErrorMk"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Nama Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
                                                    <input type="text" disabled="disabled" class="kode_mk form-control" id="nama_mk" name="nama_mk" value="{{ $item->kurikulum->nama_mk ?? null }}">

                                                    @error('nama_mk')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">SKS Pengajaran<span class="danger" style="color: #DC143C;">*</span></label>
                                                    <input type="text" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="bobot_sks" placeholder="" name="bobot_sks[]" value="{{ $item->kurikulum->bobot_sks ?? null }}">

                                                    @error('bobot_sks')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        @endforeach

                                        <button class="btn btn-success" type="button" onclick="ps_sendiri_fields();"><i class="fa fa-plus"></i></button>
                                    </div>
                                    @else
                                    <div id="ps_sendiri_fields" class="form-group">
                                        @foreach ($aktivitas->aktivitas_dosen as $item)

                                        <div class="form-group kode-{{$item->kurikulum->id ?? null}}">
                                            <div class="input-ps-sendiri form-group">

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Jenis Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
                                                    <select class="form-control @error('ket') is-invalid @enderror" name="ket[]">
                                                        <option>Pilih</option>
                                                        <option value="PS Sendiri" {{$item['ket'] == 'PS Sendiri'? 'selected' : ''}}>Program Studi Sendiri</option>
                                                        <option value="PS Lain" {{$item['ket'] == 'PS Lain'? 'selected' : ''}}>Program Studi Lain</option>
                                                        <option value="PS luar PT" {{$item['ket'] == 'PS luar PT'? 'selected' : ''}}>Program Studi Lain di Luar PT</option>
                                                    </select>

                                                    @error('ket')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Kode Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>

                                                    <div class="input-group">
                                                        <input type="text" oninput="autofillmk('kode_mk')" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="kode_mk" placeholder="Masukkan Kode MK" name="kode_mk[]" value="{{ $item->kurikulum->kode_mk ?? null }}">

                                                        <span class="input-group-btn">
                                                            <button data-room="{{ $aktivitas->id ?? null }}" data-kode_id="{{ $item->kurikulum->id ?? null }}" class="btn btn-danger" type="button" onclick="remove_sendiri_fields_edit({{$item->kurikulum->id ?? null}});">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </span>

                                                        @error('kode_mk')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
						                            <span class="kode_mk danger" style="color: #DC143C;" id="ErrorMk"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Nama Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
                                                    <input type="text" disabled="disabled" class="kode_mk form-control" id="nama_mk" name="nama_mk" value="{{ $item->kurikulum->nama_mk ?? null }}">

                                                    @error('nama_mk')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">SKS Pengajaran<span class="danger" style="color: #DC143C;">*</span></label>
                                                    <input type="text" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="bobot_sks" placeholder="" name="bobot_sks[]" value="{{ $item->kurikulum->bobot_sks ?? null }}">

                                                    @error('bobot_sks')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

						                    <span class="danger" style="color: #DC143C;" id="ShowErrorMk"></span>

                                            </div>
                                        </div>
                                        @endforeach

                                        {{-- <input type="hidden" class="kode_mk form-control" id="nama_mk" name="ket[]" value={{ "ps_sendiri" }}> --}}

                                        <button class="btn btn-success" type="button" onclick="ps_sendiri_fields();"><i class="fa fa-plus"></i></button>
                                    </div>
                                    @endif
                                    <br>

                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h6><i class="fa fa-align-left">&nbsp;&nbsp; </i>Data Aktivitas Lainnya</h6>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                            <div class="row">
                                                <div class="col-md-6 col-sm-12  form-group">
                                                    <label for="exampleFormControlInput1">SKS Penelitian</label>
                                                    <input type="text" class="form-control @error('sks_penelitian') is-invalid @enderror" placeholder="" name="sks_penelitian" value="{{ $aktivitas->sks_penelitian }}">

                                                    @error('sks_penelitian')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-sm-12  form-group">
                                                    <label for="exampleFormControlInput1">SKS Pengabdian</label>
                                                    <input type="text" class="form-control @error('sks_p2m') is-invalid @enderror" placeholder="" name="sks_p2m" value="{{ $aktivitas->sks_p2m }}">

                                                    @error('sks_p2m')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-sm-12  form-group">
                                                    <label for="exampleFormControlInput1">SKS Tugas Tambahan dan/atau Penunjang</label>
                                                    <input type="text" class="form-control @error('m_pt_sendiri') is-invalid @enderror" placeholder="" name="m_pt_sendiri" value="{{ $aktivitas->m_pt_sendiri }}">

                                                    @error('m_pt_sendiri')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <label for="exampleFormControlInput1">Tahun Aktivitas<span class="danger" style="color: #DC143C;">*</span></label>
                                                    <select name="tahun" class="form-control" required>
                                                        <option value="">Pilih Tahun Aktivitas</option>
                                                        @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++) <option value="{{$year}}" {{$year == $aktivitas->tahun ? 'selected': ''}}>{{$year}}</option>
                                                            @endfor
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                                    <a href="{{ route('dosen.tetap.aktivitas.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@stop