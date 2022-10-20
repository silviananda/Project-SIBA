@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Ubah Data Penelitian Mahasiswa</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('penelitian.mahasiswa.update', $data_penelitian->id) }}" method="post">
					@method('patch')
                    @csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
                            <label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofill('dosen')" class="dosen form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" value="{{ $data_penelitian->dosen->nip }}">
                        
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="dosen danger" style="color: #DC143C;" id="ShowError"></span>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" placeholder="" id="nama_dosen" name="nama_dosen" value="{{ $data_penelitian->dosen->nama_dosen }}">

							@error('nama_dosen')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<span class="danger" style="color: #DC143C;" id="ShowError"></span>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id" value="{{ $data_penelitian->dosen_id }}">
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Tema Roadmap Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('tema') is-invalid @enderror" placeholder="" name="tema" value="{{ $data_penelitian->tema }}">

							@error('tema')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        @foreach ($data_penelitian->penelitianmagister as $item)
                            <div class="input-mahasiswa form-group">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Npm Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
                                	<input type="text" oninput="autofillmhs('mahasiswa1')" class="mahasiswa1 form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm" value="{{ $item->biodata_mhs->npm ?? null }}">
                            
                                    @error('npm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            	<span class="mahasiswa1 danger" style="color: #DC143C;" id="ErrorVal"></span>
							</div>

							<div class="form-group form-material row">
								<input type="hidden" class="mahasiswa1 form-control" id="input-id" name="mhs_id[]" value="{{ $item->mhs_id ?? null }}">
							</div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nama Mahasiswa<span class="danger" style="color: #DC143C;">*</span></label>
                                    <input type="text"  disabled="disabled" class="mahasiswa1 form-control" id="nama" name="nama" value="{{ $item->biodata_mhs->nama ?? null }}">

                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                        @endforeach

                        <div class="form-group">
							<label for="exampleFormControlInput1">Judul Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul_penelitian') is-invalid @enderror" placeholder="" name="judul_penelitian" value="{{ $data_penelitian->judul_penelitian }}">

							@error('judul_penelitian')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Sumber Dana</label>
						<select name="sumber_dana_id" class="form-control @error('sumber_dana_id') is-invalid @enderror">
							<option value="">Pilih Jenis Sumber</option>
								@foreach ($sumber_dana as $data)
									<option value="{{ $data->id }}" {{$data->id == $data_penelitian->sumber_dana_id ? 'selected' : ''}} >{{ $data->nama_sumber_dana}}</option>
								@endforeach
						</select>
							@error('sumber_dana_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun_penelitian" class="form-control @error('tahun_penelitian') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $data_penelitian->tahun_penelitian ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

							@error('tahun_penelitian')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('penelitian.mahasiswa.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
