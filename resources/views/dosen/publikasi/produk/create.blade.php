@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Tambah Data Produk</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('publikasi.produk.store') }}" method="post">
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

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Produk/Jasa yang dihasilkan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama_produk" value="{{ old ('nama_produk') }}">

							@error('nama_produk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Deskripsi<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('deskripsi') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="deskripsi" value="{{ old ('deskripsi') }}">

							@error('deskripsi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Kesiapan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('kesiapan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="kesiapan" value="{{ old ('kesiapan') }}">

							@error('kesiapan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('publikasi.produk.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
