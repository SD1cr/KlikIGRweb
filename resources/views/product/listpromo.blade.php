@extends('appcheckout')
@section('content')

    <style>

    </style>

    <div class="container" style="margin-top: 110px;padding-left: 0px;padding-right: 0px;">
        <div class="row" style="
    margin-left: 0px;
    margin-right: 0px;
    ">

            <?php
            $promolist = \App\Models\Promotion::getListPromoAll();
            ?>


            @foreach($promolist as $index => $prow)
                <div class="col-xs-4" style="padding-left: 0px;padding-right: 0px;margin-bottom: 50px; margin-right: 0px;padding-right: 40px;">
                    <img style='border-radius: 10px;' src="https://klikigrsim.mitraindogrosir.co.id/image/{{$prow['image']}}" class="img-responsive imgbox" height="100%">
                    <nav aria-label="breadcrumb" style="margin-top: 10px;">
                        <ol style="background-color: #ecebeb;margin-bottom: 5px;" class="breadcrumb">
                            <li style="font-weight: bold">Periode Promo</li>
                            <li style="font-weight: bold; float: right">{{ date('d M', strtotime($prow['start_date'])) }} s/d {{ date('d M Y', strtotime($prow['end_date'])) }}</li>
                        </ol>
                        <ol style="background-color: #ecebeb;margin-bottom: 10px;" class="breadcrumb">
                            <li style="font-weight: bold">Kode Promo</li>
                            <li style="font-weight: bold; float: right">{{$prow['promotion_code']}}
                                {{--<input type="text" value="MAYAPADAPAYDAY" id="myInput">--}}
                                {{--<button onclick="myFunction()">Copy text</button>--}}
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ url('promonotif/'.$prow->idpromo) }}" target="_blank" type="button" class="btn btn-primary col-md-12">Lihat Detail</a>
                </div>
            @endforeach
            
        </div>
    </div>


    <script>

        function myFunction() {
            /* Get the text field */
            var copyText = document.getElementById("myInput");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/

            /* Copy the text inside the text field */
            document.execCommand("copy");

            /* Alert the copied text */
            alert("Copied the text: " + copyText.value);
        }
    </script>
@endsection
@section('scripts')