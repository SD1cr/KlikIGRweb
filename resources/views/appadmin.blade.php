<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Admin Klikindogrosir</title>

    <link rel="stylesheet" type="text/css" href="{{ secure_url('css/font.css')}}" />
    <link rel='stylesheet' href="{{ secure_url('css/font.css')}}" type='text/css' />
    <link href="{{ secure_url('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ secure_url('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-select.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-editable.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/igr.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/profil.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/sidebar.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/tabs.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/reorder.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/owl.carousel.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/owl.theme.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/smart_wizard.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/smart_wizard_theme_dots.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/smart_wizard_theme_arrows.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/smart_wizard_theme_circles.min.css') }}" rel="stylesheet"/>
    <link href="{{secure_url('css/select2.min.css')}}" rel="stylesheet">
    <link href="{{secure_url('css/overlay-bootstrap.css')}}" rel="stylesheet">
    <link href="{{secure_url('css/overlay-bootstrap.min.css')}}" rel="stylesheet">
    {{--<link href="{{ secure_url('css/category.css')}}" rel="stylesheet" >--}}
    {{--<link href="{{ secure_url('css/style2.css')}}" rel="stylesheet" > <!-- CSS reset -->--}}

    <style>
    body{
      background: url('img/retail2.jpg') no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
    </style>
</head>
<body class="body">
@yield('content')

<script type="text/javascript">
    var getProductDialogURL = '{{ url('getproductdialog') }}';
    var getCartDialogURL = '{{ url('getcartdialog') }}';
    var addCartURL = '{{ url('addcart') }}';
    var reloadCartURL = '{{ url('reloadcart') }}';
    var deleteCartURL = '{{ url('deletecart') }}';
    var updateCartURL = '{{ url('updatecart') }}';
    var getLoginMemberDialogURL = '{{ url('getlogindialog') }}';
    var getValidLoginUrl = '{{ url('loginajax') }}';
    var reloadLoginURL = '{{ url('reloadlogin') }}';
    var getOptionAddressDialogURL = '{{ url('getaddressdialog') }}';
    var getHistoryDialogURL = '{{ url('gethistorydialog') }}';

</script>
<script src="{{ secure_url('js/jquery-1.9.1.js') }}"></script>
<script src="{{ secure_url('js/bootstrap.min.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ secure_url('js/owl.carousel.min.js') }}"></script>
<script src="{{ secure_url('js/accounting.min.js') }}"></script>
<script src="{{ secure_url('js/jquery.smartWizard.min.js') }}"></script>

<script src="{{ secure_url('js/product.js') }}"></script>
<script src="{{ secure_url('js/cart.js') }}"></script>
<script src="{{ secure_url('js/history.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ secure_url('js/bukuAlamat.js') }}"></script>

<script src="{{ secure_url('js/login.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-editable.min.js') }}"></script>
<script src="{{secure_url('js/select2.min.js')}}"></script>
<script src="{{secure_url('js/bootstrap-number-input.js')}}"></script>


<script type="text/javascript" type="text/javascript">
    $(function () {
        @if(Request::is('bukualamat'))
            REinit();
        @endif
    });
</script>

@yield('scripts')

<style>
  *{
      font-size: 14px !important;
  }
</style>

<style type="text/css">

</style>

</body>
</html>
