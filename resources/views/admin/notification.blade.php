@extends('cms1')

@section('content')
	<div class="container" style="margin-top: 60px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-file-image-o"></i>
						Push Notification
					</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/notification') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
			                <div class="input-group inputs" style="min-height: 60px">
			                	<span class="input-group-addon" style="min-width: 142px">Message</span>
			                	<input type="text" name="message" class="input-sm form-control" style="min-height: 60px">
			                </div>
			                <div class="text-center" style="margin-top: 20px">
									<button type="submit" class="btn btn-primary">
										Send
									</button>
			                </div>
						</form>
					</div>
				</div>
				
			</div>
		</div>	
	</div>
@endsection