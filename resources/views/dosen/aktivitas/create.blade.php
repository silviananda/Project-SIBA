@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
					<h2>Form Tambah Data Aktivitas Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>
				<br>

				<form role="form" action="{{ route('aktivitas.store') }}" method="post">
					@csrf

					<div class="x_panel">
						<div class="x_title">

							<h6><i class="fa fa-align-left">&nbsp;&nbsp; </i>Aktivitas Pengajaran Dosen</h6>

							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<div class="row">

								<div class="x_content">
									<div class="form-group">
										<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->user_id }}" name="user_id">
									</div>

									<div class="form-group">
										<label for="exampleFormControlInput1">NIP Dosen</label>
										<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nip }}">

										@error('nip')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>

									<div class="form-group">
										<label for="exampleFormControlInput1">Nama Dosen</label>
										<input type="text" class="form-control" disabled="disabled" placeholder="" value="{{ \Auth::guard('dosen')->user()->nama_dosen }}">

										@error('nama_dosen')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>

									<div id="ps_sendiri_fields" class="form-group" required>

										<div class="input-ps-sendiri form-group">

											<div class="form-group">
												<label for="seeAnotherFieldGroup">Jenis Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
												<select id="seeAnotherFieldGroup" class="form-control @error('ket[]') is-invalid @enderror" name="ket[]">
													<option>Pilih</option>
													<option value="PS Sendiri">Program Studi Sendiri</option>
													<option value="PS Lain">Program Studi Lain</option>
													<option value="PS luar PT">Program Studi Lain di Luar PT</option>
												</select>
												
												@error('ket[]')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>

											<div class="form-group" id="otherFieldGroupDiv">
												<div class="form-group">
													<label for="kode_mk">Kode Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
													<input type="text" oninput="autofillmk('kode_mk')" class="kode_mk form-control @error('kode_mk[]') is-invalid @enderror" id="kode_mk" placeholder="Masukkan Kode MK" name="kode_mk[]">
												
													@error('kode_mk[]')
													<div class="invalid-feedback">{{ $message }}</div>
													@enderror
						                        <span class="kode_mk danger" style="color: #DC143C;" id="ErrorMk"></span>
												</div>

												<div class="form-group">
													<label for="nama_mk">Nama Mata Kuliah</label>
													<input type="text" class="kode_mk form-control" id="nama_mk" name="nama_mk[]">

													@error('nama_mk')
													<div class="invalid-feedback">{{ $message }}</div>
													@enderror
												</div>

												<div class="form-group">
													<label for="bobot_sks">SKS Pengajaran</label>
													<input type="text" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="bobot_sks" placeholder="" name="bobot_sks[]">

													@error('bobot_sks')
													<div class="invalid-feedback">{{ $message }}</div>
													@enderror
												</div>
											</div>
											

								<button class="btn btn-success" type="button" onclick="ps_sendiri_fields();"><i class="fa fa-plus"></i></button>
							</div>
						</div>
					</div>
			</div>
		</div>


		<div class="x_panel">
			<div class="x_title">
				<h6><i class="fa fa-align-left">&nbsp;&nbsp; </i>Data Aktivitas Lainnya</h6>

				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				<div class="row">

					<div class="col-md-6 col-sm-12  form-group">
						<label for="exampleFormControlInput1">SKS Penelitian</label>
						<input type="text" class="form-control @error('sks_penelitian') is-invalid @enderror" placeholder="" name="sks_penelitian" value="{{ old ('sks_penelitian') }}">

						@error('sks_penelitian')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 col-sm-12  form-group">
						<label for="exampleFormControlInput1">SKS Pengabdian</label>
						<input type="text" class="form-control @error('sks_p2m') is-invalid @enderror" placeholder="" name="sks_p2m" value="{{ old ('sks_p2m') }}">

						@error('sks_p2m')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 col-sm-12  form-group">
						<label for="exampleFormControlInput1">SKS Tugas Tambahan dan/atau Penunjang</label>
						<input type="text" class="form-control @error('m_pt_sendiri') is-invalid @enderror" placeholder="" name="m_pt_sendiri" value="{{ old ('m_pt_sendiri') }}">

						@error('m_pt_sendiri')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 col-sm-12 form-group">
						<label for="exampleFormControlInput1">Tahun Aktivitas<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="tahun" class="form-control  @error('tahun') is-invalid @enderror">
							<option value="">Pilih Tahun Aktivitas</option>
							@for ($year = date('Y') - 7; $year < date('Y') + 10; $year++) <option value="{{$year}}" {{ old('tahun') == $aktivitas ? 'selected': ''}}>{{$year}}</option>
								@endfor
						</select>
						@error('tahun')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
		<a href="{{ route('aktivitas.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

		</form>
	</div>
</div>
</div>
</div>
@stop