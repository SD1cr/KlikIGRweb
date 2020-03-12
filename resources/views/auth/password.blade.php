@extends('appcheckout')

@section('content')
	<div class="container" style="margin-top: 90px;">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						@if (session('status'))
							<div class="alert alert-success">
								{{ session('status') }}
							</div>
						@endif

						@if (count($errors) > 0)
								<div class="alert alert-success">
									Kami telah mengirimkan email untuk mereset password anda!
								</div>
						@endif
						<div class="text-center">
							<i class="fa fa-lock fa-3x"></i>      
							<h3 class="text-center">Lupa Sandi?</h3>
							<p>Anda dapat mengatur ulang sandi anda di sini.</p>
							<div class="panel-body">

								<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
									{!! csrf_field() !!}


									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
											<input type="email" class="form-control" placeholder="alamat email" name="email" value="{{ old('email') }}">
										</div>
									</div>


									<div class="form-group">
										<button type="submit" class="btn btn-lg btn-primary btn-block flat">
											Kirim Link Reset Sandi
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
