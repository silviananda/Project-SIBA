@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
					<h2>Form Ubah Data Artikel Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>

				<form role="form" action="{{ route('publikasi.artikel.update', $artikel_dosen->id) }}" method="post" enctype="multipart/form-data">
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
						<label for="exampleFormControlInput1">Judul Artikel<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" class="form-control @error('judul') is-invalid @enderror" placeholder="" name="judul" value="{{ $artikel_dosen->judul }}">

						@error('judul')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<label for="exampleFormControlInput1">Judul Penelitian dan Pengembangan Kepada Masyarakat<span class="danger" style="color: #DC143C;">*</span></label>
					<select name="pkm_id" class="form-control @error('pkm_id') is-invalid @enderror">
						<option value="">Pilih Pkm</option>
						@foreach ($data_pkm as $data)
						<option value="{{ $data->id }}" {{$data->id == $artikel_dosen->pkm_id ? 'selected' : ''}}>{{ $data->judul_pkm}}</option>
						@endforeach
					</select>
					@error('pkm_id')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
					<br>

					<label for="exampleFormControlInput1">Tingkat<span class="danger" style="color: #DC143C;">*</span></label>
					<select name="id_tingkat" class="form-control @error('id_tingkat') is-invalid @enderror">
						<option value="">Pilih Kategori Tingkat</option>
						@foreach ($kategori_tingkat as $data)
						<option value="{{ $data->id }}" {{$data->id == $artikel_dosen->id_tingkat ? 'selected' : ''}}>{{ $data->nama_kategori}}</option>
						@endforeach
					</select>
					@error('id_tingkat')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
					<br>

					<label for="exampleFormControlInput1">Jenis Publikasi<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jenis_publikasi" class="form-control @error('jenis_publikasi') is-invalid @enderror">
							<option value="">Pilih Jenis Publikasi</option>
							@foreach ($jenis_publikasi as $data)
							<option value="{{ $data->id }}" {{$data->id == $artikel_dosen->jenis_publikasi ? 'selected' : ''}}>{{ $data->jenis_publikasi}}</option>
							@endforeach
						</select>
						@error('jenis_publikasi')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					<br>

					<div class="form-group">
						<label for="exampleFormControlInput1">Jumlah Artikel yang mensitasi</label>
						<input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah" value="{{ $artikel_dosen->jumlah }}">

						@error('jumlah')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">Tahun Publikasi<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
							<option value="">Pilih Tahun Publikasi</option>
							@for ($year = date('Y') - 7; $year < date('Y') + 10; $year++) <option value="{{$year}}" {{$year == $artikel_dosen->tahun ? 'selected': ''}}>{{$year}}</option>
								@endfor
						</select>

						@error('tahun')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">Bukti</label>
						<input type="file" class="form-control-file" id="softcopy" name="softcopy" value="{{ $artikel_dosen->softcopy }}">
					</div>

					{{-- untuk verifikasi --}}
					<div class="form-group">
						<label>
							<input type="checkbox" name="is_verification" class="js-switch" {{ $artikel_dosen->is_verification ? 'checked' : ' ' }} style="display: none;"> Verifikasi
						</label>
					</div>

					<button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
					<a href="{{ route('publikasi.artikel.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

				</form>
			</div>
		</div>
	</div>
</div>
@stop