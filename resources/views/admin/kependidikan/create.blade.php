@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Tenaga Kependidikan</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('tenaga-kependidikan.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">NIP/NIPK<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nidn') is-invalid @enderror" id="nidn" placeholder="" name="nidn" value="{{ old ('nidn') }}">
                            @error('nidn')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Tenaga Kependidikan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="" name="nama" value="{{ old ('nama') }}">
                            @error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Lahir<span class="danger" style="color: #DC143C;">*</span></label>
                                <input id="tgl_lahir" class="date-picker form-control @error('tgl_lahir') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tgl_lahir" value="{{ old ('tgl_lahir') }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>
							@error('tgl_lahir')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Alamat<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('alamat') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="alamat" value="{{ old ('alamat') }}">

							@error('alamat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Unit Kerja<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="unit_kerja_id" class="form-control @error('unit_kerja_id') is-invalid @enderror">
							<option value="">Pilih Unit Kerja</option>
								@foreach ($data_unit_kerja as $data)
									<option value="{{ $data->id }}" {{ old('unit_kerja_id') == $data->id ? 'selected' : null }} >{{ $data->unit}}</option>
								@endforeach
						</select>
							@error('unit_kerja_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<label for="exampleFormControlInput1">Profesi<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="data_tenaga_kependidikan_id" class="form-control @error('data_tenaga_kependidikan_id') is-invalid @enderror">
							<option value="">Pilih Profesi</option>
								@foreach ($data_tenaga_kependidikan as $data)
									<option value="{{ $data->id }}" {{ old('data_tenaga_kependidikan_id') == $data->id ? 'selected' : null }} >{{ $data->posisi}}</option>
								@endforeach
						</select>
							@error('data_tenaga_kependidikan_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<label for="exampleFormControlInput1">Pendidikan Terakhir<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="pendidikan_id" class="form-control @error('pendidikan_id') is-invalid @enderror">
							<option value="">Pilih Pendidikan Terakhir</option>
								@foreach ($daftar_pendidikan as $data)
									<option value="{{ $data->id }}" {{ old('pendidikan_id') == $data->id ? 'selected' : null }} >{{ $data->nama_pendidikan}}</option>
								@endforeach
						</select>
							@error('pendidikan_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('tenaga-kependidikan.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
