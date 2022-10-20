@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
					<h2>Form Tambah Data Aktivitas Dosen Industri</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>

				<form role="form" action="{{ route('dosen.industri.aktivitas.store') }}" method="post">
					@csrf

					<div class="x_panel">
						<div class="x_title">

							<h6><i class="fa fa-align-left">&nbsp;&nbsp; </i>Data Aktivitas Pengajaran Dosen</h6>

							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<div class="row">

								<div class="x_content">

									<div class="form-group">
										<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

										@error('user_id')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>

									<div class="form-group">
										<label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
										<input type="text" oninput="autofill('dosen-tetap')" class="dosen-tetap form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" required="required">
						            	<span class="dosen-tetap danger" style="color: #DC143C;" id="ShowError"></span>
									</div>

									<div class="form-group">
										<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
										<input type="text" disabled="disabled" class="dosen-tetap form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
									</div>

									<div class="form-group form-material row">
										<input type="hidden" class="dosen-tetap form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
									</div>


									<div id="ps_sendiri_fields" class="form-group">

										<div class="input-ps-sendiri form-group">

											<div class="form-group">
												<label for="exampleFormControlInput1">Jenis Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
												<select class="form-control" name="ket[]" required>
													<option value="">Pilih</option>
													<option value="PS Sendiri">Program Studi Sendiri</option>
													<option value="PS Lain">Program Studi Lain</option>
													<option value="PS luar PT">Program Studi Lain di Luar PT</option>
												</select>

												@error('ket')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>

											<div class="form-group">
												<label for="exampleFormControlInput1">Kode Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
												<input type="text" oninput="autofillmk('kode_mk')" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="kode_mk" placeholder="Masukkan Kode MK" name="kode_mk[]" required="required">

												@error('kode_mk')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror
						                        <span class="kode_mk danger" style="color: #DC143C;" id="ErrorMk"></span>
											</div>

											<div class="form-group">
												<label for="exampleFormControlInput1">Nama Mata Kuliah<span class="danger" style="color: #DC143C;">*</span></label>
												<input type="text" disabled="disabled" class="kode_mk form-control" id="nama_mk" name="nama_mk" required="required">

												@error('nama_mk')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>

											<div class="form-group">
												<label for="exampleFormControlInput1">SKS Pengajaran<span class="danger" style="color: #DC143C;">*</span></label>
												<input type="text" class="kode_mk form-control @error('kode_mk') is-invalid @enderror" id="bobot_sks" placeholder="" name="bobot_sks[]" required="required">

												@error('bobot_sks')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>

											<button class="btn btn-success" type="button" onclick="ps_sendiri_fields();"><i class="fa fa-plus"></i></button>
										</div>
									</div>

									<br>

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
													<label for="exampleFormControlInput1">Tahun Aktivitas<span class="required">*</span></label>
													<select name="tahun" class="form-control" required>
														<option value="">Pilih Tahun Aktivitas</option>
														@for ($year = date('Y') - 7; $year < date('Y') + 10; $year++) <option value="{{$year}}" {{ old('tahun') == $aktivitas ? 'selected': ''}}>{{$year}}</option>
															@endfor
													</select>
												</div>

												<div class="col-md-6 col-sm-12 form-group">
													<label for="exampleFormControlInput1">Tanggal Deadline<span class="required">*</span></label>
													<input id="deadline" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="deadline" value="{{ old ('deadline') }}">
													<script>
														function timeFunctionLong(input) {
															setTimeout(function() {
																input.type = 'text';
															}, 60000);
														}
													</script>
												</div>
											</div>
										</div>
									</div>

									<button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
									<a href="{{ route('dosen.industri.aktivitas.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
@stop