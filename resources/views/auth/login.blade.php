@extends('appcheckout')

@section('content')
	<div class="container-fluid" style="margin-top:60px">
		<div class="row">
			<div class="col-xs-12">  
				<div class="panel panel-default">
					<div class="panel-heading">Login</div>
					<div class="panel-body">
						@if (session('err'))
							<div class="col-md-12 igr-flat" style="margin-top:10px;">
								<div class="alert alert-danger igr-flat">
									<strong>{{session('err')}}</strong>
								</div>
							</div>
						@endif

						<form class="form-horizontal" role="form" method="POST" action="{{ url('/loginmobile') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="panel-heading">
								<img style="display: block; margin-left: auto; margin-right: auto" width="50%" src="{{ secure_url('img/logo.png') }}"/>      
							</div>
							<div class="panel-heading" style="text-align: center">
								<span style="font-size: large !important; font-weight: 500">Masuk ke Akun</span>
							</div>
							<div class="login-page">
								{{--<div class="form-group" style='margin-left: 0;margin-right: 0px;'>--}}
								{{--<label class="control-label" for="inputNormal">Username</label>--}}
								{{--<input type="text" id="email" name="email" class="form-control flat" id="inputNormal"/>--}}
								{{--</div>--}}

								{{--<div class="form-group" style='margin-left: 0;margin-right: 0px;'>--}}
								{{--<label class="control-label" for="inputNormal">Password</label>--}}
								{{--<input  type="password" name="password" id="password" class="form-control flat" id="inputNormal"/>--}}
								{{--</div>--}}
								<input type="text" style="" id="email" name="email" placeholder="Email" required="">
								{{--<input type="password" style="width: 280px;" name="password" id="password" placeholder="password">--}}

								<input style=""type="password" name="password" id="password" placeholder="Password">
								{{--<button id="btn_login" class='btn btn-primary flat' value="Login" style='height: 100%; width: 283px; margin-top: 10px;'>MASUK</button>--}}

								{{--<input type="button" id="btn_login" class='btn btn-primary flat' style='height: 100%; margin-top: 10px;' value="MASUK">--}}
								<button style='margin-top: 10px;' type="submit" class="btn btn-primary flat">
									<i style='color:white;'></i>
									Masuk
								</button>
								<a href="{{ url('/password/email') }}" class="btn btn-danger flat" style='height: 100%; margin-top: 10px;'>Lupa Kata Sandi ?</a>
								<p class="message">Belum punya akun? <a href="{{ url('/register') }}">Daftar disini</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection     