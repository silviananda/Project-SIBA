@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Tambah Data Prestasi Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('upaya.prestasi.store') }}" method="post" enctype="multipart/form-data">
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
							<input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen" required>
						</div>
						<span class="danger" style="color: #DC143C;" id="ShowError"></span>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Prestasi<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul_prestasi') is-invalid @enderror" placeholder="" name="judul_prestasi" value="{{ old ('judul_prestasi') }}">

							@error('judul_prestasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Tingkat<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="tingkat" class="form-control @error('tingkat') is-invalid @enderror">
							<option value="">Pilih Kategori Tingkat</option>
								@foreach ($kategori_tingkat as $data)
									<option value="{{ $data->id }}" {{ old('tingkat') == $data->id ? 'selected' : null }} >{{ $data->nama_kategori}}</option>
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
                                        <option value="{{$year}}" {{ old('tahun') == $prestasi_dosen ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

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

						<div class="form-group">
							<label for="softcopy">Bukti Prestasi</label>
							<input type="file" class="form-control-file @error('softcopy') is-invalid @enderror" id="softcopy" name="softcopy">

							@error('softcopy')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror	
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('upaya.prestasi.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
