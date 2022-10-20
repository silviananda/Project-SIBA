@extends('dosen.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Ubah Biodata Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                    <form role="form" action="{{ route('biodata.update') }}" method="post">
                        @method('patch')
                        @csrf

                        <div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('dosen')->user()->dosen_id }}" name="dosen_id">

							@error('dosen_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Tempat Lahir<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('tempat') is-invalid @enderror" placeholder="" name="tempat" value="{{ \Auth::guard('dosen')->user()->tempat }}">

							@error('tempat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Lahir<span class="danger" style="color: #DC143C;">*</span></label>
                                <input id="tgl_lahir" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tgl_lahir" value="{{ \Auth::guard('dosen')->user()->tgl_lahir }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">NIP<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nip') is-invalid @enderror" placeholder="" name="nip" value="{{ \Auth::guard('dosen')->user()->nip }}">

							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">NIDN<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nidn') is-invalid @enderror" placeholder="" name="nidn" value="{{ \Auth::guard('dosen')->user()->nidn }}">

							@error('nidn')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Nomor Sertifikat Kompetensi</label>
							<input type="text" class="form-control @error('sertifikat_kompetensi') is-invalid @enderror" placeholder="" name="sertifikat_kompetensi" value="{{ \Auth::guard('dosen')->user()->sertifikat_kompetensi }}">

							@error('sertifikat_kompetensi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Nomor Sertifikat Pendidik</label>
							<input type="text" class="form-control @error('sertifikat_pendidik') is-invalid @enderror" placeholder="" name="sertifikat_pendidik" value="{{ \Auth::guard('dosen')->user()->sertifikat_pendidik }}">

							@error('sertifikat_pendidik')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Email<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="" name="email" value="{{ \Auth::guard('dosen')->user()->email }}">

							@error('email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Bidang<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('bidang') is-invalid @enderror" placeholder="" name="bidang" value="{{ \Auth::guard('dosen')->user()->bidang }}">

							@error('bidang')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<label for="exampleFormControlInput1">Jabatan Fungsional<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror">
							<option value="">Pilih Jabatan Fungsional</option>
								@foreach ($jabatan_fungsional as $data)
									<option value="{{ $data->id }}" {{$data->id == \Auth::guard('dosen')->user()->jabatan_id ? 'selected' : ''}} >{{ $data->nama_jabatan}}</option>
								@endforeach
						</select>
							@error('jabatan_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Golongan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('golongan') is-invalid @enderror" placeholder="" name="golongan" value="{{ \Auth::guard('dosen')->user()->golongan }}">

							@error('golongan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Scopus</label>
							<input type="text" class="form-control @error('scopus') is-invalid @enderror" placeholder="" name="scopus" value="{{ \Auth::guard('dosen')->user()->scopus }}">

							@error('scopus')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Sinta</label>
							<input type="text" class="form-control @error('sinta') is-invalid @enderror" placeholder="" name="sinta" value="{{ \Auth::guard('dosen')->user()->sinta }}">

							@error('sinta')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">WOS</label>
							<input type="text" class="form-control @error('wos') is-invalid @enderror" placeholder="" name="wos" value="{{ \Auth::guard('dosen')->user()->wos }}">

							@error('wos')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Pendidikan S1 <span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('pend_s1') is-invalid @enderror" placeholder="" name="pend_s1" value="{{ \Auth::guard('dosen')->user()->pend_s1 }}">

							@error('pend_s1')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Pendidikan S2 <span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('pend_s2') is-invalid @enderror" placeholder="" name="pend_s2" value="{{ \Auth::guard('dosen')->user()->pend_s2 }}">

							@error('pend_s2')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Pendidikan S3 </label>
							<input type="text" class="form-control @error('pend_s3') is-invalid @enderror" placeholder="" name="pend_s3" value="{{ \Auth::guard('dosen')->user()->pend_s3 }}">

							@error('pend_s3')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Password Akun SIBA<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="" name="password" value="{{ \Auth::guard('dosen')->user()->password }}">

							@error('password')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('biodata.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
