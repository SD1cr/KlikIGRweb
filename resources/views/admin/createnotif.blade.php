@extends('cms1')

@section('content')
	<div class="container" style="margin-top: 60px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-file-image-o"></i>
						Create Notification
					</div>
					<div class="panel-body">
						<form class="form-horizontal" id="upload" enctype="multipart/form-data" method="post" action="{{ url('createnotif') }}" autocomplete="off">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />

						{{--<div class='input-daterange input-group' id='datepicker' style="margin-top: 10px; margin-bottom: 10px;">--}}
							{{--<span style="min-width: 142px" class="input-group-addon">Periode Notif</span>--}}
							{{--<input type='text' class="form-control" name="start" id="dtStart"/>--}}
							{{--<span class="input-group-addon">Sampai Tanggal</span>--}}
							{{--<input type='text' class="form-control" name="end" id="dtEnd"/>--}}
						{{--</div>--}}

						{{--<div class="form-group" style="padding-top: 20px;margin-left: 0px;">--}}
							{{--<label for="combo_cabang">&nbsp;&nbsp;Filter Cabang : </label>--}}
							{{--<select id="cabang" name="cab[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" onchange="onPilih()" multiple>--}}
								{{--<option style="font-size: 12px;" value="%">All Cabang </option>--}}
								{{--{!! $cabang !!}--}}
							{{--</select>--}}
						{{--</div>--}}

						{{--<div class="form-group" style="padding-top: 0px;margin-left: 0px;">--}}
							{{--<label for="combo_cabang">&nbsp;&nbsp;Filter Tipe : </label>--}}
							{{--<select id="cabang" name="cab[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" onchange="onPilih()" multiple>--}}
								{{--<option style="font-size: 12px;" value="%">All Cabang </option>--}}
								{{--{!! $types !!}--}}
							{{--</select>--}}
						{{--</div>--}}

						<div class="input-group inputs">
							<span class="input-group-addon" style="min-width: 142px">Filter Cabang : </span>
							<select id="txt_cab" name="id_cab[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" onChange= "changeMember()" data-width="900px">
								<option style="font-size: 12px;" value="%">All Cabang </option>
								{!! $cabang !!}
							</select>
						</div>

						<div class="input-group inputs" style="margin-top: 20px;">
							<span class="input-group-addon" style="min-width: 142px">Filter Tipe : </span>
							<select id="txt_type" name="id_type[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" onChange= "changeMember()">
								<option style="font-size: 12px;" value="%">All Type </option>
								{!! $types !!}
							</select>
						</div>

						<div class="input-group inputs" style="margin-top: 20px;margin-bottom: 20px;">
							<span class="input-group-addon" style="min-width: 142px">Filter Member : </span>
							<select id='member' name="member[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true">
								{{--<option style="font-size: 12px;" value="%">All Cabang </option>--}}
								{!! $member !!}
							</select>
						</div>

							<div class="summernote">summernote 1</div>
							<div class="summernote">summernote 2</div>

							{{--<div class="form-group" style="padding-top: 0px;margin-left: 0px;">--}}
							{{--<label for="combo_cabang">&nbsp;&nbsp;Filter Member : </label>--}}
							{{--<select id="cabang" name="cab[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" onchange="onPilih()" multiple>--}}
								{{--<option style="font-size: 12px;" value="%">All Cabang </option>--}}
								{{--{!! $member !!}--}}
							{{--</select>--}}
						{{--</div>--}}


						<div class="input-group inputs">
							<span class="input-group-addon" style="min-width: 142px">Judul</span>
							<input type="text" name="title" class="input-sm form-control">
						</div>

							{{--<div class="input-group inputs">--}}
								{{--<span class="input-group-addon" style="min-width: 142px">Content</span>--}}
								{{--<input type="text" name="title" class="input-sm form-control">--}}
							{{--</div>--}}


						<div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
							<span class="input-group-addon" style="min-width: 142px"><i>Content</i></span>
							<input type="text" name="caption" class="input-sm form-control" style="min-height: 60px">
						</div>

						{{--<br>--}}
                        {{--<span class="note" style="margin-top: 10px; margin-bottom: 10px;">--}}
							{{--Catatan: Ukuran Gambar Promotion 600 x 200px--}}
							{{--<br><br>--}}
						{{--</span>--}}
						{{--<input id="input-image" name="input-image" type="file" class="file" accept="image/*" data-allowed-file-extensions='["jpg", "png"]'>--}}
						{{--<br>--}}

						<div class="text-center" style="margin-top: 20px">
							<button type="submit" class="btn btn-primary flat">
								Send Notification
							</button>
						</div>
					</form>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						$('.selectpicker').selectpicker();
						$('.js-example-basic-single').select2();
					});

					$('.input-daterange').datepicker({
						format: "yyyy-mm-dd",
						immediateUpdates: true,
						todayHighlight: true
					});

					$(document).ready(function() {
						$('.summernote').summernote();
					});

					function changeMember(){
						var id_cab = $("#txt_cab").val();
						var id_type = $("#txt_type").val();
						$.ajax({
							url : 'get_member',
							data : {id_cab : id_cab, id_type : id_type},
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