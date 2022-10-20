@extends('admin.layout.main')
@section('content')
 
<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Karya Ilmiah Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('luaran.karya-ilmiah.store-detail') }}" method="post" enctype="multipart/form-data">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
								<label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
								<input type="text" disabled="disabled" class="form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" value="{{ $list_dosen->nip }}">
						
							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" disabled="disabled" class="form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen" value="{{ $list_dosen->nama_dosen }}">
						</div>

						<div class="form-group form-material row">
							<input type="hidden" class="form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id" value="{{ $list_dosen->dosen_id }}">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Artikel/Karya Ilmiah<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="judul" value="{{ old ('judul') }}">

							@error('judul')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-4 col-sm-4">
							<label for="exampleFormControlInput1">Volume</label>
							<input type="text" class="form-control @error('volume') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="volume" value="{{ old ('volume') }}">

							@error('volume')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-4 col-sm-4">
							<label for="exampleFormControlInput1">Page</label>
							<input type="text" class="form-control @error('page') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="page" value="{{ old ('page') }}">

							@error('page')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-4 col-sm-4">
							<label for="exampleFormControlInput1">Issue</label>
							<input type="text" class="form-control @error('issue') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="issue" value="{{ old ('issue') }}">

							@error('issue')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Publisher</label>
							<input type="text" class="form-control @error('publisher') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="publisher" value="{{ old ('publisher') }}">

							@error('publisher')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Kategori Pengembangan Kepada Masyarakat<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="pkm_id" class="form-control @error('pkm_id') is-invalid @enderror">
							<option value="">Pilih Pkm</option>
								@foreach ($data_pkm as $data)
									<option value="{{ $data->id }}" {{ old('pkm_id') == $data->id ? 'selected' : null }} >{{ $data->judul_pkm}}</option>
								@endforeach
						</select>
							@error('pkm_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<label for="exampleFormControlInput1">Tingkat<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="id_tingkat" class="form-control @error('id_tingkat') is-invalid @enderror">
							<option value="">Pilih Kategori Tingkat</option>
								@foreach ($kategori_tingkat as $data)
									<option value="{{ $data->id }}" {{ old('tingkat') == $data->id ? 'selected' : null }} >{{ $data->nama_kategori}}</option>
								@endforeach
						</select>
							@error('id_tingkat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<label for="exampleFormControlInput1">Jenis Publikasi<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="jenis_publikasi" class="form-control @error('jenis_publikasi') is-invalid @enderror">
							<option value="">Pilih Jenis Publikasi</option>
								@foreach ($jenis_publikasi as $data)
									<option value="{{ $data->id }}" {{ old('jenis_publikasi') == $data->id ? 'selected' : null }} >{{ $data->jenis_publikasi}}</option>
								@endforeach
						</select>
							@error('jenis_publikasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Artikel yang mensitasi</label>
							<input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah" value="{{ old ('jumlah') }}">

							@error('jumlah')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Terbit Publikasi Ilmiah<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun') == $artikel_dosen ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Deadline Verifikasi<span class="danger" style="color: #DC143C;">*</span></label>
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
							<label for="softcopy">Bukti Karya Ilmiah</label>
							<input type="file" class="form-control-file @error('softcopy') is-invalid @enderror" id="softcopy" name="softcopy">
						
							@error('softcopy')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						{{-- @foreach ( $artikel_dosen as $value ) --}}
							<button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
							{{-- <a href="{{ route('luaran.karya-ilmiah.detail', $value->id ) }}" class="btn btn-danger" style="float: right;">Batal</a> --}}
						{{-- @endforeach --}}

					</form>
			</div>
        </div>
	</div>
</div>


@stop
