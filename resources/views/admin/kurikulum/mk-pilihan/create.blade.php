@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Matakuliah Pilihan</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('kurikulum.mk-pilihan.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Semester<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="semester_id" class="form-control @error('semester_id') is-invalid @enderror">
							<option value="">Pilih Semester</option>
								@foreach ($semester as $data)
									<option value="{{ $data->id }}" {{ old('semester_id') == $data->id ? 'selected' : null }} >{{ $data->nama_semester}}</option>
								@endforeach
						</select>
							@error('semester_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>
						
						<div class="form-group">
							<label for="exampleFormControlInput1">Kode Matakuliah<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('kode_mk') is-invalid @enderror" placeholder="" name="kode_mk" value="{{ old ('kode_mk') }}">

							@error('kode_mk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Matakuliah<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama" value="{{ old ('nama') }}">

							@error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>


						<div class="form-group">
							<label for="exampleFormControlInput1">Bobot Sks<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('bobot_sks') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="bobot_sks" value="{{ old ('bobot_sks') }}">

							@error('bobot_sks')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Bobot Tugas</label>
							<input type="text" class="form-control @error('bobot_tugas') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="bobot_tugas" value="{{ old ('bobot_tugas') }}">

							@error('bobot_tugas')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Unit Pengelola</label>
							<input type="text" class="form-control @error('unit') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="unit" value="{{ old ('unit') }}">

							@error('unit')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('kurikulum.mk-pilihan.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
