@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Penggunaan Dana</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('alokasi-dana.penggunaan.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Kategori Pengelola<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="kategori_pengelola_id" class="form-control @error('kategori_pengelola_id') is-invalid @enderror">
							<option value="">Pilih Kategori Pengelola</option>
								@foreach ($kategori_pengelola as $data)
									<option value="{{ $data->id }}" {{ old('kategori_pengelola_id') == $data->id ? 'selected' : null }} >{{ $data->pengelola}}</option>
								@endforeach
						</select>
							@error('kategori_pengelola_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>


						<label for="exampleFormControlInput1">Jenis Penggunaan<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jenis_penggunaan_id" class="form-control @error('jenis_penggunaan_id') is-invalid @enderror">
							<option value="">Pilih Jenis Penggunaan</option>
								@foreach ($jenis_penggunaan as $data)
									<option value="{{ $data->id }}" {{ old('jenis_penggunaan_id') == $data->id ? 'selected' : null }} >{{ $data->nama_jenis_penggunaan}}</option>
								@endforeach
						</select>
							@error('jenis_penggunaan_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Dana<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('dana') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="dana" value="{{ old ('dana') }}">

							@error('dana')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>
						<span class="danger" style="color: #DC143C;">*Input dengan format angka, contoh : 100000</span>
						<br>
						<br>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Penggunaan Dana<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun') == $penggunaan_dana ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('alokasi-dana.penggunaan.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
