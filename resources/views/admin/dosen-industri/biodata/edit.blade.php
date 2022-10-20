@extends('admin.layout.main')
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

                    <form role="form" action="{{ route('dosen.industri.biodata.update', $dosen->dosen_id) }}" method="post">
                        @method('patch')
                        @csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">NIDN</label>
							<input type="text" class="form-control @error('nidn') is-invalid @enderror" placeholder="" name="nidn" value="{{ $dosen->nidn }}">

							@error('nidn')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">NIP<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error(' nip') is-invalid @enderror" placeholder="" name="nip" value="{{ $dosen->nip }}">

							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error(' nama_dosen') is-invalid @enderror" placeholder="" name="nama_dosen" value="{{ $dosen->nama_dosen }}">

							@error('nama_dosen')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Jabatan<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror" required="required">
							<option value="">Pilih Jabatan</option>
								@foreach ($jabatan_fungsional as $data)
									<option value="{{ $data->id }}" {{$data->id == $dosen->jabatan_id ? 'selected' : ''}} >{{ $data->nama_jabatan}}</option>
								@endforeach
						</select>
							@error('jabatan_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

                        <label for="seeAnotherFieldGroup">Pendidikan<span class="danger" style="color: #DC143C;">*</span></label>
                            <select id="seeAnotherFieldGroup" name="pendidikan_id" class="form-control @error('pendidikan_id') is-invalid @enderror">
                                <option value="">Pilih Pendidikan</option>
                                    @foreach ($kategori_pendidikan as $data)
                                        <option value="{{ $data->id }}" {{$data->id == $dosen->pendidikan_id ? 'selected' : ''}} >{{ $data->pendidikan}}</option>
                                    @endforeach
                            </select>

                        <br>
                        <div class="form-group" id="otherFieldGroupDiv">
                            <div class="row">
                                <div class="col-6">
                                    <label for="otherField1">Pendidikan S2<span class="danger" style="color: #DC143C;">*</span></label>
                                        <input type="text" class="form-control w-100" id="otherField1" name="pend_s2" value="{{ $dosen->pend_s2 }}">
                                </div>
                                <div class="col-6">
                                    <label for="otherField2">Pendidikan S3</label>
                                        <input type="text" class="form-control w-100" id="otherField2" name="pend_s3" value="{{ $dosen->pend_s3 }}">
                                </div>
                            </div>
                        </div>
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Bidang</label>
							<input type="text" class="form-control @error('bidang') is-invalid @enderror" placeholder="" name="bidang" value="{{ $dosen->bidang }}">

							@error('bidang')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Sertifikasi</label>
									<select class="form-control" name="sertifikasi">
										<option value="">Pilih keterangan sertifikasi</option>
										<option value="Y" {{$dosen->sertifikasi == 'Y'? 'selected' : ''}}>Ya</option>
										<option value="N" {{$dosen->sertifikasi == 'N'? 'selected' : ''}}>Tidak</option>
									</select>
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">H Indeks Scopus</label>
							<input type="text" class="form-control @error('scopus') is-invalid @enderror" placeholder="" name="scopus" value="{{ $dosen->scopus }}">

							@error('scopus')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Impact Factor WOS</label>
							<input type="text" class="form-control @error('wos') is-invalid @enderror" placeholder="" name="wos" value="{{ $dosen->wos }}">

							@error('sertifikat_kompetensi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Sinta Score</label>
							<input type="text" class="form-control @error('sinta') is-invalid @enderror" placeholder="" name="sinta" value="{{ $dosen->sinta }}">

							@error('sinta')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nomor Sertifikat Pendidik<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('sertifikat_pendidik') is-invalid @enderror" placeholder="" name="sertifikat_pendidik" value="{{ $dosen->sertifikat_pendidik }}">

							@error('sertifikat_pendidik')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nomor Sertifikat Kompetensi</label>
							<input type="text" class="form-control @error('sertifikat_kompetensi') is-invalid @enderror" placeholder="" name="sertifikat_kompetensi" value="{{ $dosen->sertifikat_kompetensi }}">

							@error('sertifikat_kompetensi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Golongan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('golongan') is-invalid @enderror" placeholder="" name="golongan" value="{{ $dosen->golongan }}">

							@error('golongan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Tempat Lahir <span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('tempat') is-invalid @enderror" placeholder="" name="tempat" value="{{ $dosen->tempat }}">

							@error('tempat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
								<label for="exampleFormControlInput1">Tanggal Lahir<span class="danger" style="color: #DC143C;">*</span></label>
									<input id="tgl_lahir" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tgl_lahir" value="{{ $dosen->tgl_lahir }}">
										<script>
											function timeFunctionLong(input) {
											setTimeout(function() {
												input.type = 'text';
												}, 60000);
											}
										</script>
                        </div>

						<label for="seeAnotherFieldGroupPerusahaan">Jenis Dosen<span class="danger" style="color: #DC143C;">*</span></label>
						<select id="seeAnotherFieldGroupPerusahaan" name="jenis_dosen" class="form-control @error('jenis_dosen') is-invalid @enderror" required="required">
							<option value="{{ $dosen->jenis_dosen }}">Pilih Jenis Dosen</option>
								@foreach ($kategori_jenis_dosen as $data)
									<option value="{{ $data->id }}" {{$data->id == $dosen->jenis_dosen ? 'selected' : ''}} >{{ $data->jenis}}</option>
								@endforeach
						</select>
							@error('jenis_dosen')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <div class="form-group" id="otherFieldGroupDivPerusahaan">
                            <div class="row">
                                <div class="col-12">
                                    <label for="otherField1">Perusahaan/Industri</label>
                                        <input type="text" class="form-control w-100" id="otherFieldPerusahaan" name="perusahaan" value="{{ $dosen->perusahaan }}">
                                </div>
                            </div>
                        </div>
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Email<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="@gmail.com" name="email" value="{{ $dosen->email }}">

							@error('email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('dosen.industri.biodata.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
