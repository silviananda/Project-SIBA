@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Form Ubah Data Capaian</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('capaian.update', $capaian->id) }}" method="post">
					@method('patch')
					@csrf

                        <div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Lulus<span class="danger" style="color: #DC143C;">*</span></label>
                                <select name="tahun" class="form-control @error('tahun') is-invalid @enderror">
                                <option value="">Pilih Tahun</option>
                                    @for ($year = date('Y') - 7; $year < date('Y') + 10; $year++)
                                        <option value="{{$year}}" {{$year == $capaian->tahun ? 'selected': ''}}>{{$year}}</option>
                                    @endfor
                               </select>
							@error('tahun')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>


						<div class="form-group">
							<label for="exampleFormControlInput1">Jumlah Lulusan<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="jumlah" value="{{ $capaian->jumlah }}">

							@error('jumlah')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">IPK Minimum<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('minimum') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="minimum" value="{{ $capaian->minimum }}">

							@error('minimum')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">IPK Maksimum<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('maksimum') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="maksimum" value="{{ $capaian->maksimum }}">

							@error('maksimum')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="exampleFormControlInput1">IPK Rata-rata<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('rata') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="rata" value="{{ $capaian->rata }}">

							@error('rata')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('capaian.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
