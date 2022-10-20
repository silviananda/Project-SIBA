@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Rekap Pembimbing Akademik</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('pembimbing.akademik.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
                            <label for="exampleFormControlInput1">NIP Pembimbing Akademik/Dosen Wali</label>
                            <input type="text" oninput="autofill('dosen-wali')" class="dosen-wali form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama  Pembimbing Akademik/Dosen Wali</label>
                            <input type="text" disabled="disabled" class="dosen-wali form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen">
                        </div>

                        <div class="form-group form-material row">
                            <input type="hidden" class="dosen-wali form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Mahasiswa</label>
							<input type="text" class="form-control @error('jumlah_mhs') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_mhs" value="{{ old ('jumlah_mhs') }}">

							@error('jumlah_mhs')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Rata-rata banyaknya pertemuan</label>
							<input type="text" class="form-control @error('rata_pertemuan') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="rata_pertemuan" value="{{ old ('rata_pertemuan') }}">

							@error('rata_pertemuan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('pembimbing.akademik.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
