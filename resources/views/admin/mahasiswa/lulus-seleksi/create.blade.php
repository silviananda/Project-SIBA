@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Tambah Data Peserta Lulus Seleksi</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('mahasiswa.lulus-seleksi.store') }}" method="POST">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
							<!-- <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="exampleFormControlInput1" placeholder="hide" value="{!! Auth::user()->kode_ps !!}" name="user_id"> -->
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nomor Ujian<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('no_ujian') is-invalid @enderror" placeholder="" name="no_ujian" value="{{ old ('no_ujian') }}">

							@error('no_ujian')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="" name="nama" value="{{ old ('nama') }}">

							@error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Asal Sekolah<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" placeholder="" name="asal_sekolah" value="{{ old ('asal_sekolah') }}">

							@error('asal_sekolah')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Jalur Masuk<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jalur_masuk_id" class="form-control @error('jalur_masuk_id') is-invalid @enderror">
							<option value="">Pilih Jalur Masuk</option>
								@foreach ($kategori_jalur as $data)
									<option value="{{ $data->id }}" {{ old('jalur_masuk_id') == $data->id ? 'selected' : null }} >{{ $data->jalur_masuk}}</option>
								@endforeach
						</select>
							@error('jalur_masuk_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Lulus Seleksi<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun_masuk" class="form-control @error('tahun_masuk') is-invalid @enderror">
                                <option value="">Pilih Tahun Lulus Seleksi</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun_masuk') == $mhs_lulus ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

							@error('tahun_masuk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('mahasiswa.lulus-seleksi.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
