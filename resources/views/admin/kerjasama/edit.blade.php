@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Kerjasama</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('kerjasama.update', $kerjasama->id) }}" method="post" enctype="multipart/form-data">
					@method('patch')
					@csrf
						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Lembaga Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama_instansi') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama_instansi" value="{{ $kerjasama->nama_instansi }}">

							@error('nama_instansi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Kegiatan Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul_kegiatan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="judul_kegiatan" value="{{ $kerjasama->judul_kegiatan }}">

							@error('judul_kegiatan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>


						<label for="exampleFormControlInput1">Jenis Tingkat Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="id_kategori_tingkat" class="form-control @error('id_kategori_tingkat') is-invalid @enderror">
							<option value="">Pilih Kategori Tingkat</option>
								@foreach ($kategori_tingkat as $data)
									<option value="{{ $data->id }}" {{$data->id == $kerjasama->id_kategori_tingkat ? 'selected' : ''}} >{{ $data->nama_kategori}}</option>
								@endforeach
						</select>
							@error('id_kategori_tingkat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<label for="exampleFormControlInput1">Jenis Kategori Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="id_kategori_kerjasama" class="form-control @error('id_kategori_kerjasama') is-invalid @enderror">
							<option value="">Pilih Kategori</option>
								@foreach ($kategori_kerjasama as $data)
									<option value="{{ $data->id }}" {{$data->id == $kerjasama->id_kategori_kerjasama ? 'selected' : ''}} >{{ $data->kategori}}</option>
								@endforeach
						</select>
							@error('id_kategori_kerjasama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Manfaat bagi PS yang diakreditasi</label>
							<input type="text" class="form-control @error('manfaat') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="manfaat" value="{{ $kerjasama->manfaat }}">

							@error('manfaat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Kerjasama<span class="danger" style="color: #DC143C;">*</span></label>
                                <input id="tanggal_kegiatan" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tanggal_kegiatan" value="{{ $kerjasama->tanggal_kegiatan }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Kepuasan Kerjasama</label>
							<input type="text" class="form-control @error('kepuasan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="kepuasan" value="{{ $kerjasama->kepuasan }}">

							@error('kepuasan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Bukti Kerjasama</label>
							<input type="file" class="form-control-file @error('softcopy') is-invalid @enderror" id="softcopy" name="softcopy" value="{{ $kerjasama->softcopy }}">
                        
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
