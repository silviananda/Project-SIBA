@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Pustaka</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('sarana.pustaka.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jenis Pustaka<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jenis_pustaka') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jenis_pustaka" value="{{ old ('jenis_pustaka') }}">

							@error('jenis_pustaka')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Judul<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jumlah_judul') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_judul" value="{{ old ('jumlah_judul') }}">

							@error('jumlah_judul')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Copy<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jumlah_copy') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_copy" value="{{ old ('jumlah_copy') }}">

							@error('jumlah_copy')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('sarana.pustaka.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
