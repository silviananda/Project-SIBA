@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Tambah Data Paten Dosen</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('luaran.paten.store') }}" method="post">
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
                            <label for="exampleFormControlInput1">NIP Dosen Pendamping<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" oninput="autofill('dosen')" class="dosen form-control @error('nip') is-invalid @enderror" id="nip" placeholder="Masukkan NIP Dosen" name="nip" value="{{ old ('nip') }}">
                        
							@error('nip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                            <span class="dosen danger" style="color: #DC143C;" id="ShowError"></span>
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Dosen Pendamping<span class="danger" style="color: #DC143C;">*</span></label>
                            <input type="text" disabled="disabled" class="dosen form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" placeholder="" name="nama_dosen" value="{{ old ('nama_dosen') }}">
                        </div>
						<span class="danger" style="color: #DC143C;" id="ShowError"></span>

                        <div class="form-group form-material row">
                            <input type="hidden" class="dosen form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" placeholder="" name="dosen_id">
                        </div>

						<label for="exampleFormControlInput1">Kategori Penelitian dan Pengembangan Kepada Masyarakat<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="pkm_id" class="form-control @error('pkm_id') is-invalid @enderror">
							<option value="">Pilih Pkm</option>
								@foreach ($data_pkm as $data)
									<option value="{{ $data->id }}" {{ old('pkm_id') == $data->id ? 'selected' : null }} >{{ $data->judul_pkm}}</option>
								@endforeach
						</select>
							@error('pkm_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        <br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nama Produk/Jasa<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('karya') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="karya" value="{{ old ('karya') }}">

							@error('karya')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Nomor HKI</label>
							<input type="text" class="form-control @error('no_hki') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="no_hki" value="{{ old ('no_hki') }}">

							@error('no_hki')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Terbit Paten<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old ('tahun') }}">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{ old('tahun') == $paten ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tanggal Deadline Verifikasi<span class="danger" style="color: #DC143C;">*</span></label>
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

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('luaran.paten.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
