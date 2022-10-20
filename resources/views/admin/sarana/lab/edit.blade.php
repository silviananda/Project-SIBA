@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Laboratorium</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('sarana.lab.update', $data_lab->id) }}" method="post">
					@method('patch')
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">Lokasi Penempatan Barang<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="lokasi" value="{{ $data_lab->lokasi }}">

							@error('lokasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Alat<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama_alat') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama_alat" value="{{ $data_lab->nama_alat }}">

							@error('nama_alat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Alat<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jumlah_alat') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_alat" value="{{ $data_lab->jumlah_alat }}">

							@error('jumlah_alat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Pengadaan<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun_pengadaan" class="form-control @error('tahun_pengadaan') is-invalid @enderror">
                                <option value="">Pilih Tahun Pengadaan</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $data_lab->tahun_pengadaan ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>

							@error('tahun_pengadaan')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Fungsi Alat</label>
							<input type="text" class="form-control @error('fungsi') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="fungsi" value="{{ $data_lab->fungsi }}">

							@error('fungsi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('sarana.lab.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
