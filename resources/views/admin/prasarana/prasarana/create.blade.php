@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Prasarana</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('prasarana.data.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Prasarana<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jenis_prasarana') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jenis_prasarana" value="{{ old ('jenis_prasarana') }}">

							@error('jenis_prasarana')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Total Luas<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('total_luas') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="total_luas" value="{{ old ('total_luas') }}">

							@error('total_luas')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Unit<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jumlah_unit') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_unit" value="{{ old ('jumlah_unit') }}">

							@error('jumlah_unit')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Kepemilikan<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="kepemilikan" class="form-control @error('kepemilikan') is-invalid @enderror">
							<option value="">Pilih Jenis</option>
								@foreach ($kategori_kepemilikan as $data)
									<option value="{{ $data->id }}" {{ old('kepemilikan') == $data->id ? 'selected' : null }} >{{ $data->jenis}}</option>
								@endforeach
						</select>
							@error('kepemilikan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<label for="exampleFormControlInput1">Kondisi<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="kondisi" class="form-control @error('kondisi') is-invalid @enderror">
							<option value="">Pilih Jenis</option>
								@foreach ($kategori_kondisi as $data)
									<option value="{{ $data->id }}" {{ old('kondisi') == $data->id ? 'selected' : null }} >{{ $data->kondisi}}</option>
								@endforeach
						</select>
							@error('kondisi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('prasarana.data.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
