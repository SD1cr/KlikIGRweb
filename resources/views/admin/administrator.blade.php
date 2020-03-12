@extends('appadmin')
@section('content')

<style>

.container{
	width: 400px;
	height: 200px;
	position: absolute;
	top: 35%;
	left: 50%;
	margin-top: -140px;
	margin-left: -200px;
	padding:40px;
	display: table;
}
.coba{
	display: table-cell;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius:5px;
  box-shadow: rgba(0,0,0,50) 0 0 60px;

  opacity: 0.9;
  filter: alpha(opacity=50); /* For IE8 and earlier */
}

.input-group-addon
{
    background-color: rgb(50, 118, 177);
    border-color: rgb(40, 94, 142);
    color: rgb(255, 255, 255);
}

.form-signup input[type="text"],.form-signup input[type="password"] { border: 1px solid rgb(50, 118, 177); }
.fullscreen_bg {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-size: cover;
    background-position: 50% 50%;
    background-repeat:repeat;
  }

</style>

<div class="container">                      
  <div class="coba" style="background:#FFFFFF;width:300px;height:350px;" style="text-align:center;">
    <div class="" style="text-align: center;margin-top:25px;">
      <img src="{{secure_url('img/logo.png')}}" alt="">
    </div>
      <div style="text-align: center;">
          <p>Content Management System</p>
      </div>
	@if (session('err'))
          <div class="col-md-12 igr-flat" style="margin-top:10px;">
              <div class="alert alert-danger igr-flat">
                  <strong>{{session('err')}}</strong>
              </div>
          </div>
      @endif
    <br>
    <div style="margin-top:0px;margin-left:10px;margin-right:10px;">
      <form class="" action="login_admin" method="post">
        <div class="input-group" style="margin-bottom:10px;">
          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input type="text" class="form-control" name="email" id="txt_email_admin" placeholder="Email" required>
        </div>
        <div class="input-group" style="margin-bottom:10px;">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input type="password" class="form-control" name="password" id="txt_pass_admin" placeholder="password" required>
          <span class="highlight"></span>
        </div>
        <button type="submit" class="btn btn-primary flat" style="width:300px;">Login</button>    
      </form>
    </div>
	       
  </div>
</div>

@endsection

@section('scripts')
@endsection
