@extends('registerapp')
@section('content')
    <style>
        .div-title {
            margin-top: 20px;
        }
        .product-grid {
            padding-left: 0px;
            padding-right: 0px;
            margin-bottom: 10px;
            border-width:0px;
            border-style:solid;
            border-color: #9e9e9e;
        }

        .recproduct-grid {
            padding-left: 0px;
            padding-right: 0px;
            margin-bottom: 10px;
            border-width:1px;
            border-style:solid;
            border-color: whitesmoke;
        }
        .product-grid:hover{
            border: 1px solid #9e9e9e;
        }
        .product-grid > .imgbox {
            padding: 10px;
        }
        .product-grid > .imgbox:hover {
            padding: 5px;
        }
        .col-xs-15,
        .col-sm-15,
        .col-md-15,
        .col-lg-15 {
            position: relative;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }

        .col-xs-15 {
            width: 20%;
            float: left;
        }
        @media (min-width: 768px) {
            .col-sm-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 992px) {
            .col-md-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 1200px) {
            .col-lg-15 {
                width: 20%;
                float: left;
            }
        }

    </style>
    <div class="container" style="margin-top: 75px;">

        <div class="row">
            <div class="col-sm-2" style="min-height: 0px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
                    <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;margin-bottom: 10px;">
                    <span>Harga : &nbsp;</span>
                    <div style="margin-top: 10px; ">
                        <input style='width:75px;' id="inputmin" value="<?php if(!empty($_GET['min'])){echo $_GET['min'];} ?>" type="number"  min="1"/> -
                        <input style='width:75px;' id="inputmax" value="<?php if(!empty($_GET['max'])){echo $_GET['max'];} ?>" type="number"  min="1"/>
                        <a class='btn btn-default flat' onclick='PriceFilterContract()' style='margin-top: 10px;float: right; height: 50%'><i class=""></i>Filter</a>
                    </div>
                    </div>
                <hr style='margin-top: 5px;margin-bottom: 5px;'/>
           </div>
            <div class="col-sm-10" style="min-height: 4px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
                <div style="background-color: #FFFFFF; min-height: 0px; margin-bottom: 10px;">
                    <div class="form-group">
                        <ol class="breadcrumb">
                                <li class="breadcrumb-item active"><a style='color: #337AB7;'>Produk Kontrak</a></li>
                        </ol>
                    </div>
                    <form method="get" id="searchForm"  style="margin-top:5px">
                        <div class="col-sm-12" style="padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: whitesmoke"><span>Tampilkan &nbsp;</span>
                            <select style="color: #0000C2; border-radius: 0px;" class="selectpicker" data-width="20%" id="ordSelect" name="ord" onChange= "changeOrd()">
                                <option style="font-size: 12px;" value="25" @if(isset($_GET['ord'])) @if($_GET['ord'] == "25") {{ 'selected' }} @endif @else {{ 'selected' }} @endif>25 Item/Hal</option>
                                <option style="font-size: 12px;" value="50" @if(isset($_GET['ord'])) @if($_GET['ord'] == "50") {{ 'selected' }} @endif @endif>50 Item/Hal</option>
                                <option style="font-size: 12px;" value="100" @if(isset($_GET['ord'])) @if($_GET['ord'] == "100") {{ 'selected' }} @endif @endif>100 Item/Hal</option>
                            </select>
                        </div>
                    </form>    
                </div>
                <?php
                $sindex = 0;
                if(isset($_GET['PROD'])){
                    if($_GET['PROD'] != "" && $_GET['PROD'] != null){
                        $rpp = $_GET['PROD'];
                    }else{
                        $rpp = 10;
                    }
                }else{
                    $rpp = 10;
                }
                ?>
                @foreach($ProdContractArray as $index => $row)
                    <div class="col-md-15 col-sm-3">
                        <a href="{{ url('detail/'.$row->prdcd) }}" style="display:block">
                            <div class="product-grid" style="margin-bottom: 0px;background-color: white;">
                                @if($row['url_pic_prod'] != null) 
                                    <div>
                                        <img style='padding:10%;' src="{{ $row['url_pic_prod'] }}" class="img-responsive imgbox" height="100%">  
                                    </div>
                                    @else
                                    <div>
                                        <img style='padding:10%;' src="{{ url('../resources/assets/img/noimage.png') }}" class="img-responsive imgbox" height="100%">      
                                    </div>
                                @endif

                                <div class="producttitle" style="font-size: small !important; color: black !important;min-height: 100px; text-align: center; padding-left: 10px; padding-right: 10px">{{ ucwords(strtolower($row['long_description'])) }}</div>

                                <div class="productprice" style="min-height: 70px;">
                                    <div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ;font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Harga : Rp. {{ number_format($row['price'], 0, ',', '.') }}<span>/ {{ $row['unit'] }}</span><br/><span>(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
                                </div>
                            </div>
                        </a>
                        <div data-id="{{$row['prdcd']}}" class="productdialog" style="text-align:center; margin-bottom: 10px;margin-top: 0px; border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white" >
                            <a href="#" class="btn btn-default flat" data-target="#" data-href="#" style="display: block"><i class='fa fa-shopping-cart'></i>&nbsp; BELI</a>
                        </div>
                    </div>
                @endforeach
                <div class='col-xs-12' style="text-align: center">
                    {!! str_replace('/?', '?', $ProdContractArray->appends(Input::except('page'))->render()) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection