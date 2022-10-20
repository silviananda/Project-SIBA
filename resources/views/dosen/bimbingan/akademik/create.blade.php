@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Bimbingan Akademik</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('bimbingan.akademik.store') }}" method="post">
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
                            <label for="exampleFormControlInput1">NPM<span class="danger" style="color: #DC143C;">*</span></label>
								<input type="text" oninput="autofillmhs('mahasiswa')" class="mahasiswa form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm">

                            @error('npm')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group form-material row">
							<input type="hidden" class="mahasiswa form-control" id="input-id" name="mhs_id">
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text"  disabled="disabled" class="mahasiswa form-control" id="nama" name="nama">

							@error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Tahun Masuk<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="mahasiswa form-control" id="tahun_masuk" name="tahun_masuk">

							@error('tahun_masuk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('bimbingan.akademik.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
