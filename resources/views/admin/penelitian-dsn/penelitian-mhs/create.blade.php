@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Tambah Data Keterlibatan Mahasiswa dalam Penelitian Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('penelitian.dosen.store') }}" method="post" enctype="multipart/form-data">
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
                            <input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
                        </div>
						<span class="danger" style="color: #DC143C;" id="ShowError"></span>

                        <div class="form-group form-material row">
                            <input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
                        </div>

                        <div id="mahasiswa_fields" class="form-group">
                            <div class="input-mahasiswa form-group">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nama Mahasiswa yang berpartisipasi</label>
                                    <input type="text" oninput="autofillmhs('mahasiswa1')" class="mahasiswa1 form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm">
                                
                            		<span class="mahasiswa1 danger" style="color: #DC143C;" id="ErrorVal"></span>
							    </div>

                                <div class="form-group form-material row">
                                    <input type="hidden" class="mahasiswa1 form-control" id="input-id" name="mhs_id[]">
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nama Mahasiswa</label>
                                    <input type="text"  disabled="disabled" class="mahasiswa1 form-control" id="nama" name="nama">

                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="btn btn-success" type="button" onclick="mahasiswa_fields();"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Tema Roadmap Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('tema') is-invalid @enderror" placeholder="" name="tema" value="{{ old ('tema') }}">

							@error('tema')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Judul Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul_penelitian') is-invalid @enderror" placeholder="" name="judul_penelitian" value="{{ old ('judul_penelitian') }}">

							@error('judul_penelitian')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Sumber Dana</label>
						<select name="sumber_dana_id" class="form-control @error('sumber_dana_id') is-invalid @enderror">
							<option value="">Pilih Jenis Sumber</option>
								@foreach ($sumber_dana as $data)
									<option value="{{ $data->id }}" {{ old('sumber_dana_id') == $data->id ? 'selected' : null }} >{{ $data->nama_sumber_dana}}</option>
								@endforeach
						</select>
							@error('sumber_dana_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Dana</label>
							<input type="text" class="form-control @error('jumlah_dana') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_dana" value="{{ old ('jumlah_dana') }}">

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
                            <label for="exampleFormControlInput1">Tahun Penelitian<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun_penelitian" class="form-control @error('tahun_penelitian') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun_penelitian') == $data_penelitian ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

							@error('tahun_penelitian')
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
							<label for="exampleFormControlFile1">File Penelitian</label>
							<input type="file" class="form-control-file @error('softcopy') is-invalid @enderror" id="exampleFormControlFile1" name="softcopy">
                        
							@error('softcopy')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>


                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('penelitian.dosen.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
