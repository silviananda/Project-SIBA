@extends('super.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Akun Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('data-dosen.store') }}" method="post">
					@csrf

                    <div class="form-group">
                        <input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->user_id !!}">
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <label for="exampleFormControlInput1">Nama Jurusan</label>
                    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                        <option value="">Pilih Jurusan</option>
                            @foreach ($jurusan as $data)
                                <option value="{{ $data->jurusan }}" {{ old('user_id') == $data->jurusan ? 'selected' : null }} >{{ $data->nama_jurusan}}</option>
                            @endforeach
                    </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama</label>
							<input type="text" class="form-control @error('nama_dosen') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama_dosen" value="{{ old ('nama_dosen') }}">

							@error('nama_dosen')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Email</label>
							<input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="email" value="{{ old ('email') }}">

							@error('email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Password Akun SIBA</label>
							<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="" name="password" value="{{ old ('password') }}">

							@error('password')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ URL::to('data-admin') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
