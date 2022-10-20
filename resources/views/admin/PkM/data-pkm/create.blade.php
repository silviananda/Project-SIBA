@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Rekapitulasi Pengabdian Kepada Masyarakat</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('pkm.data.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Tahun Pkm</label>
								<select id="heard" class="form-control" name="tahun" required>
									<option value="">Pilih..</option>
									<option value="2020">2020</option>
									<option value="2019">2019</option>
									<option value="2018">2018</option>
									<option value="2017">2017</option>
									<option value="2016">2016</option>
									<option value="2015">2015</option>
								</select>
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">PT Uiversitas Syiah Kuala</label>
							<input type="text" class="form-control @error('tema') is-invalid @enderror" placeholder="" name="tema" value="{{ old ('tema') }}">

							@error('tema')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul Pkm</label>
							<input type="text" class="form-control @error('judul_pkm') is-invalid @enderror" placeholder="" name="judul_pkm" value="{{ old ('judul_pkm') }}">

							@error('judul_pkm')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div id="mahasiswa_fields" class="form-group">

                            <div class="input-mahasiswa form-group">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nama Mahasiswa yang berpartisipasi</label>
                                    <input type="text" oninput="autofillmhs('mahasiswa1')" class="mahasiswa1 form-control @error('npm') is-invalid @enderror" id="npm" placeholder="Masukkan NIM Mahasiswa" name="npm">
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
							<label for="exampleFormControlInput1">Tahun Pkm</label>
								<select id="heard" class="form-control" name="tahun" required>
									<option value="">Pilih..</option>
									<option value="2020">2020</option>
									<option value="2019">2019</option>
									<option value="2018">2018</option>
									<option value="2017">2017</option>
									<option value="2016">2016</option>
									<option value="2015">2015</option>
								</select>
						</div>

						<button type="submit" class="btn btn-primary">Simpan</button>
					</form>
			</div>
        </div>
	</div>
</div>
@stop
