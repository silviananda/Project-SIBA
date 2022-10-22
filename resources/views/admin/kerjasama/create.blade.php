@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Kerjasama</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                    <form role="form" action="{{ route('kerjasama.store') }}" method="post" enctype="multipart/form-data">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Lembaga Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama_instansi') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama_instansi" value="{{ old ('nama_instansi') }}">

							@error('nama_instansi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Jenis Tingkat Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="id_kategori_tingkat" class="form-control @error('id_kategori_tingkat') is-invalid @enderror">
							<option value="">Pilih Tingkat Kerjasama</option>
								@foreach ($kategori_tingkat as $data)
									<option value="{{ $data->id }}" {{ old('id_kategori_tingkat') == $data->id ? 'selected' : null }}>{{ $data->nama_kategori }}</option>
                                @endforeach
						</select>
                            @error('id_kategori_tingkat')
							    <div class="invalid-feedback">{{ $message }}</div>
						    @enderror
                        <br>

						<label for="exampleFormControlInput1">Kategori Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="id_kategori_kerjasama" class="form-control @error('id_kategori_kerjasama') is-invalid @enderror">
							<option value="">Pilih Kategori Kerjasama</option>
								@foreach ($kategori_kerjasama as $data)
									<option value="{{ $data->id }}" {{ old('id_kategori_kerjasama') == $data->id ? 'selected' : null }}>{{ $data->kategori }}</option>
                                @endforeach
						</select>

                            @error('id_kategori_kerjasama')
							    <div class="invalid-feedback">{{ $message }}</div>
						    @enderror
						<br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Kegiatan Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul_kegiatan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="judul_kegiatan" value="{{ old ('judul_kegiatan') }}">

							@error('judul_kegiatan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Manfaat bagi PS yang diakreditasi</label>
							<input type="text" class="form-control @error('manfaat') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="manfaat" value="{{ old ('manfaat') }}">

							@error('manfaat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
                                <input id="tanggal_kegiatan" class="date-picker form-control @error('tanggal_kegiatan') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tanggal_kegiatan" value="{{ old ('tanggal_kegiatan') }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>

							@error('tanggal_kegiatan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Kepuasan Kerjasama</label>
							<input type="text" class="form-control @error('kepuasan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="kepuasan" value="{{ old ('kepuasan') }}">

							@error('kepuasan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="softcopy">Bukti Kerjasama</label>
							<input type="file" class="form-control-file @error('softcopy') is-invalid @enderror" id="softcopy" name="softcopy">

							@error('softcopy')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('kerjasama.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
