@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Ubah Data Kegiatan</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                    <form role="form" action="{{ route('kegiatan-dosen.update', $kegiatan->id) }}" method="post">
                        @method('patch')
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
							<input type="text" class="dosen form-control @error('nama_dosen') is-invalid @enderror" disabled="disable" id="exampleFormControlInput1" placeholder="" name="nama_dosen" value="{{ $kegiatan->dosen['nama_dosen'] }}">
						</div>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="dosen_id" value="{{ $kegiatan->dosen_id }}">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jenis Kegiatan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jenis_kegiatan" value="{{ $kegiatan->jenis_kegiatan }}">

							@error('jenis_kegiatan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Lokasi/Tempat Kegiatan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('tempat') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="tempat" value="{{ $kegiatan->tempat }}">

							@error('tempat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Kegiatan<span class="danger" style="color: #DC143C;">*</span></label>
                                <input id="waktu" class="date-picker form-control @error('waktu') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="waktu" value="{{ $kegiatan->waktu }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>

								@error('waktu')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
                        </div>

						<label for="exampleFormControlInput1">Peran<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="peran_id" class="form-control @error('peran_id') is-invalid @enderror">
							<option value="">Pilih Kategori Peran</option>
								@foreach ($kategori_peran as $data)
									<option value="{{ $data->id }}" {{$data->id == $kegiatan->peran_id ? 'selected' : ''}} >{{ $data->peran}}</option>
								@endforeach
						</select>
							@error('peran_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        {{-- untuk verifikasi --}}
						<div class="form-group">
							<label>
								<input type="checkbox" name="is_verification" class="js-switch" {{ $kegiatan->is_verification ? 'checked' : ' ' }} style="display: none;"> Verifikasi
							</label>
						</div>


                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('kegiatan-dosen.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
