@extends('app')
@section('content')
    <style>
        .div-title {
            margin-top: 20px;
        }
        .product-grid {
            padding-left: 0px;
            padding-right: 0px;
            margin-bottom: 10px;
            border-width:1px;
            border-style:solid;
            border-color: #9e9e9e;
        }
        .product-grid:hover{
            border: 3px solid #9e9e9e;
        }
        .product-grid > .imgbox {
            padding: 10px;
        }
        .product-grid > .imgbox:hover {
            padding: 5px;
        }

    </style>
    <div class="container" style="margin-top: 95px;">
        <div class="row">
            {!! $detailproduct !!}
        </div>
    </div>


@endsection
@section('scripts')
@endsection