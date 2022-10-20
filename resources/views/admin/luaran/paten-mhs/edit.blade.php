@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Paten Mahasiswa</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('luaran.paten-mhs.update', $paten->id) }}" method="post">
					@method('patch')
					@csrf

                    <div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Npm Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofillmhs('mahasiswa1')" class="mahasiswa1 form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm" value="{{ $paten->biodata_mhs['npm'] }}">
                        
                            @error('npm')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="mahasiswa1 danger" style="color: #DC143C;" id="ErrorVal"></span>
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Nama Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" disabled="disabled" class="mahasiswa1 form-control @error('nama') is-invalid @enderror" id="nama" placeholder="" name="nama" value="{{ $paten->biodata_mhs['nama'] }}">
						</div>

						<div class="form-group form-material row">
							<input type="hidden" class="mahasiswa1 form-control @error('mhs_id') is-invalid @enderror" id="input-id" placeholder="" name="mhs_id" value="{{ $paten->mhs_id }}">
						</div>

						<label for="exampleFormControlInput1">Kategori Penelitian dan Pengembangan Kepada Masyarakat<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="pkm_id" class="form-control @error('pkm_id') is-invalid @enderror">
							<option value="">Pilih Pkm</option>
								@foreach ($data_pkm as $data)
									<option value="{{ $data->id }}" {{$data->id == $paten->pkm_id ? 'selected' : ''}}  >{{ $data->judul_pkm}}</option>
								@endforeach
						</select>
							@error('pkm_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Produk/Jasa<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('karya') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="karya" value="{{ $paten->karya }}">

							@error('karya')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nomor HKI</label>
							<input type="text" class="form-control @error('no_hki') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="no_hki" value="{{ $paten->no_hki }}">

							@error('no_hki')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Terbit Paten<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $paten->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('luaran.paten-mhs.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
