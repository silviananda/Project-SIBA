@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

                    <h2>Form Ubah Data Struktur Kurikulum</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                    <form role="form" action="{{ route('kurikulum.struktur.update', $kurikulum->id) }}" method="post" enctype="multipart/form-data">
                        @method('patch')
                        @csrf

                        <div class="form-group">
							<input type="hidden" class="form-control" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<label for="exampleFormControlInput1">Semester<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="semester_id" class="form-control @error('semester_id') is-invalid @enderror" required>
							<option value="">Pilih Semester</option>
								@foreach ($semester as $data)
									<option value="{{ $data->id }}" {{$data->id == $kurikulum->semester_id ? 'selected' : ''}} >{{ $data->nama_semester}}</option>
								@endforeach
						</select>
							@error('semester_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>
                        {{-- <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun </label>
                                <select name="tahun" class="form-control" required>
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $kurikulum->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
                        </div> --}}


						<div class="form-group">
							<label for="exampleFormControlInput1">Kode Matakuliah<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text"  class="form-control @error('kode_mk') is-invalid @enderror" placeholder="" name="kode_mk" value="{{ $kurikulum->kode_mk }}">

							@error('kode_mk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Nama Matakuliah<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text"  class="form-control @error('nama_mk') is-invalid @enderror" placeholder="" name="nama_mk" value="{{ $kurikulum->nama_mk }}">

							@error('nama_mk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>


						<div class="col-md-6 col-sm-12  form-group">
                            <label for="exampleFormControlInput1">Sks Matakuliah<span class="danger" style="color: #DC143C;">*</span></label>
							    <input type="text"  class="form-control @error('bobot_sks') is-invalid @enderror" placeholder="" name="bobot_sks" value="{{ $kurikulum->bobot_sks }}">

                                @error('bobot_sks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="col-md-6 col-sm-12  form-group">
							<label for="exampleFormControlInput1">Sks Praktikum</label>
                                <input type="text"  class="form-control @error('sks_praktikum') is-invalid @enderror" placeholder="" name="sks_praktikum" value="{{ $kurikulum->sks_praktikum }}">

                                @error('sks_praktikum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="col-md-6 col-sm-12  form-group">
                            <label for="exampleFormControlInput1">Sks Seminar</label>
                                <input type="text"  class="form-control @error('sks_seminar') is-invalid @enderror" placeholder="" name="sks_seminar" value="{{ $kurikulum->sks_seminar }}">

                                @error('sks_seminar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="col-md-6 col-sm-12  form-group">
							<label for="exampleFormControlInput1">Sks Tugas</label>
                                <input type="text"  class="form-control @error('bobot_tugas') is-invalid @enderror" placeholder="" name="bobot_tugas" value="{{ $kurikulum->bobot_tugas }}">

                                @error('bobot_tugas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1" >Keterangan Matakuliah Wajib/Tidak</label>
								<select class="form-control" name="wajib">
									<option value="">Pilih</option>
                                    <option value="Y" {{ $kurikulum->wajib == 'Y' ? 'selected' : '' }}>Ya</option>
                                    <option value="N" {{ $kurikulum->wajib == 'N' ? 'selected' : '' }}>Tidak</option>
								</select>
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Unit Penyelenggara</label>
							<input type="text"  class="form-control @error('unit') is-invalid @enderror" placeholder="" name="unit" value="{{ $kurikulum->unit }}">

							@error('unit')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="silabus">Silabus</label>
							<input type="file" class="form-control-file @error('silabus') is-invalid @enderror" id="silabus" name="silabus">
                        
							@error('silabus')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="rps">RPS</label>
							<input type="file" class="form-control-file @error('rps') is-invalid @enderror" id="rps" name="rps">
                        
							@error('rps')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('kurikulum.struktur.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
