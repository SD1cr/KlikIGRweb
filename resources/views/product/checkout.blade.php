@extends('appcheckout')
@section('content')
    <style>
        /* Print Only */
        @media print {
            .noprint {
                display: none !important;
            }

            .noshow {
                display: block !important;
            }

            body, html, #wrapper {
                width: 100%;
            }

            body {
                display: block;
                font-size: 13px !important;
            }   
        }   
    </style>    
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="modal fade" id="confirm-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Konfirmasi Checkout</h4>
                        </div>

                        <div class="modal-body">
                            <p>Apakah anda Yakin Untuk Melakukan Checkout Keranjang Belanjaan ?</p>
                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-danger btn-ok flat" onclick='$("#confirm-form").submit()'><i class="fa fa-check-square-o"></i> Checkout</a>
                            <button type="button" class="btn btn-default flat" data-dismiss="modal">Cancel</button>
                        </div>

                    </div>
                </div>
            </div>
            @if (session('err'))
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <strong>Pesanan Tidak mencukupi, Minimal Order anda Adalah Rp. {{number_format(session('err'),0,",",".")}} </strong> <br><br>
                    </div>
                </div>
            @endif
            {{--<div class="col-md-12" style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: left; background-color: white;padding-left: 0;padding-right: 0; padding-left: 20px;padding-right: 0; padding-bottom: 20px;padding-top: 20px;margin-bottom: 20px;'>--}}
                {{--<div style='text-align: left; font-weight: bold'>Pengiriman dilakukan</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>--}}

                {{--<div class="row" style="padding-left: 20px;">--}}
                    {{--<div class="form-check">--}}
                        {{--<label class="form-check-label">--}}
                        {{--<input type="radio" name='sendRadio' id='asu' style="margin-right: 10px; margin-bottom: 10px; margin-top:10px;" checked onclick="hide_Address();"><span>Kirim Sekarang</span>--}}
                        {{--</label>--}}
                    {{--</div>--}}
                    {{--<div class="form-check">--}}
                        {{--<label class="form-check-label">--}}
                            {{--<input type="radio" name='sendRadio' id='kirik' style="margin-right: 10px;" onclick="show_Address();"><span>Kirim Nanti</span>--}}
                        {{--</label>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="panel panel-default flat" id="formAddress" style="display: none">--}}
                    {{--<div class="panel-body">--}}
                        {{--<div class="input-daterange" id='datepicker'>--}}
                            {{--<input style="width: 150px; margin-right: 10px;" type='text' class="col-md-3 form-control" name="tglso[]" id="dtStart"/>--}}
                            {{--<span class="add_field_button">--}}
                                {{--<button class="btn btn-success flat">+ Tambah Tanggal</button>--}}
                            {{--</span>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-12">--}}
                            {{--<button style='margin-top: 10px;' class="btn btn-primary flat" type="submit">Submit</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}


            <div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; padding-bottom: 15px;' class='col-md-7'>
                <div style='font-weight: bold;text-align: left;font-size: medium !important;padding-left: 20px;padding-top: 20px;'><span class="caret" style="border-width: 10px; margin-right: 5px;"></span>Detail Barang Belanja</div>
                <hr style='margin-top: 5px;margin-bottom: 5px;'/>
                {!! $cartdetail !!}
            </div>

            <div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; padding-left: 20px;padding-right: 0; padding-bottom: 20px;padding-top: 20px; margin-left: 20px;' class='col-md-4'>
                {!! $detail !!}
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function show_Address()
        {
            jQuery('#formAddress').show();
        }
        function hide_Address()
        {
            jQuery('#formAddress').hide();
        }
        $(function() {

            $('#dtStart').datepicker({
                format: 'dd/mm/yyyy',
                immediateUpdates: true,
                todayHighlight: true,
                orientation: 'auto bottom',
                autoclose : true
            });

            var max_fields      = 5; //maximum input boxes allowed
            var wrapper         = $(".input-daterange"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID
            var total = $("#total").html().substring($("#total").html().indexOf("Rp.")+3).replace(".", "").trim();
            var x = 1; //initlal text box count

            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    countTotal(total, x);
                    $(wrapper).append('<div class="row" style="margin-top: 5px;padding-left: 10px;"><input class="form-control" style="width: 150px; float: left" type="text" name="tglso[]" id="dtStart' + x + '"/><button style="margin-left:2px;float: left; padding: 3px 8px" href="#" class="btn btn-danger igr-flat remove_field"><i class="fa fa-trash-o"></i></button></div>');
//                    $(wrapper).append('<div class="input-daterange" id="datepicker"><input style="width: 150px;" type="text" class="form-control" name="tglso[]" id="dtStart"/><span class="add_field_button"><button class="btn btn-success flat">+ Tambah Tanggal</button></span></div>'); //add input box
                    $('#dtStart'+x).datepicker({
                        format: 'dd/mm/yyyy',
                        immediateUpdates: true,
                        todayHighlight: true,
                        orientation: 'auto bottom',
                        autoclose : true
                    });
                }
            });
            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
                countTotal(total, x);
            })
            function countTotal(total, jmlkirim){
                var hasil = total * jmlkirim;

                $("#total").html("Total Belanja :   Rp. " + hasil);
            }
        });
    </script>
@endsection

