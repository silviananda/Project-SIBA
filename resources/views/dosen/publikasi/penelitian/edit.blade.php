@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
                <div class="x_title">

                    <h2>Form Ubah Data Keterlibatan Mahasiswa dalam Penelitian Dosen</h2>
                    <ul class="nav navbar-right panel_toolbox"></ul>
                    <div class="clearfix"></div>
                </div>

                <form role="form" action="{{ route('publikasi.penelitian.update', $data_penelitian->id) }}" method="post" enctype="multipart/form-data">
                    @method('patch')
                    @csrf

                    <div class="form-group">
                        <input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->dosen_id }}" name="dosen_id">

                        @error('dosen_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

	                <div class="form-group">
						<label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nip }}">

						@error('nip')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nama_dosen }}">

						@error('nama_dosen')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tema Roadmap Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
                        <input type="text" class="form-control @error('tema') is-invalid @enderror" placeholder="" name="tema" value="{{ $data_penelitian->tema }}">

                        @error('tema')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Judul Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
                        <input type="text" class="form-control @error('judul_penelitian') is-invalid @enderror" placeholder="" name="judul_penelitian" value="{{ $data_penelitian->judul_penelitian }}">

                        @error('judul_penelitian')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($data_penelitian->penelitianmhs != null)
                    <div id="mahasiswa_fields">
                        @foreach ($data_penelitian->penelitianmhs as $item)
                        <div class="form-group mhs-{{$item->mahasiswa->id ?? null}}">
                            <div class="input-mahasiswa form-group">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">NPM Mahasiswa yang berpartisipasi</label>
                                    <div class="input-group">
                                        <input type="text" oninput="autofillmhs('mahasiswa1')" class="mahasiswa1 form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm" value="{{ $item->mahasiswa->nama ?? null }}">

                                        {{-- <span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="remove_mahasiswa_fields();"> <i class="fa fa-minus"></i></span> --}}
                                        <span class="input-group-btn">
                                            <button data-room="{{ $data_penelitian->id ?? null }}" data-mhs_id="{{ $item->mahasiswa->id ?? null }}" class="btn btn-danger" type="button" onclick="remove_mahasiswa_fields_edit({{$item->mahasiswa->id ?? null}});">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </span>
                                    <span class="mahasiswa1 danger" style="color: #DC143C;" id="ErrorVal"></span>
                                    </div>

                                    <div class="form-group form-material row">
                                        <input type="hidden" class="mahasiswa1 form-control" id="input-id" name="mhs_id[]" value="{{ $item->mahasiswa->id ?? null }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div>
                        <button class="btn btn-success" type="button" onclick="mahasiswa_fields();"><i class="fa fa-plus"></i></button>
                    </div>
                    @else
                    <div id="mahasiswa_fields">
                        @foreach ($data_penelitian->penelitianmhs as $item)
                        <div class="form-group mhs-{{$item->mahasiswa->id ?? null}}">
                            <div class="input-mahasiswa form-group">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nama Mahasiswa yang berpartisipasi</label>
                                    <div class="input-group">
                                        <input type="text" oninput="autofillmhs('mahasiswa1')" class="mahasiswa1 form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm" value="{{ $item->mahasiswa->nama ?? null }}">

                                        {{-- <span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="remove_mahasiswa_fields();"> <i class="fa fa-minus"></i></span> --}}
                                        <span class="input-group-btn">
                                            <button data-room="{{ $data_penelitian->id ?? null }}" data-mhs_id="{{ $item->mahasiswa->id ?? null }}" class="btn btn-danger" type="button" onclick="remove_mahasiswa_fields_edit({{$item->mahasiswa->id ?? null}});">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </span>
                                    <span class="mahasiswa1 danger" style="color: #DC143C;" id="ErrorVal"></span>
                                    </div>

                                    <div class="form-group form-material row">
                                        <input type="hidden" class="mahasiswa1 form-control" id="input-id" name="mhs_id[]" value="{{ $item->mahasiswa->id ?? null }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div>
                        <button class="btn btn-success" type="button" onclick="mahasiswa_fields();"><i class="fa fa-plus"></i></button>
                    </div>

                    @endif

                    <label for="exampleFormControlInput1">Sumber Dana</label>
                    <select name="sumber_dana_id" class="form-control @error('sumber_dana_id') is-invalid @enderror">
                        <option value="">Pilih Sumber Dana</option>
                        @foreach ($sumber_dana as $data)
                        <option value="{{ $data->id }}" {{$data->id == $data_penelitian->sumber_dana_id ? 'selected' : ''}}>{{ $data->nama_sumber_dana}}</option>
                        @endforeach
                    </select>
                    @error('sumber_dana_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <br>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Jumlah Dana</label>
                        <input type="text" class="form-control @error('jumlah_dana') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_dana" value="{{ $data_penelitian->jumlah_dana }}">

                        @error('jumlah_dana')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <span class="danger" style="color: #DC143C;">*Input dengan format angka, contoh : 100000</span>
                        <br>
                        <span class="danger" style="color: #DC143C;">*Jika data kosong, input : 0</span>
                    <br>
                    <br>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tahun Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
                        <select name="tahun_penelitian" class="form-control @error('tahun_penelitian') is-invalid @enderror">
                            <option value="">Pilih Tahun</option>
                            @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++) <option value="{{$year}}" {{$year == $data_penelitian->tahun_penelitian ? 'selected': ''}}>{{$year}}</option>
                                @endfor
                        </select>
                        @error('tahun_penelitian')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Bukti Penelitian</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="softcopy">
                    </div>

                    {{-- untuk verifikasi --}}
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_verification" class="js-switch" {{ $data_penelitian->is_verification ? 'checked' : ' ' }} style="display: none;"> Verifikasi
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                    <a href="{{ route('publikasi.penelitian.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

                </form>
            </div>
        </div>
    </div>
</div>
@stop