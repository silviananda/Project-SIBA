@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Tambah Data Karya Ilmiah Mahasiswa</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('luaran.publikasi-mhs-terapan.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Npm Mahasiswa yang berpartisipasi</label>
                            <input type="text" oninput="autofillmhs('mahasiswa1')" class="mahasiswa1 form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm">
                        </div>

                        <div class="form-group form-material row">
                            <input type="hidden" class="mahasiswa1 form-control" id="input-id" name="mhs_id">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Mahasiswa</label>
                            <input type="text"  disabled="disabled" class="mahasiswa1 form-control" id="nama" name="nama">

                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Artikel/Karya Ilmiah</label>
							<input type="text" class="form-control @error('judul') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="judul" value="{{ old ('judul') }}">

							@error('judul')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Judul Penelitian dan Pengembangan Kepada Masyarakat</label>
						<select name="pkm_id" class="form-control @error('pkm_id') is-invalid @enderror">
							<option value="">Pilih Pkm</option>
								@foreach ($data_pkm as $data)
									<option value="{{ $data->id }}" {{ old('pkm_id') == $data->id ? 'selected' : null }} >{{ $data->judul_pkm}}</option>
								@endforeach
						</select>
							@error('pkm_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<label for="exampleFormControlInput1">Tingkat</label>
						<select name="id_tingkat" class="form-control @error('id_tingkat') is-invalid @enderror">
							<option value="">Pilih Kategori Tingkat</option>
								@foreach ($kategori_tingkat as $data)
									<option value="{{ $data->id }}" {{ old('tingkat') == $data->id ? 'selected' : null }} >{{ $data->nama_kategori}}</option>
								@endforeach
						</select>
							@error('id_tingkat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<label for="exampleFormControlInput1">Jenis Publikasi</label>
						<select name="jenis_publikasi" class="form-control @error('jenis_publikasi') is-invalid @enderror">
							<option value="">Pilih Jenis Publikasi</option>
								@foreach ($jenis_publikasi_terapan as $data)
									<option value="{{ $data->id }}" {{ old('jenis_publikasi') == $data->id ? 'selected' : null }} >{{ $data->jenis_publikasi}}</option>
								@endforeach
						</select>
							@error('jenis_publikasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah</label>
							<input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah" value="{{ old ('jumlah') }}">

							@error('jumlah')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Terbit Publikasi Ilmiah</label>
                                <select name="tahun" class="form-control">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun') == $artikel_mhs_terapan ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('luaran.publikasi-mhs-terapan.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
