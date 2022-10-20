@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Ubah Data Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                    <form role="form" action="{{ route('prestasi-dosen.update', $prestasi_dosen->id) }}" method="post" enctype="multipart/form-data">
                        @method('patch')
                        @csrf

                        <div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->dosen_id }}" name="dosen_id">

							@error('dosen_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">NIP Dosen</label>
							<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nip }}">

							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="dosen form-control @error('nama_dosen') is-invalid @enderror" disabled="disable" id="exampleFormControlInput1" placeholder="" name="nama_dosen" value="{{ $prestasi_dosen->dosen['nama_dosen'] }}">
						</div>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="dosen_id" value="{{ $prestasi_dosen->dosen_id }}">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Prestasi<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul_prestasi') is-invalid @enderror" placeholder="" name="judul_prestasi" value="{{ $prestasi_dosen->judul_prestasi }}">

							@error('judul_prestasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Tingkat<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="tingkat" class="form-control @error('tingkat') is-invalid @enderror">
							<option value="">Pilih Kategori Tingkat</option>
								@foreach ($kategori_tingkat as $data)
									<option value="{{ $data->id }}" {{$data->id == $prestasi_dosen->tingkat ? 'selected' : ''}} >{{ $data->nama_kategori}}</option>
								@endforeach
						</select>
							@error('tingkat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Prestasi<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun Prestasi</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $prestasi_dosen->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

								@error('tahun')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Bukti Prestasi</label>
							<input type="file" class="form-control-file" id="softcopy" name="softcopy" value="{{ $prestasi_dosen->softcopy }}">
                        </div>

                        {{-- untuk verifikasi --}}
						<div class="form-group">
							<label>
								<input type="checkbox" name="is_verification" class="js-switch" {{ $prestasi_dosen->is_verification ? 'checked' : ' ' }} style="display: none;"> Verifikasi
							</label>
						</div>


                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('prestasi-dosen.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
