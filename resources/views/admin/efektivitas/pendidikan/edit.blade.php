@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				  <h2>Form Ubah Data Mahasiswa</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

					<form role="form" action="{{ route('efektivitas.pendidikan.update', $efektivitas->id) }}" method="post">
					@method('patch')
					@csrf

					<div class="form-group">
							<input type="hidden" class="form-control" disabled="disabled" placeholder="Disabled Input" value="{!! Auth::user()->name !!}" name="{!! Auth::user()->kode_ps !!}">
							@error('user_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">NPM<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('npm') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="npm" value="{{ $efektivitas->npm }}">

							@error('npm')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>


						{{-- <div class="form-group">
							<label for="exampleFormControlInput1">NPM</label>
							<input type="text" class="form-control @error('npm') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="ipk" value="{{ $biodata_mhs->ipk }}">

							@error('ipk')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div> --}}


						<div class="form-group">
							<label for="exampleFormControlInput1">Nama<span class="danger" style="color: #DC143C;">*</span></label>
							<input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" name="nama" value="{{ $efektivitas->nama }}">

							@error('nama')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Masuk<span class="danger" style="color: #DC143C;">*</span></label>
                                <input id="tahun_masuk" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tahun_masuk" value="{{ $efektivitas->tahun_masuk }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tahun Lulus<span class="danger" style="color: #DC143C;">*</span></label>
                                <input id="tahun_lulus" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="tahun_lulus" value="{{ $efektivitas->tahun_lulus }}">
                                    <script>
                                        function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                            }, 60000);
                                        }
                                    </script>
                        </div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('efektivitas.pendidikan.index') }}" class="btn btn-danger" style="float: right;">Batal</a>

				</form>
			</div>
        </div>
	</div>
</div>
@stop
