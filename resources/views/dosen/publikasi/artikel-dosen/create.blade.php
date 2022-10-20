@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Tambah Data Artikel Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('publikasi.artikel.store') }}" method="post" enctype="multipart/form-data">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->dosen_id }}" name="dosen_id">

							@error('dosen_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nip }}">

							@error('nip')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nama_dosen }}">

							@error('nama_dosen')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->user_id }}" name="user_id">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Artikel<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul') is-invalid @enderror" placeholder="" name="judul" value="{{ old ('judul') }}">

							@error('judul')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Judul Penelitian dan Pengembangan Kepada Masyarakat<span class="danger" style="color: #DC143C;">*</span></label>
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

						<label for="exampleFormControlInput1">Tingkat<span class="danger" style="color: #DC143C;">*</span></label>
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

						<label for="exampleFormControlInput1">Jenis Publikasi<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jenis_publikasi" class="form-control @error('jenis_publikasi') is-invalid @enderror">
							<option value="">Pilih Jenis Publikasi</option>
								@foreach ($jenis_publikasi as $data)
									<option value="{{ $data->id }}" {{ old('jenis_publikasi') == $data->id ? 'selected' : null }} >{{ $data->jenis_publikasi}}</option>
								@endforeach
						</select>
							@error('jenis_publikasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Artikel yang mensitasi</label>
							<input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah" value="{{ old ('jumlah') }}">

							@error('jumlah')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Publikasi<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun Publikasi</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun') == $artikel_dosen ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="softcopy">Bukti Karya Ilmiah</label>
							<input type="file" class="form-control-file" id="softcopy" name="softcopy">
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('publikasi.artikel.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
