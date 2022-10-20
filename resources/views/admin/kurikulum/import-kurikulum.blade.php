@extends('admin.layout.main')
@section('content')

<div class="right_col" role="main">
	<div class="">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel shadow-sm p-3 mb-5 bg-white rounded">
				<div class="x_title">

				    <h2>Import Data Kurikulum</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
			    </div>

                <form role="form" action="{{ route('kurikulum.import.store') }}" method="post" enctype="multipart/form-data">
					@csrf

						<div class="form-group">
							<label for="softcopy">Data Kurikulum</label>
							<input type="file" class="form-control-file" id="file" name="file">
						</div>

                        <button type="submit" class="btn btn-primary" style="float: right;">Simpan</button>
                        <a href="{{ route('kurikulum.kurikulum') }}" class="btn btn-danger" style="float: right;">Batal</a>
				</form>
			</div>
        </div>
	</div>
</div>
@stop
