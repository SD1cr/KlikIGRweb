<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\TransactionHeader as TrHeader;
use App\Models\TransactionDetail as TrDetail;
use App\Models\User as User;
use App\Models\Cart as Cart;
use App\Models\Product as Product;
use App\Models\Invoice;
use App\Models\Address;
use App\Models\Branch;
use App\Models\Category as Kat;
use App\Models\Category;
use App\Models\Department;
use App\Models\Divisi as Div;
use App\Models\Department as Dep;

class HistoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function getMenuDropdown()
    {
        $htmlFormat ="";
        $htmlFormat .= "<div class=\"col-md-12\" style='width: 100%; padding-left: 0px;padding-right: 0px;'z-index: 1000;'>
                        <div class='profile-sidebar' style='box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);padding-top: 0px; padding-bottom: 0px;'>";
//        foreach ($newkatAssoc as $index => $katRow) {
        $htmlFormat .= "<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-default flat' style='font-weight: bold ;font-size: small; color: black;text-align:left; padding-left:6px; width: 100%' data-target='#' href='/page.html'>
            <i class='fa fa-bars'></i> &nbsp;
            KATEGORI BELANJA &nbsp;
            </a>";
        $divisiAssoc = Div::getAllDivisi();
        foreach ($divisiAssoc as $index => $Divrow) {
            $htmlFormat .= "<li class=\"dropdown-submenu\" style=\"list-style-type:none; padding-top: 10px;padding-bottom: 10px;padding-left: 10px;padding-right: 10px;margin-right: 10px;white-space: nowrap;\">
                        <a class='kigr-hover' tabindex=\"-1\" href=" . url("list/" . $Divrow->id) . " style=\"font-size: small; color: black;\" >$Divrow->division</a>";
            $htmlFormat .= "<ul class=\"dropdown-menu\" style='overflow:auto;max-height:500px; min-height: 350px;  margin-top: 0px;position: absolute !important;top:-". ((40*$index)+35) ."px !important; left:100% !important;'>";
            $depAssoc = Dep::getDepByDivisi($Divrow->id);
            if(count($depAssoc)) {
                foreach ($depAssoc as $index => $Deprow) {
                    $htmlFormat .= "<li style='width: 960px; padding-bottom: 20px '><a class='kigr-hover' href=" . url("list/" . $Divrow->id . "/" . $Deprow->id) . " style=\"font-size: small;color: #3498db;\">$Deprow->department</a>";
                    $htmlFormat .= "<dt class=\"dropdown-menu\">";
                    $kategoriAssoc = Category::getKatByDep($Deprow->id);
                    foreach ($kategoriAssoc as $index => $Katrow) {
                        $htmlFormat .= "<dd class='col-md-2' style='white-space: nowrap;font-size: x-small !important;'><a class='kigr-hover' href=" . url("list/" . $Divrow->id . "/" . $Deprow->id . "/" . $Katrow->id) . " style=\"font-size: small !important; color: black;\">" . ucwords(strtolower($Katrow->nama)) . "</a></dd>";
                    }
                    $htmlFormat .= "</dt>";
                    $htmlFormat .= "</li>";
                }
            }
            $htmlFormat .= "</ul>";
            $htmlFormat .= "</li>";
        }
        $htmlFormat .= "</div></div>";
        return $htmlFormat;

    }

    public function getMenuDropdownMobile()
    {
        $htmlFormat ="";
        $htmlFormat .= " <ul class=\"accordion\">
                <li>";
//        foreach ($newkatAssoc as $index => $katRow) {
        $htmlFormat .= "<a id=\"top\" class=\"toggle\" href=\"javascript:void(0);\"><i class='fa fa-bars'></i> &nbsp;
            Kategori Belanja &nbsp;
            </a>";
        $divisiAssoc = Div::getAllDivisi();
        $htmlFormat .= "<ul class='inner'>";
        foreach ($divisiAssoc as $index => $Divrow) {
            $htmlFormat .= "
                        <li>
                            <a href=" . url("list/" . $Divrow->id) . " class='toggle'><span class='kigr-hover igrspan-hover' link=" . url("list/" . $Divrow->id) . ">$Divrow->division</span><i style='float:right' class='fa fa-arrow-right'></i></a>";
            $depAssoc = Dep::getDepByDivisi($Divrow->id);
            if(count($depAssoc)) {
                $htmlFormat .= "<ul class='inner'>";
                foreach ($depAssoc as $index => $Deprow) {
                    $htmlFormat .= "
                        <li>
                            <a href=" . url("list/" . $Divrow->id . "/" . $Deprow->id) . " class='toggle'><span class='kigr-hover igrspan-hover' link=" . url("list/" . $Divrow->id . "/" . $Deprow->id) . ">$Deprow->department</span><i style='float:right' class='fa fa-arrow-right'></i></a>";

                    $kategoriAssoc = Category::getKatByDep($Deprow->id);
                    $htmlFormat .= "<ul class='inner'>";
                    foreach ($kategoriAssoc as $index => $Katrow) {
                        $htmlFormat .= "
                        <li>
                            <a href=" . url("list/" . $Divrow->id . "/" . $Deprow->id . "/" . $Katrow->id) . " class='toggle'><span class='kigr-hover igrspan-hover' link=" . url("list/" . $Divrow->id . "/" . $Deprow->id . "/" . $Katrow->id) . ">" . ucwords(strtolower($Katrow->nama)) . "</span></a>";

                    }
                    $htmlFormat .= "</li>";
                    $htmlFormat .= "</ul>";
                }
            }
            $htmlFormat .= "</li>";
            $htmlFormat .= "</ul>";
        }
        $htmlFormat .= "</li></ul>";
        return $htmlFormat;

    }


    public function getHistoryAll()
    {
        $addID = Address::getAddressID();

        $trhAssoc = TrHeader::getListTransactionHeaders2($addID);

        return view('product.historypesanan')->with('trharray', $trhAssoc)->with('divdeptkat', $this->getMenuDropdown())->with('sidebar', $this->getSideBar())->with('divdeptkatmobile', $this->getMenuDropdownMobile());
    }

    public function HistoryPembelian(){
        if(!isset($_GET['TRID']) || $_GET['TRID'] == "" || $_GET['TRID'] == null) {
            return view('blank')->with('page', 'Kosong');
        }else{
            $kdTran = $_GET['TRID'];

            $allowedStatus = TrHeader::checkRequestAllowed($kdTran);

            if($allowedStatus == "OK"){
                $trhAssoc = TrHeader::getTransactionHeader($kdTran);
                $trdAssoc = TrDetail::getTransactionDetail($kdTran);
                return view('history.trhistory')->with('trharray', $trhAssoc)->with('trdarray', $trdAssoc);
            }else{
                //Balikin Ke History List
            }
        }
    }

    public function validateQty($QTY, $PLU){
//        $validSt = 'OK';
//        $minBeli = Product::getMinBeli($PLU);
//        if($QTY % $minBeli != 0){
//            $validSt = "QTY Harus Kelipatan " . $minBeli;
//        }
//        return $validSt;
        if ($QTY == 0) {
            return 'Zero';
        }
        $validSt = 'OK';
        $minBeli = Product::getMinBeli($PLU);
        if ($QTY < $minBeli) {
            $validSt = "QTY Minimal " . $minBeli;
        }
        return $validSt;
    }


    public function reOrder(Request $Request){
        $kdTran = $Request->Get('TRID');
        $allowedStatus = TrHeader::checkRequestAllowed($kdTran);

        $trAssoc = TrDetail::getTransactionReorderDetail($kdTran);

        $countcart = Cart::getcountcartall();

        if(count($trAssoc) + count($countcart) >= 100 && \Auth::User()->type_id == 2){
            return redirect('history')->with('err', 'Item Yang Anda order ulang melebihi batas maksimal jumlah item di keranjang ,maks. 100 item');
        }else{
            foreach($trAssoc as $index => $row){
                $PLU = $row['PLU'];
                $QTY = $row['qty'];
                $QTYErr = $this->validateQty($QTY, $PLU);
//                $QTYErr = 'OK';
                if($QTYErr == 'OK'){
                    $UNIT = Product::getunit($PLU);
                    Cart::addCartItem($PLU, $QTY, $UNIT);
                }
            }
            return redirect('history')->with('opencart', true);
        }
    }

    public function getListInfo(Request $Request){
        $id = \Auth::user()->id;
        if(!isset($_GET['LST']) || $_GET['LST'] == '' || $_GET['LST'] == null){
            $key = '%';
        }else{
            $key = $_GET['LST'];
        }
            $listAssoc = TrDetail::getListHistory($key,$id);

        return view('history.list')->with('list', $listAssoc);
    }

    public function getHistoryInfo(Request $Request)
    {
        if ($Request->ajax()) {
            $invoiceID = $Request->Get('trid');
            $type = $Request->Get('name');

//            $address = TrHeader::Distinct()
//                ->Where('kode_transaksi', $invoiceID)
//                ->Pluck('address_id');
//
//            dd($address);

            $CartAddress = Address::getCartAddresses();
            $cFormatRaw = "";
//            $CartAddress = Address::Distinct();
//            if($typeuserid != 1) {
//                $CartAddress = $CartAddress->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
//                    ->join('branches','addresses.branch_id', '=', 'branches.id')
//                    ->join('provinces','addresses.province_id', '=', 'provinces.id')
//                    ->join('cities', 'addresses.city_id','=','cities.id')
//                    ->join('members', 'addresses.member_id', '=', 'members.id')
//                    ->join('districts', 'addresses.district_id', '=', 'districts.id')
//                    ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
//                    ->Where('member_id',$userid)
//                    ->Where('flag_default', 1)
//                    ->Get();
//            }else{
//                $CartAddress = $CartAddress->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
//                    ->join('branches','addresses.branch_id', '=', 'branches.id')
//                    ->join('provinces','addresses.province_id', '=', 'provinces.id')
//                    ->join('cities', 'addresses.city_id','=','cities.id')
//                    ->join('members', 'addresses.member_id', '=', 'members.id')
//                    ->join('districts', 'addresses.district_id', '=', 'districts.id')
//                    ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
//                    ->Where('member_id',$userid)
//                    ->Get();
//            }

            $allowedStatus = TrHeader::checkRequestAllowed($invoiceID);

            if ($allowedStatus == "OK") {
                foreach ($CartAddress as $cIdx => $aRow) {
                    $trdAssoc = TrDetail::getTransactionDetail($invoiceID, $aRow['id']);
//                    if($trdAssoc == ""){
//                        $cFormatRaw .= "<span style='color:red; font-weight: bold;'>Pastikan Alamat Default Sesuai Dengan history order yang akan dilihat</span>";
//                    }

                    if (count($trdAssoc) > 0) {
                         $cFormatRaw .= "<div class='row'><div class='col-xs-12' style='box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);'><table width='100%' style='text-align: start; border-right-color:white; padding-bottom: 0px' class='table table-striped table-condensed table-responsive cart cart" . $aRow['id'] . "' data-id='" . $aRow['id'] . "'>";

                        $cFormatRaw .= "<tr style='background-color: #2980b9'>
                                        <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>No.</th>
                                        <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Gambar</th>
                                        <th width='25%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Deskripsi</th>
                                        <th width='20%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Jumlah</th>
                                        <th width='10%' class='font-15' style='text-align: center;color: #FFFFFF; vertical-align: middle;'>Harga</th>
                                         <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Diskon</th>
                                        <th width='15%' class='font-15' style='text-align: center;color: #FFFFFF; vertical-align: middle;'>Subtotal</th>

                                    </tr>";

                        $cFormatRaw .= "<tr><th colspan='7' width='25%' class='font-15' style='text-align: left; color: black; vertical-align: middle;'>Alamat : " . $aRow['label'] . " </th></tr>";
                        $sindex = 0;
                        $totalSub = 0;
                        $totalDisc = 0;
//                        $total = 0;

                        foreach($trdAssoc as $cIdx => $tRow){
                            $totalSub = $totalSub + $tRow['subtotal'];
                            $totalDisc = $totalDisc + $tRow['disc'];
                            $total = $totalSub + $totalDisc;
                            $sindex++;
                            $cFormatRaw .= "<tr>
                                            <td style='text-align: center; vertical-align: middle;'>" . $sindex ."</td>";

                            if ($tRow['URL_PIC_PROD'] != null) {
                                $cFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . $tRow['URL_PIC_PROD'] . "'/></td>";
                            } else {
                                $cFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . url('../resources/assets/img/noimage.png') . "'/></td>";
                            }
							 if($tRow['kode_tag'] != 'N'){
							  $cFormatRaw .= "<td style='text-align: left'>" . $tRow['PLU'] . "-" . $tRow['long_description'] . "</td>";
							 }else{
							  $cFormatRaw .= "<td style='text-align: left'>" . $tRow['PLU'] . "-" . $tRow['long_description'] . "<br/><br/><span style='color:red; font-weight: bold;'>Sudah Tidak Jual Toko</span></td>";
							 }

                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['qty'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['harga'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['disc'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['subtotal'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "</tr>";
                        }
                        $cFormatRaw .= "</table></div></div>";
                    }
               }
                $cFormatRaw .= "<div style='text-align: right; margin-top:10px; font-weight: bold'>Detail Order</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
                $cFormatRaw .= "<div style='text-align: right;'>Sub Total : &nbsp; Rp. " . number_format($total, 0, ",", ".") . "</div>";
                $cFormatRaw .= "<div style='text-align: right;'>Total Diskon : &nbsp; Rp. " . number_format($totalDisc, 0, ",", ".") . "</div>";
//                $cFormatRaw .= "<div style='text-align: right;'>Pengiriman : &nbsp; GRATIS</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
                $cFormatRaw .= "<div style='text-align: right; font-weight: bold' id='total'>Total Belanja : &nbsp; Rp. " . number_format($totalSub, 0, ",", ".") . "</div>";

            }
            return $cFormatRaw;
        }
    }

}
