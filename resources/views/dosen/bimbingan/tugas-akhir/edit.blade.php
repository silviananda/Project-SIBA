@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
					<h2>Form Ubah Data Bimbingan Tugas Akhir</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>

				<form role="form" action="{{ route('bimbingan.tugas-akhir.update', $data_pembimbing_ta->id) }}" method="post">
					@method('patch')
					@csrf

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

					@if($data_pembimbing_ta->jenis_id1 != null)
						<label for="exampleFormControlInput1">Kategori Mahasiswa Bimbingan<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jenis_id" class="form-control @error('jenis_id') is-invalid @enderror" required="required">
							<option value="">Pilih Kategori</option>
								@foreach ($jenis_bimbingan as $data)
									<option value="{{ $data->id }}" {{$data->id == $data_pembimbing_ta->jenis_id1 ? 'selected' : ''}}>{{ $data->jenis}}</option>
								@endforeach
						</select>
						@error('jenis')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
						<br>
					@else
						<label for="exampleFormControlInput1">Kategori Mahasiswa Bimbingan<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jenis_id" class="form-control @error('jenis_id') is-invalid @enderror" required="required">
							<option value="">Pilih Kategori</option>
								@foreach ($jenis_bimbingan as $data)
									<option value="{{ $data->id }}" {{$data->id == $data_pembimbing_ta->jenis_id2 ? 'selected' : ''}}>{{ $data->jenis}}</option>
								@endforeach
						</select>
						@error('jenis')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
						<br>
					@endif

                    <label for="exampleFormControlInput1">Tahun Mulai Bimbingan<span class="danger" style="color: #DC143C;">*</span></label>
                        <select name="tahun" class="form-control" required>
                            <option value="">Pilih Tahun Mulai Bimbingan</option>
                                @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++) <option value="{{$year}}" {{$year == $data_pembimbing_ta->tahun ? 'selected': ''}}>{{$year}}</option>
                                @endfor
                        </select>
					<br>

					@if($data_pembimbing_ta->doping1 != 0)
						<label for="exampleFormControlInput1">Kategori Pembimbing<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" readonly="readonly">
							<option value="">Pilih Kategori Pembimbing</option>
								@foreach ($kategori_pembimbing as $data)
									<option value="{{ $data->id }}" {{$data->id == "1" ? 'selected' : ''}}>{{ $data->jenis}}</option>
								@endforeach
						</select>
						@error('kategori_id')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
						<br>
					@else
						<label for="exampleFormControlInput1">Kategori Pembimbing<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" readonly="readonly">
							<option value="">Pilih Kategori Pembimbing</option>
								@foreach ($kategori_pembimbing as $data)
									<option value="{{ $data->id }}" {{$data->id == "2" ? 'selected' : ''}}>{{ $data->jenis}}</option>
								@endforeach
						</select>
						@error('kategori_id')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
						<br>
					@endif

					<div class="form-group">
						<label for="exampleFormControlInput1">NPM<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" disabled="disabled" class="form-control @error('npm') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="npm" value="{{ $data_pembimbing_ta->biodata_mhs['npm'] }}">

                        <span class="mahasiswa danger" style="color: #DC143C;" id="ErrorVal"></span>
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">Nama Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" disabled="disabled" class="form-control @error('nama') is-invalid @enderror" disabled="disable" id="exampleFormControlInput1" placeholder="" name="nama" value="{{ $data_pembimbing_ta->biodata_mhs['nama'] }}">
					</div>

					<div class="form-group form-material row">
						<input type="hidden" class="form-control @error('mhs_id') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="mhs_id" value="{{ $data_pembimbing_ta->mhs_id }}">
					</div>

					<button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
					<a href="{{ route('bimbingan.tugas-akhir.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

				</form>
			</div>
		</div>
	</div>
</div>
@stop