@extends('admin.layout.main')
@section('content')

	<!-- page content -->
	<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Visi dan Misi</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

						<li class="dropdown">
						    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
							    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="#">Settings 1</a>
						    <a class="dropdown-item" href="#">Settings 2</a>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
						<div class="clearfix"></div>
			    </div>

				<form role="form" action="" method="post">
				@csrf

					<div class="form-group blue-border-focus">
						<label for="exampleFormControlTextarea5">Input Visi</label>
						<textarea class="form-control @error('desc_visi') is-invalid @enderror" id="exampleFormControlTextarea5" rows="8" name="desc_visi"></textarea>

							@error('desc_visi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
					</div>
					<br>

					<div class="form-group blue-border-focus">
						<label for="exampleFormControlTextarea5">Input Misi</label>
						<textarea class="form-control @error('desc_misi') is-invalid @enderror"" id="exampleFormControlTextarea5" rows="8" name="desc_misi"></textarea>

							@error('desc_misi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
					</div>
					<br>
						<input type="submit" class="btn btn-primary" value="Simpan">
				</form>
		    </div>
        </div>
	</div>
</div>

@stop

