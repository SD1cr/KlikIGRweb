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

        <div class="row" style="margin-top: 50px;">
            <div class="hidden-xs col-sm-2 col-lg-2" style="min-height: 0px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
                    <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;margin-bottom: 10px;">
                        <span>Brand &nbsp;</span>
                        <input style="margin-top: 10px;margin-bottom: 10px;" id="filter" type="text" class="form-control" placeholder="Type here...">
                        <div  style="max-height: 300px; overflow-y: scroll;">
                            <form method="get" id="filterForm"  style="margin-top:5px">
                            <table class="table table-responsive">
                                <tbody class="searchable">
                                {{--@if ($brow['BRG_MERK'] != "") checked @endif--}}
                                @foreach($brgMerkArray as $index => $brow)
                                    <tr>
                                        <td style="margin-bottom: 0px;">
                                            <div class="checkbox" style="margin-bottom: 0px;margin-top:0px;">
                                                <label><input type='checkbox' name='brand' class='brand' onclick='PriceFilter()' value="{{$brow['brg_merk']}}" {{ (in_array($brow->brg_merk, $brand))? 'checked' : '' }}  />{{ ucwords(strtolower($brow['brg_merk'])) }}</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            </form>
                        </div>
                        <hr style='margin-top: 5px;margin-bottom: 5px;'/>

                    <span>Harga : &nbsp;</span>
                    <div style="margin-top: 10px; ">
                        <input style='width:75px;' placeholder="Rp." id="inputmin" value="<?php if(!empty($_GET['min'])){echo $_GET['min'];} ?>" type="number"  min="1"/> -
                        <input style='width:75px;'  placeholder="Rp." id="inputmax" value="<?php if(!empty($_GET['max'])){echo $_GET['max'];} ?>" type="number"  min="1"/>
                        <a class='btn btn-default flat' onclick='PriceFilter()' style='margin-top: 10px;float: right; height: 50%'><i class=""></i>Filter</a>
                    </div>
                </div>
                <hr style='margin-top: 5px;margin-bottom: 5px;'/>
           </div>
            <div class="col-sm-10" style="min-height: 4px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
                <div style="background-color: #FFFFFF; min-height: 0px; margin-bottom: 10px;">
                    <div class="form-group">
                        <ol class="breadcrumb">
                            @if(\Request::is('list/*/*/*'))
                                <li class="breadcrumb-item"><a href="{{url('list/' . \Request::segment(2))}}">{{ucfirst(strtolower(App\Models\Divisi::getDivNama(Request::segment(2))))}}</a></li>
                                <li class="breadcrumb-item"><a href="{{url('list/' . \Request::segment(2) . '/' . \Request::segment(3))}}">{{ucfirst(strtolower(App\Models\Department::getDepNama(Request::segment(2), Request::segment(3))))}}</a></li>
                                <li class="breadcrumb-item active"><a style='color: #337AB7;' href="{{url('list/' . \Request::segment(2) . '/' . \Request::segment(3) . '/' . \Request::segment(4))}}">{{ucfirst(strtolower(App\Models\Category::getKatName(Request::segment(3), Request::segment(4))))}}</a></li>
                            @elseif(\Request::is('list/*/*'))
                                <li class="breadcrumb-item"><a href="{{url('list/' . \Request::segment(2))}}">{{ucfirst(strtolower(App\Models\Divisi::getDivNama(Request::segment(2))))}}</a></li>
                                <li class="breadcrumb-item active"><a style='color: #337AB7;' href="{{url('list/' . \Request::segment(2) . '/' . \Request::segment(3))}}">{{ucfirst(strtolower(App\Models\Department::getDepNama(Request::segment(2), Request::segment(3))))}}</a></li>
                            @else(\Request::is('list/*'))
                                <li class="breadcrumb-item active"><a style='color: #337AB7;' href="{{url('list/' . \Request::segment(2))}}">{{ucfirst(strtolower(App\Models\Divisi::getDivNama(Request::segment(2))))}}</a></li>
                            @endif
                        </ol>
                    </div>
                    <form method="get" id="searchForm"  style="margin-top:5px">
                        <div class="col-sm-6" style="padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: whitesmoke"><span>Tampilkan &nbsp;</span>
                            <select style="color: #0000C2; border-radius: 0px;" class="selectpicker" data-width="50%" id="ord" name="ord" onChange= "PriceFilter()">
                                <option style="font-size: 12px;" value="25" @if(isset($_GET['ord'])) @if($_GET['ord'] == "25") {{ 'selected' }} @endif @else {{ 'selected' }} @endif>25 Item/Hal</option>
                                <option style="font-size: 12px;" value="50" @if(isset($_GET['ord'])) @if($_GET['ord'] == "50") {{ 'selected' }} @endif @endif>50 Item/Hal</option>
                                <option style="font-size: 12px;" value="100" @if(isset($_GET['ord'])) @if($_GET['ord'] == "100") {{ 'selected' }} @endif @endif>100 Item/Hal</option>
                            </select>
                        </div>
                    </form>

                    <div class="col-sm-6" style="padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: whitesmoke"><span>Urutan &nbsp;</span>
                        <select style="color: #0000C2; border-radius: 0px;" class="selectpicker" data-width="50%" id="sort" name="sort" onChange="PriceFilter()">
                            <option style="font-size: 12px;" value="%" @if(isset($_GET['sort'])) @if($_GET['sort'] == "%") {{ 'selected' }} @endif @else {{ 'selected' }} @endif>Semua </option>
                            <option style="font-size: 12px;" value="asc" @if(isset($_GET['sort'])) @if($_GET['sort'] == "asc") {{ 'selected' }} @endif @endif>Harga Termurah</option>
                            <option style="font-size: 12px;" value="desc" @if(isset($_GET['sort'])) @if($_GET['sort'] == "desc") {{ 'selected' }} @endif @endif>Harga Termahal</option>    
                        </select>
                    </div>

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
                @foreach($ProdArray as $index => $row)
                    <div class="col-xs-6 col-md-3 col-md-15 col-sm-3">    
                        <a href="{{ url('detail/'.$row->prdcd) }}" style="display:block">
                            <div class="product-grid" style="margin-bottom: 0px;background-color: white;">
                                @if($row['url_pic_prod'] != null)
                                    <div>
                                        <img style='padding:10%;' src="{{ $row['url_pic_prod'] }}" class="img-responsive imgbox" height="100%">
                                    </div>

                                    @elseif($row['kode_tag'] == 'N')
                                    <div>
                                        <img style='padding:10%;' src="{{ url('../resources/assets/img/nocart.png') }}" class="img-responsive imgbox" height="100%">
                                    </div>
                                    @else
                                    <div>
                                        <img style='padding:10%;' src="{{ url('../resources/assets/img/noimage.png') }}" class="img-responsive imgbox" height="100%">
                                    </div>

                                @endif

                                <div class="producttitle" style="font-size: small !important; color: black !important;min-height: 80px; text-align: center; padding-left: 10px; padding-right: 10px">{{ ucwords(strtolower($row['long_description'])) }}</div>
                                    @if($typeid == 1)
                                        <div class="productprice" style="min-height: 90px;">
                                            <div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ;font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Harga : Rp. {{ $row['price']!=null ? number_format($row['price'], 0, ',', '.') : number_format($row['hrg_jual'], 0, ',', '.') }}<span>/ {{ $row['unit'] }}</span><br/><span>(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
                                        </div>
                                    @elseif($typeid == 3)
                                            @if($row['flagpromomd'] ==1 && $row['hrg_jual'] != $row['prmd_hrgjual'])
                                            <div class="productprice" style="min-height: 90px;">
                                                <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" ><i style='text-decoration: line-through;'>Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}</i><br/><span style="color: rgb(247, 147, 30); font-weight: 600">Rp. {{ number_format($row['prmd_hrgjual'], 0, ',', '.') }}</span><span style="color: #F7931E; font-weight: 600">/ {{ $row['unit'] }}</span><br/><span style="color: #F7931E; font-weight: 600">(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
                                            </div>
                                            @else
                                            <div class="productprice" style="min-height: 90px;">
                                                <div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}<span>/ {{ $row['unit'] }}</span><br/><span>(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
                                            </div>
                                            @endif
                                    @elseif($typeid == 2)
                                        @if($row['PRICE_FLAGPROMOCB'] == 1 && $row['flagpromomd'] == 1)
                                            <div class="productprice" style="min-height: 90px;">
                                                <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" ><i style='text-decoration: line-through;'>Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}</i><br/><span style="color: rgb(247, 147, 30); font-weight: 600">Rp. {{ number_format(($row['prmd_hrgjual']-$row['PRICE_TOTALPOTMAX']),0,",",".") }}</span><span style="color: #F7931E; font-weight: 600">/ {{ $row['unit'] }}</span><br/><span style="color: #F7931E; font-weight: 600">(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
                                            </div>
                                        @elseif($row['flagpromomd'] == 1)
                                            <div class="productprice" style="min-height: 90px;">
                                                <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" ><i style='text-decoration: line-through;'>Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}</i><br/><span style="color: rgb(247, 147, 30); font-weight: 600">Rp. {{ number_format($row['prmd_hrgjual'], 0, ',', '.') }}</span><span style="color: #F7931E; font-weight: 600">/ {{ $row['unit'] }}</span><br/><span style="color: #F7931E; font-weight: 600">(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
                                            </div>
                                        @elseif($row['PRICE_FLAGPROMOCB'] == 1)
                                            <div class="productprice" style="min-height: 90px;">
                                                <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" ><i style='text-decoration: line-through;'>Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}</i><br/><span style="color: rgb(247, 147, 30); font-weight: 600">Rp. {{ number_format(($row['hrg_jual']-$row['PRICE_TOTALPOTMAX']),0,",",".") }}</span><span style="color: #F7931E; font-weight: 600">/ {{ $row['unit'] }}</span><br/><span style="color: #F7931E; font-weight: 600">(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
                                            </div>
                                        @else
                                            <div class="productprice" style="min-height: 90px;">
                                            <div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}<span>/ {{ $row['unit'] }}</span><br/><span>(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
                                            </div>
                                        @endif  
                                    @endif
                                {{--@if($typeid == 1)--}}
                                    {{--<div class="productprice">--}}
                                        {{--<div class="pricetext" style="font-size: 12px !important; text-align: left; color: cornflowerblue; font-weight: bold; padding-left: 10px; padding-right: 10px">Harga Kontrak : -</div>--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                            </div>
                        </a>
                        <div data-id="{{$row['prdcd']}}" class="productdialog" style="text-align:center; margin-bottom: 10px;margin-top: 0px; border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white" >
                            <a href="#" class="btn btn-default flat" data-target="#" data-href="#" style="display: block"><i class='fa fa-shopping-cart'></i>&nbsp; BELI</a>
                        </div>
                    </div>
                @endforeach
                <div class='col-xs-12' style="text-align: center">
                    {!! str_replace('/?', '?', $ProdArray->appends(Input::except('page'))->render()) !!}
                </div>

                @if(count($RecProdArray) > 0)
                <div class="hidden-xs col-sm-12" style="min-height: 0px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14); margin-bottom: 20px;">
                    <div class="hidden-xs col-sm-12" style="padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: gainsboro;font-weight: bold;font-family: 'Roboto Condensed', sans-serif !important;font-size: large"><span>Produk Terpopuler &nbsp;</span></div>
                    <div class="hidden-xs col-sm-6 col-md-5 owl-carousel1" style='width: 100%;padding-left: 0px; padding-right: 0px; max-height: 100%;'>    
                        @foreach($RecProdArray as $index => $row)
                            {{--<div>--}}
                            <a href="{{ url('detail/'.$row->prdcd) }}" style="display:block">
                                <div class="product-grid" style="margin-bottom: 0px;background-color: white;">
                                    @if($row['url_pic_prod'] != null)
                                        <div>
                                            <img style='padding:10%;' src="{{ $row['url_pic_prod'] }}" class="img-responsive imgbox" height="100%">
                                        </div>
                                        {{--@if($typeid == 1)--}}
                                            {{--<div>--}}
                                                {{--<img style='padding:10%;' src={{ $row['url_pic_prod'] }} class="img-responsive imgbox" height="100%">--}}
                                            {{--</div>--}}
                                        {{--@elseif($typeid == 3 || $typeid == 2)--}}
                                            {{--@if($row['flagpromomd'] ==1 && $row['hrg_jual'] != $row['prmd_hrgjual'])--}}
                                                {{--<div>--}}
                                                    {{--<img style='padding-right:30px;position: absolute; z-index: 9;' src="{{ url('../resources/assets/img/promo.png') }}" class="img-responsive imgbox" height="100%"><img style='padding:15px;position: relative;float: left' src={{ $row['url_pic_prod'] }} class="img-responsive imgbox" height="100%">--}}
                                                {{--</div>--}}
                                            {{--@else--}}
                                                {{--<div>--}}
                                                    {{--<img style='padding:10%;' src={{ $row['url_pic_prod'] }} class="img-responsive imgbox" height="100%">--}}
                                                {{--</div>--}}
                                            {{--@endif--}}
                                        {{--@endif--}}
                                    @else
                                        <div>
                                            <img style='padding:10%;' src="{{ url('../resources/assets/img/noimage.png') }}" class="img-responsive imgbox" height="100%">
                                        </div>
                                        {{--@if($typeid == 1)--}}
                                            {{--<div>--}}
                                                {{--<img style='padding:10%;' src="{{ url('../resources/assets/img/noimage.png') }}" class="img-responsive imgbox" height="100%">--}}
                                            {{--</div>--}}
                                        {{--@elseif($typeid == 3 || $typeid == 2)--}}
                                            {{--@if($row['flagpromomd'] ==1 && $row['hrg_jual'] != $row['prmd_hrgjual'])--}}
                                                {{--<div>--}}
                                                    {{--<img style='padding-right:30px;position: absolute; z-index: 9;' src="{{ url('../resources/assets/img/promo.png') }}" class="img-responsive imgbox" height="100%"><img style='padding:15px;position: relative;float: left' src="{{ url('../resources/assets/img/noimage.png') }}" class="img-responsive imgbox" height="100%">--}}
                                                {{--</div>--}}
                                            {{--@else--}}
                                                {{--<div>--}}
                                                    {{--<img style='padding:10%;' src="{{ url('../resources/assets/img/noimage.png') }}" class="img-responsive imgbox" height="100%">--}}
                                                {{--</div>--}}
                                            {{--@endif--}}
                                        {{--@endif--}}
                                    @endif

                                    <div class="producttitle" style="font-size: small !important; color: black !important;min-height: 58px; text-align: center; padding-left: 10px; padding-right: 10px">{{ ucwords(strtolower($row['long_description'])) }}</div>
                                    @if($typeid == 1)
                                        <div class="productprice" style="min-height: 50px;">
                                            <div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ;font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Harga : Rp. {{ $row['price']!=null ? number_format($row['price'], 0, ',', '.') : number_format($row['hrg_jual'], 0, ',', '.') }}</div>
                                        </div>
                                    @elseif($typeid == 3 || $typeid == 2)
                                        @if($row['flagpromomd'] ==1 && $row['hrg_jual'] != $row['prmd_hrgjual'])
                                            <div class="productprice" style="min-height: 50px;">
                                                <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" ><i style='text-decoration: line-through;'>Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}</i><br/><span style="color: rgb(247, 147, 30); font-weight: 600">Rp. {{ number_format($row['prmd_hrgjual'], 0, ',', '.') }}</span></div>
                                            </div>
                                        @else
                                            <div class="productprice" style="min-height: 50px;">
                                                <div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Harga : Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}</div>
                                            </div>
                                        @endif
                                    @endif
                                    {{--@if($typeid == 1)--}}
                                    {{--<div class="productprice">--}}
                                    {{--<div class="pricetext" style="font-size: 12px !important; text-align: left; color: cornflowerblue; font-weight: bold; padding-left: 10px; padding-right: 10px">Harga Kontrak : -</div>--}}
                                    {{--</div>--}}
                                    {{--@endif--}}
                                </div>
                            </a>
                            {{--<div data-id="{{$row['PRD_PRDCD']}}" class="productdialog" style="text-align:center; margin-bottom: 10px;margin-top: 0px; border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white" >--}}
                            {{--<a href="#" class="btn btn-default flat" data-target="#" data-href="#" style="height: 100%; width: 183px"><i class='fa fa-shopping-cart'></i>&nbsp; BELI</a>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        @endforeach
                    </div>
                </div>
                @endif

                @if(count($ProdArray) < 1)
                    <div class='col-md-10 col-md-offset-5' style="padding-top: 20px;">
                        <img class='col-lg-2' style='float: left' width='100px' src='{{ url('../resources/assets/img/alert.png') }}'></div>
                    <div class='col-md-12 col-md-offset-0' style='margin-top: 10px; margin-bottom: 10px; text-align: center;'>
                        <h2 style='margin-bottom: 10px;'>Maaf, barang belum tersedia di KlikIndogrosir</h2>
                        <h2 style='margin-bottom: 10px; margin-top: 10px;'>Silakan belanja kembali</h2> 
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.owl-carousel1').owlCarousel({
                autoPlay : 5000,
                stopOnHover : false,
                items:5,
                navigation:true,
                navigationText: [
                    "<i class='fa fa-chevron-left'></i>",
                    "<i class='fa fa-chevron-right'></i>"
                ],
            });

            (function ($) {
                $('#filter').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable tr').hide();
                    $('.searchable tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                });
            }(jQuery));
        });

//        $(function() {
//            $(".brand").on("change", function() {
//                var x = $(".brand:checked").map(function() {
//                    return this.value;
//                }).toArray();
//                x = x.join(",");
//                window.location.href = window.location.href.replace( /[\?#].*|$/, "?brand=" + x );
//            });
//        });


        $( document ).ready(function() {
            cartReload();
        });
    </script>
@endsection