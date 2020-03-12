@extends('cms1')
<style>
.btn-custom {
color: #fff;
background-color: #008CBA;
border-color: #008CBA;
}

.btn-custom:hover {
color: #fff;
background-color: #138496;
border-color: #117a8b;
}

.btn-custom:focus, .btn-custom.focus {
box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5);
}

.btn-custom.disabled, .btn-custom:disabled {
color: #fff;
background-color: #17a2b8;
border-color: #17a2b8;
}

.btn-custom:not(:disabled):not(.disabled):active, .btn-custom:not(:disabled):not(.disabled).active,
.show > .btn-custom.dropdown-toggle {
color: #fff;
background-color: #117a8b;
border-color: #10707f;
}

.btn-custom:not(:disabled):not(.disabled):active:focus, .btn-custom:not(:disabled):not(.disabled).active:focus,
.show > .btn-custom.dropdown-toggle:focus {
box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5);
}

.bootstrap-select > .dropdown-toggle.bs-placeholder.btn-custom,
.bootstrap-select > .dropdown-toggle.bs-placeholder.btn-custom:hover,
.bootstrap-select > .dropdown-toggle.bs-placeholder.btn-custom:focus,
.bootstrap-select > .dropdown-toggle.bs-placeholder.btn-custom:active {
color: rgba(255, 255, 255, 0.5);
}
</style>
@section('content')
	<div class="container" style="margin-top: 60px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-file-image-o"></i>
						Create Promotion
					</div>
					<div class="panel-body">
						<form class="form-horizontal" id="upload" enctype="multipart/form-data" method="post" action="{{ url('createnotif') }}" autocomplete="off">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />


						{{--<div class="input-group inputs" style="margin-top: 20px;margin-bottom: 20px;">--}}
							{{--<span class="input-group-addon" style="min-width: 50px">Pilih Tipe : </span>--}}
							{{--<select id="txt_type" name="id_type" class="selectpicker">--}}
								{{--<option style="font-size: 12px;" value="1">Informasi </option>--}}
								{{--<option style="font-size: 12px;" value="2">Promosi </option>--}}
							{{--</select>--}}
						{{--</div>--}}

						<div class="row" style="margin-left: 0px;margin-right: 0px;margin-bottom: 20px;">
							<span class="col-md-6 input-group-addon" style="min-width: 142px">Filter Cabang : </span>
							<select id="txt_cab" name="id_cab[]" class="col-md-8 selectpicker" data-style="btn-custom" data-live-search="true" multiple data-actions-box="true" onChange= "changeMember()" >
								{!! $cabang !!}
							</select>
						</div>

						<div class="row" style="margin-left: 0px;margin-right: 0px;margin-bottom: 20px;">
							<span class="col-md-2 input-group-addon" style="min-width: 142px">Filter Member : </span>
							<select id='member' name="member[]" class="col-md-8 selectpicker" data-style="btn-custom" data-live-search="true" multiple data-actions-box="true" style="max-width: 300px;">
								{!! $member !!}
							</select>
						</div>


						<div class="input-group inputs">
							<span class="input-group-addon" style="min-width: 142px">Judul</span>
							<input type="text" name="title" class="input-sm form-control">
						</div>


						<div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
							<span class="input-group-addon" style="min-width: 142px"><i>Deskripsi</i></span>
							<input type="text" name="caption" class="input-sm form-control" style="min-height: 60px">
						</div>

						<div class="input-group inputs" style="margin-top: 10px; margin-bottom: 10px;">
							<span class="input-group-addon" style="min-width: 142px">isi Content</span>
							<textarea class="summernote" name="isi"></textarea>
							{{--<div style="margin-top: 30px;" name="isi" class="summernote"></div>--}}
						</div>

							{{--<div class="input-group inputs">--}}
								{{--<span class="input-group-addon" style="min-width: 142px">Content</span>--}}
								{{--<input type="text" name="title" class="input-sm form-control">--}}
							{{--</div>--}}



						<br>
                        <span class="note" style="margin-top: 10px; margin-bottom: 10px;">
							Catatan: Ukuran Gambar Promotion 600 x 200px
							<br><br>
						</span>
						<input id="input-image" name="input-image" type="file" class="file" accept="image/*" data-allowed-file-extensions='["jpg", "png"]'>
						<br>

						{{--<div class="text-center" style="margin-top: 20px">--}}
							{{--<button type="submit" class="btn btn-primary flat">--}}
								{{--Create Promotion--}}
							{{--</button>--}}
						{{--</div>--}}
					</form>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						$('.selectpicker').selectpicker({buttonWidth: '20%'});
//						$('.js-example-basic-single').select2();
					});

//					$(document).ready(function() {
//						$('.summernote').summernote({ followingToolbar: false });
//					});
					$(document).ready(function() {
						$('.summernote').summernote({
							placeholder: 'Write your blog content here...',
							tabsize: 1,
							height: 100,
							focus: true,
							followingToolbar: false
						});
					});

//					$('.input-daterange').datepicker({
//						format: "yyyy-mm-dd",
//						immediateUpdates: true,
//						todayHighlight: true
//					});

					function changeMember(){
						var id_cab = $("#txt_cab").val();
//						var id_type = $("#txt_type").val();
						$.ajax({
							url : 'get_member',
							data : {id_cab : id_cab},
							success : function(msg){
								document.getElementById("member").disabled = false;
								$("#member").html(msg);
								$("#member").selectpicker('refresh');
							}
						});
					}

				</script>
			</div>
		</div>
	</div>
@endsection