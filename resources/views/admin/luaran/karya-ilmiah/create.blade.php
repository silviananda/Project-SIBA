@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Karya Ilmiah Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('luaran.karya-ilmiah.store') }}" method="post" enctype="multipart/form-data">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
								<label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
								<input type="text" oninput="autofill('dosen')" class="dosen form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
						
							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                            <span class="dosen danger" style="color: #DC143C;" id="ShowError"></span>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
						</div>
						<span class="danger" style="color: #DC143C;" id="ShowError"></span>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Link Google Scholar<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="url" class="form-control @error('link') is-invalid @enderror" id="exampleFormControlInput1"  placeholder="https://example.com" name="link" value="{{ old ('link') }}">

							@error('link')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('luaran.karya-ilmiah.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>


@stop
