@extends('app')
@section('content')
    <style>
        .product-grid {
            padding-left: 0px;
            padding-right: 0px;
            margin-top: 0px;
            margin-bottom: 0px;
            border-width:1px;
            border-style:solid;
            border-color: #9e9e9e;
            border-left-width: 0px;
            border-top-width: 0px;
            background-color: white;
        }

        .product-detail {
            padding-left: 0px;
            padding-right: 0px;
            margin-top: 0px;
            margin-bottom: 0px;
            border-width:0px;
            border-style:solid;
            border-color: whitesmoke;
            border-left-width: 0px;
            border-top-width: 0px;
            background-color: white;
        }
        .img:hover{
            position: relative;
            right: -3px;
        }

        .item img{
            max-width: 100%;
            -moz-transition: all 0.5s;
            -webkit-transition: all 0.5s;
            transition: all 0.5s;
        }

        .item {
            position: relative;
            border: 0px solid #333;
            overflow: hidden;
        }

        .img_banner_kanan:hover{
            -moz-transform: scale(1.1);
            -webkit-transform: scale(0,1.0,1);
            transform: scale(0,1.0,1);
        }

        .linkHover:hover {
            font-size: 16px !important;
            font-weight: 700;
        }
        #index1_banner, #index2_banner
        {
            position: relative;
        }
        #index1_banner{
            z-index: 1;
        }

        #index2_banner{
            z-index: 2;
        }

        .img_elevator:hover {
          background-color: #E6E6E6;
        }

        #product1, #product2 {
            position: relative;
        }

        #product1{
            z-index: 1;
        }

        #product2{
            z-index: 2;
        }

        dd {
            display: block;
            margin-left: 40px;
        }

        .slick-center {
            -webkit-transform: scale(1.25);
            -moz-transform: scale(1.25);
            transform: scale(1.25);
            /*padding-left: 30px;*/
            /*padding-right: 30px;*/
        }

        .slick-list {
            padding:45px 60px !important;
            margin-left:20px !important;
        }

        .slick-slide {
            padding-left: 30px;
            padding-right: 30px;
        }

        /*.slick-current {*/
            /*opacity: 1;*/
        /*}*/
        #example-four {
            border-radius: 5px 20px 5px;
            background: #BADA55;
        }

        .slick-next{
            position: absolute;
            z-index: 1000;
            top: 50%;
            right: 0 !important;
            color: #BFAFB2;
        }
        .slick-prev{
            position: absolute;
            z-index: 1000;
            top: 50%;
            left: 0;
            color: #BFAFB2;
        }

        .slick-prev:before,
        .slick-next:before {
            color: #BFAFB2;
            font-size: 40px;
        }

    </style>

    <div class="hidden-xs elevator"  id="product2" style=" background-color:#FFFFFF; position: fixed !important; right: 0; margin-top: 200px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
        <?php
        $seq = 0;
        foreach ($elevator as $key => $value) {
        $seq++;
        ?>
        <table>
            <tr class="panel-body">
                <td style="width:40px;height:40px;">
                    <a href="#<?php echo $seq;  ?>" class="a<?php echo $value->id ?>">
                        <img class='img_elevator'style='padding:10%;height:40px;width:40px;'  src='https://www.klikindogrosir.com/public/image/{!! $value->icon !!}'>
                    </a>
                    <div class="panel-danger-overlay-right" style="height:40px;background-color:<?php echo $value->color;  ?>;width: 150px;color:#FFFFFF;" align="center">
                        <a href="#<?php echo $seq;  ?>" class="a<?php echo $value->id ?>">
                            <p style="color:#FFFFFF;text-align:center;padding-top:5px;height:40px;"><?php echo $value->name; ?></p>
                        </a>
                    </div>
                </td>
            </tr>
        </table>
        <?php } ?>
    </div>

    {!! $BannerMobile !!}

    <div class="visible-xs container" style="margin-top: 80px;">
    <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 0px 0px 0 rgba(0, 0, 0, 0.19);padding-left: 0px;padding-right: 0px;" class="col-xs-12">
        <div class="panel-heading" style="margin-top: 0px;background-color: #ffffff;"><a style="font-weight: bold">Kategori Pilihan</a>
        </div>
        @foreach($categoryicon as $index => $crow)
            <div style="text-align: center;padding-top: 10px;" class="product-detail col-xs-3">
                <div class="productprice" style="min-height: 60px;">
                    <a href="https://klikigrsim.mitraindogrosir.co.id/list/{{$crow['id']}}">
                        <img style="max-height: 60px; max-width: 60px;padding-top: 5px;padding-bottom: 5px;padding-right: 5px;padding-left: 5px;" src="https://klikigrsim.mitraindogrosir.co.id/image/{{$crow['images']}}">
                    </a>
                </div>
                <div class="productprice" style="min-height: 80px;">
                    <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-top: 10px; padding-right: 10px; padding-bottom: 10px;" >{{$crow['division']}}</div>
                </div>
            </div>
        @endforeach
    </div>

    {{--<div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 0px 0px 0 rgba(0, 0, 0, 0.19);padding-left: 0px;padding-right: 0px;margin-top: 20px;" class="col-xs-12">--}}
        {{--<div class="panel-heading" style="margin-top: 0px;background-color: #ffffff;"><a style="font-weight: bold">Promo Pilihan</a>--}}
        {{--</div>--}}
        {{--@foreach($sectionheader as $index => $crow)--}}
            {{--<div style="min-height: 50px;">--}}
                {{--<p style="text-align: left; color:black; font-size: large!important;font-weight: bold">{{$crow['name']}}</p>--}}
            {{--</div>--}}
        {{--@endforeach--}}
    {{--</div>--}}
    </div>


    <div class="container" style="margin-top: 75px; " id="product1">
        @if (session('new'))
            <div class="col-md-12">
                <div class="alert alert-info flat">
                    <strong>Selamat ! Akun Anda telah aktif. Silakan pilih dan pesan produk pilihan Anda. Selamat berbelanja !</strong>
                </div>
            </div>
        @endif
        {!! $Banner !!}
            <div class="hidden-xs row">
                <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 0px 0px 0 rgba(0, 0, 0, 0.19);padding-left: 0px;padding-right: 0px;" class="panel panel-default col-md-7">
                    <div class="panel-heading" style="margin-top: 0px;background-color: #ffffff;"><a style="font-weight: bold">Kategori Pilihan</a>
                        {{--<a style="float:right;font-weight: bold;">Lihat Selengkapnya</a>--}}
                    </div>
                    @foreach($categoryicon as $index => $crow)
                    <div style="text-align: center;padding-top: 10px;" class="product-detail col-md-3">
                        <div class="productprice" style="min-height: 60px;">
                            <a href="https://klikigrsim.mitraindogrosir.co.id/list/{{$crow['id']}}">
                                <img style="max-height: 60px; max-width: 60px;padding-top: 5px;padding-bottom: 5px;padding-right: 5px;padding-left: 5px;" src="https://klikigrsim.mitraindogrosir.co.id/image/{{$crow['images']}}">
                            </a>
                        </div>
                        <div class="productprice" style="min-height: 30px;">
                            <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-top: 10px; padding-right: 10px; padding-bottom: 10px;" >{{$crow['division']}}</div>
                        </div>
                        {{--<div class="producttitle" style="font-size: small !important;font-weight: bold ;color: black !important;min-height: 60px; text-align: center; padding-left: 10px; padding-right: 10px">{{$crow['division']}}</div>--}}
                    </div>
                    @endforeach
                </div>

                <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 0px 0px 0 rgba(0, 0, 0, 0.19);;padding-left: 0px;padding-right: 0px;left: 10px;" class="panel panel-default col-md-5">
                    <div class="panel-heading" style="margin-top: 0px;"><a style="font-weight: bold">Brand Pilihan</a>
                    </div>
                    <div class="panel-body" style="padding-top: 20px;padding-bottom: 20px;">
                        <?php
                        $SectionBrandAssocPriority = \App\Models\SectionBrand::getBrandSectionPriority();
                        ?>
                        <div class='col-sm-12' style="padding-right: 0px;padding-left: 0px;padding-top: 0px;">
                            @foreach ($SectionBrandAssocPriority as $index => $BrandRow)
                                    <a href={{ $BrandRow['url'] }} class="col-sm-3" style="text-align: center;padding-left: 0px;padding-right: 0px;display:block;margin-bottom: 40px;"><img src="https://klikigrsim.mitraindogrosir.co.id/image/{{ $BrandRow['image'] }}" style="-webkit-user-select: none;margin: auto;"></a>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>


        <div id="index1_banner" class="row">
            @foreach($sectionheader as $index => $crow)
                <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 0px 0px 0 rgba(0, 0, 0, 0.19);padding-left: 0px;padding-right: 0px;border-radius: 10px" class="panel panel-default col-md-12">
                    {{--<div class="panel-heading" style="margin-top: 0px;background-color: #ffffff;"><a style="font-weight: bold">Kategori Pilihan</a><a style="float:right;font-weight: bold;">Lihat Selengkapnya</a>--}}
                    {{--</div>--}}
                    <div class="panel-body">
                        <div class="col-md-12">

                            <div class="col-md-12">
                                <div class="col-md-3 col-sm-6 thumbnail" style="
                                        border-left-width: 0px;
                                        border-top-width: 0px;
                                        border-right-width: 0px;
                                        border-bottom-width: 0px;margin-bottom: 0px;
                                    ">
                                    <a href="https://klikigrsim.mitraindogrosir.co.id/list/{{$crow['id']}}">
                                        {{--<img style='width: 100%;' src="https://klikigrsim.mitraindogrosir.co.id/image/{{$crow['icon']}}" alt="Lights">--}}
                                        <div style="min-height: 50px;">
                                            <p style="text-align: left; color:black; font-size: large!important;font-weight: bold">{{$crow['name']}}</p>
                                        </div>
                                    </a>
                                </div>

                                <?php
                                $SectionDetailAssoc = \App\Models\SectionDetail::getDetailSection($crow['section_id']);
                                ?>

                                <div class="hidden-xs col-md-9 col-sm-6" style='padding-right: 0px !important;padding-right: 0px;'>
                                    <ul class="nav nav-tabs navbar-right" style="border-bottom-width: 0px;">
                                        @foreach ($SectionDetailAssoc as $index => $DetailRow)
                                            <li style="margin-bottom: 0px;"><a style='border-radius: 0px;margin-right: 0px;border-right-width: 1px;border-right-color: #F07818;border-top-width: 0px;border-left-width: 0px;border-bottom-width: 0px;' href="#tab-{{ $DetailRow->id }}" data-toggle="tab"><span style="color: #F07818;">{{ $DetailRow->name }}</span></a></li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>

                            <?php
                                $SectionBannerAssoc = \App\Models\SectionBanner::getBannerSection($crow['section_id']);
                            ?>

                            <div class='col-md-3' style="padding-left: 0px;padding-right: 0px;">
                            <!-- Carousel
                            ================================================== -->
                                <div class='myCarousel carousel slide'>
                                    <div class='carousel-inner'>
                                        @foreach ($SectionBannerAssoc as $index => $BanRow)
                                        @if($index === 0)
                                                <?php
                                        $tes = "active";
                                                ?>
                                        @else
                                                <?php
                                                $tes = "";
                                                ?>
                                       @endif
                                      <div class='item {{ $tes }}'><a href={{ $BanRow['url'] }}><img style="border-radius: 5px;" src='https://klikigrsim.mitraindogrosir.co.id/image/{{ $BanRow['image'] }}' alt=" . $BanRow->alt_name . "></a></div>
                                        @endforeach
                                    </div>
                                </div><!-- End Carousel -->

                            </div>

                            <div class='hidden-xs col-md-9' style="padding-left: 0px;padding-right: 0px;">

                                    <div class="tab-content well" style='background-color: white; border-style: none; padding-top: 0px;padding-bottom: 0px;padding-left: 0px;padding-right: 0px;margin-bottom: 0px;' >
                                        @foreach ($SectionDetailAssoc as $index => $DetailRow)
                                                <?php
                                                    $SectionItemAssoc = \App\Models\SectionItem::getItemSectionPlu($DetailRow->id);
                                                    $detailPriority = $DetailRow->priority;
                                                    $detailId = $DetailRow->id;
                                                ?>

                                            @if ($detailPriority === 1)
                                                <div class="tab-pane active" id="tab-{{ $detailId }}">
                                                    <div class="col-xs-12 owl-carousel3">
                                                        {{--<div class="col-sm-12 owl-carousel2">--}}
                                                        @foreach ($SectionItemAssoc as $index => $Prodrow)
                                                            @if($index === 0)
                                                                <?php
                                                                $tes = "active";
                                                                ?>
                                                            @else
                                                                <?php
                                                                $tes = "";
                                                                ?>
                                                            @endif
                                                            <div class='item {{ $tes }}'>
                                                                <a href="{{ url('detail/'.$Prodrow->kodeplu) }}" style="display:block">
                                                                <div class="product-detail">
                                                                    {{--<a>--}}
                                                                        <img style='padding:10%;' src="{{ $Prodrow['url_pic_prod'] }}" class="img-responsive imgbox" height="100%">
                                                                    {{--</a>--}}
                                                                    <div class="producttitle" style="font-size: small !important;font-weight: bold ;color: black !important;min-height: 60px; text-align: center; padding-left: 10px; padding-right: 10px">{{ ucwords(strtolower($Prodrow['long_description'])) }}</div>
                                                                    @if($Prodrow['flagpromomd'] ==1 && $Prodrow['hrg_jual'] != $Prodrow['prmd_hrgjual'])
                                                                        <div class="productprice" style="min-height: 90px;">
                                                                            <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" ><i style='text-decoration: line-through;'>Rp. {{ number_format($Prodrow['hrg_jual'], 0, ',', '.') }}</i><br/><span style="color: rgb(247, 147, 30); font-weight: 600">Rp. {{ number_format($Prodrow['prmd_hrgjual'], 0, ',', '.') }}</span><span style="color: #F7931E; font-weight: 600">/ {{ $Prodrow['unit'] }}</span><br/><span style="color: #F7931E; font-weight: 600">(isi {{ $Prodrow['frac'] }}&nbsp;Pcs)</span></div>
                                                                        </div>
                                                                    @else
                                                                        <div class="productprice" style="min-height: 90px;">
                                                                            <div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Rp. {{ number_format($Prodrow['hrg_jual'], 0, ',', '.') }}<span>/ {{ $Prodrow['unit'] }}</span><br/><span>(isi {{ $Prodrow['frac'] }}&nbsp;Pcs)</span></div>
                                                                        </div>
                                                                    @endif
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div><!-- End Carousel -->
                                                </div>
                                            @else
                                                <div class="tab-pane" id="tab-{{ $detailId }}">
                                                    <div class="col-xs-12 owl-carousel3">
                                                        {{--<div class="col-sm-12 owl-carousel2">--}}
                                                        @foreach ($SectionItemAssoc as $index => $Prodrow)
                                                            @if($index === 0)
                                                                <?php
                                                                $tes = "active";
                                                                ?>
                                                            @else
                                                                <?php
                                                                $tes = "";
                                                                ?>
                                                            @endif
                                                            <div class='item {{ $tes }}'>
                                                                <a href="{{ url('detail/'.$Prodrow->kodeplu) }}" style="display:block">
                                                                <div class="product-detail">
                                                                    {{--<a>--}}
                                                                        <img style='padding:10%;' src="{{ $Prodrow['url_pic_prod'] }}" class="img-responsive imgbox" height="100%">
                                                                    {{--</a>--}}
                                                                    <div class="producttitle" style="font-size: small !important;font-weight: bold ;color: black !important;min-height: 60px; text-align: center; padding-left: 10px; padding-right: 10px">{{ ucwords(strtolower($Prodrow['long_description'])) }}</div>
                                                                    @if($Prodrow['flagpromomd'] ==1 && $Prodrow['hrg_jual'] != $Prodrow['prmd_hrgjual'])
                                                                        <div class="productprice" style="min-height: 90px;">
                                                                            <div class="pricetext" style="font-size: 13px !important; text-align: center; color:#9e9e9e  ;font-weight: 500; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" ><i style='text-decoration: line-through;'>Rp. {{ number_format($Prodrow['hrg_jual'], 0, ',', '.') }}</i><br/><span style="color: rgb(247, 147, 30); font-weight: 600">Rp. {{ number_format($Prodrow['prmd_hrgjual'], 0, ',', '.') }}</span><span style="color: #F7931E; font-weight: 600">/ {{ $Prodrow['unit'] }}</span><br/><span style="color: #F7931E; font-weight: 600">(isi {{ $Prodrow['frac'] }}&nbsp;Pcs)</span></div>
                                                                        </div>
                                                                    @else
                                                                        <div class="productprice" style="min-height: 90px;">
                                                                            <div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Rp. {{ number_format($Prodrow['hrg_jual'], 0, ',', '.') }}<span>/ {{ $Prodrow['unit'] }}</span><br/><span>(isi {{ $Prodrow['frac'] }}&nbsp;Pcs)</span></div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div><!-- End Carousel -->
                                                </div>
                                            @endif

                                    @endforeach
                                    </div>

                                <?php
                                $SectionLinkAssoc = \App\Models\SectionLink::getLinkSection($crow['section_id']);
                                ?>

                                <div class='hidden-xs col-xs-12' style="padding-right: 0px;padding-left: 0px;background-color: #E6F9FE">
                                    @foreach ($SectionLinkAssoc as $index => $linkRow)
                                        <div style='overflow: hidden; height: 100%; border-right-width: 1px;border-right-style: solid; text-align: center !important; border-right-color: antiquewhite; padding-top: 5px;padding-bottom: 5px;' class='col-sm-2'>
                                            <a href={{ $linkRow['url'] }}></a><span style="color:#0079c2; font-size: 9pt !important;">{{ $linkRow['text'] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <?php
                            $SectionBrandAssoc = \App\Models\SectionBrand::getBrandSection($crow['section_id']);
                            ?>
                            <div class='hidden-xs col-xs-12' style="padding-right: 0px;padding-left: 0px;padding-top: 20px;">
                                @foreach ($SectionBrandAssoc as $index => $BrandRow)
                                    <div class="">
                                        <a href={{ $BrandRow['url'] }} class="col-sm-2" style="text-align: center;"><img src="https://klikigrsim.mitraindogrosir.co.id/image/{{ $BrandRow['image'] }}" style="-webkit-user-select: none;margin: auto;"></a>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                    @endforeach

            {{--{!! $content !!}--}}
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $(".slider").slick({
                autoplay:true,
                autoplaySpeed:1500,
                arrows:true,
                prevArrow:'<button type="button" class="slick-prev"></button>',
                nextArrow:'<button type="button" class="slick-next"></button>',
                dots: true,
                margin: 10,
                infinite: true,
                centerMode: true,
                slidesToShow: 1,
                variableWidth: true
            })

            });

        $('.myCarousel2').carousel({
            item:3,
            autoplay:false,
        });

    </script>

    <script>
        $(document).ready(function(){
            $('.owl-carousel2').owlCarousel({
                autoPlay : 5000,
                stopOnHover : false,
                items:1,
                pagination : false,
            });
        });

        $(document).ready(function(){
            $('.owl-carousel3').owlCarousel({
                autoPlay : 5000,
                stopOnHover : false,
                items:4,
                pagination : false,
            });
        });

    </script>


    @if (session('err'))
        <script>
            $(function () {
                $('#myModal').modal('show');
                getLoginMember();
                $('#modal-error').html("<div style='text-align: left' class='alert alert-danger alert-flat'><strong>Maaf, Login tidak berhasil.</strong> Silahkan coba kembali.</div>");
            });
        </script>
    @endif

    @if (session('alamat'))
        <script>
            $(function(){
                $('#myModal').modal('show');
                getOptAddress();
            })
        </script>
    @endif
    <script type="text/javascript" defer src="{{ secure_url('js/bootstrap-hover-tabs.js') }}"></script>
@endsection
