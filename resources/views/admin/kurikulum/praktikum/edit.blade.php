@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Praktikum</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('kurikulum.praktikum.update', $praktikum->id) }}" method="post">
					@method('patch')
					@csrf

                        <div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Kode Matakuliah Praktek<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofillmk('mk')" class="mk form-control @error('kode_mk') is-invalid @enderror" id="kode_mk" placeholder="Masukkan Kode MK" name="kode_mk" value="{{ $praktikum->kurikulum['kode_mk'] }}">
                        
							@error('kode_mk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						    <span class="mk danger" style="color: #DC143C;" id="ErrorMk"></span>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Matakuliah<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" disabled="disabled" class="mk form-control @error('nama_mk') is-invalid @enderror" id="nama_mk" placeholder="" name="nama_mk" value="{{ $praktikum->kurikulum['nama_mk'] }}">
					
						</div>


						<div class="form-group">
							<label for="exampleFormControlInput1">Judul/Modul<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="judul" value="{{ $praktikum->judul }}">

							@error('judul')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jam Pelaksanaan</label>
							<input type="time" id="datetimenew" class="form-control @error('jam') is-invalid @enderror" placeholder="" name="jam" value="{{ $praktikum->jam }}">

							@error('jam')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						{{-- <div class='col-sm-4'>
							Only Time Picker <small>For 24H format use format: 'HH:mm'</small>
							<div class="form-group">
								<div class='input-group date' id='tesaja'>
									<input type='text' class="form-control" />
									<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div> --}}
						

						<div class="form-group">
							<label for="exampleFormControlInput1">Tempat/Lokasi Praktikum/Praktek</label>
							<input type="text" class="form-control @error('tempat') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="tempat" value="{{ $praktikum->tempat }}">

							@error('tempat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('kurikulum.praktikum.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
