@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Import Data Mahasiswa</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('mahasiswa.import.store') }}" method="post" enctype="multipart/form-data">
					@csrf

						<div class="form-group">
							<label for="softcopy">Data Mahasiswa</label>
                            <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file">

							@error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
						</div>
						<br>

						<div class="form-group">
							<label for="softcopy"><span class="danger" style="color: #DC143C;">*  Contoh Format File yang Dapat di Import</span></label>
                            
								<div>
                                <img src="/assets/images/excel.png" height="50" width="50">
             						<span class="count_top"><i class=""></i> mahasiswa.xlsx </span>
                                <div class="message_date">
                                </div>
								<br>
                                <div class="message_wrapper">
                                  <p class="url">
                                    <span class="fs1" aria-hidden="true" data-icon=""></span>
                                    <a href="{{ asset('file/mahasiswa.xlsx') }}" target="_blank" data-original-title="">Download</a>
                                  </p>
                                </div>
								</div>
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('mahasiswa.mahasiswa') }}" class="btn btn-danger" style="float: right;">Batal</a>

					</form>
			</div>
        </div>
	</div>
</div>
@stop
