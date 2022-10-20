@extends('himpunan.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Ubah Data Prestasi Himpunan</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                    <form role="form" action="{{ route('prestasi.update', $prestasi_mhs->id) }}" method="post" enctype="multipart/form-data">
                        @method('patch')
                        @csrf

                        <div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('himpunan')->user()->id }}" name="himpunan_id">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Kegiatan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama_kegiatan" value="{{ $prestasi_mhs->nama_kegiatan }}">

							@error('nama_kegiatan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
								<label for="exampleFormControlInput1">Waktu Kegiatan<span class="danger" style="color: #DC143C;">*</span></label>
									<input id="waktu" class="date-picker form-control @error('waktu') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tahun" value="{{ $prestasi_mhs->tahun }}">
										<script>
											function timeFunctionLong(input) {
											setTimeout(function() {
												input.type = 'text';
												}, 60000);
											}
										</script>
							@error('waktu')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<label for="exampleFormControlInput1">Tingkat<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="tingkat" class="form-control @error('tingkat') is-invalid @enderror">
							<option value="">Pilih Kategori Tingkat</option>
								@foreach ($kategori_tingkat as $data)
									<option value="{{ $data->id }}" {{$data->id == $prestasi_mhs->tingkat ? 'selected' : ''}} >{{ $data->nama_kategori}}</option>
								@endforeach
						</select>
							@error('tingkat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Prestasi yang dicapai<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('prestasi') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="prestasi" value="{{ $prestasi_mhs->prestasi }}">

							@error('prestasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Jenis Prestasi<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jenis_prestasi" class="form-control @error('jenis_prestasi') is-invalid @enderror">
							<option value="">Pilih Jenis Prestasi</option>
								@foreach ($kategori_jenis_prestasi as $data)
									<option value="{{ $data->id }}" {{$data->id == $prestasi_mhs->jenis_prestasi ? 'selected' : null }} >{{ $data->jenis}}</option>
								@endforeach
						</select>
							@error('jenis_prestasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="softcopy">Bukti Prestasi</label>
							<input type="file" class="form-control-file" id="softcopy" name="softcopy">
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('prestasi.index') }}" class="btn btn-danger" style="float: right;">Batal</a>
					</form>
			</div>
        </div>
	</div>
</div>
@stop
