@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Alumni</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('alumni.update', $alumni->id) }}" method="post">
					@method('patch')
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Npm Alumni<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('npm') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="npm" value="{{ $alumni->npm }}">

							@error('npm')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama" value="{{ $alumni->nama }}">

							@error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Ipk Terakhir<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('ipk') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="ipk" value="{{ $alumni->ipk }}">

							@error('ipk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-12 col-sm-12 form-group">
							<label for="exampleFormControlInput1">Tanggal Masuk<span class="danger" style="color: #DC143C;">*</span></label>
								<input id="tahun_masuk" class="date-picker form-control @error('tahun_masuk') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tahun_masuk" value="{{ $alumni->tahun_masuk }}">
								<script>
									function timeFunctionLong(input) {
										setTimeout(function() {
											input.type = 'text';
											}, 60000);
										}
								</script>

							@error('tahun_masuk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-12 col-sm-12 form-group">
							<label for="exampleFormControlInput1">Tanggal Lulus<span class="danger" style="color: #DC143C;">*</span></label>
								<input id="tahun_lulus" class="date-picker form-control @error('tahun_lulus') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tahun_lulus" value="{{ $alumni->tahun_lulus }}">
								<script>
									function timeFunctionLong(input) {
										setTimeout(function() {
											input.type = 'text';
											}, 60000);
										}
								</script>

							@error('tahun_lulus')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <label for="exampleFormControlInput1">Mulai Kerja</label>
						<select name="id_mulai_kerja" class="form-control @error('id_mulai_kerja') is-invalid @enderror">
							<option value="">Pilih Status Mulai Kerja</option>
								@foreach ($mulai_kerja as $data)
									<option value="{{ $data->id }}" {{$data->id == $alumni->id_mulai_kerja ? 'selected' : ''}} >{{ $data->waktu_kerja}}</option>
								@endforeach
						</select>
							@error('id_mulai_kerja')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <label for="exampleFormControlInput1">Jenis Pekerjaan Lulusan</label>
						<select name="id_jenis_pekerjaan" class="form-control @error('id_jenis_pekerjaan') is-invalid @enderror">
							<option value="">Pilih Jenis Pekerjaan</option>
								@foreach ($jenis_pekerjaan as $data)
									<option value="{{ $data->id }}" {{$data->id == $alumni->id_jenis_pekerjaan ? 'selected' : ''}} >{{ $data->jenis}}</option>
								@endforeach
						</select>
							@error('id_jenis_pekerjaan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <label for="exampleFormControlInput1">Pendapatan/Penghasilan</label>
						<select name="id_pendapatan" class="form-control @error('id_pendapatan') is-invalid @enderror">
							<option value="">Pilih Pendapatan</option>
								@foreach ($kategori_pendapatan as $data)
									<option value="{{ $data->id }}" {{$data->id == $alumni->id_pendapatan ? 'selected' : ''}} >{{ $data->pendapatan}}</option>
								@endforeach
						</select>
							@error('id_pendapatan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <label for="exampleFormControlInput1">Waktu Tunggu</label>
						<select name="id_waktu_tunggu" class="form-control @error('id_waktu_tunggu') is-invalid @enderror">
							<option value="">Pilih Waktu Tunggu</option>
								@foreach ($waktu_tunggu as $data)
									<option value="{{ $data->id }}" {{$data->id == $alumni->id_waktu_tunggu ? 'selected' : ''}} >{{ $data->waktu}}</option>
								@endforeach
						</select>
							@error('id_waktu_tunggu')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('alumni.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
