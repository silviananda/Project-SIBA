@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">
				    <h2>Form Tambah Data Rekognisi Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('upaya.rekognisi.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">

							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
								<label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span></label>
								<input type="text" oninput="autofill('dosen-tetap')" class="dosen-tetap form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
						
							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                            <span class="dosen-tetap danger" style="color: #DC143C;" id="ShowError"></span>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" disabled="disabled" class="dosen-tetap form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
						
							@error('nama_dosen')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group form-material row">
							<input type="hidden" class="dosen-tetap form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
						</div>


						<div class="form-group">
							<label for="exampleFormControlInput1">Bidang Keahlian<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('bidang_keahlian') is-invalid @enderror" placeholder="" name="bidang_keahlian" value="{{ old ('bidang_keahlian') }}">

							@error('bidang_keahlian')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Rekognisi<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('rekognisi') is-invalid @enderror" placeholder="" name="rekognisi" value="{{ old ('rekognisi') }}">

							@error('rekognisi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Rekognisi<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun Rekognisi</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun') == $rekognisi ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>


                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('upaya.rekognisi.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
