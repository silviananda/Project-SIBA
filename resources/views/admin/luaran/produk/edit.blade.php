@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Produk/Jasa yang dihasilkan Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('luaran.produk.update', $produk->id) }}" method="post">
					@method('patch')
					@csrf

                    <div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
                            <label for="exampleFormControlInput1">NIP Dosen Pendamping<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofill('dosen')" class="dosen form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" value="{{ $produk->dosen->nip }}">
                        
							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                            <span class="dosen danger" style="color: #DC143C;" id="ShowError"></span>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen Pendamping<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen" value="{{ $produk->dosen->nama_dosen }}">

							@error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<span class="danger" style="color: #DC143C;" id="ShowError"></span>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen-tetap form-control @error('dosen_id') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="dosen_id" value="{{ $produk->dosen_id }}">
						</div>

						<label for="exampleFormControlInput1">Kategori Penelitian dan Pengembangan Kepada Masyarakat<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="pkm_id" class="form-control @error('pkm_id') is-invalid @enderror">
							<option value="">Pilih Pkm</option>
								@foreach ($data_pkm as $data)
									<option value="{{ $data->id }}" {{$data->id == $produk->pkm_id ? 'selected' : ''}}  >{{ $data->judul_pkm}}</option>
								@endforeach
						</select>
							@error('pkm_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Produk/Jasa yang dihasilkan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama_produk" value="{{ $produk->nama_produk }}">

							@error('nama_produk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Deskripsi</label>
							<input type="text" class="form-control @error('deskripsi') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="deskripsi" value="{{ $produk->deskripsi }}">

							@error('deskripsi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Kesiapan</label>
							<input type="text" class="form-control @error('kesiapan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="kesiapan" value="{{ $produk->kesiapan }}">

							@error('kesiapan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('luaran.produk.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
