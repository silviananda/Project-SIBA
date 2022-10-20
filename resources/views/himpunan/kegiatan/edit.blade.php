@extends('himpunan.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Pengabdian Kepada Masyarakat</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('kegiatan.update', $data_pkm->id) }}" method="post" enctype="multipart/form-data">
                    @method('patch')
                    @csrf

                        <div class="form-group">
                            <input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('himpunan')->user()->id }}" name="himpunan_id">
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{{ \Auth::guard('himpunan')->user()->user_id }}" name="user_id">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofill('dosen')" class="dosen form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" value="{{ $data_pkm->dosen['nip']}}">
                        
							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                            <span class="dosen danger" style="color: #DC143C;" id="ShowError"></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen" value="{{ $data_pkm->dosen['nama_dosen'] }}">
                        </div>
						<span class="danger" style="color: #DC143C;" id="ShowError"></span>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id" value="{{ $data_pkm->dosen['dosen_id'] }}">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Tema PKM<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('tema') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="tema" value="{{ $data_pkm->tema }}">

							@error('tema')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Npm Mahasiswa yang Bertanggung Jawab<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofillmhs('mahasiswa1')" class="mahasiswa1 form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm" value="{{ $data_pkm->biodata_mhs['npm'] }}">
                        
                            @error('npm')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="mahasiswa1 danger" style="color: #DC143C;" id="ErrorVal"></span>
						</div>

                        <div class="form-group form-material row">
                            <input type="hidden" class="mahasiswa1 form-control" id="input-id" name="mhs_id" value="{{ $data_pkm->mhs_id }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
                                <input type="text"  disabled="disabled" class="mahasiswa1 form-control" id="nama" name="nama" value="{{ $data_pkm->biodata_mhs['nama'] }}">

                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul PKM<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul_pkm') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="judul_pkm" value="{{ $data_pkm->judul_pkm }}">

							@error('judul_pkm')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <label for="exampleFormControlInput1">Sumber Dana</label>
						<select name="sumber_dana_id" class="form-control @error('sumber_dana_id') is-invalid @enderror">
							<option value="">Pilih Sumber Dana</option>
								@foreach ($sumber_dana as $data)
									<option value="{{ $data->id }}" {{$data->id == $data_pkm->sumber_dana_id ? 'selected' : ''}} >{{ $data->nama_sumber_dana}}</option>
								@endforeach
						</select>
							@error('sumber_dana_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Dana</label>
							<input type="text" class="form-control @error('jumlah_dana') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_dana" value="{{ $data_pkm->jumlah_dana }}">

							@error('jumlah_dana')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<span class="danger" style="color: #DC143C;">*Input dengan format angka, contoh : 100000</span>
                        <br>
                        <span class="danger" style="color: #DC143C;">*Jika data kosong, input : 0</span>
						
						<br>
						<br>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $data_pkm->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlFile1">Dokumentasi</label>
							<input type="file" class="form-control-file" id="exampleFormControlFile1" name="softcopy">
                        </div>


                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-danger" style="float: right;">Batal</a>
					</form>
			</div>
        </div>
	</div>
</div>
@stop
