@extends('appcheckout')

@section('content')
	<div class="container" style="margin-top: 90px;">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					{{--<div class="panel-heading">Atur Ulang Sandi</div>--}}
					<div class="panel-body">
						@if (count($errors) > 0)
							<div class="alert alert-success">
								{{--<strong>Whoops!</strong> Ada beberapa masalah saat input.<br><br>--}}
								<ul>
									<p>Kami telah mengirimkan email untuk mereset password anda </p>
								</ul>
							</div>
						@endif

						<div class="text-center">
							<i class="fa fa-key fa-3x"></i>    
							<h3 class="text-center">Atur Ulang Sandi</h3>
							<p>Anda dapat memasukkan sandi baru anda di sini.</p>
							<div class="panel-body">

								<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
									{!! csrf_field() !!}
									<input type="hidden" name="token" value="{{ $token }}">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
											<input type="email" class="form-control" placeholder="alamat email" name="email" value="{{ old('email') }}">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-key"></i></span>
											<input type="password" class="form-control" placeholder="sandi baru" name="password">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-key"></i></span>
											<input type="password" class="form-control" placeholder="konfirmasi sandi baru" name="password_confirmation">
										</div>
									</div>


									<div class="form-group">
										<button type="submit" class="btn btn-lg btn-primary btn-block flat">
											Atur Ulang Sandi
										</button>
									</div>

								</form>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
