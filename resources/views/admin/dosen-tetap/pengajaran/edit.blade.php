@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				  <h2>Form Ubah Data Pengajaran</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('dosen.tetap.pengajaran.update', $mengajar->id) }}" method="post">
					@method('patch')
					@csrf

					<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						
						<div class="form-group">
                            <label for="exampleFormControlInput1">NIP Dosen<span class="danger" style="color: #DC143C;">*</span> </label>
                            <input type="text" oninput="autofill('dosen-wali')" class="dosen-wali form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" value="{{ $mengajar->dosen['nip'] }}">
                        
							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						    <span class="dosen-pengajar danger" style="color: #DC143C;" id="ShowError"></span>
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Dosen<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" disabled="disabled" class="dosen-wali form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen" value="{{ $mengajar->dosen['nama_dosen'] }}">
                        </div>


                        <div class="form-group form-material row">
                            <input type="hidden" class="dosen-wali form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id" value="{{ $mengajar->dosen_id }}">
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlInput1">Kode Matakuliah<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofillmk('mk')" class="mk form-control @error('kode_mk') is-invalid @enderror" id="kode_mk" placeholder="Masukkan Kode MK" name="kode_mk" value="{{ $mengajar->kurikulum['kode_mk'] }}">
                        
							@error('kode_mk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						    <span class="mk danger" style="color: #DC143C;" id="ErrorMk"></span>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Matakuliah<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="mk form-control @error('nama_mk') is-invalid @enderror" id="nama_mk" placeholder="" name="nama_mk" value="{{ $mengajar->kurikulum['nama_mk'] }}">
						</div>

						<input type="hidden" class="mk form-control @error('kurikulum_id') is-invalid @enderror" id="kurikulum_id" placeholder="" name="kurikulum_id" value="{{ $mengajar->kurikulum_id }}">

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Kelas</label>
							<input type="text" class="form-control @error('jumlah_kelas') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_kelas" value="{{ $mengajar->jumlah_kelas }}">

							@error('jumlah_kelas')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label for="exampleFormControlInput1">Jumlah SKS Rencana</label>
							<input type="text" class="form-control @error('rencana') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="rencana" value="{{ $mengajar->rencana }}">

                            @error('rencana')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
						</div>

						<div class="form-group col-md-6 col-sm-12">
							<label for="exampleFormControlInput1">Jumlah SKS Terlaksana</label>
							<input type="text" class="form-control @error('laksana') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="laksana" value="{{ $mengajar->laksana }}">

                            @error('laksana')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('dosen.tetap.pengajaran.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

				</form>
			</div>
        </div>
	</div>
</div>
@stop
