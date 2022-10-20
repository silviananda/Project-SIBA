@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
					<h2>Form Tambah Data Prestasi Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>

				<form role="form" action="{{ route('prestasi-dosen.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->dosen_id }}" name="dosen_id">

						@error('dosen_id')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->user_id }}" name="user_id">
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
						<label for="exampleFormControlInput1">Judul Prestasi<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" class="form-control @error('judul_prestasi') is-invalid @enderror" placeholder="" name="judul_prestasi" value="{{ old ('judul_prestasi') }}">

						@error('judul_prestasi')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<label for="exampleFormControlInput1">Tingkat<span class="danger" style="color: #DC143C;">*</span></label>
					<select name="tingkat" class="form-control @error('tingkat') is-invalid @enderror">
						<option value="">Pilih Kategori Tingkat</option>
						@foreach ($kategori_tingkat as $data)
						<option value="{{ $data->id }}" {{ old('tingkat') == $data->id ? 'selected' : null }}>{{ $data->nama_kategori}}</option>
						@endforeach
					</select>
					@error('tingkat')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
					<br>

					<div class="form-group">
						<label for="exampleFormControlInput1">Tahun Prestasi<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
							<option value="">Pilih Tahun Prestasi</option>
							@for ($year = date('Y') - 7; $year < date('Y') + 10; $year++) <option value="{{$year}}" {{ old('tahun') == $prestasi_dosen ? 'selected': ''}}>{{$year}}</option>
								@endfor
						</select>
						@error('tahun')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="softcopy">Bukti Prestasi</label>
						<input type="file" class="form-control-file" id="softcopy" name="softcopy">
					</div>

					<button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
					<a href="{{ route('prestasi-dosen.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

				</form>
			</div>
		</div>
	</div>
</div>
@stop