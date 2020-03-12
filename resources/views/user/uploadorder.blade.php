@extends('app')
@section('content')

    <div class="container" style="margin-top: 75px;">
        <div class="row">

            {!! $sidebar !!}

            <div class="col-md-9">
                <div class="panel panel-default flat">
                    {{--<div class="panel-heading igr-flat"><i style='font-size: larger;' class='fa fa-list'></i>&nbsp; Upload File Order</div>--}}
                    <div class="bs-callout bs-callout-danger" style="margin-top: 0px;">
                        <h4 style="font-size: 30px !important;"><i style='color:#D9534F; font-size: xx-large !important;' class='fa fa-list'></i>&nbsp; Import File</h4>            
                    </div>
                    <div class="panel-body">
                        @if($errors->has('image'))
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                {{ $errors->first('image',':message') }}
                                <span class="close kv-error-close error-close">×</span>
                            </div>
                        @endif
                        @if(Session::has('error_message'))
                            <div class="alert alert-danger">
                                <strong>Warning!</strong> {!!  Session::get('error_message')  !!} <br/>
                                <span class="close kv-error-close error-close">×</span>
                            </div>
                        @elseif (Session::has('success_message'))
                            <div class="alert alert-info">
                                <strong>Success!</strong> {!!  Session::get('success_message')  !!} <br/>
                                <span class="close kv-error-close error-close">×</span>
                            </div>
                        @endif
                        @if (session('err'))
                            <div class="col-md-12 igr-flat" style="margin-top:10px;">
                                <div class="alert alert-danger igr-flat">
                                    <strong>{{session('err')}}</strong>
                                </div> 
                            </div>
                        @endif
                        @if (isset($err))
                            <div class="col-md-12 igr-flat" style="margin-top:10px;">
                                <div class="alert alert-danger igr-flat">
                                    <strong>{{$err}}</strong>
                                </div>
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ url('addcartcsv') }}">
                            <div style="margin-bottom: 10px;"><span style="font-size: large !important;">Import File From</span></div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <div>
                                <input id="inputv" name="import_file" type="file" multiple class="file-loading igr-flat">
                            </div>
                        </form>
                        <div class="form-group" style="margin-top: 10px;">  
                            <span>
                            Gunakan Fitur ini apabila anda ingin membeli dengan jumlah banyak tanpa harus membeli satu persatu, gunakan format order seperti contoh dibawah ini untuk proses pembelian.<br />
                            <a style="text-decoration: underline" download="contoh_form_order.csv" href="{{ ('contents/contoh_form_order.csv') }}">Download Contoh Order Form File CSV</a>
                            </span><br><br>
							Catatan: tipe file .csv

						</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(function() {
            //Initialize Fileinput
            $("#inputv").fileinput({
                maxFileCount: 1,
                allowedFileExtensions: ["xls", "xlsx", "csv"]
            });
        });
    </script>
@endsection