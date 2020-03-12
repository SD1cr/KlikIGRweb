<link href="{{ url('../resources/assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
<table width="100%" class="table table-striped table-condensed table-responsive" style=";
color: #333;
font-size: 11px;
font-weight: 700;
padding-bottom: 5px;
padding-left: 5px;
padding-right: 5px;
padding-top: 5px;
font-family: 'Lato,sans-serif;';">
    <tbody>
    <?php
    $TRID = $trharray->kode_transaksi;
    $TRDT = $trharray->created_at;
    $TRHRG = $trharray->total_harga;
    $TRDSC = $trharray->total_disc;
    $TRBYR = $trharray->total_bayar;
    $alm = $trharray->shipping_address;
    $subdist = $trharray->shipping_subdistrict;
    $dist = $trharray->shipping_district;
    $cit = $trharray->shipping_city;
    $prov = $trharray->shipping_province;
    $kdp = $trharray->shipping_postal;
    $fee = $trharray->shipping_fee;
    $tlp = $trharray->phone;
    $nama = $usrarray->nama;
    $typeid = $usrarray->type_id;
    ?>
    <tr class="warning" >
        <th class="font-16" style="text-align: left" colspan="7">
            <span>Member {{ $kodeMM }} Baru Saja Melakukan Pemesanan di Web Klik Indogrosir</span>
        </th>
    </tr>

    <tr class="warning" >
        <th class="font-16" style="text-align: left" colspan="4">
            <span style="font-size:14px; color:#2980b9">KONFIRMASI PESANAN</span><br/>
            <span style="font-size:14px; color:#2980b9">NOMOR PESANAN : #{{ str_pad($TRID, 6, '0', STR_PAD_LEFT) }}</span>
        </th>
        <th class="font-16" style="text-align: right" colspan="4">
            <a href="{{ url('/product') }}"><img  src="{{ url('../resources/assets/img/logo.png') }}"/></a>
        </th>
    </tr>

    <tr class="warning">
        <td style="text-align: left" colspan="8">
            Alamat : <br>
            <span>{{ $alm }}, <br> Kel.{{ $subdist }}, Kec. {{ $dist }},  Kota {{ $cit }}, Prov. {{ $prov }}, <br> {{ $kdp }}</span>
        </td>
    </tr>

    <tr class='warning' >
        <th class='font-16' style='text-align: left' colspan='4'>
            No.Pesanan      : {{ str_pad($TRID, 6, '0', STR_PAD_LEFT) }}<br/><br/>
            Tanggal Pesanan : {{ $TRDT }}<br/><br/>
            Status          : Pesanan sedang diproses<br/>
        </th>
    </tr>

    {{--<tr class='warning'>--}}
    {{--<th class='font-16' style='text-align: left' colspan='3'>--}}
    {{--Alamat Pengiriman : {{$alm}}, {{$cit}} {{$kdp}}--}}
    {{--</th>--}}
    {{--<th class='font-16' style='text-align: right' colspan='4'>--}}
    {{--Biaya Kirim :Rp. {{ number_format($fee, 0, ',', '.') }}--}}
    {{--</th>--}}
    {{--</tr>--}}

    <tr class="info" style='background-color: #2980b9'>
        <th class="font-13" style='text-align: center; color: #FFFFFF; vertical-align: middle;'>
            No.
        </th>
        <th class="font-13" style='text-align: center; color: #FFFFFF; vertical-align: middle;'>
        </th>
        <th class="font-13" style='text-align: center; color: #FFFFFF; vertical-align: middle;'>
            Nama Produk
        </th>
        <th class="font-13" style='text-align: center; color: #FFFFFF; vertical-align: middle;'>
            Unit
        </th>
        <th class="font-13" style='text-align: center; color: #FFFFFF; vertical-align: middle;'>
            Qty
        </th>
        <th class="font-13" style='text-align: center; color: #FFFFFF; vertical-align: middle;'>
            Harga
        </th>
        <th class="font-13" style='text-align: center; color: #FFFFFF; vertical-align: middle;'>
            Disc
        </th>
        <th class="font-13" style='text-align: center; color: #FFFFFF; vertical-align: middle;'>
            Subtotal
        </th>
    </tr>
    <?php
    $totgab = 0;
    $totalcashback = 0;
    $totcashbackgab = 0;
    $sindex = 0;
    $totalSub = 0;

    ?>
    @foreach($trdarray as $index => $row)
        @if($typeid == 2)
            <?php
            $flagKenaPromo = array_keys(array_column($promktarray, 'KD_PLU'), (substr($row['PLU'], 0, 6) . "0"));
            ?>
        @endif
        <tr>
            <td>
                <?php
                $totalSub = $totalSub + $row['subtotal']
                ?>
                <b>{{ $index + $sindex + 1 }}</b>
            </td>
            @if ($row['URL_PIC_PROD'] != null)
                <td style="text-align: center">
                    <img  height='100' width='100' src='{{ $row['URL_PIC_PROD'] }}' />
                </td>
            @else
                <td style="text-align: center">
                    <img  height='100' width='100' src='{{ url('../resources/assets/img/noimage.png') }}' />
                </td>
            @endif
            <td style="text-align: left">
                {{ $row['PLU'] . "-" . $row['long_description'] }}
            </td>
            <td style="text-align: center">
                {{ $row['unit'] . "/" . $row['frac'] }}
            </td>
            <td style="text-align: center">
                {{ number_format($row['qty'], 0, ',', '.') }}
            </td>
            <td style="text-align: center">
                Rp. {{ number_format($row['harga'], 0, ',', '.') }}
            </td>
            <td style="text-align: center">
                Rp. {{ number_format($row['disc'], 0, ',', '.') }}
            </td>
            <td style="text-align: right">
                Rp. {{ number_format($row['subtotal'], 0, ',', '.') }}
            </td>
        @if($typeid == 2)
            @if(count($flagKenaPromo) > 0)
                @foreach ($flagKenaPromo as $key)
                    <tr style='background-color: beige;'>
                        <td colspan='4' style='vertical-align: middle;text-align:right'>Potongan CB {{$promktarray[$key]['KD_PROMOSI'] }} : </td>
                        <td class='font-14' colspan='2' style='vertical-align: middle;text-align:center'>{{$promktarray[$key]['KELIPATAN'] }} x -{{number_format($promktarray[$key]['RUPIAH']/$promktarray[$key]['KELIPATAN'], 0, ",", ".") }}</td>
                        <td class='font-14' colspan='2' style='text-align: right;vertical-align: middle;'>- Rp. {{number_format($promktarray[$key]['RUPIAH'], 0, ",", ".") }}</td>
                    </tr>
                @endforeach
            @endif
        @endif

    @endforeach
    <tr class="warning">
        <td class="font-14" colspan='7' style="text-align: right">
            <b>Total Harga Item : </b>
        </td>
        <td class="font-14" style="text-align: right">
            Rp. {{number_format($TRHRG, 0, ',', '.')}}
        </td>
    </tr>
    <tr class="warning">
        <td class="font-14" colspan='7' style="text-align: right">
            <b>Total Diskon : </b>
        </td>
        <td class="font-14" style="text-align: right">
            Rp. {{number_format($TRDSC, 0, ',', '.')}}
        </td>
    </tr>
    <tr class="warning">
        <td class="font-14" colspan='7' style="text-align: right">
            <b>Total Belanja : </b>
        </td>
        <td class="font-14" style="text-align: right">
            Rp. {{number_format($TRBYR, 0, ',', '.')}}
        </td>
    </tr>
    @if($typeid == 2)
        @if(count($promktarray) > 0)
            @foreach($promktarray as $index => $prow)
                @if($prow['TIPE_PROMOSI'] == "CASHBACK" && $prow['JENIS_PROMOSI'] == "0" || $prow['JENIS_PROMOSI'] == "4" && $prow['FLAG_KIOSK'] != "Y")
                    <?php
                    $cashback = $prow['RUPIAH'];
                    $totalcashback = $totalcashback + ($cashback);
                    ?>
                @endif

                @if($prow['TIPE_PROMOSI'] == "CASHBACK" && $prow['JENIS_PROMOSI'] == "1" && $prow['FLAG_KIOSK'] != "Y")
                    <?php
                    $cashbackgab = $prow['RUPIAH'];
                    $totcashbackgab = $totcashbackgab + ($cashbackgab);
                    ?>
                    <tr class='info'>
                        <td colspan='7' class='font-14' style='text-align: right'><b>Potongan &nbsp;{{$prow['NM_PROMOSI']}} : Rp. {{number_format($cashbackgab, 0, ",", ".")}}</b></td>
                    </tr>
                @endif
            @endforeach
        @endif
    @endif

    <tr class='info'>
        <td colspan='8' class='font-14' style='text-align: right'><b>POTONGAN PRODUK (CSBC) : Rp. {{number_format($totalcashback, 0, ",", ".") }}</b></td>
    </tr>

    <tr class='success'>
        <td colspan='8' class='font-16' style='text-align: right'><b>Total Yang Harus Dibayar : &nbsp; Rp. {{number_format($totalSub - $totalcashback - $totcashbackgab + $fee, 0, ",", ".")}}</b></td>
    </tr>
    @if($typeid == 2)
        <?php
        $firstGift = TRUE;
        ?>
        @foreach($promktarray as $index => $prow)
            @if($prow['TIPE_PROMOSI'] === "GIFT")

                @if($prow['TIPE_PROMOSI'] == "GIFT" && $prow['JENIS_PROMOSI'] == "PD" && $prow['FLAG_KIOSK'] != "Y")
                    @if($firstGift === TRUE)
                        <tr class='danger'>
                            <td colspan='7' class='font-14' style='text-align: left'><b>Anda memperoleh : &nbsp; </b></td>
                        </tr>
                        <?php
                        $firstGift = FALSE;
                        ?>
                        <tr class='warning'>
                            <td colspan='7' class='font-12' style='text-align: left'><b>{{$prow['QTY']}} buah &nbsp;({{$prow['KET_HADIAH']}})</b></td>
                        </tr>
                    @endif
                @elseif($prow['TIPE_PROMOSI'] == "GIFT" && $prow['JENIS_PROMOSI'] == "PR" && $prow['FLAG_KIOSK'] != "Y")
                    @if($firstGift === TRUE)
                        <tr class='danger'>
                            <td colspan='7' class='font-14' style='text-align: left'><b>Anda memperoleh : &nbsp; </b></td>

                        </tr>
                        <?php
                        $firstGift = FALSE;
                        ?>
                        <tr class='warning'>
                            <td colspan='7' class='font-12' style='text-align: left'><b>{{$prow['QTY']}} POIN dari PROMOSI &nbsp;({{$prow['NM_PROMOSI']}})</b></td>
                        </tr>
                    @endif
                @endif
            @endif
        @endforeach


        <?php
        $firstInstore = TRUE;
        ?>
        @foreach($promktarray as $index =>$prow)

            @if($prow['TIPE_PROMOSI'] == "INSTORE" && $prow['JENIS_PROMOSI'] == "I" )
                @if($firstInstore === TRUE)
                    <tr class='danger'>
                        <td colspan='7' class='font-14' style='text-align: left'><b>Anda memperoleh : &nbsp; </b></td>

                    </tr>
                    <?php
                    $firstInstore = FALSE;
                    ?>
                    <tr class='warning'>
                        <td colspan='7' class='font-12' style='text-align: left'><b>{{$prow['ISH_KETERANGAN']}}</b></td>
                    </tr>
                @endif
            @elseif($prow['TIPE_PROMOSI'] == "INSTORE" && $prow['JENIS_PROMOSI'] == "H" )
                @if($firstInstore === TRUE)
                    <tr class='danger'>
                        <td colspan='7' class='font-14' style='text-align: left'><b>Anda memperoleh : &nbsp; </b></td>

                    </tr>
                    <?php
                    $firstInstore = FALSE;
                    ?>
                    <tr class='warning'>
                        <td colspan='7' class='font-12' style='text-align: left'><b>{{$prow['ISH_NAMAPROMOSI']}}</b></td>
                    </tr>
                @endif
            @endif
        @endforeach
    @endif
    </tbody>
</table>
<script src="{{ secure_url('../resources/assets/js/jquery-2.1.4.js') }}"></script>  
<script src="{{ secure_url('../resources/assets/js/bootstrap.min.js') }}"></script>  
