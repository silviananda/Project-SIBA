@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Karya Ilmiah</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('luaran.karya-ilmiah.update-detail', $artikel_dosen->id) }}" method="post" enctype="multipart/form-data">
					@method('patch')
					@csrf
					<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
                            <label for="exampleFormControlInput1">NIP Dosen</label>
                            <input type="text" oninput="autofill('dosen')" class="dosen form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" value="{{ $artikel_dosen->dosen['nip'] }}">
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen</label>
							<input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen" value="{{ $artikel_dosen->dosen['nama_dosen'] }}">
						</div>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id" value="{{ $artikel_dosen->dosen_id }}">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Artikel/Karya Ilmiah</label>
							<input type="text" class="form-control @error('judul') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="judul" value="{{ $artikel_dosen->judul }}">

							@error('judul')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>


						<div class="col-md-4 col-sm-4">
							<label for="exampleFormControlInput1">Volume</label>
							<input type="text" class="form-control @error('volume') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="volume" value="{{ $artikel_dosen->volume }}">

							@error('volume')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-4 col-sm-4">
							<label for="exampleFormControlInput1">Page</label>
							<input type="text" class="form-control @error('page') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="page" value="{{ $artikel_dosen->page }}">

							@error('page')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-4 col-sm-4">
							<label for="exampleFormControlInput1">Issue</label>
							<input type="text" class="form-control @error('issue') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="issue" value="{{ $artikel_dosen->issue }}">

							@error('issue')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Publisher</label>
							<input type="text" class="form-control @error('publisher') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="publisher" value="{{ $artikel_dosen->publisher }}">

							@error('publisher')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Judul Penelitian dan Pengembangan Kepada Masyarakat</label>
						<select name="pkm_id" class="form-control @error('pkm_id') is-invalid @enderror">
							<option value="">Pilih Pkm</option>
								@foreach ($data_pkm as $data)
									<option value="{{ $data->id }}" {{$data->id == $artikel_dosen->pkm_id ? 'selected' : ''}}  >{{ $data->judul_pkm}}</option>
								@endforeach
						</select>
							@error('pkm_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<label for="exampleFormControlInput1">Tingkat</label>
						<select name="id_tingkat" class="form-control @error('id_tingkat') is-invalid @enderror">
							<option value="">Pilih Kategori Tingkat</option>
								@foreach ($kategori_tingkat as $data)
									<option value="{{ $data->id }}" {{$data->id == $artikel_dosen->id_tingkat ? 'selected' : ''}} >{{ $data->nama_kategori}}</option>
								@endforeach
						</select>
							@error('id_tingkat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<label for="exampleFormControlInput1">Jenis Publikasi</label>
						<select name="jenis_publikasi" class="form-control @error('jenis_publikasi') is-invalid @enderror">
							<option value="">Pilih Jenis Publikasi</option>
								@foreach ($jenis_publikasi as $data)
									<option value="{{ $data->id }}" {{$data->id == $artikel_dosen->jenis_publikasi ? 'selected' : ''}} >{{ $data->jenis_publikasi}}</option>
								@endforeach
						</select>
							@error('jenis_publikasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah</label>
							<input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah" value="{{ $artikel_dosen->jumlah }}">

							@error('jumlah')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Deadline<span class="required">*</span></label>
                                <input id="deadline" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="deadline" value="{{ $artikel_dosen->deadline }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                            setTimeout(function() {
                                                input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Publikasi</label>
                                <select name="tahun" class="form-control">
                                <option value="">Pilih Tahun Publikasi</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $artikel_dosen->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
                        </div>

						<div class="form-group">
							<label for="softcopy">Bukti Karya Ilmiah</label>
							<input type="file" class="form-control-file @error('softcopy') is-invalid @enderror" id="softcopy" name="softcopy">
						
							@error('softcopy')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('luaran.karya-ilmiah.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
