@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Peningkatan Kegiatan Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('kegiatan-akademik.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
                            <label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofill('dosen')" class="dosen form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
                        	@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						    <span class="dosen danger" style="color: #DC143C;" id="ShowError"></span>
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
                        </div>

						<span class="danger" style="color: #DC143C;" id="ShowError"></span>

                        <div class="form-group form-material row">
                            <input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Kegiatan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jenis_kegiatan" value="{{ old ('jenis_kegiatan') }}">

							@error('jenis_kegiatan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Tempat Kegiatan <span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('tempat') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="tempat" value="{{ old ('tempat') }}">

							@error('tempat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
								<label for="exampleFormControlInput1">Tanggal Kegiatan<span class="danger" style="color: #DC143C;">*</span></label>
									<input id="waktu" class="date-picker form-control @error('waktu') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="waktu" value="{{ old ('waktu') }}">
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

						<!-- Date time untuk yang ada waktunya -->
						<!-- <div class="form-group">
							<label for="exampleFormControlInput1">Tanggal dan Waktu</label>
							<input type="text" class="date-picker form-control" id="datetimepicker" placeholder="dd-mm-yyyy" name="waktu" value="{{ old ('waktu') }}">

						</div> -->

						<label for="exampleFormControlInput1">Peran<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="peran_id" class="form-control @error('peran_id') is-invalid @enderror">
							<option value="">Pilih Kategori Peran</option>
								@foreach ($kategori_peran as $data)
									<option value="{{ $data->id }}" {{ old('peran_id') == $data->id ? 'selected' : null }} >{{ $data->peran}}</option>
								@endforeach
						</select>
							@error('peran_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Deadline<span class="danger" style="color: #DC143C;">*</span></label>
                                <input id="deadline" class="date-picker form-control @error('deadline') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="deadline" value="{{ old ('deadline') }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>

							@error('deadline')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('kegiatan-akademik.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
