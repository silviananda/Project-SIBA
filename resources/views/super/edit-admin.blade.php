@extends('super.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Ubah Akun Admin</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                    <form role="form" action="{{ route('data-admin.update', $admin->id) }}" method="post">
                        @method('patch')
                        @csrf

						<label for="exampleFormControlInput1">Nama Jurusan</label>
						<select name="kode_ps" class="form-control @error('kode_ps') is-invalid @enderror">
							<option value="">Pilih Jurusan</option>
								@foreach ($jurusan as $data)
									<option value="{{ $data->jurusan }}" {{$data->jurusan == $admin->kode_ps ? 'selected' : ''}} >{{ $data->nama_jurusan}}</option>
								@endforeach
						</select>
							@error('nama_jurusan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Tenaga Kependidikan/Dosen</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="name" value="{{ $admin->name }}">
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Email</label>
							<input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="" name="email" value="{{ $admin->email }}">

							@error('email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Password Akun SIBA</label>
							<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="" name="password" value="{{ $admin->password }}">

							@error('password')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>


                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('bimbingan.tugas-akhir.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
