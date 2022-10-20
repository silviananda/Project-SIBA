@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Produk Lainnya</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('luaran.lainnya.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<label for="exampleFormControlInput1">Kategori Penelitian dan Pengembangan Kepada Masyarakat<span class="danger" style="color: #DC143C;">*</span></label>
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
							<label for="exampleFormControlInput1">Nama Produk Lainnya<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama" value="{{ old ('nama') }}">

							@error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <label for="exampleFormControlInput1">Jenis Produk Lainnya<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
							<option value="">Pilih Jenis Produk</option>
								@foreach ($jenis_produk as $data)
									<option value="{{ $data->id }}" {{ old('jenis') == $data->id ? 'selected' : null }} >{{ $data->jenis}}</option>
								@endforeach
						</select>
							@error('jenis')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Terbit Produk<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun') == $produk_lain ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Keterangan</label>
							<input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="keterangan" value="{{ old ('keterangan') }}">

							@error('keterangan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Penanggung Jawab Produk/Luaran<span class="danger" style="color: #DC143C;">*</span></label>
								<select id="heard" class="form-control  @error('jenis_data') is-invalid @enderror" name="jenis_data">
									<option value="">Pilih..</option>
									<option value="Dosen">Dosen</option>
									<option value="Mahasiswa">Mahasiswa</option>
								</select>

							@error('jenis_data')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Input Link (Khusus untuk data Buku)</label>
							<input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="link" value="{{ old ('link') }}">

							@error('link')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('luaran.lainnya.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
