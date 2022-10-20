@extends('dosen.layout.main')
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

                <form role="form" action="{{ route('aktivitas.update', $aktivitas->id) }}" method="post">
                    @method('patch')
                    @csrf

                    <div class="x_panel">
                        <div class="x_title">

                            <h6><i class="fa fa-align-left">&nbsp;&nbsp; </i>Aktivitas Pengajaran Dosen</h6>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="row">

                                <div class="x_content">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->dosen_id }}" name="dosen_id">

                                        @error('dosen_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

									<div class="form-group">
										<label for="exampleFormControlInput1">NIP Dosen</label>
										<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nip }}">

										@error('nip')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>

									<div class="form-group">
										<label for="exampleFormControlInput1">Nama Dosen</label>
										<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nama_dosen }}">

										@error('nama_dosen')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>


                                    <div class="form-group form-material row">
                                        <input type="hidden" class="dosen-tetap form-control @error('dosen_id') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="dosen_id" value="{{ $aktivitas->dosen_id }}">
                                    </div>

                                    @if ($aktivitas->aktivitas_dosen != null)
                                    <div id="ps_sendiri_fields" class="form-group">
                                        @foreach ($aktivitas->aktivitas_dosen as $item)

                                        <div class="form-group kode-{{$item->kurikulum->id ?? null}}">
                                            <div class="input-ps-sendiri form-group">

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Jenis Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
                                                    <select class="form-control" name="ket[]" required="required">
                                                        <option>Pilih</option>
                                                        <option value="PS Sendiri" {{$item['ket'] == 'PS Sendiri'? 'selected' : ''}}>Program Studi Sendiri</option>
                                                        <option value="PS Lain" {{$item['ket'] == 'PS Lain'? 'selected' : ''}}>Program Studi Lain</option>
                                                        <option value="PS luar PT" {{$item['ket'] == 'PS luar PT'? 'selected' : ''}}>Program Studi Lain di Luar PT</option>
                                                    </select>
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
                                                    </div>
						                        <span class="kode_mk danger" style="color: #DC143C;" id="ErrorMk"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Nama Mata Kuliah</label>
                                                    <input type="text" disabled="disabled" class="kode_mk form-control" id="nama_mk" name="nama_mk" value="{{ $item->kurikulum->nama_mk ?? null }}">

                                                    @error('nama_mk')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">SKS Pengajaran</label>
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
                                                    <label for="exampleFormControlInput1">Jenis Mata Kuliah</label>
                                                    <select class="form-control" name="ket[]">
                                                        <option>Pilih</option>
                                                        <option value="PS Sendiri" {{$item['ket'] == 'PS Sendiri'? 'selected' : ''}}>Program Studi Sendiri</option>
                                                        <option value="PS Lain" {{$item['ket'] == 'PS Lain'? 'selected' : ''}}>Program Studi Lain</option>
                                                        <option value="PS luar PT" {{$item['ket'] == 'PS luar PT'? 'selected' : ''}}>Program Studi Lain di Luar PT</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Kode Mata Kuliah</label>

                                                    <div class="input-group">
                                                        <input type="text" oninput="autofillmk('kode_mk')" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="kode_mk" placeholder="Masukkan Kode MK" name="kode_mk[]" value="{{ $item->kurikulum->kode_mk ?? null }}">

                                                        <span class="input-group-btn">
                                                            <button data-room="{{ $aktivitas->id ?? null }}" data-kode_id="{{ $item->kurikulum->id ?? null }}" class="btn btn-danger" type="button" onclick="remove_sendiri_fields_edit({{$item->kurikulum->id ?? null}});">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </span>
                                                    </div>
						                        <span class="kode_mk danger" style="color: #DC143C;" id="ErrorMk"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Nama Mata Kuliah</label>
                                                    <input type="text" disabled="disabled" class="kode_mk form-control" id="nama_mk" name="nama_mk" value="{{ $item->kurikulum->nama_mk ?? null }}">

                                                    @error('nama_mk')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">SKS Pengajaran</label>
                                                    <input type="text" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="bobot_sks" placeholder="" name="bobot_sks[]" value="{{ $item->kurikulum->bobot_sks ?? null }}">

                                                    @error('bobot_sks')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                        {{-- <input type="hidden" class="kode_mk form-control" id="nama_mk" name="ket[]" value={{ "ps_sendiri" }}> --}}

                                        <button class="btn btn-success" type="button" onclick="ps_sendiri_fields();"><i class="fa fa-plus"></i></button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>


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

                                {{-- untuk verifikasi --}}
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="is_verification" class="js-switch" {{ $aktivitas->is_verification ? 'checked' : ' ' }} style="display: none;"> Verifikasi
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('aktivitas.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

                </form>
            </div>
        </div>
    </div>
</div>
@stop