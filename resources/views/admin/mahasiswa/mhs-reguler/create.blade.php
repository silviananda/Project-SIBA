@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

					<h2>Form Tambah Data Mahasiswa Reguler</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>

				<form role="form" action="{{ route('mahasiswa.reguler.store') }}" method="post">
					@csrf

					<div class="form-group">
						<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
						@error('user_id')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>


					<div class="form-group">
						<label for="exampleFormControlInput1">Nomor Induk Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" class="form-control @error('npm') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="npm" value="{{ old ('npm') }}">

						@error('npm')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>


					<div class="form-group">
						<label for="exampleFormControlInput1">Nama Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama" value="{{ old ('nama') }}">

						@error('nama')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">NIP Dosen Wali</label>
						<input type="text" oninput="autofill('dosen-wali')" class="dosen-wali form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
						<span class="dosen-wali danger" style="color: #DC143C;" id="ShowError"></span>
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">Nama Dosen Wali</label>
						<input type="text" disabled="disabled" class="dosen-wali form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
					</div>

					<div class="form-group form-material row">
						<input type="hidden" class="dosen-wali form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
					</div>


					<div class="form-group">
						<label for="exampleFormControlInput1">Jenis Kelamin<span class="danger" style="color: #DC143C;">*</span></label>
						<p>
							Laki-laki: <input type="radio" class="flat form-control" name="jenis_kelamin" id="" value="Laki-laki" checked="" required />
							Perempuan: <input type="radio" class="flat form-control" name="jenis_kelamin" id="" value="Perempuan" checked="" required />
						</p>
					</div>

					<label for="seeAnotherFieldGroupProv">Tempat Tinggal Asal<span class="danger" style="color: #DC143C;">*</span></label>
					<select name="asal_id" id="seeAnotherFieldGroupProv" class="form-control @error('asal_id') is-invalid @enderror">
						<option value="">Pilih Asal</option>
						@foreach ($kategori_asal as $data)
						<option value="{{ $data->id }}" {{ old('asal_id') == $data->id ? 'selected' : null }}>{{ $data->asal}}</option>
						@endforeach
					</select>
					@error('asal_id')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
					<br>

					<div class="form-group">
						<label for="exampleFormControlInput1">Asal Sekolah<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="asal_sekolah" value="{{ old ('asal_sekolah') }}">

						@error('asal_sekolah')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">Tahun Masuk<span class="danger" style="color: #DC143C;">*</span></label>
						<input id="tahun_masuk" class="date-picker form-control @error('tahun_masuk') is-invalid @enderror" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tahun_masuk" value="{{ old ('tahun_masuk') }}">
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

					<label for="exampleFormControlInput1">Jalur Masuk<span class="danger" style="color: #DC143C;">*</span></label>
					<select name="jalur_masuk_id" class="form-control @error('jalur_masuk_id') is-invalid @enderror">
						<option value="">Pilih Jalur Masuk</option>
						@foreach ($kategori_jalur as $data)
						<option value="{{ $data->id }}" {{ old('jalur_masuk_id') == $data->id ? 'selected' : null }}>{{ $data->jalur_masuk}}</option>
						@endforeach
					</select>
					@error('jalur_masuk_id')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
					<br>

					<input type="hidden" class="form-control @error('id_jurusan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="id_jurusan" value="{!! Auth::user()->kode_ps_jurusan !!}">

					<label for="exampleFormControlInput1">Status Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
					<select name="id_status" class="form-control @error('id_status') is-invalid @enderror" disabled>
						<option value="">Pilih Status Mahasiswa</option>
							@foreach ($kategori_status_mhs as $data)
							<option value="{{ $data->id }}" {{ $data->id == 1 ? 'selected' : '' }}>{{ $data->status}}</option>
							@endforeach
					</select>
					@error('id_status')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
					<br>

					<div class="form-group">
						<label for="exampleFormControlInput1">Email<span class="danger" style="color: #DC143C;">*</span></label>
						<input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="email" value="{{ old ('email') }}">

						@error('email')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">Ipk</label>
						<input type="text" class="form-control @error('ipk') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="ipk" value="{{ old ('ipk') }}">

						@error('ipk')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>


					<div class="x_panel">
						<div class="x_title">
							<h2>Data Bimbingan Mahasiswa</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item" href="#">Settings 1</a>
										<a class="dropdown-item" href="#">Settings 2</a>
									</div>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<div class="row">

								<div class="col-md-12 col-sm-12 form-group">			
									<label for="exampleFormControlInput1">Tahun Mulai Bimbingan</label>
										<select name="tahun" class="form-control">
											<option value="">Pilih Tahun Mulai Bimbingan</option>
												@for ($year = date('Y') - 7; $year < date('Y') + 10; $year++) <option value="{{$year}}" {{ old('tahun') == $data_pembimbing_ta ? 'selected': ''}}>{{$year}}</option>
												@endfor
										</select>
								</div>

								<div class="col-md-12 col-sm-12 form-group">
									<label for="exampleFormControlInput1">Kategori Asal Dosen Pembimbing 1</label>
										<select name="jenis_id1" class="form-control @error('jenis_id1') is-invalid @enderror">
											<option value="">Pilih Kategori</option>
											@foreach ($jenis_bimbingan as $data)
											<option value="{{ $data->id }}" {{ old('jenis_id1') == $data->id ? 'selected' : null }}>{{ $data->jenis}}</option>
											@endforeach
										</select>
										@error('jenis')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">NIP Dosen Pembimbing I Tugas Akhir</label>
									<input type="text" oninput="autofill('pembimbing1')" class="pembimbing1 form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
									<span class="pembimbing1 danger" style="color: #DC143C;" id="ShowError"></span>
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">Nama Dosen Pembimbing I Tugas Akhir</label>
									<input type="text" disabled="disabled" class="pembimbing1 form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
								</div>
								

								<div class="form-group form-material row">
									<input type="hidden" class="pembimbing1 form-control @error('doping1') is-invalid @enderror" id="dosen_id" placeholder="" name="doping1">
								</div>

								<br>

								<div class="col-md-12 col-sm-12 form-group">
									<label for="exampleFormControlInput1">Kategori Asal Dosen Pembimbing 2</label>
										<select name="jenis_id2" class="form-control @error('jenis_id2') is-invalid @enderror">
											<option value="">Pilih Kategori</option>
											@foreach ($jenis_bimbingan as $data)
											<option value="{{ $data->id }}" {{ old('jenis_id2') == $data->id ? 'selected' : null }}>{{ $data->jenis}}</option>
											@endforeach
										</select>
										@error('jenis')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">NIP Dosen Pembimbing II Tugas Akhir</label>
									<input type="text" oninput="autofill('pembimbing2')" class="pembimbing2 form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
									<span class="pembimbing2 danger" style="color: #DC143C;" id="ShowError"></span>
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">Nama Dosen Pembimbing II Tugas Akhir</label>
									<input type="text" disabled="disabled" class="pembimbing2 form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
								</div>

								<div class="form-group form-material row">
									<input type="hidden" class="pembimbing2 form-control @error('doping2') is-invalid @enderror" id="dosen_id" placeholder="" name="doping2">
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">NIP Dosen Penguji I Tugas Akhir</label>
									<input type="text" oninput="autofill('penguji1')" class="penguji1 form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
									<span class="penguji1 danger" style="color: #DC143C;" id="ShowError"></span>
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">Nama Dosen Penguji I Tugas Akhir</label>
									<input type="text" disabled="disabled" class="penguji1 form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
								</div>

								<div class="form-group form-material row">
									<input type="hidden" class="penguji1 form-control @error('penguji1') is-invalid @enderror" id="dosen_id" placeholder="" name="penguji1">
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">NIP Dosen Penguji II Tugas Akhir</label>
									<input type="text" oninput="autofill('penguji2')" class="penguji2 form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
									<span class="penguji2 danger" style="color: #DC143C;" id="ShowError"></span>
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">Nama Dosen Penguji II Tugas Akhir</label>
									<input type="text" disabled="disabled" class="penguji2 form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
								</div>

								<div class="form-group form-material row">
									<input type="hidden" class="penguji2 form-control @error('penguji2') is-invalid @enderror" id="dosen_id" placeholder="" name="penguji2">
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">NIP Dosen Penguji III Tugas Akhir</label>
									<input type="text" oninput="autofill('penguji3')" class="penguji3 form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
									<span class="penguji3 danger" style="color: #DC143C;" id="ShowError"></span>
								</div>

								<div class="col-md-6 col-sm-12  form-group">
									<label for="exampleFormControlInput1">Nama Dosen Penguji III Tugas Akhir</label>
									<input type="text" disabled="disabled" class="penguji3 form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
								</div>

								<div class="form-group form-material row">
									<input type="hidden" class="penguji3 form-control @error('penguji3') is-invalid @enderror" id="dosen_id" placeholder="" name="penguji3">
								</div>


								<div class="col-md-4 col-sm-12 form-group">
									<label for="exampleFormControlInput1">Tanggal Seminar Proposal</label>
									<input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="proposal" value="{{ old ('proposal') }}">
									<script>
										function timeFunctionLong(input) {
											setTimeout(function() {
												input.type = 'text';
											}, 60000);
										}
									</script>
								</div>

								<div class="col-md-4 col-sm-12 form-group">
									<label for="exampleFormControlInput1">Tanggal Seminar Hasil</label>
									<input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="hasil" value="{{ old ('hasil') }}">
									<script>
										function timeFunctionLong(input) {
											setTimeout(function() {
												input.type = 'text';
											}, 60000);
										}
									</script>
								</div>

								<div class="col-md-4 col-sm-12 form-group">
									<label for="exampleFormControlInput1">Tanggal Sidang</label>
									<input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="sidang" value="{{ old ('sidang') }}">
									<script>
										function timeFunctionLong(input) {
											setTimeout(function() {
												input.type = 'text';
											}, 60000);
										}
									</script>
								</div>

								<div class="col-md-12 col-sm-12 form-group">
									<label for="exampleFormControlInput1">Tanggal Lulus</label>
									<input id="tahun_keluar" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tahun_keluar" value="{{ old ('tahun_keluar') }}">
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
					<a href="{{ route('mahasiswa.reguler.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

				</form>
			</div>
		</div>
	</div>
</div>
@stop