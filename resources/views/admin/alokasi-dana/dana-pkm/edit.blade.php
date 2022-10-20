@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Dana PkM</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('alokasi-dana.pkm.update', $data_pkm->id) }}" method="post">
					@method('patch')
					@csrf

						<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Judul PKM<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('judul_pkm') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="judul_pkm" value="{{ $data_pkm->judul_pkm }}" required>

							@error('judul_pkm')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Pkm<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $data_pkm->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
                        </div>

						<label for="exampleFormControlInput1">Sumber Dana<span class="danger" style="color: #DC143C;">*</span></label>
						<select name="sumber_dana_id" class="form-control @error('sumber_dana_id') is-invalid @enderror">
							<option value="">Pilih Jenis Sumber</option>
								@foreach ($sumber_dana as $data)
									<option value="{{ $data->id }}" {{$data->id == $data_pkm->sumber_dana_id ? 'selected' : ''}} >{{ $data->nama_sumber_dana}}</option>
								@endforeach
						</select>
							@error('sumber_dana_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						<br>

						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Dana<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jumlah_dana') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah_dana" value="{{ $data_pkm->jumlah_dana }}" required>

							@error('jumlah_dana')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<span class="danger" style="color: #DC143C;">*Input dengan format angka, contoh : 100000</span>
						<br>
						<br>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('alokasi-dana.pkm.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
