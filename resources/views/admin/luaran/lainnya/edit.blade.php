@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Ubah Data Produk Lainnya</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('luaran.lainnya.update', $produk_lain->id) }}" method="post">
					@method('patch')
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
										<option value="{{ $data->id }}" {{$data->id == $produk_lain->pkm_id ? 'selected' : ''}}  >{{ $data->judul_pkm}}</option>
									@endforeach
							</select>
								@error('pkm_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Produk Lainnya<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama" value="{{ $produk_lain->nama }}">

							@error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <label for="exampleFormControlInput1">Jenis Produk Lainnya<span class="danger" style="color: #DC143C;">*</span></label>
							<select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
								<option value="">Pilih Jenis Produk</option>
									@foreach ($jenis_produk as $data)
										<option value="{{ $data->id }}" {{$data->id == $produk_lain->jenis ? 'selected' : ''}} >{{ $data->jenis}}</option>
									@endforeach
							</select>
								@error('jenis')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
                        <br>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Terbit<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $produk_lain->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Keterangan</label>
							<input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="keterangan" value="{{ $produk_lain->keterangan }}">

							@error('keterangan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Penanggung Jawab Produk/Luaran<span class="danger" style="color: #DC143C;">*</span></label>
								<select id="heard" class="form-control @error('jenis_data') is-invalid @enderror" name="jenis_data">
									<option value="">Pilih..</option>
									<option value="Dosen" {{ $produk_lain->jenis_data == 'Dosen' ? 'selected' : '' }}>Dosen</option>
									<option value="Mahasiswa" {{ $produk_lain->jenis_data == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
								</select>
							@error('jenis_data')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Input Link (Khusus untuk data Buku)</label>
							<input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="link" value="{{ $produk_lain->link }}">

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
