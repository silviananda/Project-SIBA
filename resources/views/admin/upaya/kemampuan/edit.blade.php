@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Dosen Tugas Belajar</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('upaya.tugas-belajar.update', $kemampuan_dosen->id) }}" method="post">
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
								<input type="text" oninput="autofill('dosen-tetap')" class="dosen-tetap form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" value="{{ $kemampuan_dosen->dosen['nip'] }}">
						
							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                            <span class="dosen-tetap danger" style="color: #DC143C;" id="ShowError"></span>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="dosen-tetap form-control @error('nama_dosen') is-invalid @enderror" disabled="disabled" id="nama_dosen" placeholder="" name="nama_dosen" value="{{ $kemampuan_dosen->dosen['nama_dosen'] }}">
						</div>
						
						<span class="danger" style="color: #DC143C;" id="ShowError"></span>


						<div class="form-group form-material row">
							<input type="hidden" class="dosen-pendamping form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id" value="{{ $kemampuan_dosen->dosen_id }}">
						</div>


						<div class="form-group">
							<label for="exampleFormControlInput1">Bidang<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('bidang') is-invalid @enderror" placeholder="" name="bidang" value="{{ $kemampuan_dosen->bidang }}">

							@error('bidang')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Perguruan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('perguruan') is-invalid @enderror" placeholder="" name="perguruan" value="{{ $kemampuan_dosen->perguruan }}">

							@error('perguruan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Negara<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('negara') is-invalid @enderror" placeholder="" name="negara" value="{{ $kemampuan_dosen->negara }}">

							@error('negara')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Mulai Pendidikan<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $kemampuan_dosen->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('upaya.tugas-belajar.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
