<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Branch;
use App\Models\Category as Kat;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Divisi as Div;
use App\Models\Department as Dep;
use App\Models\Divisi;
use App\Models\EmailRecv;
use App\Models\Invoice;
use App\Models\NewCategory;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ProductView;
use App\Models\SectionBanner;
use App\Models\SectionBrand;
use App\Models\SectionDetail;
use App\Models\SectionHeader;
use App\Models\SectionItem;
use App\Models\SectionLink;
use App\Models\TempPromo;
use App\Models\User;
use Carbon\Carbon;

use App\Models\TransactionHeader as TrHeader;
use App\Models\TransactionDetail as TrDetail;
use App\Models\TransactionDownload as TrDown;

use App\Models\Promotion as Promotion;
use App\Models\EmailRecipient as EmailRcv;
use App\Models\BankAccount as BankAcc;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        //
    }

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
                        $htmlFormat .= "<dd class='col-md-3' style='white-space: nowrap;font-size: x-small !important;'><a class='kigr-hover' href=" . url("list/" . $Divrow->id . "/" . $Deprow->id . "/" . $Katrow->id) . " style=\"font-size: small !important; color: black;\">" . ucwords(strtolower($Katrow->nama)) . "</a></dd>";
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

//    public function getMenuDropdown()
//    {
//        $ddk = "";
//        $divisiAssoc = Div::getAllDivisi();
//        foreach ($divisiAssoc as $index => $row) {
//            $ddk .= "<li class=\"dropdown-submenu\">
//                        <a class='kigr-hover' tabindex=\"-1\" href=" . url("list/" . $row->DIV_KODEDIVISI) . " style=\"font-size: small; color: #3498db;\" >$row->DIV_NAMADIVISI</a>";
//            $ddk .= "<ul class=\"dropdown-menu\">";
//            $depAssoc = Dep::getDepByDivisi($row['DIV_KODEDIVISI']);
//            foreach ($depAssoc as $index => $row) {
//                $ddk .= "<li class=\"dropdown-submenu\"><a class='kigr-hover' href=" . url("list/" . $row->DEP_KODEDIVISI . "/" . $row->DEP_KODEDEPARTEMENT) . " style=\"font-size: small;color: #3498db;\">$row->DEP_NAMADEPARTEMENT</a>";
//                $ddk .= "<ul class=\"dropdown-menu\">";
//
//                $kategoriAssoc = Category::getKatByDep($row['DEP_KODEDEPARTEMENT']);
//
//                foreach ($kategoriAssoc as $index => $row) {
//                    $ddk .= "<li><a class='kigr-hover' href=" . url("list/" . $row->DEP_KODEDIVISI . "/" . $row->KAT_KODEDEPARTEMENT . "/" . $row->KAT_KODEKATEGORI) . " style=\"font-size: small; color: #3498db;\">$row->nama</a></li>";
//                }
//
//                $ddk .= "</ul>";
//                $ddk .= "</li>";
//            }
//            $ddk .= "</ul>";
//
//            $ddk .= "</li>";
//        }
//
//        return $ddk;
//    }

    public function getElevator()    
    {
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        if (!\Auth::guest()) {
            $sectionHdr = SectionHeader::Distinct() ->leftJoin('section_membertype', 'section_headers.id', '=', 'section_membertype.section_id')->Where('type_id', $typeuserid)->where('period_start', '<=', Carbon::today())
                ->where('period_end', '>=', Carbon::today())->WhereNull('deleted_at')->OrderBy('priority', 'asc')->get();

        }else{
            $sectionHdr = SectionHeader::Distinct()->leftJoin('section_membertype', 'section_headers.id', '=', 'section_membertype.section_id')->Where('type_id', 3)->WhereNull('deleted_at')->where('period_start', '<=', Carbon::today())
                ->where('period_end', '>=', Carbon::today())->OrderBy('priority', 'asc')->get();
        }

        $elevatorFormat = "";
        $elevatorFormat .= "<div id =\"nav\" class=\"sidebar\" style=\"position: fixed !important; right: 0; margin-top: 200px\">";
                $elevatorFormat .= "<ul>";
                $seq=1;
                foreach ($sectionHdr as $index => $Secrow) {
                  // " . $Secrow->id . "
                    $elevatorFormat .= "<tr><a href=#".$seq."><img class='img_elevator' style='padding:15%;' height=\"50\" width=\"50\"src=" . env('URLPRODUCT') . "/" . $Secrow->icon . "></a></tr><br>";
                    // $elevatorFormat .= "<li><a href=#section_".$seq."><img height=\"50\" width=\"50\"src=" . env('URLPRODUCT') . "/" . $Secrow->icon . "></a></li>";
                  $seq++;
                }
                $elevatorFormat .= "</ul>";
                $elevatorFormat .= "</div>";

                return $sectionHdr;

    }

    public function getBannerMobile()
    {
        if (!\Auth::guest()) {
            $typeid = \Auth::User()->type_id;
        }else{
            $typeid = '3';
        }

        $date = Carbon::today();

        $htmlFormat = "";
        $banner = \DB::table('banners')->distinct()
            ->leftJoin('banner_membertype', 'banners.id', '=', 'banner_membertype.banner_id')->Where('type_id', $typeid)
            ->where(\DB::raw('DATE(start_date)'), '<=', $date)
            ->where(\DB::raw('DATE(end_date)'), '>=',$date)
            ->WhereNull('deleted_at')
            ->OrderBy('priority')->get();

        $htmlFormat .= "<div class='visible-xs col-md-12 owl-carousel2' style=\"margin-top:180px;margin-bottom:70px;\">";
        foreach ($banner as $index => $BanRow) {
            $htmlFormat .="<div><img width='100%' style='border-radius: 12px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $BanRow->images . "' alt=" . $BanRow->altname . "></div>";
            }
        $htmlFormat .= "</div>";

        return $htmlFormat;
    }

    public function getBanner()
    {
        if (!\Auth::guest()) {
            $typeid = \Auth::User()->type_id;
        }else{
            $typeid = '3';
        }

        $date = Carbon::today();

        $htmlFormat = "";
        $banner = \DB::table('banners')->distinct()
            ->leftJoin('banner_membertype', 'banners.id', '=', 'banner_membertype.banner_id')->Where('type_id', $typeid)
            ->where(\DB::raw('DATE(start_date)'), '<=', $date)
            ->where(\DB::raw('DATE(end_date)'), '>=',$date)
            ->WhereNull('deleted_at')
            ->OrderBy('priority')->get();

        $htmlFormat .= "<div id=\"hidden-xs index2_banner\" class=\"row\" style=\"margin-bottom:10px;\">";
        $htmlFormat .= "<div class=\"hidden-xs col-md-12 slider\" style='width: 100%;padding-left: 0px; padding-right: 0px;'>";

        foreach ($banner as $index => $BanRow) {
            $htmlFormat .= "<div class='item' style='margin-right: 20px;margin-left: 20px;'>
                            <a href=" . $BanRow->url . "><img style='border-radius: 12px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);' width=\"600px\" height='180px' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $BanRow->images . "' alt=" . $BanRow->altname . "></a>
                            </div>";
        }
        $htmlFormat .= "</div>";

        $htmlFormat .= "<div class='hidden-xs alert alert-info' role='alert' style='float:right'><a href=" . url('listpromo') . " style='font-weight: bold'>Lihat Semua Promo</a></div>";

        if(!\Auth::guest() && $typeid == 1) {
            $countItemContract = Contract::getCountItemContract();
        }

        if(!\Auth::guest() && $typeid == 1 && $countItemContract > 0){
            $ProductContract = Product::getProductContractFont();
            if($ProductContract != null){
                $htmlFormat .="
        <div class=\"hidden-xs col-sm-12\" style=\"min-height: 0px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14); margin-bottom: 20px;padding-left: 0px;padding-right: 0px;margin-top: 20px;\">
            <div class=\"col-sm-12\" style=\"padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: gainsboro;font-weight: bold;font-family: 'Roboto Condensed', sans-serif !important;font-size: large\"><span>Produk Kontrak &nbsp;</span><a href=" . url('listcontract') . "><span style='float:right;' >Lihat Semua &nbsp;</span></a></div>
            <div class=\"col-sm-12 owl-carousel2\" style='width: 100%;padding-left: 0px; padding-right: 0px; max-height: 100%;'>";
                foreach($ProductContract as $index => $row){
                    $htmlFormat .="
                    <a href=". url('detail/'.$row->prdcd) ."  style=\"display:block\">
                        <div class=\"product1-grid\" style=\"margin-bottom: 0px;background-color: white;\">";
                    if($row->url_pic_prod != null){
                        $htmlFormat .="
                                <div>
                                    <img style='padding:10%;' src='" . $row->url_pic_prod ."' class=\"img-responsive imgbox\" height=\"100%\">
                                </div>
                                ";
                    }else{
                        $htmlFormat .="
                                <div>
                                    <img style='padding:10%;' src='" . url('img/noimage.png') . "' class=\"img-responsive imgbox\" height=\"100%\">
                                </div>";
                    }
                    $htmlFormat .="
                            <div class=\"producttitle\" style=\"font-size: small !important; color: black !important;min-height: 58px; text-align: center; padding-left: 10px; padding-right: 10px\">" . ucwords(strtolower($row->long_description)) . "</div>";
                    if($typeid == 1) {

                        $htmlFormat .= "<div class=\"productprice\" style=\"min-height: 50px;\">
                                        <div class=\"pricetext\" style=\"font-size: 16px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;\">Rp. " . number_format($row->price, 0, ',', '.') . "</div>
                                        </div>";
                    }
                    $htmlFormat .="
                        </div>
                    </a>";
                }
                $htmlFormat .="
            </div>
        </div>";
            }
        }

        $htmlFormat .= "</div>";

        return $htmlFormat;
    }

    public function getProduct()
    {
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        $divisiAssoc = Div::getAllDivisi();

        $contentFormat = "<ul>";
        foreach ($divisiAssoc as $index => $Divrow) {
            $contentFormat .= "<div class=\"col-xs-12\">
                                <a id=" . $Divrow->url . " style=\"font-size: x-large !important; font-weight: bold !important; color: black\">
                                <img height=\"64\" width=\"64\"src=" . $Divrow->icon . ">" . $Divrow->DIV_NAMADIVISI . "</a> &nbsp
                                <i style='font-size:x-large !important;' class=\"fa fa-angle-double-right\"></i>
                                </div>";
            $contentFormat .= "<div class=\"col-xs-12\">";

            $contentFormat .= "<div style=\"background-color: " . $Divrow->color . "; min-height: 2px; margin-top='0 !important'; margin-bottom: '0 !important';  padding-left='0 !important'; padding-right='0 !important'\" class=\"col-xs-12\"></div>";
//            $contentFormat .= "<div style=\"background-color: #C20000; min-height: 8px;\" class=\"col-xs-12\"></div>";

            $contentFormat .= "<li class=\"breadcrumb bread-primary\" style='background-color:#FFFFFF; padding-top: 0px;'>";
//            $contentFormat .= "<a href=" . url("list/" . $row->DIV_KODEDIVISI) . "><span style='font-size:25px !important;' >" . $row->DIV_NAMADIVISI . "</span></a>";
//            $contentFormat .= "<hr style='padding-bottom: 8px; margin-left: -15px; margin-top: 0px;' class=\"hr-primary\"/>";

            $contentFormat .= "<div class=\"container-fluid\">";
            $contentFormat .= "<div class=\"row\">";
//            $contentFormat .= "<div class=\"col-md-12\"><img src=" . $Divrow->icon . "></div>";
            $contentFormat .= "<div class=\"col-md-3 col-sm-6\" style='padding-right: 0px !important;'>";

            $prodTenant = Product::getProductTenant($Divrow['DIV_KODEDIVISI']);
            $depAssoc = Dep::getDepByDivisi($Divrow['DIV_KODEDIVISI']);
//            $contentFormat .= "<div class=\"col-xs-12\" style='padding-right: 0px !important;'>";
            $contentFormat .= "<div class=\"col-xs-12 owl-carousel2\">
                                <div ><img width=\"100%\" src='https://img10.jd.id/Indonesia/s296x426_/nHBfsgAAAgAAAB4ACgmGAAAA5X4.jpg!q80' alt=\"First slide\"></div>
                                <div><img width=\"100%\" src='https://img10.jd.id/Indonesia/s296x426_/nHBfsgAAAgAAABEACc5l7wAAms8.jpg!q80' alt=\"Second slide\"></div>
                                <div><img width=\"100%\" src='https://img10.jd.id/Indonesia/s296x426_/nHBfsgAAAgAAAA8ACkTNEwAAVtM.jpg!q80' alt=\"Third slide\"></div>
                               </div>";

//            $contentFormat .= "<div class=\"col-md-12\"><img height=\"150\" width=\"150\"src=" . $Divrow->icon . "></div>";
            $contentFormat .= "<div class='col-xs-12' style='background-color:" . $Divrow->color . ";'>";

            foreach ($depAssoc as $index => $Deprow) {
                $contentFormat .= "<div style='overflow: hidden;height: 20px;' class='col-xs-6'>";
                $contentFormat .= "<a class='linkHover' href=" . url("list/" . $Deprow->DEP_KODEDIVISI . "/" . $Deprow->DEP_KODEDEPARTEMENT) . " style=\"font-size: 10px !important; color: white;\">$Deprow->DEP_NAMADEPARTEMENT</a>";
                $contentFormat .= "</div>";
            }
            $contentFormat .= "</div>";
            $contentFormat .= "</div>";
//            $contentFormat .= "</div>";
            $contentFormat .= "<div class=\"col-md-9 col-sm-6\" style='padding-left: 0px !important; padding-top: 0px !important;'>";
            //12
            $contentFormat .= "<div class=\"col-xs-12\" style='padding-left: 0px !important; padding-top: 0px !important;'>";
            foreach ($prodTenant as $index => $Prodrow) {
                $contentFormat .= "<div class=\"col-md-3 product-grid\">
                <div class=\"productdialog\" data-id=" . $Prodrow->PRD_PRDCD . ">";
                if ($Prodrow->url_pic_prod != null) {
                    $contentFormat .= "<img src=" . $Prodrow->url_pic_prod . " class=\"img - responsive imgbox\" height=\"80%\" width=\"80%\">";
                } else {
                    $contentFormat .= "<img src=\"" . url('img/noimage.png') . "\" class=\"img-responsive imgbox\" height=\"80%\" width=\"80%\">";
                }
                $contentFormat .= "
                        <div class=\"producttitle\" style=\"font-size: x-small !important; font-weight: bold; min-height: 50px; text-align: center\">" . $Prodrow->PRD_DESKRIPSIPANJANG . "</div>
                        <div class=\"productprice\">
                            <div class=\"pricetext\" style=\"font-size: x-small !important;  text-align: center; color:#3075f1 ; font-weight: bold\">HARGA NORMAL : Rp. " . $Prodrow->PRD_HRGJUAL . "</div>
                        </div>";
                if($typeuserid == 1){
                    $contentFormat .= "<div class=\"productprice\">
                                            <div class=\"pricetext\" style=\"font-size: x-small !important;  text-align: center; color:#ee802f ; font-weight: bold\">HARGA KONTRAK : -</div>
                                        </div>";
                }

                $contentFormat .= "
                    </div>
                </div>";
            }
//            $contentFormat .= " </div>";

//            $contentFormat .= "<div class=\"col-xs-12\" style='padding-left: 0px !important; padding-top: 0px !important;'>";
            $contentFormat .= "<table style='height: 100%; width: 100%;' class=\"table table-bordered kigr-hover\">";
            $contentFormat .= "<tbody>";
            $contentFormat .= "<tr>";
//            $contentFormat .= "<td width='20%' rowspan='2'><img width='100%' src=" . $Divrow->banner . "></td>";
            $contentFormat .= "<td ><a href='" . url('product') . "'><img width='100%' src='https://img10.jd.id/Indonesia/s97x47_/nHBfsgAABwAAAAIACdbaPwAAQS8.jpg!q80'></a></td>";
            $contentFormat .= "<td><a href='" . url('product') . "'><img width='100%' src='https://img10.jd.id/Indonesia/s97x47_/nHBfsgAABwAAAAIACdbaPwAAQS8.jpg!q80'></a></td>";
            $contentFormat .= "<td><a href='" . url('product') . "'><img width='100%' src='https://img10.jd.id/Indonesia/s97x47_/nHBfsgAABwAAAAIACdbaPwAAQS8.jpg!q80'></a></td>";
            $contentFormat .= "<td><a href='" . url('product') . "'><img width='100%' src='https://img10.jd.id/Indonesia/s97x47_/nHBfsgAABwAAAAIACdbaPwAAQS8.jpg!q80'></a></td>";
            $contentFormat .= "<td><a href='" . url('product') . "'><img width='100%' src='https://img10.jd.id/Indonesia/s97x47_/nHBfsgAABwAAAAIACdbaPwAAQS8.jpg!q80'></a></td>";
            $contentFormat .= "<td><a href='" . url('product') . "'><img width='100%' src='https://img10.jd.id/Indonesia/s97x47_/nHBfsgAABwAAAAIACdbaPwAAQS8.jpg!q80'></a></td>";
            $contentFormat .= "</tr>";
            $contentFormat .= "</tbody>";
            $contentFormat .= "</table>";
            $contentFormat .= " </div>";

            $contentFormat .= "</div>";
            $contentFormat .= "<div style=\"background-color: " . $Divrow->color . "; min-height: 2px; margin-top='0 !important'; margin-bottom: '0'\" class=\"col-xs-12\"></div>";
            $contentFormat .= " </div>";
            $contentFormat .= "</div>";
            $contentFormat .= "</li>";

            $contentFormat .= "</div>";

        }
        $contentFormat .= "</ul>";

        return view('product.product')->with('divdeptkat', $this->getMenuDropdown())->with('elevator', $this->getElevator())->with('Banner', $this->getBanner())->with('content', $contentFormat)->with('divdeptkatmobile', $this->getMenuDropdownMobile());

    }

    public function getSection()
    {

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        if (!\Auth::guest()) {
            $SectioHeaderAssoc = SectionHeader::Distinct() ->leftJoin('section_membertype', 'section_headers.id', '=', 'section_membertype.section_id')->Where('type_id', $typeuserid)->where('period_start', '<=', Carbon::today())
                ->where('period_end', '>=', Carbon::today())->WhereNull('deleted_at')->OrderBy('priority', 'asc')->get();

        }else{
            $SectioHeaderAssoc = SectionHeader::Distinct()->leftJoin('section_membertype', 'section_headers.id', '=', 'section_membertype.section_id')->Where('type_id', 3)->WhereNull('deleted_at')->where('period_start', '<=', Carbon::today())
                ->where('period_end', '>=', Carbon::today())->OrderBy('priority', 'asc')->get();
        }


        $sect=0;
        $contentFormat = "";
        $contentFormat .= "<style>";
        $contentFormat .= "#";
        foreach ($SectioHeaderAssoc as $index => $HdrRow) {
            $sect++;
            if($sect == 1){
                $contentFormat .= "section".$sect;
            }
            else{
                $contentFormat .= ", #section".$sect;
            }
        }
        $contentFormat .= "{  position: relative; }";

        $count = count($SectioHeaderAssoc);
        $sect = 0;
        foreach ($SectioHeaderAssoc as $index => $HdrRow) {
            $sect++;
            $contentFormat .= "\n #section".$sect."{ z-index: ".$count."; }";
            $count--;
        }
        $contentFormat .= "</style>";

        $contentFormat .= "<ul class='hidden-xs'>";
        $coumt = count($SectioHeaderAssoc);
        $sect = 0;
        foreach ($SectioHeaderAssoc as $index => $HdrRow) {
            $sect++;
            $contentFormat .= "<div id=\"section".$sect."\">";
            $contentFormat .= "<div class=\"col-xs-12\" style='max-width: ; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);'>
                                  <div class=\"col-md-3 col-sm-6\" style='padding-top: 8px !important;height:100%;'>
                                      <a id=". $sect . " style=\"font-size: large !important;padding-top:37%;font-weight: bold !important; color: black; padding-left:0px;\">
                                      <img height=\"25\" width=\"25\" src='https://klikigrsim.mitraindogrosir.co.id/image/" . $HdrRow->icon . "'>&nbsp;". $HdrRow->name."</a>
                                      <i style='font-size:small !important;' class=\"fa fa-angle-double-right\"></i>
                                  </div>";
            //Loop Detail
            $SectionDetailAssoc = SectionDetail::getDetailSection($HdrRow['section_id']);

            $contentFormat .= "<div class=\"col-md-9 col-sm-6\" style='padding-right: 0px !important;padding-right: 0px;'>
                                  <ul class=\"nav nav-tabs navbar-right\">";
            foreach ($SectionDetailAssoc as $index => $DetailRow) {
                $contentFormat .= "<li><a style='border-radius: 0px;margin-right: 0px;' href=\"#tab-" . $DetailRow->id . "\" data-toggle=\"tab\">" . $DetailRow->name . "</a></li>";
            }
            $contentFormat .= "</ul></div>";
            $contentFormat .= "</div>";
//            $contentFormat .= "<div class=\"col-xs-12\" style='height:526px; width:1150px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);'>";

            $contentFormat .= "<div style='background-color: " . $HdrRow->color . "; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);min-height: 2px; margin-top='0 !important'; margin-bottom: '0 !important';  padding-left='0 !important'; padding-right='0 !important' class='col-xs-12'></div>";
            $contentFormat .= "<li class=\"breadcrumb bread-primary\" style='background-color:#FFFFFF; padding-top: 0px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);padding-bottom: 0px;border-radius: 0px;padding-left: 0px;padding-right: 0px;'>";
            $contentFormat .= "<div class=\"container-fluid\">";
            $contentFormat .= "<div class=\"row\">";
            $contentFormat .= "<div class=\"col-md-3 col-sm-6\" style=\"padding-right: 0px;padding-left: 0px;\">";

//            $prodTenant = Product::getProductTenant($Divrow['DIV_KODEDIVISI']);
//            $depAssoc = Dep::getDepByDivisi($Divrow['DIV_KODEDIVISI']);

            //Loop Banner
            $SectionBannerAssoc = SectionBanner::getBannerSection($HdrRow['section_id']);

            $contentFormat .="<div class='col-md-12' style=\"padding-left: 0px;padding-right: 0px;\">
                            <!-- Carousel
                            ================================================== -->
                            <div class='myCarousel carousel slide'>
                                <div class='carousel-inner'>
                                   ";

            foreach ($SectionBannerAssoc as $index => $BanRow) {
                if($index === 0) {
                    $tes = "active";
                }else{
                    $tes = "";
                }
                $contentFormat .= "<div class='item $tes'><a href=" . $BanRow->url . "><img class='thumbnail' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $BanRow->image . "' alt=" . $BanRow->alt_name . "></a></div>";
            }
            $contentFormat .="</div>


                            </div><!-- End Carousel -->";

//            $contentFormat .= "<div class='col-md-12 myCarousel' style='height:440px;padding-right: 0px;padding-left: 0px;'>";
//            foreach ($SectionBannerAssoc as $index => $BanRow) {
//                $contentFormat .= "<div><a href=" . $BanRow->url . "><img height='400px' width=\"100%\" src='https://klikigrsim.mitraindogrosir.co.id/image/" . $BanRow->image . "' alt=" . $BanRow->alt_name . "></a></div>";
//            }
            $contentFormat .= "</div>";
            $contentFormat .= "<div class='col-xs-12' style='background-color:" . $HdrRow->color . "; padding-left: 0px;padding-right: 0px; margin-left:0px;padding-bottom: 5px;margin-bottom: 0px;'>";

            //Loop Link
            $SectionLinkAssoc = SectionLink::getLinkSection($HdrRow['section_id']);
            foreach ($SectionLinkAssoc as $index => $LinkRow) {
                $contentFormat .= "<div style='overflow: hidden;height: 20px;' class='col-xs-6'>";
                $contentFormat .= "<a class='linkHover' href=" . $LinkRow->url . " style=\"font-size: 12px !important; color: white;\">$LinkRow->text</a>";
                $contentFormat .= "</div>";
            }
            $contentFormat .= "</div>";
            $contentFormat .= "</div>";

            $contentFormat .= "<div class=\"col-md-9 col-sm-6\" style='padding-left: 0px !important; padding-top: 0px !important;padding-right: 0px;'>";
            $contentFormat .= "<div class=\"col-xs-12\" style='padding-left: 0px !important; padding-top: 0px !important;padding-right: 0px;'>";


            // Loop item
            $contentFormat .= "<div class=\"tab-content well\" style='background-color: white; border-style: none; padding-top: 0px;padding-bottom: 0px;padding-left: 0px;padding-right: 0px;margin-bottom: 0px;' >";

            foreach ($SectionDetailAssoc as $index => $DetailRow) {
                $SectionItemAssoc = SectionItem::getItemSection($DetailRow->id);
                $detailPriority = $DetailRow->priority;
                $detailId = $DetailRow->id;
                if ($detailPriority === 1) {
                    $contentFormat .= "<div class=\"tab-pane active\" id=\"tab-$detailId\">";
                    $contentFormat .= "<div class=\"col-xs-9 product-detail\">";
                    $contentFormat .= "<div class=\"col-xs-12 product-detail\">";
                    $highlight = "";
//                    var_dump(env('URLPRODUCT'));
                    foreach ($SectionItemAssoc as $index => $Prodrow) {
                        if ($Prodrow->priority !== 7) {
                            $contentFormat .= "<div class=\"col-sm-4 product-detail\">";
                            $contentFormat .= "";
                            $contentFormat .= "<a href=" . $Prodrow->url . "><img style=\"padding:10%;\" src='https://klikigrsim.mitraindogrosir.co.id/image/" . $Prodrow->image . "' class=\"img - responsive imgbox\" height=\"219px\" width=\"100%\"></a>";
                            $contentFormat .= "</div>";
                        } else {
                            $highlight = "<a href=" . $Prodrow->url . "><img class='col-xs-12' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $Prodrow->image . "' class=\"img_banner_kanan - responsive imgbox\"  style='padding-left:0; padding-right:0px;' ></a>";
                        }

                    }
                    $contentFormat .= "</div>";
                    $contentFormat .= "</div>";
                    $contentFormat .= "<div class=\"col-xs-3 item\" style=\"padding-left:0px; padding-right: 0; \">";
                    $contentFormat .= $highlight;
                    $contentFormat .= "</div>";
                    $contentFormat .= "</div>";
                } else {
                    $contentFormat .= "<div class=\"tab-pane\" id=\"tab-$detailId\">";
                    $contentFormat .= "<div class=\"col-xs-12 product-detail\">";
                    foreach ($SectionItemAssoc as $index => $Prodrow) {
                        $contentFormat .= "<div class=\"col-sm-3 product-detail\">";
                        $contentFormat .= "<a href=" . $Prodrow->url . "><img src='https://klikigrsim.mitraindogrosir.co.id/image/" . $Prodrow->image . "' class=\"img - responsive imgbox\" style='padding:10%;' height=\"219px\" width=\"100%\"></a>";
                        $contentFormat .= "</div>";
                    }
                    $contentFormat .= "</div>";
                    $contentFormat .= "</div>";
                }
            }
            $contentFormat .= "</div>";


            //Loop Brand
            $SectionBrandAssoc = SectionBrand::getBrandSection($HdrRow['section_id']);
            $contentFormat .= "<div class='col-xs-12' style=\"padding-right: 0px;padding-left: 0px;\">";
            foreach ($SectionBrandAssoc as $index => $BrandRow) {
                $contentFormat .= "<div style='overflow: hidden; height: 100%; border-right-width: 1px;border-right-style: solid; border-right-color: antiquewhite; padding-top: 5px;padding-bottom: 5px;' class='col-sm-2'>";
                $contentFormat .= "<div><a href=" . $BrandRow->url . "><img width='100%' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $BrandRow->image . "'></a></div>";
                $contentFormat .= "</div>";
            }
            $contentFormat .= " </div>";
            $contentFormat .= " </div>";

            $contentFormat .= "</div>";
//            $contentFormat .= "<div style=\"background-color: " . $HdrRow->color . "; min-height: 2px; margin-top='0 !important'; margin-bottom: '0'\" class=\"col-xs-12\"></div>";
            $contentFormat .= " </div>";
            $contentFormat .= "</div>";
            $contentFormat .= "</li>";

//            $contentFormat .= "</div>";
            $contentFormat .= "</div>";
        }
        $contentFormat .= "</ul>";


        $contentFormat .= "<div class='visible-xs col-xs-12' style=\"padding-right: 0px;padding-left: 0px; padding-top :60px;\">";
        foreach ($SectioHeaderAssoc as $index => $HdrRow) {
            $contentFormat .= "<div class=\"col-xs-12\" style='padding-top: 8px !important;height:50%;padding-bottom: 10px;padding-left: 0px;padding-right: 0px;'>

                                      <img height=\"25\" width=\"25\" src='https://klikigrsim.mitraindogrosir.co.id/image/" . $HdrRow->icon . "'>&nbsp;". $HdrRow->name."</a>
                                      <i style='font-size:small !important;' class=\"fa fa-angle-double-right\"></i>
                                  ";
            $SectionBannerAssoc = SectionBanner::getBannerSection($HdrRow['section_id']);
            $kontol = "";

            $contentFormat .= "

                        <div class='col-xs-12' style=\"padding-left: 0px;padding-right: 0px;\">
                            <!-- Carousel
                            ================================================== -->
                            <div class='myCarousel carousel slide'>
                                <div class='carousel-inner'>
                                   ";

            foreach ($SectionBannerAssoc as $index => $BanRow) {
                if($index === 0) {
                    $tes = "active";
                }else{
                    $tes = "";
                }
                $contentFormat .= "<div class='item $tes'><a href=" . $BanRow->url . "><img class='thumbnail' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $BanRow->image . "' alt=" . $BanRow->alt_name . "></a></div>";
            }
            $contentFormat .="</div>


                            </div><!-- End Carousel -->


                </div>";


            $contentFormat .= "<div class='col-xs-12' style='background-color:" . $HdrRow->color . "; padding-left: 0px;padding-right: 0px; margin-left:0px;padding-bottom: 5px;margin-bottom: 0px;'>";

            //Loop Link
            $SectionLinkAssoc = SectionLink::getLinkSection($HdrRow['section_id']);
            foreach ($SectionLinkAssoc as $index => $LinkRow) {
                $contentFormat .= "<div style='overflow: hidden;height: 20px;' class='col-xs-6'>";
                $contentFormat .= "<a class='linkHover' href=" . $LinkRow->url . " style=\"font-size: 12px !important; color: white;\">$LinkRow->text</a>";
                $contentFormat .= "</div>";
            }
            $contentFormat .= "</div>";

            $contentFormat .= "</div>";
        }

        $contentFormat .= "<div class=\"col-xs-12\" style=\"padding-right: 0px;padding-left: 0px;\">";
//            $SectionBrandAssoc = SectionBrand::getBrandSectionMobile();

        $divisiAssoc = Div::getAllDivisi();
        $contentFormat .= "<div class=\"col-sm-12\" style=\"padding-top: 10px;padding-bottom: 10px;border-bottom-width: 1px;border-bottom-style: solid; border-color: gainsboro;border-top-width: 1px;border-top-style: solid;background-color:white !important;'\"><span>Kategori Belanja &nbsp;</span><a href=''><span style='float:right;' > &nbsp;</span></a></div>";
        foreach ($divisiAssoc as $index => $DivRow) {
            $contentFormat .= "<div class=\"col-xs-3 product-grid\" style='overflow: hidden; height: 100%; border-right-width: 1px;border-right-width: 1px;border-right-style: solid; border-bottom-width: 2px;border-bottom-style: solid; border-bottom-color: antiquewhite; border-right-color: antiquewhite; padding-top: 5px;padding-bottom: 5px;'>";
            $contentFormat .= "<div style=\"text-align:center !important;padding-top: 15px;padding-bottom: 15px;\"><a href=" . url("list/" . $DivRow->id) . "><img width='60%' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $DivRow->images . "'></a></div>";
            $contentFormat .= "<div class=\"producttitle\" style=\"font-size: small !important; color: black !important;min-height: 60px; text-align: center; padding-left: 10px; padding-right: 10px\">" . $DivRow->division . "</div>";
            $contentFormat .= "</div>";
        }
        $contentFormat .= "</div>";
        $contentFormat .= " </div>";


        $contentFormat .= "<div class=\"visible-xs col-xs-12\" style=\"padding-right: 0px;padding-left: 0px;padding-top: 10px;\">";
//            $SectionBrandAssoc = SectionBrand::getBrandSectionMobile();

        $SectionBrandAssoc = SectionBrand::Distinct()->OrderBy('priority', 'asc')->take(9)->get();
        $contentFormat .= "<div class=\"col-xs-12\" style=\"padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: gainsboro;\"><span>FEATURED BRAND &nbsp;</span><a class='branddialog'><span style='float:right;' >Lihat Semua &nbsp;</span></a></div>";
        foreach ($SectionBrandAssoc as $index => $BrandRow) {
            $contentFormat .= "<div class='col-xs-4' style='overflow: hidden; height: 100%; border-right-width: 1px;border-right-width: 1px;border-right-style: solid; border-bottom-width: 2px;border-bottom-style: solid; border-bottom-color: antiquewhite; border-right-color: antiquewhite; padding-top: 5px;padding-bottom: 5px;background-color:white !important;'>";
            $contentFormat .= "<div><a href=" . $BrandRow->url . "><img width='100%' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $BrandRow->image . "'></a></div>";
            $contentFormat .= "</div>";
        }
        $contentFormat .= "</div>";
        $contentFormat .= " </div>";
        $contentFormat .= "</div>";

        return view('product.product')->with('divdeptkat', $this->getMenuDropdown())->with('elevator', $this->getElevator())->with('Banner', $this->getBanner())->with('content', $contentFormat)->with('divdeptkatmobile', $this->getMenuDropdownMobile())->with('categoryicon', $this->getCategoryIcon())->with('sectionheader', $this->getSectionHeader())->with('sectionbanner', $this->getSectionBanner())->with('BannerMobile', $this->getBannerMobile());
    }

    public function getSectionHeader(){
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        if (!\Auth::guest()) {
            $SectioHeaderAssoc = SectionHeader::Distinct() ->leftJoin('section_membertype', 'section_headers.id', '=', 'section_membertype.section_id')->Where('type_id', $typeuserid)->where('period_start', '<=', Carbon::today())
                ->where('period_end', '>=', Carbon::today())->WhereNull('deleted_at')->OrderBy('priority', 'asc')->get();

        }else{
            $SectioHeaderAssoc = SectionHeader::Distinct()->leftJoin('section_membertype', 'section_headers.id', '=', 'section_membertype.section_id')->Where('type_id', 3)->WhereNull('deleted_at')->where('period_start', '<=', Carbon::today())
                ->where('period_end', '>=', Carbon::today())->OrderBy('priority', 'asc')->get();
        }

        return $SectioHeaderAssoc;

    }

    public function getSectionBanner(){

        $SectioBannerAssoc = SectionBanner::Distinct()->OrderBy('priority', 'asc')->get();

        return $SectioBannerAssoc;
    }

    public function getCategoryIcon()
    {
        $Categoryicon = Divisi::Distinct()->whereNull('deleted_at')->OrderBy('priority', 'asc')->take(8)->get();
        return $Categoryicon;
    }

    public function getBrandSection()
    {
        $contentFormat = "";
        $SectionBrandAssoc = SectionBrand::Distinct()->OrderBy('priority', 'asc')->get();
//        $contentFormat = "<div class=\"col-sm-12\" style=\"padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: gainsboro;\"><span>FEATURED BRAND &nbsp;</span><a href=''><span style='float:right;' >Lihat Semua &nbsp;</span></a></div>";
        foreach ($SectionBrandAssoc as $index => $BrandRow) {
            $contentFormat .= "<div class='col-xs-4' style='overflow: hidden; height: 100%; border-right-width: 1px;border-right-width: 1px;border-right-style: solid; border-bottom-width: 2px;border-bottom-style: solid; border-bottom-color: antiquewhite; border-right-color: antiquewhite; padding-top: 5px;padding-bottom: 5px;'>";
            $contentFormat .= "<div><a href=" . $BrandRow->url . "><img width='100%' src='https://klikigrsim.mitraindogrosir.co.id/image/" . $BrandRow->image . "'></a></div>";
            $contentFormat .= "</div>";
        }
        return $contentFormat;
    }

    public function getProductInfo(Request $Request)
    {
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }

        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }


        $PLU = substr($Request->get('prdcd'), 0, 6) . "0";
        $prodDetails = Product::getProductDetails($PLU);
        if ($Request->ajax()) {
            $htmlFormat = "";
            $plu = \DB::table('products')->select('url_pic_prod', 'long_description')->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

            })->Where('prdcd', $PLU)->Where('kode_igr', $kodecabang)->first();


            $countPic = \DB::table('products')->select('url_pic_prod')->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
            })->Where('prdcd', $PLU)->Where('kode_igr', $kodecabang)->Where('url_pic_prod', '<>', 'null')->Count();


            $htmlFormat .= "<div class='row'>";
//            $htmlFormat .= "<div class='col-md-12' style='font-size: 30px; text-align: left; font-weight: bold; margin-bottom: 10px;'><span>" . $plu->long_description . "</span></div>";
            if ($plu != null) {
                $htmlFormat .= "<div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; ' class='col-md-4'><img id='imgzoom' style='padding:5%;' src='" . $plu->url_pic_prod . "'/></div>";
            } else {
                $htmlFormat .= "<div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;background-color: white; padding-left: 0;padding-right: 0; ' class='col-md-4'><img style='padding:5%;' src='" . url('img/noimage.png') . "'/></div>";
            }

            $htmlFormat .= "<div class='col-md-8' style='font-size: 30px; text-align: center; font-weight: bold;'>";

            $htmlFormat .= "<div style=\"border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: left; background-color: white;padding-left: 20px;padding-right: 0; padding-top: 20px;padding-bottom: 20px;\">";
            $hrg = array();
            foreach ($prodDetails as $index => $row) {
                array_push($hrg, $row['hrg_jual']/$row['frac']);
                if($row['price']!=0){array_push($hrg, $row['price']);}
                if($row['prmd_hrgjual']/$row['frac']!=0){array_push($hrg, $row['prmd_hrgjual']/$row['frac']);}
//                if($row['prmd_hrgjual']!=0){array_push($hrg, $row['prmd_hrgjual']);}
//                if($row['prmd_hrgjual']!=0 && $row['price']!=0){array_push($hrg,$row['price']);}
            }

            if($row['price']!=0){
                $hrg= $row['price'];
            }else{
                $hrg = min($hrg);
            }

            $htmlFormat .= "<div class='productprice'>
                       <span style='font-size: small !important'>Harga Termurah : </span><span style='font-size: xx-large !important;'>Rp. " . number_format($hrg, 0, ',', '.') . "</span>
                        </div>";

            $htmlFormat .="</div>";

            $htmlFormat .="<div class='col-xs-12' style='border-width:0px; border-style:solid; border-color:whitesmoke;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 2px;background-color: white;padding-bottom: 0px;margin-top: 10px;margin-bottom: 10px;'>";
            foreach ($prodDetails as $index => $row) {
                $htmlFormat .= "<div class='col-md-12 content' onclick='getQty(" . $row['min_jual'] . ")' style='margin-top: 10px;margin-bottom:10px; text-align: left'>";
                $hrg = $row['hrg_jual'];
                if($row['price']!=0){$hrg = $row['price'];}
                $perPcs = "Rp." . number_format($hrg / $row['frac'], 0, ",", ".") . "";
                if ($row['flagpromomd'] == "1") {
                    $hrgDisc = $row['prmd_hrgjual'];
                    if($row['price']!=0){$hrgDisc = $row['price'];}
                    $perPcs = "Rp." . number_format($hrgDisc / $row['frac'], 0, ",", ".") . "";
                    $hrgDisc = ($row['hrg_jual'] - $hrgDisc) / $row['frac'];
                }
                $htmlFormat .= "<input id='test1' type='radio' name='radioplu'";
                if($index === 0){
                    $htmlFormat .= " CHECKED ";
                }
                $htmlFormat .= " value='" . $row['prdcd'] . "'/><a class='kigr-hover' style='padding-left:10px; color:black; font-size : 14px !important'>" . $row['unit'] . " - ";

//                $htmlFormat .= "<input id='test1' type='radio' name='radioplu'  value='" . $row['prdcd'] . "'/><a class='kigr-hover' style='padding-left:10px; color:black'>" . $row['unit'] . " - ";

                if ($row['flagpromomd'] == "1" && $hrgDisc > 0) {
                    if($row['price']== 0) {
                        $htmlFormat .= "Rp. " . number_format($row['prmd_hrgjual'], 0, ",", ".") . " <i style='text-decoration: line-through;'>Rp. " . number_format($hrg, 0, ",", ".") . "</i>( Potongan Harga Rp. " . number_format($hrgDisc, 0, ",", ".") . " Per Pcs) ";

//                        $htmlFormat .= "<i style='text-decoration: line-through;'>Rp. " . number_format($hrg, 0, ",", ".") . "</i> ( Potongan Harga Rp. " . number_format($hrgDisc, 0, ",", ".") . " Per Pcs) ";
                    }
                    } else {
                    $htmlFormat .= "Rp. " . number_format($hrg, 0, ",", ".");
                }
                $htmlFormat .= " / Isi " . $row['frac'] . " (" . $perPcs . " Per Pcs) ";
                if ($row['min_jual'] > 1) {
                    $htmlFormat .= "Min. Beli :  " . $row['min_jual'];
                }
                $htmlFormat .= "</a></div>";
            }
            $htmlFormat .="</div>";

            $htmlFormat .= "<div class='col-xs-12' style='margin-top: 0px; border-width:0px; border-style:solid; border-color:whitesmoke;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 2px;background-color: white;padding-bottom: 0px;'>";
            $htmlFormat .= " <div class=\"col-md-4\"><div class=\"form-group\" style=\"padding-top: 12px;border-right-width: 1px;border-right-style: solid;padding-right: 20px;border-color: gainsboro;\"><input class='form-control QTYSELECT after' id=\"getqty\" type=\"number\" value=\"1\" min=\"1\" max=\"100\" /></div></div>";

            if (\Auth::guest()) {
                $htmlFormat .= "<div class='col-md-8 logindialog' data-toggle=\"modal\" data-target=\"#modalLogin\"><button class='btn btn-danger flat' style='height: 100%; width: 75%; margin-top: 10px;'><i class='fa fa-shopping-cart'></i>&nbsp; BELI SEKARANG</button>
                </div><script>$(function()
                            {
                                $('.logindialog').click(function(){
                                  $('#myModal').modal('hide');
                                });
                            });
                            </script>";
            } else {
                $htmlFormat .= "<div class='col-md-8 btnsubmit'><button class='btn btn-danger flat' style='height: 100%; width: 75%; margin-top: 10px;'><i class='fa fa-shopping-cart'></i>&nbsp; BELI SEKARANG</button>
                            <script>$(function()
                            {
                              $('.btnsubmit').on('click',function()
                              {
                                $(this).val('Please wait ...')
                                  .attr('disabled','disabled');
                                addToCart(1);
                              });
                            });
                            </script>
                            </div>";
            }
            $htmlFormat .= "</div>";
            if($typeuserid == 2) {  
                $htmlFormat .= "<div>
                                <span class='font-14' style='float: left; color:red; padding-top: 10px;'><b><strong>* Promo Potongan Langsung dapat dilihat pada Keranjang Belanja Anda</strong></b></span>
                            </div>";
            }
            $htmlFormat .= "</div>";



            return $htmlFormat;
        }
    }

    public function getDetailProduct2(Request $Request, $PLU = '%'){

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }

        if ($PLU == "" || $PLU == null || $PLU == 0) {
            $PLU = "%";
        }

        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

//        $OptAddress = Address::getOptAddress();

        $prodDetails = Product::getProductDetails($PLU);
        $prodviewDetails = ProductView::getProductViewDetails($PLU);
        $prodviewDetailsDesc = ProductView::getProductViewDetailsGramasi($PLU);


        $htmlFormat = "";
        $plu = \DB::table('products')->select('url_pic_prod', 'long_description', 'hrg_jual')->leftJoin('ms_picture_productnew', function ($join) {
            $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//            $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

        })->Where('prdcd', $PLU)->Where('kode_igr', $kodecabang)->first();


        $countPic = \DB::table('products')->select('url_pic_prod')->leftJoin('ms_picture_productnew', function ($join) {
            $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//            $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
        })->Where('prdcd', $PLU)->Where('kode_igr', $kodecabang)->Where('url_pic_prod', '<>', 'null')->Count();

        $stockplu = \DB::table('tbmaster_stock')->distinct()
            ->Where('st_prdcd', $PLU)->Where('st_kodeigr', $kodecabang)
            ->Pluck('st_saldoakhir');


        if($plu != null){
            $htmlFormat .= "<div class='col-md-12' style='font-size: 30px; text-align: left; font-weight: bold; margin-bottom: 10px;'><span>" . $plu->long_description . "</span></div>";
            if ($countPic != 0) {
                $htmlFormat .= "<div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; ' class='col-md-4'><img id='imgzoom' style='padding:5%;' src='" . $plu->url_pic_prod . "'/></div>";
            } else {
                $htmlFormat .= "<div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;background-color: white; padding-left: 0;padding-right: 0; ' class='col-md-4'><img style='padding:5%;' src='" . url('../resources/assets/img/noimage.png') . "'/></div>";
            }
            $htmlFormat .= "<div class='col-md-8' style='font-size: 30px; text-align: center; font-weight: bold;'>";

            $htmlFormat .= "<div style=\"border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: left; background-color: white;padding-left: 20px;padding-right: 0; padding-top: 20px;padding-bottom: 20px;\">";
            $hrg = array();
            $fracmax = array();
            foreach ($prodDetails as $index => $row) {
                array_push($hrg, $row['hrg_jual']/$row['frac']);
                if($row['price']!=0){array_push($hrg, $row['price']);}
                if($row['prmd_hrgjual']!=0){
                    array_push($hrg, $row['prmd_hrgjual']/$row['frac']);
                }
                array_push($fracmax, $row['frac']);
            }

//            $fracmax = array();
//            array_push($fracmax, $row['frac']);


            $maxfrac = max($fracmax);



            if($row['price']!=0){
                $hrg= $row['price'];
            }else{
                $hrg = min($hrg);
            }


            $htmlFormat .= "<div class='productprice'>
                       <span style='font-size: small !important'>Harga Termurah : </span><span style='font-size: xx-large !important;color: #F7931E'>Rp. " . number_format($hrg, 0, ',', '.') . "</span>
                        </div>";

            $htmlFormat .="</div>";

            $htmlFormat .="<div class='col-md-12' style='border-width:0px; border-style:solid; border-color:whitesmoke;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 2px;background-color: white;padding-bottom: 0px;margin-top: 10px;margin-bottom: 10px;'>";
            foreach ($prodDetails as $index => $row) {
                $htmlFormat .= "<div class='col-md-12 content' onclick='getQty(" . $row['min_jual'] . ")'  style='margin-top: 10px;margin-bottom:10px; text-align: left'>";
                $hrg = $row['hrg_jual'];
                if($row['price']!=0){$hrg = $row['price'];}
                $perPcs = "Rp." . number_format($hrg / $row['frac'], 0, ",", ".") . "";
                if ($row['flagpromomd'] == "1") {
                    $hrgDisc = $row['prmd_hrgjual'];
                    if($row['price']!=0){$hrgDisc = $row['price'];}
                    $perPcs = "Rp." . number_format($hrgDisc / $row['frac'], 0, ",", ".") . "";
                    $hrgDisc = ($row['hrg_jual'] - $hrgDisc) / $row['frac'];
                }
                $htmlFormat .= "<input type='radio' name='radioplu'";
                if($index === 0){
                    $htmlFormat .= " CHECKED ";
                }
                $htmlFormat .= " value='" . $row['prdcd'] . "'/><a class='kigr-hover' style='padding-left:10px; color:black; font-size : 14px !important'>" . $row['unit'] . " - ";

                if ($row['flagpromomd'] == "1" && $hrgDisc > 0) {
                    if($row['price']== 0){
                        $htmlFormat .= "Rp. " . number_format($row['prmd_hrgjual'], 0, ",", ".") . " <i style='text-decoration: line-through;'>Rp. " . number_format($hrg, 0, ",", ".") . "</i>( Potongan Harga Rp. " . number_format($hrgDisc, 0, ",", ".") . " Per Pcs) ";
                    }
                } else {
                    $htmlFormat .= "Rp. " . number_format($hrg, 0, ",", ".");
                }
                $htmlFormat .= " / Isi " . $row['frac'] . " (" . $perPcs . " Per Pcs) ";
                if ($row['min_jual'] > 1) {
                    $htmlFormat .= "Min. Beli :  " . $row['min_jual'];
                }
                $htmlFormat .= "Stok :  " . $row['qty'];
                $htmlFormat .= "</a></div>";
            }
            $htmlFormat .="</div>";

            $htmlFormat .= "<div id='validateQty' class='col-md-12'></div>";
            $htmlFormat .= "<div class='col-md-12' style='margin-top: 0px; border-width:0px; border-style:solid; border-color:whitesmoke;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 2px;background-color: white;padding-bottom: 0px;'>";
            $htmlFormat .= " <div class=\"col-md-4\"><div class=\"form-group\" style=\"padding-top: 12px;border-right-width: 1px;border-right-style: solid;padding-right: 20px;border-color: gainsboro;\"><input class='form-control QTYSELECT after' id=\"getqty\" type=\"number\" value=\"1\" min=\"1\" max=\"100\" /></div></div>";
            if (\Auth::guest()) {
                if($stockplu < $maxfrac){
                    $htmlFormat .= "<div class='col-md-4' style=\"border-right-width: 1px;border-right-style: solid;padding-right: 20px;border-color: gainsboro;margin-top: 15px\"><span style='margin-top: 10px;color:red;font-size: large !important;'>&nbsp; Stok Kosong</span>
                            </div>";
                }else{
                    $htmlFormat .= "<div class='col-md-4' data-toggle=\"modal\" data-target=\"#modalLogin\"><button class='btn btn-danger flat' style='height: 100%; width: 200px; margin-top: 10px;'><i class='fa fa-briefcase'></i>&nbsp; TAMBAH KERANJANG</button>
                </div><script>$(function()
                            {
                                $('.logindialog').click(function(){
                                  $('#myModal').modal('hide');
                                });
                            });
                            </script>";
                    $htmlFormat .= "<div class='col-md-4' data-toggle=\"modal\" data-target=\"#modalLogin\"><button class='btn btn-primary flat' style='height: 100%; width: 200px; margin-top: 10px;'><i class='fa fa-shopping-cart'></i>&nbsp; BELI SEKARANG</button>
                            </div>";
                }

            } else {
                if($stockplu < $maxfrac){
                    $htmlFormat .= "<div class='col-md-4' style=\"border-right-width: 1px;border-right-style: solid;padding-right: 20px;border-color: gainsboro;margin-top: 15px\"><span style='margin-top: 10px;color:red;font-size: large !important;'>&nbsp; Stok Kosong</span>
                            </div>";
                }else{
                    $htmlFormat .= "<div class='col-md-4' style=\"border-right-width: 1px;border-right-style: solid;padding-right: 20px;border-color: gainsboro;\"><button class='btn btn-danger flat ' onclick='addToCart(1)' style='height: 100%; width: 200px; margin-top: 10px;'><i class='fa fa-briefcase'></i>&nbsp; TAMBAH KERANJANG</button>
                            </div>";
                    $htmlFormat .= "<div class='col-md-4'><a id='coba' class='btn btn-primary flat' onclick='addToCart(0)' style='height: 100%; width: 200px; margin-top: 10px;'><i class='fa fa-shopping-cart'></i>&nbsp; BELI SEKARANG</a>
                            </div>";
                }

//            $htmlFormat .= "<div class='col-md-4'><a id='coba' class='btn btn-default flat' onclick='addToCart(0)' style='height: 100%; width: 200px; margin-top: 10px;border-left-width: 00px;border-top-width: 0px;border-right-width: 0px;border-bottom-width: 0px;'><i class='fa fa-heart'></i>&nbsp; Tambahkan ke Wishlist</a>
//                            </div>";
            }

//        $htmlFormat .= "<div class='col-md-8' data-toggle=\"modal\" data-target=\"#modalLogin\"><button class='btn btn-danger flat' style='height: 100%; width: 283px; margin-top: 10px;'><i class='fa fa-shopping-cart'></i>&nbsp; BELI SEKARANG</button></div>";

            $htmlFormat .= "</div>";

            $htmlFormat .= "</div>";

            $htmlFormat .= "<div class='col-lg-12' style='margin-top: 10px;padding-left: 0px;padding-right: 0px;'>";


            $htmlFormat .= "
        <div class=\"container\" style='padding-left: 0px;'>

        <div class=\"col-md-12\" style='padding-left: 0; padding-right: 0;'>
                    <div class=\"tabbable-line\">
                        <ul class=\"nav nav-tabs \">";

            $htmlFormat .= "<li class=\"active\" style='border-bottom: 0px;'>
                                <a href=\"#tab_default_1\" data-toggle=\"tab\" style='color: white;background-color: #D9534F;'>
                                    Spesifikasi </a>
                            </li>";

            if(count($prodviewDetails) > 0) {
                $htmlFormat .= "<li style='border-bottom: 0px;'>
                                <a href=\".tab_default_2\" data-toggle=\"tab\" style='color: white; background-color: #D9534F;'>
                                    Deskripsi Produk </a>
                            </li>";
            }

            $htmlFormat .= "</ul>";
            $htmlFormat .= "<div class=\"tab-content\" style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: left; background-color: white;padding-left: 0;padding-right: 0;'>";
            foreach ($prodviewDetails as $index => $row) {
                $htmlFormat .= "<div class=\"tab-pane tab_default_2\" style=\"padding-left: 15px;padding-right: 15px;padding-top: 15px;padding-bottom: 15px;\"'>";
                $htmlFormat .= "<div class='container'>";
                $htmlFormat .= "<p style=\"padding-right: 30px;\">
                                     <b>" . $row['nama_field'] . "</b><br/>" . $row['deskripsi'] . "
                                     </p>";
                $htmlFormat .= "</div>";
                $htmlFormat .= "</div>";
            }

            foreach ($prodviewDetailsDesc as $index => $row) {
                $htmlFormat .= "
                            <div class=\"tab-pane active\" id=\"tab_default_1\">
                               <div class='container' style='padding-right: 30px;'>
                                <table class='table'>
                                    <tbody>
                                     <tr class='danger'>
                                                <td>Unit</td>
                                                <td>" . $row['unit'] . "&nbsp;</td>
                                        </tr>";
                if(substr($row['prdcd'], -1) == 0){
                    $htmlFormat .= "<tr class=''>
                                                                <td>Berat</td>
                                                                <td>" . round($row['brg_brutoctn']) . "&nbsp; gram</td>
                                                        </tr>";
                }else{
                    $htmlFormat .= "<tr class=''>
                                                                <td>Berat</td>
                                                                <td>" . round($row['brg_brutopcs']) . "&nbsp; gram</td>
                                                        </tr>";
                }
                $htmlFormat .= "<tr class='danger'>
                                                <td>Dimensi Panjang</td>
                                                <td>" . $row['length'] . "&nbsp; cm</td>
                                        </tr>
                                         <tr>
                                                <td>Dimensi Lebar</td>
                                                <td>" . $row['width'] . "&nbsp; cm</td>
                                        </tr>
                                           <tr class='danger'>
                                                <td>Dimensi Tinggi</td>
                                                <td>" . $row['height'] . "&nbsp; cm</td>
                                        </tr>";
//                                        if($row->brg_ukuran != null){
//                                        $htmlFormat .= "<tr class='danger'>
//                                                            <td>Ukuran</td>
//                                                            <td>" . $row['brg_ukuran'] . "</td>
//                                                        </tr>";
//                                        }

                if($row->brg_merk != null){
                    $htmlFormat .= " <tr>
                                                                <td>Merk</td>
                                                                <td>" . $row['brg_merk'] . "</td>
                                                            </tr>";
                }

                if($row->brg_flavor != null){
                    $htmlFormat .= " <tr class='danger'>
                                                                        <td>Varian</td>
                                                                        <td>" . $row['brg_flavor'] . "</td>
                                                            </tr>";
                }
                $htmlFormat .= "</tbody>
                                    </table>
                                </div>
                            </div>";
            }
            $htmlFormat .= "
                         </div>
                        </div>
                    </div>
        </div>
    </div>";

            return view('product.detailproduct')->with('divdeptkat', $this->getMenuDropdown())->with('detailproduct', $htmlFormat)->with('divdeptkatmobile', $this->getMenuDropdownMobile());
        }else{
            $htmlFormat .= "<div class='col-md-10 col-md-offset-5'>
            <img class='col-lg-2' style='float: left' width='100px' src='" . url('../resources/assets/img/alert.png') . "'/></div>
            <div class='col-md-12 col-md-offset-0' style='margin-top: 10px; margin-bottom: 10px; text-align: center;'>
                <h2 style='margin-bottom: 10px;'>Barang tidak tersedia di Indogrosir Anda</h2>
                <h2 style='margin-bottom: 10px; margin-top: 10px;'>Silakan lakukan belanja kembali</h2>
            </div>
             <div class='col-md-10 col-md-offset-5' style='margin-top: 25px; padding-right: 10px;'><a href='" . url('/product') . "' class=\"btn btn-primary flat\">Lanjutkan Belanja</a></div>
            ";

            return view('product.detailproduct')->with('divdeptkat', $this->getMenuDropdown())->with('detailproduct', $htmlFormat)->with('divdeptkatmobile', $this->getMenuDropdownMobile());
        }




    }

    public function getDetailProduct(Request $Request, $PLU = '%'){
        if ($PLU == "" || $PLU == null || $PLU == 0) {
            $PLU = "%";
        }

        $prodDetails = Product::getProductDetails($PLU);
        $htmlFormat = "";

        try {
            $plu = \DB::table('products')->select('url_pic_prod', 'long_description')->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

            })->Where('prdcd', $PLU)->Where('kode_igr', 18)->first();
        }catch(\Exception $ex){
            return "Non Desc";
        }

        $countPic = \DB::table('products')->select('url_pic_prod')->leftJoin('ms_picture_productnew', function ($join) {
            $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//            $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
        })->Where('prdcd', $PLU)->Where('kode_igr', 18)->Where('url_pic_prod', '<>', 'null')->Count();

        $htmlFormat .= "<div class='row'><div style='float:none'>";
        $htmlFormat .= "<div class='col-md-12' style='font-size: 30px; text-align: left; font-weight: bold; margin-bottom: 10px;'><span>" . $plu->long_description . "</span></div>";
//        $htmlFormat .= "<div class='container' style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);'>";
        if ($countPic != 0) {
            $htmlFormat .= "<div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; ' class='col-md-4'><img id='imgzoom' style='padding:0%;' src='" . $plu->url_pic_prod . "'/></div>";
        } else {
            $htmlFormat .= "<div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;background-color: white; padding-left: 0;padding-right: 0; ' class='col-md-4'><img style='padding:5%;' src='" . url('img/noimage.png') . "'/></div>";
        }
//            $htmlFormat .="<div style='border-width:1px;border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;' class='col-md-4'><img src='" . $plu->url_pic_prod . "'/></div>";

        $htmlFormat .= "<div class='col-md-8' style='font-size: 30px; text-align: center; font-weight: bold;'>";

        $htmlFormat .= "<div class='col-md-12' style='margin-top: 0px; border-width:0px; border-style:solid; border-color:whitesmoke;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 2px;background-color: white;padding-bottom: 105px;'>";

        foreach ($prodDetails as $index => $row) {
            $htmlFormat .= "<div  class='col-md-8' style='margin-top: 20px;text-align: left'>";
            $hrg = $row['hrg_jual'];
            if($row['price']!=0){$hrg = $row['price'];}
            $perPcs = "Rp." . number_format($hrg / $row['frac'], 0, ",", ".") . "";
                if ($row['flagpromomd'] == "1") {
                    $hrgDisc = $row['prmd_hrgjual'];
                    $perPcs = "Rp." . number_format($hrgDisc / $row['frac'], 0, ",", ".") . "";
                    $hrgDisc = ($row['hrg_jual'] - $row['prmd_hrgjual']) / $row['frac'];
                }
            $htmlFormat .= "<input type='hidden' class=\"PLUArray\" name=\"PLUArray[]\" value='" . $row['prdcd'] . "'/>" . $row['unit'] . " - ";
                if ($row['flagpromomd'] == "1" && $hrgDisc > 0) {
                    $htmlFormat .= "<i style='text-decoration: line-through;'>Rp. " . number_format($hrg, 0, ",", ".") . "</i> ( Potongan Harga Rp. " . number_format($hrgDisc, 0, ",", ".") . " Per Pcs) ";
                } else {
            $htmlFormat .= "Rp. " . number_format($hrg, 0, ",", ".");
                }
            $htmlFormat .= " / Isi " . $row['frac'] . " (" . $perPcs . " Per Pcs) ";
            if ($row['min_jual'] > 1) {
                $htmlFormat .= "Min. Beli :  " . $row['min_jual'];
            }
            $htmlFormat .= "</div>";

            $htmlFormat .= "<div class='input-group input-group-sm col-md-2 col-md-offset-4' style='text-align: right;margin-top: 20px;'>
                                    <input type='number' min='0' max='999999' class='QTYArray' name=\"QTYArray[]\" class='form-control' placeholder='Qty'/>
                                </div>";
        }


        $htmlFormat .= "</div>";

        if (\Auth::guest()) {
            $htmlFormat .= "<div class='col-md-12' data-toggle=\"modal\" data-target=\"#modalLogin\" style='margin-top: 20px;'><button class='btn btn-danger flat' style='height: 100%; width: 283px;'><i class='fa fa-shopping-cart'></i>&nbsp; Beli</button>

                </div><script>$(function()
                            {
                                $('.logindialog').click(function(){
                                  $('#myModal').modal('hide');
                                });
                            });
                            </script>";

        } else {
            $htmlFormat .= "<div class='btnsubmit' style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;background-color: white; padding-bottom: 10px;'><button class='btn btn-danger flat' onclick='addToCart()' style='height: 100%; width: 283px; margin-top: 10px;'><i class='fa fa-shopping-cart'></i>&nbsp; Beli</button>
                            <script>$(function()
                            {
                              $('.btnsubmit').on('click',function()
                              {
                                $(this).val('Please wait ...')
                                  .attr('disabled','disabled');
                                addToCart();
                              });
                            });
                            </script>
                            </div>";
        }
//        $htmlFormat .= "</div>";
        $htmlFormat .= "</div>";
        $htmlFormat .= "</div>";

        $htmlFormat .= "<div class='col-lg-12' style='margin-top: 10px;padding-left: 0px;padding-right: 0px;'>";

        $htmlFormat .= "
        <div class=\"container\">
        <div class=\"row\" style='margin-left: -30px;'>
            <div class=\"col-md-12\" style='padding-left: 0; padding-right: 0;'>

                    <div class=\"tabbable-line\" style='background-color: rgb(41, 128, 185)'>
                        <ul class=\"nav nav-tabs \">
                            <li class=\"active\">
                                <a href=\"#tab_default_1\" data-toggle=\"tab\" style='color: white; padding-left: 15px;'>
                                    Deskripsi Produk </a>
                            </li>
                            <li>
                                <a href=\"#tab_default_2\" data-toggle=\"tab\" style='color: white'>
                                    Spesifikasi </a>
                            </li>
                        </ul>
                        <div class=\"tab-content\">
                            <div class=\"tab-pane active\" id=\"tab_default_1\" style='padding-left: 15px;'>
                                <p>
                                    I'm in Tab 1.
                                </p>
                                <p>
                                    Duis autem eum iriure dolor in hendrerit in vulputate velit esse molestie consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.
                                </p>
                            </div>
                            <div class=\"tab-pane\" id=\"tab_default_2\">
                               <div class='container'>
                                <table class='table'>

                                    <tbody>
                                        <tr class='danger'>
                                                <td>Material</td>
                                                <td>Polyester with velvet print</td>
                                        </tr>
                                         <tr>
                                                <td>Dimensi Produk</td>
                                                <td>10x10x10 cm</td>
                                        </tr>
                                         <tr class='danger'>
                                                <td>Berat</td>
                                                <td>200 gram</td>
                                        </tr>
                                           <tr>
                                                <td>Brand</td>
                                                <td>Jersi Clothing</td>
                                        </tr>
                                        <tr class='danger'>
                                                <td>Garansi Produk</td>
                                                <td>Garansi Seller</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

            </div>
        </div>
    </div>";
        return view('product.detailproduct')->with('divdeptkat', $this->getMenuDropdown())->with('detailproduct', $htmlFormat);
    }

    public function getListProduct(Request $request, $divisi = '%', $department = '%', $kategori = '%', $key = '%', $brand = 0, $min='%', $max='%', $sort='%')      
    {
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }


        $ord = 24;
        $sort = '%';
        $title = "Product";

        if ($divisi == "" || $divisi == null || $divisi == 0) {
            $divisi = "%";
//        }else{
//            $title = Div::find($divisi)->DIV_NAMADIVISI;
        }

        if ($department == "" || $department == null || $department == 0) {
            $department = "%";
//        }else{
//            $title = Dep::find($department)->DEP_NAMADEPARTEMENT;
        }

        if ($kategori == "" || $kategori == null || $kategori == 0) {
            $kategori = "%";
//        }else{
//            $title = Category::find($kategori)->KAT_NAMAKATEGORI;
        }

//        if (!isset($_GET['KEY']) || $_GET['KEY'] == '' || $_GET['KEY'] == null) {
//            $key = '%';
//        } else {
//            $key = $_GET['KEY'];
//        }

        if (!isset($_GET['key']) || $_GET['key'] == '' || $_GET['key'] == null) {
            $key = '%';
        } else {
            $key = $_GET['key'];
        }
        
        if (isset($request->ord)) {
            if ($request->ord != "" || $request->ord != null) {
                $ord = $request->ord;
            }
        }

        $min = $request->get('min');
        $max = $request->get('max');

        $sort = $request->get('sort');


            $brand = $request->brand;

//        dd($brand);
            $brand = explode(',', $brand);
//        if (isset($request->brand)) {
//            if ($request->brand == "" || $request->brand == null) {
//                $merk = '%';
//            }else{
//                $merk = $request->brand;
//            }
//        }

        if ($ord < 25) {
            $ord = 25;
        } else if ($ord > 25 && $ord < 50) {
            $ord = 25;
        } else if ($ord > 50 && $ord < 100) {
            $ord = 50;
        } else if ($ord >= 100) {
            $ord = 100;
        }
        $ProdAssoc = ProductView::getAllProduct($divisi, $department, $kategori, $ord, $key, $brand, $min, $max, $sort);
        $FilterBrgAssoc = ProductView::getFilterProduk($divisi, $department, $kategori, $key, $brand);
        $RecomendProdAssoc = ProductView::getProductRecomended($divisi, $department, $kategori, $key, $brand);

        return view('product.listproduct')->with('divdeptkat', $this->getMenuDropdown())->with('ProdArray', $ProdAssoc)->with('RecProdArray', $RecomendProdAssoc)->with('title', $title)->with('typeid', $typeuserid)->with('brgMerkArray', $FilterBrgAssoc)->with('brand', $brand)->with('divdeptkatmobile', $this->getMenuDropdownMobile());
    }

    public function getListProductContract(Request $request, $key = '%', $min='%', $max='%')
    {
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }

        $ord = 24;
        $title = "Product";


        if (!isset($_GET['KEY']) || $_GET['KEY'] == '' || $_GET['KEY'] == null) {
            $key = '%';
        } else {
            $key = $_GET['KEY'];
        }

        if (isset($request->ord)) {
            if ($request->ord != "" || $request->ord != null) {
                $ord = $request->ord;
            }
        }

        $min = $request->get('min');
        $max = $request->get('max');


        if ($ord < 25) {
            $ord = 25;
        } else if ($ord > 25 && $ord < 50) {
            $ord = 25;
        } else if ($ord > 50 && $ord < 100) {
            $ord = 50;
        } else if ($ord >= 100) {
            $ord = 100;
        }

        $ProductContract = Product::getProductContract($key, $min, $max, $ord);           

        return view('product.listproductcontract')->with('divdeptkat', $this->getMenuDropdown())->with('ProdContractArray', $ProductContract)->with('divdeptkatmobile', $this->getMenuDropdownMobile());
    }

    public function validateQty($QTY, $PLU)
    {
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

    public function cekHargaMBT($cart, $PLU, $QTY)
    {
        $JumlahPerPieces = 0;

        foreach ($cart as $cIdx => $cRow) {
            if (strcasecmp(substr($cRow['PLU'], 0, 6), substr($PLU, 0, 6)) == 0) {
                $cFrac = Product::getFrac($cRow['PLU']);
                if (strcasecmp($cRow['unit'], 'KG') == 0) {
                    $JumlahPerPieces = $JumlahPerPieces + $cRow['qty'] / 1000;
                } else {
                    $JumlahPerPieces = $JumlahPerPieces + ($cRow['qty'] * $cFrac);
                }
            }
        }

        $frac = Product::getFrac($PLU);
        $prclist = Product::getListHarga(substr($PLU, 0, 6));
        foreach ($prclist as $pIdx => $pRow) {
            if (strcasecmp($pRow['unit'], 'KG') == 0) {
                if ($JumlahPerPieces >= $pRow['min_jual']) {
                    return ($pRow['hrg_jual'] / $pRow['frac']) * ($QTY * $frac);
                }
            } else {
                if ($JumlahPerPieces >= $pRow['frac'] && $JumlahPerPieces >= $pRow['min_jual']) {
                    return ($pRow['hrg_jual'] / $pRow['frac']) * ($QTY * $frac);
                }
            }
        }
    }

    public function cekHargaDiskon($PLU, $harga, $qty){
        //TODO: Buat Fungsi Cek Diskon
        $hrgPromo = Product::getHrgPromo($PLU);
        $PerPcs = $harga/$qty;
        if($hrgPromo != null && $hrgPromo != "" && $hrgPromo != 0 && $hrgPromo < $PerPcs){
            return ($PerPcs - $hrgPromo) * $qty;
        }else{
            return 0;
        }
    }

    public function getHargaDiskon($PLU)
    {
        //TODO: Buat Fungsi Cek Diskon
//        $hrgPromo = Product::getHrgPromo($PLU);
        $hrgPromo = 0;

        return $hrgPromo;
    }

    public function AddToCart(Request $Request){
        if ($Request->ajax()) {

            if(\Auth::guest()){
                $kodecabang = '18';
            }else{
                $kodecabang = Branch::getBranches();
            }

            $countcart = Cart::getcountcartall();

            if(count($countcart) >= 100 && \Auth::User()->type_id == 2){
                return "Hanya dapat membeli total maks. 100 produk dalam satu pesanan, Silahkan ubah jumlah/ hapus sebagian.";
            }else{
                $PLU = $Request->get('prdcd');
                $QTY = $Request->get('qty');

                $frac = Product::getFrac($PLU);

                $PLUs = substr($PLU, 0, 6) . "0";

                $stockplu = \DB::table('stocks')->distinct()
                    ->where('plu', $PLUs)
                    ->where('branch_id', $kodecabang)
                    ->Pluck('qty');

                $stockreserv = \DB::table('stock_reserves')->distinct()
                    ->where('plu', $PLUs)
                    ->where('kode_igr', $kodecabang)
                    ->Pluck('qty');

                if((($QTY*$frac) + $stockreserv) > $stockplu){
                    return "Stock tidak mencukupi";
                }
                $QTYErr = $this->validateQty($QTY, $PLU);
                if($QTYErr == 'OK'){
                    $UNIT = Product::getunit($PLU);
                    Cart::addCartItem($PLU, $QTY, $UNIT);
                    return 1;
                }else{
                    return $QTYErr;
                }
            }
        }
    }

    public function reloadCart()
    {
        if (\Auth::guest()) {
            return "<a style='font-size: large; color: #FFFFFF'>0</a>";
        }

        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }

        $getCartContent = Cart::Distinct()
            ->Join('ms_product_oracle', 'carts.PLU', '=', 'ms_product_oracle.prd_prdcd')
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('ms_product_oracle.prd_prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('ms_product_oracle.prd_kodeigr', '=', 'ms_picture_productnew.PIC_KODEIGR');

            })
            ->Join('addresses', 'carts.address_id', '=', 'addresses.id');
//        if($typeuserid != 1) {
//            $getCartContent = $getCartContent->Where('flag_default', 1);
//        }
        $getCartContent = $getCartContent->Where('prd_kodeigr', $kodecabang)
            ->Where('flag_default',1)
            ->whereNotIn('prd_kodetag', ['A', 'H','O','X','Z','C','N'])            
            ->Where('userid',\Auth::User()->id)
            ->OrderBy('carts.PLU')
            ->Get();

        $cFormatRaw = "";
        $count = 0;
        foreach ($getCartContent as $cIdx => $cRow) {
            $count++;
        }
        $cFormatRaw .= "<a style='font-size: large; color: #FFFFFF'>" . $count . "</a>";
        return $cFormatRaw;
    }

    public function deleteCart(Request $Request)
    {
        if ($Request->ajax()) {
            $ADDR = $Request->get('addr');
            $PLU = str_pad($Request->prdcd, 7, '0', STR_PAD_LEFT);
            $delStat = Cart::delCartItem($PLU, $ADDR);
            if ($delStat == 'OK') {
                return 1;
            } else {
                return 'Gagal Menghapus Item, Silahkan Coba Lagi';
            }
        }
    }

    public function deleteCartAll(Request $Request)
    {
        if ($Request->ajax()) {
            $delStat = Cart::delCartAll();
            if ($delStat == 'OK') {
                return 1;
            } else {
                return 'Gagal Menghapus Item, Silahkan Coba Lagi';
            }
        }
    }

    public function updateCart(Request $Request)
    {
        if ($Request->ajax()) {
            $ADDR = $Request->get('addr');
            $PLUs = $Request->get('prdcd');
            $QTY = $Request->get('qty');
            $resp = 0;
            \DB::beginTransaction();
            foreach ($PLUs as $index => $plu) {

                if ($QTY[$index] == 0) {
                    Cart::delCartItem($plu, $ADDR);
                } else {
                    $QTYErr = $this->validateQty($plu, $QTY[$index]);
                    if ($QTYErr == 'OK') {
                        $updStat = Cart::updCartItem($plu, $QTY[$index], $ADDR);
                    } else if ($QTYErr == 'Zero') {
                        //Skip
                    } else {
                        \DB::rollBack();
                        $resp = $QTYErr;
                    }
                }
                $resp = 1;
            }                
	     \DB::commit();
            return $resp;
        }
    }

    public function getCartInfo(Request $Request)
    {
        $cFormatRaw = "";

        if(\Auth::guest()){
            $cFormatRaw .= "<div class='warning'>
                                    <a style='vertical-align: middle;'><img  height='100' width='100' src='" . url('img/bag.png') . "'/></a>
                                </div>";
            $cFormatRaw .= "<div class='warning'>
                                    <a colspan='8' class='font-14' style='text-align: center'><b>Tidak ada item di Keranjang Anda</b></a>
                                 </div>";
            $cFormatRaw .= "<div class='warning' style='margin-top: 10px;'>
                                   <button  class='btn btn-warning flat' data-dismiss='modal'><i style='color:white' class='fa fa-shopping-cart'/> Lanjut Belanja</button>
                                 </div>";

            return $cFormatRaw;
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }

        if($typeuserid == 1) {
            $kodemember = \DB::table('customers')->distinct()
                ->Join('members', 'customers.id', '=', 'members.customer_id')
                ->Pluck('kode_member');
        }else{
            $kodemember = \Auth::user()->kodemember;
        }


            $branchid = \DB::table('members')
                ->Join('addresses', 'members.id', '=', 'addresses.member_id')
                ->Where('members.id', \Auth::User()->id)
                ->Where('flag_default', 1)
                ->pluck('branch_id');

        if($typeuserid == 1){
            $minimalorder = User::find(\Auth::User()->id)->minor;
            $minimaldelivery = 1000000;
        }else{
            try{
                $minimalorder = \DB::table('min_order_settings')->distinct()
                    //                    ->Join('branches', 'branches.id', '=', 'min_order_settings.branch_id')
                    ->Where('user_type_id',$typeuserid)
                    ->Where('branch_id',$branchid)
                    ->Pluck('min_pickup');

                $minimaldelivery = \DB::table('min_order_settings')->distinct()
                    //                    ->Join('branches', 'branches.id', '=', 'min_order_settings.branch_id')
                    ->Where('user_type_id',$typeuserid)
                    ->Where('branch_id',$branchid)
                    ->Pluck('min_delivery');

            }catch(\Exception $ex){
                $minimalorder = 500000;
                $minimaldelivery = 1000000;
            }

        }



        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        $cartAssoc = Cart::getCartContent();

        if(count($cartAssoc) == 0 || $cartAssoc == ""){
            $cFormatRaw .= "<div class='warning'>
                                    <a style='vertical-align: middle;'><img  height='100' width='100' src='" . url('img/bag.png') . "'/></a>
                                </div>";
            $cFormatRaw .= "<div class='warning'>
                                    <a colspan='8' class='font-14' style='text-align: center'><b>Tidak ada item di Keranjang Anda</b></a>
                                 </div>";
            $cFormatRaw .= "<div class='warning' style='margin-top: 10px;'>
                                   <button  class='btn btn-warning flat' data-dismiss='modal'><i style='color:white' class='fa fa-shopping-cart'/> Lanjut Belanja</button>
                                 </div>";

            return $cFormatRaw;
        }




        $data = "$kodecabang@$kodemember|"; 
//dd(\Auth::user()->flag_verif == 1);

        if($kodemember != "" && \Auth::user()->flag_verif == 1){
            foreach($cartAssoc as $index => $row){
                if($index > 0) {
                    $data .= "#";
                }
                else{
                    $cFormatRaw .= "<div class='warning'>
                                    <a style='vertical-align: middle;'><img  height='100' width='100' src='" . url('img/bag.png') . "'/></a>
                                </div>";
                    $cFormatRaw .= "<div class='warning'>
                                    <a colspan='8' class='font-14' style='text-align: center'><b>Tidak ada item di Keranjang Anda</b></a>
                                 </div>";
                    $cFormatRaw .= "<div class='warning' style='margin-top: 10px;'>
                                   <button  class='btn btn-warning flat' data-dismiss='modal'><i style='color:white' class='fa fa-shopping-cart'/> Lanjut Belanja</button>
                                 </div>";
                }

                $prdInfo = Product::getInfoData($row['PLU']);
                $diskon = $prdInfo->DISC;
                if(!$diskon) $diskon = 0;
                $perPcs = $prdInfo->HRG;
                $frac = $prdInfo->frac;
                $perFrac = $perPcs * $frac;
                $plu = $row['PLU'];
                $qty = $row['qty'];
                $unit = $prdInfo->unit;
                $data .= "$plu@$qty@$unit@$perFrac@$diskon";
            }


            // return $data;
            $Prodata = "s=".$data;
            $url ="http://172.31.2.119/IPW/Service1.asmx/GetPromotion";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded;')); 
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$Prodata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            $xml = new \SimpleXMLElement($response);
            $array = json_decode($xml, true);
            curl_close($ch);

        }


        if ($Request->ajax()) {
//            $CartAddress = Address::getAddress();
            if (!\Auth::guest()) {
                $typeuserid = \Auth::User()->type_id;
                $userid = \Auth::User()->id;
            }


            $CartAddress = Address::Distinct();

            if($typeuserid != 1) {
                $CartAddress = $CartAddress->Where('flag_default', 1);
            }
            $CartAddress = $CartAddress->Where('member_id',$userid)
                ->Get();


            $cFormatRaw = "";
            $total = 0;
            $count = 0;
            $tdisc = 0;
            $totalbelanja=0;
            $totalcashback = 0;
            $totgab = 0;
            $userid = \Auth::User()->id;
            $min_order = User::find($userid)->minor;
            foreach ($CartAddress as $cIdx => $aRow) {
                $cAssoc = Cart::getCartContentKat($aRow['id']);
                if (count($cAssoc) > 0) { // HITUNG CART / ALAMAT, KLO KOSONG SKIP
                    $cFormatRaw .= "<div class='row'><div class='col-xs-12 col-md-9' style='box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);'><table width='100%' style='text-align: start; border-right-color:white;padding-bottom: 0px' class='table table-striped table-condensed table-responsive cart cart" . $aRow['id'] . "' data-id='" . $aRow['id'] . "'>";
                    $cFormatRaw .= "<tr style='background-color: #2980b9'>
                                        <th width='10%' class='hidden-xs' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>No.</th>
                                        <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Gambar</th>
                                        <th width='25%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Deskripsi</th>
                                        <th width='20%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Jumlah</th>
                                        <th width='10%' class='hidden-xs' style='text-align: center;color: #FFFFFF; vertical-align: middle;'>Harga/Pcs</th>
                                        <th width='15%' class='hidden-xs' style='text-align: center;color: #FFFFFF; vertical-align: middle;'>Subtotal</th>
                                        <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Hapus</th>
                                    </tr>";

                    $cFormatRaw .= "<tr><th colspan='4' width='25%' class='font-15' style='text-align: left; color: black; vertical-align: middle;'>Alamat : " . $aRow['label'] . "</th>
                    <th class='hidden-xs' colspan='8'><label width='25%' style='float: right;' class='label label-danger flat' onclick='deleteAllCart()'><i style='color:white' class='fa fa-trash'/> Hapus Semua Keranjang</button></th>";
                    $cFormatRaw .= "</tr>";


                    if(\Auth::user()->flag_verif == 1){
                        $arrayPromosi = $array;
                    }
                    foreach ($cAssoc as $cIdx => $cRow) {
                        $minbeli = Product::getMinBeli($cRow['PLU']);
                        if($cRow['price'] == null){
                            $harga = $this->cekHargaMBT($cAssoc, $cRow['PLU'], $cRow['qty']);
                            $diskon = $this->cekHargaDiskon($cRow['PLU'], $harga, $cRow['qty']);
                        }else{
                            $harga = $cRow['price'] * $cRow['qty'];
                            $diskon = 0;
                        }
                        $tdisc = $tdisc + ($diskon);


//                        if($cRow['price']!=0){$diskon = 0;}
                        $total = $total + ($harga);
                        $count++;
                        $unit = Product::getUnit($cRow['PLU']);
                        $frac = Product::getFrac($cRow['PLU']);

                        if(\Auth::user()->flag_verif == 1){
                            $flagKenaPromo = array_search((substr($cRow['PLU'], 0, 6) . "0"), array_column($arrayPromosi, 'KD_PLU')); //RETURN-AN AGUS VS PLU CART
                        }

                        $cFormatRaw .= "<tr>
                                            <td class='hidden-xs' style='text-align: center; vertical-align: middle;'>$count</td>";

                        if ($cRow['url_pic_prod'] != null) {
                            $cFormatRaw .= "<td style='vertical-align: middle;' ><img  height='100' width='100' src='" . $cRow['url_pic_prod'] . "'/></td>";
                        } else {
                            $cFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . url('img/noimage.png') . "'/></td>";
                        }

                        $cFormatRaw .= " <td style='vertical-align: middle; font-size:small !important;'><a href='" . url('detail/'. $cRow['PLU']) . "' style='display:block'>" . $cRow['PLU'] . " <br>" . Product::getDesc($cRow['PLU']) . "</a></td>
                                            <input type='hidden' class=\"PLUArray" . $aRow['id'] . "\" name=\"PLUArray[]\" value='" . $cRow['PLU'] . "'/>";

                        if ($unit == 'PCS') {
                            $cFormatRaw .= "<td style='vertical-align: middle;' id='field1'>";
                            if($cRow['qty'] < $minbeli){
                                $cFormatRaw .= "<span style='vertical-align: middle;color: red' >Masukkan Qty <br>(Min Kelipatan $minbeli)</span><br>";
                            }
                            $cFormatRaw .= "<button type=\"button\" id=\"sub\" class=\"sub\">-</button>
                                                        <input class='QTYArray" . $aRow['id'] . "' name=\"QTYArray[]\" style=\"width: 30px\" type=\"text\" id=\"1\" value=\"" . $cRow['qty'] . "\" class=\"field\" />
                                                    <button type=\"button\" id=\"add\" class=\"add\">+</button>
                                                    <div style='font-weight:bold; font-size:small !important;'>" . $unit . "</div>
                                                </td>";
                        } else {
                            $cFormatRaw .= "<td style='vertical-align: middle;' id='field1'>";
                            if($cRow['qty'] < $minbeli){
                                $cFormatRaw .= "<span style='vertical-align: middle;color: red'>Masukkan Qty <br>(Min Kelipatan $minbeli)</span><br>";
                            }
                            $cFormatRaw .= "<button type=\"button\" id=\"sub\" class=\"sub\">-</button>
                                                    <input class='QTYArray" . $aRow['id'] . "' name=\"QTYArray[]\" style=\"width: 30px\" type=\"text\" id=\"1\" value=\"" . $cRow['qty'] . "\" class=\"field\" />
                                                <button type=\"button\" id=\"add\" class=\"add\">+</button>
                                                <div style='font-weight:bold; font-size:small !important;'> " . $unit . " (" . ($cRow['qty'] * $frac) . " PCS)</div>
                                            </td>";
                        }




                        if ($diskon > 0) {
                            if($cRow['price'] == null){
                                $cFormatRaw .= "<td class='hidden-xs font-14' style='text-align: right;vertical-align: middle;'><i style='text-decoration: line-through;'>Rp. " . number_format($harga / ($cRow['qty'] * $frac), 0, ",", ".") . "</i><br/>Rp. " . number_format(($harga / ($cRow['qty'] * $frac)) - ($diskon / ($cRow['qty'] * $frac)), 0, ",", ".") . "" . "";
                            }else{
                                $cFormatRaw .= "<td class='hidden-xs font-14' style='text-align: right;vertical-align: middle;'><i style='text-decoration: line-through;'>Rp. " . number_format($harga / ($cRow['qty']), 0, ",", ".") . "</i><br/>Rp. " . number_format(($harga / ($cRow['qty'] )) - ($diskon / ($cRow['qty'])), 0, ",", ".") . "" . "";

                            }
                        } else {
                            if($cRow['price'] == null){
                                $cFormatRaw .= "<td class='hidden-xs font-14' style='text-align: right;vertical-align: middle;'>Rp. " . number_format($harga / ($cRow['qty'] * $frac), 0, ",", ".") . "";
                            }else{
                                $cFormatRaw .= "<td class='hidden-xs font-14' style='text-align: right;vertical-align: middle;'>Rp. " . number_format($harga / ($cRow['qty']), 0, ",", ".") . "";
                            }
                        }
                        $cFormatRaw .= "</td>
                                            <td class='hidden-xs font-14' style='text-align: right;vertical-align: middle;'><b>Rp. " . number_format($harga - $diskon, 0, ",", ".") . "</b></td>
                                             <td class='font-14' style='text-align: right; vertical-align: middle;'><button class='btn btn-danger flat' onclick='deleteCart(\"" . $cRow['PLU'] . "\")'><i style='color:white' class='fa fa-trash'/></button></td>
                                            </tr>";
                        if(\Auth::user()->flag_verif == 1){
                            if($flagKenaPromo !== FALSE){

                                $cFormatRaw .= "<tr style='background-color: beige;'>
									<td colspan='3' style='vertical-align: middle;text-align:right'>Potongan CB " . $arrayPromosi[$flagKenaPromo]['KD_PROMOSI'] . " : </td>
									<td class='font-14' colspan='2' style='vertical-align: middle;text-align:center'>" . $arrayPromosi[$flagKenaPromo]['KELIPATAN'] . " x -" . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH']/$arrayPromosi[$flagKenaPromo]['KELIPATAN'], 0, ",", ".") . "</td>
									<td class='font-14' colspan='2' style='text-align: middle;vertical-align: middle;'>- Rp." . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH'], 0, ",", ".") . "</td>
							   </tr>";
                                unset($arrayPromosi[$flagKenaPromo]); // remove item at index 0
                                $arrayPromosi = array_values($arrayPromosi);
                            }
                        }

                    }



                    if ($total < $minimalorder) {

                        $cFormatRaw .= "<script>
                                    $('.add').click(function () {
                                    $(this).prev().val(+$(this).prev().val() + 1);
                                    });
                                    $('.sub').click(function () {
                                    if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
                                    });

                                $(function () {";

                        foreach ($cAssoc as $cIdx => $cRow) {
                            $minbeli = Product::getMinBeli($cRow['PLU']);

                            $cFormatRaw .= "    $('#crt" . $cRow['PLU'] . "').editable({
                                            type: 'text',";
                            if ($minbeli > 1) {
                                $cFormatRaw .= "    title: 'Masukkan Qty (Minimal Kelipatan $minbeli)',";
                            } else {
                                $cFormatRaw .= "    title: 'Masukkan Qty',";
                            }
                            $cFormatRaw .= "        success: function(response, newValue) {
                                                changeCartQty('" . $cRow['PLU'] . "', newValue);
                                            },
                                            validate: function(value) {
                                                if($.trim(value)%" . $minbeli . " != 0 || $.trim(value) < 1) {
                                                    return 'Quantity Tidak Valid';
                                                }
                                            }
                                        });";
                        }
                        $cFormatRaw .= "});
                                </script>";
                    }

                }
            }
            if(\Auth::user()->flag_verif == 1) {
                foreach ($array as $index => $Row) {
                    //$cashback = $array[$key]['RUPIAH'];
                    if ($Row['TIPE_PROMOSI'] == "CASHBACK" && $Row['JENIS_PROMOSI'] == "0") {
                        $cashback = $Row['RUPIAH'];
                        $totalcashback = $totalcashback + ($cashback);
                    }
                    if ($Row['TIPE_PROMOSI'] == "CASHBACK" && $Row['JENIS_PROMOSI'] === "1") {
                        $cashbackgabungan = $Row['RUPIAH'];
                        $totgab = $totgab + ($cashbackgabungan);
                    }
                }
            }

            if ($count == 0) {
                $cFormatRaw .= "<div class='warning'>
                                    <a style='vertical-align: middle;'><img  height='100' width='100' src='" . url('img/bag.png') . "'/></a>
                                </div>";
                $cFormatRaw .= "<div class='warning'>
                                    <a colspan='8' class='font-14' style='text-align: center'><b>Tidak ada item di Keranjang Anda</b></a>
                                 </div>";
                $cFormatRaw .= "<div class='warning' style='margin-top: 10px;'>
                                   <button  class='btn btn-warning flat' data-dismiss='modal'><i style='color:white' class='fa fa-shopping-cart'/> Lanjut Belanja</button>
                                 </div>";
            }
            if ($typeuserid == 2 || $typeuserid == 3) {
                $cFormatRaw .= "<tr class='default'>
		                    <td colspan='7' class='font-12' style='text-align: left'><b>* Total nilai yang harus dibayarkan selama syarat dan ketentuan terpenuhi  </b></td>
	                    </tr>";
            }

            $cFormatRaw .= "</table></div>";
            if ($count > 0) {

                $cFormatRaw .= "<div class='col-xs-12 col-md-3'>";

//                $cFormatRaw .= "<div style='margin-bottom: 10px;'><button style='width: 100%' class='btn btn-danger flat' onclick='deleteAllCart()'><i style='color:white' class='fa fa-trash'/> Hapus Semua Keranjang</button></div>";

                $cFormatRaw .= "<div style='margin-bottom: 10px;'><button style='width: 100%' class='btn btn-primary flat' data-dismiss='modal'><i style='color:white' class='fa fa-cart-plus'/> Lanjutkan Belanja</button></div>";


                $cFormatRaw .= "<div style='margin-bottom: 10px'><button style='width: 100%' id='crt' class='btn btn-warning flat btnupdt' type='submit'><i style='color:white' class='fa fa-refresh'/> Perbarui Keranjang</button>
                                            <script>$(function()
                                            {
                                            $('.btnupdt').on('click',function()
                                            {
                                            changeCartQty();
                                            });
                                            });
                                            </script>
                                    </div>";


                $cFormatRaw .= "<div style='text-align: left; font-weight: bold'>Detail Order</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";



                $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Belanja <span style='float: right; padding-right: 10px;'>Rp. " . number_format($total, 0, ",", ".") . "</span></div>";

                $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Diskon <span style='float: right; padding-right: 10px;'>Rp. " . number_format($tdisc, 0, ",", ".") . "</span></div>";

                $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Cashback <span style='float: right; padding-right: 10px;'>Rp. " . number_format($totalcashback, 0, ",", ".") . "</span></div>";

                $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total CB Gabungan <span style='float: right; padding-right: 10px;'>Rp. " . number_format($totgab, 0, ",", ".") . "</span></div>";

                //  $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='float: right; padding-right: 10px;'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";


                $cFormatRaw .= "<div style='text-align: left; font-weight: bold; margin-bottom: 20px;' id='total'>Total Bayar<span style='float: right; padding-right: 10px;'>Rp. " . number_format($total - $totalcashback - $tdisc - $totgab, 0, ",", ".") . "</span></div>";

                $totalbelanja = $total - $totalcashback - $tdisc - $totgab;
            }

            $FlagCabOngkir = \DB::table('freeongkir_hdr')
//                ->where('periode_start', '<=', Carbon::today())
//                ->where('periode_end', '>=', Carbon::today())
                ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
                ->where('cabang', $kodecabang)
                ->Where('flag_all', 'Y')
                ->get();

           // dd($kodecabang);

            $countFreeOngkir = \DB::table('freeongkir_hdr')->select('id')
                ->Join('freeongkir_dtl', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
                ->Where('kodemember', $userid)
                ->Where('kode_igr', $kodecabang)   
                    ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                    ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
//                ->where('periode_start', '<=', Carbon::today())
//                ->where('periode_end', '>=', Carbon::today())
                ->Where('flag_all', 'N')
                ->Count();

//            dd($countFreeOngkir);
            if($total < $minimalorder){
                $cFormatRaw.="<div class='alert alert-danger' role='alert'>
                                 Total Pembelanjaan Anda Tidak Bisa Kurang dari <br><strong>Rp. " . number_format($minimalorder, 0, ",", ".") . "</strong>
                            </div>";
            }else
                if($totalbelanja >= $minimaldelivery){
                    if($countFreeOngkir > 0) {
                        $cFormatRaw .= "<div class='alert alert-info' role='alert'>
                                  <h4 class='alert-heading'>Selamat !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  <p>Anda mendapatkan Promo <strong>Gratis Ongkir</strong></p>

                            </div>";
                    }elseif(count($FlagCabOngkir) > 0 && $totalbelanja < $FlagCabOngkir){
                        $cFormatRaw.="<div class='alert alert-warning' role='alert'>
                                  Total Pembelanjaan Anda <br>Masih Kurang<strong> Rp. " . number_format($FlagCabOngkir - $totalbelanja, 0, ",", ".") . "</strong>
                                  <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Untuk Mendapatkan <br><strong>Promo GRATIS ONGKIR</strong>
                            </div>";

                    }elseif(count($FlagCabOngkir) != null){
                        $cFormatRaw.="<div class='alert alert-info' role='alert'>
                                  <h4 class='alert-heading'>Selamat !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Anda mendapatkan<br><strong>Promo Gratis Ongkir</strong>
                            </div>";
                    }
                }else{
                    $cFormatRaw.="<div class='alert alert-danger' role='alert'>
                                Pembelanjaan Anda Dibawah  <strong>Rp 1.000.000,-</strong><br>
                              <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  <strong>Silakan Ambil di Toko Terdekat</strong>
                            </div>";


                }


            if ($count > 0 && $total >= $minimalorder) {
                if($typeuserid == 1){
                    $cFormatRaw .= "<div style='margin-top: 10px; margin-bottom:10px;'><a href=" . url('/precheckout') . " style='width: 100%' class='btn btn-danger flat'><i style='color:white' class='fa fa-cart-arrow-down'/> Pesan Sekarang</a></div>";
                }else{
                    $cFormatRaw .= "<div style='margin-top: 10px; margin-bottom:10px;'><a href=" . url('/detailcheckout') . " style='width: 100%' class='btn btn-danger flat'><i style='color:white' class='fa fa-cart-arrow-down'/> Pesan Sekarang</a></div>";
                }

                $firstGift = TRUE;
                if(\Auth::user()->flag_verif == 1) {
                    foreach ($array as $index => $Row) {

                        if ($Row['TIPE_PROMOSI'] == "GIFT" && $Row['JENIS_HADIAH'] == "PD" && $Row['FLAG_KIOSK'] != "Y") {
                            if ($firstGift === TRUE) {
                                $cFormatRaw .= "<div style='text-align: left; font-weight: bold; margin-bottom: 10px;'><b>Anda memperoleh : &nbsp; </b></div>";
                                $firstGift = FALSE;
                            }

                            $cFormatRaw .= "<div style='text-align: left;'>- " . $Row['QTY'] . " buah &nbsp;" . $Row['KET_HADIAH'] . "</div>";

                        } elseif ($Row['TIPE_PROMOSI'] == "GIFT" && $Row['JENIS_HADIAH'] == "PR" && $Row['FLAG_KIOSK'] != "Y" && $typeuserid != 3) {
                            if ($firstGift === TRUE) {
                                $cFormatRaw .= "<div style='text-align: left; font-weight: bold; margin-bottom: 10px;'>Anda Memperoleh :</div>";
                                $firstGift = FALSE;
                            }

                            $cFormatRaw .= "<div style='text-align: left;'>-" . $Row['QTY'] . " POIN dari PROMOSI &nbsp;(" . $Row['NM_PROMOSI'] . ")</div>";
                        }
                    }
                }


                $cFormatRaw .= "<script>
                                    $('.add').click(function () {
                                    $(this).prev().val(+$(this).prev().val() + 1);
                                    });
                                    $('.sub').click(function () {
                                    if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
                                    });

                                $(function () {";

                foreach ($cAssoc as $cIdx => $cRow) {
                    $minbeli = Product::getMinBeli($cRow['PLU']);
                    $cFormatRaw .= "    $('#crt" . $cRow['PLU'] . "').editable({
                                            type: 'text',";
                    if ($minbeli > 1) {
                        $cFormatRaw .= "    title: 'Masukkan Qty (Minimal Kelipatan $minbeli)',";
                    } else {
                        $cFormatRaw .= "    title: 'Masukkan Qty',";
                    }
                    $cFormatRaw .= "        success: function(response, newValue) {
                                                changeCartQty('" . $cRow['PLU'] . "', newValue);
                                            },
                                            validate: function(value) {
                                                if($.trim(value)%" . $minbeli . " != 0 || $.trim(value) < 1) {
                                                    return 'Quantity Tidak Valid';
                                                }
                                            }
                                        });";
                }
                $cFormatRaw .= "});
                                </script>";

                $cFormatRaw .= "</div></div>";

            }
            return $cFormatRaw;
        }
    }

    public function getcheckOut(Request $Request)
    {
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        $userid = \Auth::User()->id;

		$CartAddress = Address::getAddresses();

        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        #if($typeuserid != 1) {   
         #   $CartAddress = $CartAddress->Where('flag_default', 1);
       # }
       # $CartAddress = $CartAddress->Where('member_id',$userid)
        #    ->Get();


        $total = 0;
        $count = 0;
        $tdisc = 0;

        $cFormatRaw ="";
        $cartFormatRaw ="";
        $OngkirFormatRaw= "";
        foreach ($CartAddress as $cIdx => $aRow) {  

            $cAssoc = Cart::getCartContentKat($aRow['id']);    
            $nopo = Cart::getCartContentKat($aRow['id'])->pluck('no_po')->first();
            if (count($cAssoc) > 0) {
                $cartFormatRaw .= "<div style='font-weight: bold;text-align: left;font-size: small !important;padding-left: 20px;'>Alamat Pengiriman </div>";
                 $cartFormatRaw .="<div style='font-weight: bold; text-align: left;padding-left: 20px;'>" . $aRow['email'] . "</div>";
                $cartFormatRaw .= "<div style='text-align: left;padding-top: 5px;padding-left: 20px;'>" . $aRow['label'] . "</div>";
                $cartFormatRaw .= "<div style='text-align: left;padding-top: 10px;padding-left: 20px;'>" . $aRow['address'] . ",<br> Kel." . $aRow['sub_district_name'] . ", Kec. " . $aRow['district_name'] . ",  Kota " . $aRow['city_name'] . ", Prov. " . $aRow['province_name'] . "</div>";
                $cartFormatRaw .= "<div style='text-align: left;padding-left: 20px;'>" . $aRow['postal_code'] . "</div>";
                $cartFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;padding-left: 20px;'>" . $aRow['phone_number'] . "</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
//                $cartFormatRaw .= "<tr><th colspan='7' width='25%' class='font-15' style='text-align: left; color: black; vertical-align: middle;'>Alamat : " . $aRow['address'] . "</th></tr>";
                foreach ($cAssoc as $cIdx => $cRow) {
                    if($cRow['price'] == null){
                        $harga = $this->cekHargaMBT($cAssoc, $cRow['PLU'], $cRow['qty']);
                        $diskon = $this->cekHargaDiskon($cRow['PLU'], $harga, $cRow['qty']);
                    }else{
                        $harga = $cRow['price'] * $cRow['qty'];
                        $diskon = 0;
                    }
                    $total = $total + ($harga);
                    $count++;
                    $unit = Product::getUnit($cRow['PLU']);
                    $frac = Product::getFrac($cRow['PLU']);
                    $tdisc = $tdisc + ($diskon);       

                    $cartFormatRaw .= "<a href='" . url('detail/'.$cRow['PLU']) . "' style='display:block'><div style='margin-left: 15px;'><table><tr>";
                    if ($cRow['url_pic_prod'] != null) {
                        $cartFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . $cRow['url_pic_prod'] . "'/></td>";
                    } else {
                        $cartFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . url('img/noimage.png') . "'/></td>";
                    }
                    $cartFormatRaw .= "<td style='text-align: left; padding-left: 10px;'>" . $cRow['long_description'] . " <br><br>Jumlah = " . $cRow['qty'] . "  " . $cRow['unit'] . "</td>";
                    $cartFormatRaw .= "<span style='float:right;color:#F7931E; padding-top: 20px;padding-right: 20px;'>Rp. " . number_format($harga) . "</span>";
                    $cartFormatRaw .= "</tr></table></div></a><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

                }
            }

        }

        $hitongkir = $total - $tdisc;


        $cFormatRaw .= "<div style='text-align: left; font-weight: bold'>Metode Pengiriman</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
        $totalbelanja = $total - $tdisc;

        $FlagCabOngkir = \DB::table('freeongkir_hdr')
//            ->where('periode_start', '<=', Carbon::today())
//            ->where('periode_end', '>=', Carbon::today())
            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
            ->where('cabang', $kodecabang)
            ->Where('flag_all', 'Y')
            ->Pluck('nominal');

        $countFreeOngkir = \DB::table('freeongkir_hdr')->select('id')
            ->Join('freeongkir_dtl', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
            ->Where('kodemember', $userid)
            ->Where('kode_igr', $kodecabang)
            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
//            ->where('periode_start', '<=', Carbon::today())
//            ->where('periode_end', '>=', Carbon::today())
            ->Where('flag_all', 'N')
            ->Count();



        if($hitongkir >= 500000){
            $cFormatRaw .= "<div style='float: left'>
                                <input type='radio' id='contactChoice1' class='kirim' name='kirim' value='COD'>
                                <label for='contactChoice1'>Diambil di Toko</label>
                            </div>";
            $cFormatRaw .= "<div>
                               <input type='radio' id='contactChoice2' class='kirim' name='kirim' value='ANTAR' CHECKED>
                               <label for='contactChoice2'>Diantar dari Toko</label>";
            $cFormatRaw .= "</div><hr style='margin-top: 10px;margin-bottom:10px;'>";
            if($countFreeOngkir > 0) {
                $cFormatRaw .= "<div class='alert alert-info' role='alert'>
                                  <h4 class='alert-heading'>Selamat !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Anda mendapatkan Promo <strong>Gratis Ongkir</strong>

                            </div>";
            }elseif(count($FlagCabOngkir) > 0 && $totalbelanja < $FlagCabOngkir){
                $cFormatRaw.="<div class='alert alert-warning' role='alert'>
                                  Total Pembelanjaan Anda <br>Masih Kurang<strong> Rp. " . number_format($FlagCabOngkir - $totalbelanja, 0, ",", ".") . "</strong>
                                  <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Untuk Mendapatkan <br><strong>Promo GRATIS ONGKIR</strong>
                            </div>";

            }elseif(count($FlagCabOngkir) != null){
                $cFormatRaw.="<div class='alert alert-info' role='alert'>
                                  <h4 class='alert-heading'>Selamat !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Anda mendapatkan<br><strong>Promo Gratis Ongkir</strong>
                            </div>";
            }else{
                $cFormatRaw .= "<div id='diantar' class='alert alert-success noprint' role='alert'>
                                  <h4 class='alert-heading'>Info !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Biaya Pengiriman Akan Kami Info <br>Setelah Anda Melakukan Proses Checkout
                            </div>";

                $cFormatRaw .= "<div id='diambil' class='alert alert-info noprint' role='alert' style='display: none'>
                                  <h4 class='alert-heading'>Info !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Silakan Ambil Barang Belanjaan di Toko Terdekat
                            </div>";
            }
        }else{
            $cFormatRaw .= "<div class='noprint' style='float: left; display: none'>
                                <input type='radio' id='contactChoice1' class='kirim' name='kirim' value='COD' CHECKED>
                                <label for='contactChoice1'>Diambil di Toko</label>
                            </div>";
            $cFormatRaw.="<div class='alert alert-danger noprint' role='alert'>
                                Pembelanjaan Anda Dibawah  <br><strong>Rp 1.000.000,-</strong><br>
                              <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  <strong>Silakan Ambil di Toko Terdekat</strong>
                            </div>";

        }

        if($typeuserid == 1 && $nopo == null){

        $cFormatRaw .= "<div class='noprint' style='text-align: left; font-weight: bold'>Referensi Nomor PO</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
            $cFormatRaw .= "<div class='form-group noprint'>
							<div style='padding-right: 10px;padding-bottom: 10px;'>";
//            $cFormatRaw .= "<a href=\"#\" style=\"text-transform:uppercase\" class=\"username\" data-type=\"text\" data-pk=\"\" data-url=\"updtkategori\" data-original-title=\"Enter Category Alias\"></a><script> $('.username').editable();</script>";
            $cFormatRaw .= "<input id='nomorpo' type='text' class='form-control input1 txtref' name='nomorpo'>
							</div>
							<span style='color: deepskyblue'>Isian huruf atau simbol yang dianjurkan : [A-Za-z0-9_/-] </span>
						</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>

						";
        }


        $cFormatRaw .= "<div style='text-align: left; font-weight: bold'>Detail Order</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

        $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Belanja <span style='float: right; padding-right: 10px;'>Rp. " . number_format($total, 0, ",", ".") . "</span></div>";  

        $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Diskon <span style='float: right; padding-right: 10px;'>Rp. " . number_format($tdisc, 0, ",", ".") . "</span></div>";

      //  $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='float: right; padding-right: 10px;'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>"; 

        $cFormatRaw .= "<div style='text-align: left; font-weight: bold; margin-bottom: 20px;' id='total'>Total Pembayaran<span style='float: right; padding-right: 10px;'>Rp. " . number_format($total-$tdisc, 0, ",", ".") . "</span></div>";

        $cFormatRaw .= "<div class='noprint' style='text-align: left; margin-top: 25px;float: right; padding-right: 10px;'><a data-toggle='modal' data-target='.confirm-create' class='btn btn-primary flat btn-lanjutbayar'>Lanjutkan Pembayaran</a></div>";

        $cFormatRaw .= "<div class='noprint' style='text-align: left; margin-top: 25px;float: right; padding-right: 10px;'><a href='" . url('precheckout/') . "' class=\"btn btn-warning flat\" onClick=\"window.print();return false\"<i class='icon-print'></i>Cetak List Pesanan </a></div>";

        return view('product.checkout')->with('divdeptkat', $this->getMenuDropdown())->with('detail', $cFormatRaw)->with('cartdetail', $cartFormatRaw)->with('divdeptkatmobile', $this->getMenuDropdownMobile());
    }

    public function getViewCheckout(){
        return view('product.viewcheckout')->with('divdeptkat', $this->getMenuDropdown());
    }

    public function getDetailCheckout(Request $Request){
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        $userid = \Auth::User()->id;

        if($typeuserid == 1) {
            $kodemember = \DB::table('customers')->distinct()
                ->Join('members', 'customers.id', '=', 'members.customer_id')
                ->Pluck('kode_member');
        }else{
            $kodemember = \Auth::user()->kodemember;
        }


        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        $CartAddress = Address::Distinct();


        if($typeuserid != 1) {
            $CartAddress = $CartAddress->Where('flag_default', 1);
        }
        $CartAddress = $CartAddress->Where('member_id',$userid)
            ->Get();

        $branchid = \DB::table('members')
            ->Join('addresses', 'members.id', '=', 'addresses.member_id')
            ->Where('members.id', \Auth::User()->id)
            ->Where('flag_default', 1)
            ->pluck('branch_id');


        try{
            $minimalorder = \DB::table('min_order_settings')->distinct()
                //                    ->Join('branches', 'branches.id', '=', 'min_order_settings.branch_id')
                ->Where('user_type_id',$typeuserid)
                ->Where('branch_id',$branchid)
                ->Pluck('min_pickup');

            $minimaldelivery = \DB::table('min_order_settings')->distinct()
                //                    ->Join('branches', 'branches.id', '=', 'min_order_settings.branch_id')
                ->Where('user_type_id',$typeuserid)
                ->Where('branch_id',$branchid)
                ->Pluck('min_delivery');

        }catch(\Exception $ex){
            $minimalorder = 500000;
            $minimaldelivery = 1000000;
        }


        $cartAssoc = Cart::getCartContent();

        $data = "$kodecabang@$kodemember|";
        $cartFormatRaw ="";

        if($kodemember != "" && \Auth::user()->flag_verif == 1){
            foreach($cartAssoc as $index => $row){
                if($index > 0) {
                    $data .= "#";
                }
//                else{
//                    $cartFormatRaw .= "<tr class='warning'>
//						   <td colspan='7' class='font-14' style='text-align: center'><b>Tidak ada item di Keranjang Anda</b></td>
//						   </tr>";
//                }

                $prdInfo = Product::getInfoData($row['PLU']);
                $diskon = $prdInfo->DISC;
                if(!$diskon) $diskon = 0;
                $perPcs = $prdInfo->HRG;
                $frac = $prdInfo->frac;
                $perFrac = $perPcs * $frac;
                $plu = $row['PLU'];
                $qty = $row['qty'];
                $unit = $prdInfo->unit;
                $data .= "$plu@$qty@$unit@$perFrac@$diskon";
            }

            // return $data;
            $Prodata = "s=".$data;
            $url ="http://172.31.2.119/IPW/Service1.asmx/GetPromotion";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded;'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$Prodata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            $xml = new \SimpleXMLElement($response);
            $array = json_decode($xml, true);
            curl_close($ch);
        }

        if(\Auth::user()->flag_verif == 1){

            $date = new \DateTime;
            $string_array = json_encode($array);
            $csvDB = New TempPromo();
            $csvDB = TempPromo::firstOrNew(['userid' => \Auth::User()->id]);
            $csvDB->created_at = $date;
            $csvDB->updated_at = $date;
            $csvDB->details_promo = $string_array;

            $csvDB->save();
        }

        $CartAddressDefault = Address::getAddressCheckout();
//        $cartAssoc = Cart::getCartContent();
        $cFormatRaw ="";
        $OngkirFormatRaw ="";
        $total = 0;
        $count = 0;
        $tdisc = 0;
        $totgab = 0;
        $totalbelanja=0;
        $totalcashback = 0;

        if(\Auth::user()->flag_verif == 1){
            $arrayPromosi = $array;
        }
        foreach ($CartAddress as $cIdx => $aRow) {
            $cAssoc = Cart::getCartContentKat($aRow['id']);
            foreach ($cAssoc as $cIdx => $cRow) {
                if($cRow['price'] == null){
                    $harga = $this->cekHargaMBT($cAssoc, $cRow['PLU'], $cRow['qty']);
                    $diskon = $this->cekHargaDiskon($cRow['PLU'], $harga, $cRow['qty']);
                }else{
                    $harga = $cRow['price'] * $cRow['qty'];
                    $diskon = 0;
                }
                $plu =$cRow['PLU'];
                $total = $total + ($harga);
                $count++;
                $unit = Product::getUnit($cRow['PLU']);
                $frac = Product::getFrac($cRow['PLU']);
                $tdisc = $tdisc + ($diskon);

                if(\Auth::user()->flag_verif == 1){
                    $flagKenaPromo = array_search((substr($cRow['PLU'], 0, 6) . "0"), array_column($arrayPromosi, 'KD_PLU')); //RETURN-AN AGUS VS PLU CART
                }

                $cartFormatRaw .= "<a href='" . url('detail/'.$plu) . "' style='display:block;'><div style='margin-left: 15px;'><table><tr>";         
                if ($cRow['url_pic_prod'] != null) {
                    $cartFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . $cRow['url_pic_prod'] . "'/></td>";
                } else {
                    $cartFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . url('img/noimage.png') . "'/></td>";
                }
                $cartFormatRaw .= "<td style='text-align: left; padding-left: 10px;'>" . $cRow['long_description'] . " <br><br>Jumlah = " . $cRow['qty'] . "  " . $cRow['unit'] . "</td>";

                if ($diskon > 0) {
                    $cartFormatRaw .= "<span style='float:right;color:#F7931E; padding-top: 20px;padding-right: 20px;'><i style='text-decoration: line-through;'>Rp. " . number_format($harga, 0, ",", ".") . "</i><br/>Rp. " . number_format($harga - $diskon, 0, ",", ".") . "" . "</span>";
//                    $cartFormatRaw .= "<span style='float:right;color:#F7931E; padding-top: 20px;padding-right: 20px;'>Rp. " . number_format($harga-$diskon) . "</span>";
                }else{
                    $cartFormatRaw .= "<span style='float:right;color:#F7931E; padding-top: 20px;padding-right: 20px;'>Rp. " . number_format($harga) . "</span>";
                }
                if(\Auth::user()->flag_verif == 1){
                    if($flagKenaPromo !== FALSE){
                        $cartFormatRaw .= "<table class='col-md-12'><tr style='background-color: beige;'>
									<td class='col-md-4' style='text-align:left'>Potongan CB " . $arrayPromosi[$flagKenaPromo]['KD_PROMOSI'] . " : </td>
									<td class='col-md-4' style='text-align:center'>" . $arrayPromosi[$flagKenaPromo]['KELIPATAN'] . " x -" . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH']/$arrayPromosi[$flagKenaPromo]['KELIPATAN'], 0, ",", ".") . "</td>
									<td class='col-md-4' style='text-align:right;'>- Rp." . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH'], 0, ",", ".") . "</td>
							   </tr></table>";
                        unset($arrayPromosi[$flagKenaPromo]); // remove item at index 0
                        $arrayPromosi = array_values($arrayPromosi);
                    }
                }

//                if(\Auth::user()->flag_verif == 1){
//                    if($flagKenaPromo !== FALSE){
//                        $cartFormatRaw .= "<tr style='background-color: beige;'>
//									<td colspan='4' style='vertical-align: middle;text-align:right'>Potongan CB " . $arrayPromosi[$flagKenaPromo]['KD_PROMOSI'] . " : </td>
//									<td class='font-14' colspan='2' style='vertical-align: middle;text-align:center'>" . $arrayPromosi[$flagKenaPromo]['KELIPATAN'] . " x -" . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH']/$arrayPromosi[$flagKenaPromo]['KELIPATAN'], 0, ",", ".") . "</td>
//									<td class='font-14' colspan='2' style='text-align: middle;vertical-align: middle;'>- Rp." . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH'], 0, ",", ".") . "</td>
//							   </tr>";
//                        unset($arrayPromosi[$flagKenaPromo]); // remove item at index 0
//                        $arrayPromosi = array_values($arrayPromosi);
//                    }
//                }
                $cartFormatRaw .= "</tr></table></div><hr style='margin-top: 5px;margin-bottom: 5px;'/></a>";

            }
        }

        if(\Auth::user()->flag_verif == 1) {
            foreach ($array as $index => $Row) {
                //$cashback = $array[$key]['RUPIAH'];
                if ($Row['TIPE_PROMOSI'] == "CASHBACK" && $Row['JENIS_PROMOSI'] == "0") {
                    $cashback = $Row['RUPIAH'];
                    $totalcashback = $totalcashback + ($cashback);
                }
                if ($Row['TIPE_PROMOSI'] == "CASHBACK" && $Row['JENIS_PROMOSI'] === "1") {
                    $cashbackgabungan = $Row['RUPIAH'];
                    $totgab = $totgab + ($cashbackgabungan);
                }
            }
        }

        $hitongkir = $total - $totalcashback - $tdisc - $totgab;

        $OngkirFormatRaw .= "<div class='noprint' style='text-align: left; font-weight: bold'>Metode Pengiriman</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
        $totalbelanja = $total - $totalcashback - $tdisc - $totgab;

        $FlagCabOngkir = \DB::table('freeongkir_hdr')
            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
            ->where('cabang', $kodecabang)
            ->Where('flag_all', 'Y')
            ->Pluck('nominal');


        $countFreeOngkir = \DB::table('freeongkir_hdr')->select('id')
            ->Join('freeongkir_dtl', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
            ->Where('kodemember', $userid)
            ->Where('kode_igr', $kodecabang)
            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
            ->Where('flag_all', 'N')
            ->Count();


        if($hitongkir >= $minimaldelivery){
            $OngkirFormatRaw .= "<div class='noprint' style='float: left'>
                                <input type='radio' id='contactChoice1' class='kirim' name='kirim' value='COD'>
                                <label for='contactChoice1'>Diambil di Toko</label>
                            </div>";
            $OngkirFormatRaw .= "<div class='noprint'>
                               <input type='radio' id='contactChoice2' class='kirim' name='kirim' value='ANTAR' CHECKED>
                               <label for='contactChoice2'>Diantar dari Toko</label>";
            $OngkirFormatRaw .= "</div><hr style='margin-top: 10px;margin-bottom:10px;'>";
            if($countFreeOngkir > 0) {
                $cFormatRaw .= "<div class='alert alert-info noprint' role='alert'>
                                  <h4 class='alert-heading'>Selamat !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Anda mendapatkan Promo <strong>Gratis Ongkir</strong>

                            </div>";
            }elseif($FlagCabOngkir != null && $totalbelanja < $FlagCabOngkir){
                $cFormatRaw.="<div class='alert alert-warning noprint' role='alert'>
                                  Total Pembelanjaan Anda <br>Masih Kurang<strong> Rp. " . number_format($FlagCabOngkir - $totalbelanja, 0, ",", ".") . "</strong>
                                  <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Untuk Mendapatkan <br><strong>Promo GRATIS ONGKIR</strong>
                            </div>";

            }elseif($FlagCabOngkir != null){
                $cFormatRaw.="<div class='alert alert-info noprint' role='alert'>
                                  <h4 class='alert-heading'>Selamat !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Anda mendapatkan<br><strong>Promo Gratis Ongkir</strong>
                            </div>";
            }else{
                $cFormatRaw .= "<div id='diantar' class='alert alert-success noprint' role='alert'>
                                  <h4 class='alert-heading'>Info !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Biaya Pengiriman Akan Kami Info <br>Setelah Anda Melakukan Proses Checkout
                            </div>";

                $cFormatRaw .= "<div id='diambil' class='alert alert-info noprint' role='alert' style='display: none'>
                                  <h4 class='alert-heading'>Info !</h4>
                                   <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  Silakan Ambil Barang Belanjaan di Toko Terdekat
                            </div>";
            }
        }else{
            $OngkirFormatRaw .= "<div class='noprint' style='float: left; display: none'>
                                <input type='radio' id='contactChoice1' class='kirim' name='kirim' value='COD' CHECKED>
                                <label for='contactChoice1'>Diambil di Toko</label>
                            </div>";
            $OngkirFormatRaw.="<div class='alert alert-danger noprint' role='alert'>
                                Pembelanjaan Anda Dibawah  <br><strong>Rp 1.000.000,-</strong><br>
                              <hr style='margin-top: 10px;margin-bottom:10px;'>
                                  <strong>Silakan Ambil di Toko Terdekat</strong>
                            </div>";

        }

        $cFormatRaw .= "<div style='text-align: left; font-weight: bold'>Detail Order</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

        $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Belanja <span style='float: right; padding-right: 10px;'>Rp. " . number_format($total, 0, ",", ".") . "</span></div>";

        $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Diskon <span style='float: right; padding-right: 10px;'>Rp. " . number_format($tdisc, 0, ",", ".") . "</span></div>";

        $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Cashback <span style='float: right; padding-right: 10px;'>Rp. " . number_format($totalcashback, 0, ",", ".") . "</span></div>";

        $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total CB Gabungan <span style='float: right; padding-right: 10px;'>Rp. " . number_format($totgab, 0, ",", ".") . "</span></div>";

//        $cFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Pengiriman <span style='float: right; padding-right: 10px;'>" . $ongkir . "</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";


        $cFormatRaw .= "<div style='text-align: left; font-weight: bold; margin-bottom: 20px;' id='total'>Total Pembayaran<span style='float: right; padding-right: 10px;'>Rp. " . number_format($total - $totalcashback - $tdisc - $totgab, 0, ",", ".") . "</span></div>";



        $firstGift = TRUE;
        if(\Auth::user()->flag_verif == 1){
            foreach ($array as $index => $Row) {

                if ($Row['TIPE_PROMOSI'] == "GIFT" && $Row['JENIS_PROMOSI'] == "PD" && $Row['FLAG_KIOSK'] != "Y") {
                    if ($firstGift === TRUE) {
                        $cFormatRaw .= "
						   <div class='font-14' style='text-align: left'>Anda memperoleh : &nbsp; </div>";
                        $firstGift = FALSE;
                    }

                    $cFormatRaw .= "
                               <div class='font-12' style='text-align: left'><b>" . $Row['QTY'] . " buah &nbsp;" . $Row['KET_HADIAH'] . "</b></div>";

                } elseif ($Row['TIPE_PROMOSI'] == "GIFT" && $Row['JENIS_PROMOSI'] == "PR" && $Row['FLAG_KIOSK'] != "Y") {
                    if ($firstGift === TRUE) {
                        $cFormatRaw .= "<div class='font-14' style='text-align: left'>Anda memperoleh : &nbsp; </div>";
                        $firstGift = FALSE;
                    }

                    $cFormatRaw .= "
                               <div class='font-12' style='text-align: left'><b>" . $Row['QTY'] . " POIN dari PROMOSI &nbsp;(" . $Row['NM_PROMOSI'] . ")</b></div>

                           ";
                }
            }
        }

        if($total >= $minimalorder){
            $cFormatRaw .= "<div class='noprint' style='text-align: left; margin-top: 25px;float: right; padding-right: 10px;'><a href='" . url('detailcheckout/') . "' class=\"btn btn-warning flat\" onClick=\"window.print();return false\"<i class='icon-print'></i>Cetak List Pesanan </a></div>";
            $cFormatRaw .= "<div class='noprint' style='text-align: left; margin-top: 25px;float: right; padding-right: 10px;'><a data-toggle='modal' data-target='.confirm-create' class='btn btn-primary flat'>Lanjutkan Pembayaran</a></div>";

        }
        return view('product.detailcheckout')->with('ListAddress', $CartAddressDefault)->with('detail', $cFormatRaw)->with('cartdetail', $cartFormatRaw)->with('divdeptkat', $this->getMenuDropdown())->with('ongkir', $OngkirFormatRaw);
    }

    public function checkOut1($nopo, $kirim)
    {

        if($nopo == 'blank'){
            $nomor =  "NO-PO-" . str_pad(Invoice::getInvoice(), 6, '0', STR_PAD_LEFT) . "";
        }else{
            $nomor= $nopo;
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        $userid = \Auth::User()->id;

        if($typeuserid == 1) {
            $kodemember = \DB::table('customers')->distinct()
                ->Join('members', 'customers.id', '=', 'members.customer_id')
                ->Pluck('kode_member');
        }else{
            $kodemember = \Auth::user()->kodemember;
        }

        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        $CartAddress = Address::Distinct();
        if($typeuserid != 1) {
            $CartAddress = $CartAddress->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
                ->join('branches','addresses.branch_id', '=', 'branches.id')
                ->join('provinces','addresses.province_id', '=', 'provinces.id')
                ->join('cities', 'addresses.city_id','=','cities.id')
                ->join('members', 'addresses.member_id', '=', 'members.id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
                ->Where('member_id',$userid)
                ->Where('flag_default', 1)
                ->Get();
        }else{
            $CartAddress = $CartAddress->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
                ->join('branches','addresses.branch_id', '=', 'branches.id')
                ->join('provinces','addresses.province_id', '=', 'provinces.id')
                ->join('cities', 'addresses.city_id','=','cities.id')
                ->join('members', 'addresses.member_id', '=', 'members.id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
                ->Where('member_id',$userid)
                ->Get();
        }

        $cartAssoc = Cart::getCartContent();

        $data = "$kodecabang@$kodemember|";
        $cFormatRaw = "";

        if($kodemember != "" && \Auth::user()->flag_verif == 1){
            foreach($cartAssoc as $index => $row){
                if($index > 0) {
                    $data .= "#";
                }
                else{
                    $cFormatRaw .= "<tr class='warning'>
						   <td colspan='7' class='font-14' style='text-align: center'><b>Tidak ada item di Keranjang Anda</b></td>
						   </tr>";
                }

                $prdInfo = Product::getInfoData($row['PLU']);
                $diskon = $prdInfo->DISC;
                if(!$diskon) $diskon = 0;
                $perPcs = $prdInfo->HRG;
                $frac = $prdInfo->frac;
                $perFrac = $perPcs * $frac;
                $plu = $row['PLU'];
                $qty = $row['qty'];
                $unit = $prdInfo->unit;
            }
        }

        $CartAddressDefault = Address::getAddressCheckout();

        $count = 0;
        $cFormatRaw = "";
        $detailFormatRaw = "";

        if (Count($CartAddress) > 0) {

            \DB::beginTransaction();
            try {

                $InvoiceAssoc = Invoice::createInvoice($userid);
                $invoiceID = Invoice::getInvoice();

                if($typeuserid != 1) {

                    $array = \DB::table('temp_promo')
                        ->select('details_promo')
                        ->where('userid', \Auth::User()->id)
                        ->get();
//                        ->pluck('details_promo');

                    $arrayPromosi = $array;
                }

                foreach ($CartAddress as $cIdx => $aRow) {
                    $cAssoc = Cart::getCartContentKat($aRow['id']);

                    if (count($cAssoc) > 0) {
                        $userid = \Auth::User()->id;
                        $kdCabang = Branch::getCartBranches($aRow['id']);
                        $member = User::getNameMember();

                        $addressid = \DB::table('members')
                            ->Join('addresses', 'members.id', '=', 'addresses.member_id')
                            ->Where('members.id', $userid)
                            ->Where('flag_default', 1)
                            ->pluck('addresses.id');


                        foreach ($member as $uIdx => $uRow) {
                            $kdmem = $uRow['kode_member'];
                            $name = $uRow['nama'];
                            $email = $uRow['email'];
                            $namanpwp = $uRow['npwp_name'];
                            $nomornpwp = $uRow['npwp_number'];
                            $alamatnpwp = $uRow['npwp_address'];
                        }
                        $address = $aRow->address;
                        $addressID = $aRow->id;
                        $subdistrictname = $aRow->sub_district_name;
                        $districtname = $aRow->district_name;
                        $cityname = $aRow->city_name;
                        $provincename = $aRow->province_name;
                        $phone = $aRow->phone_number;
                        $postalcode = $aRow->postal_code;
                        $distance = $aRow->distance;

                        $nopo = Cart::getCartContentKat($aRow['id'])->pluck('no_po')->first();

                        if($nopo == "" || $nopo == null){
                            $nopo = $nomor;
                        }

                        $HeaderID = TrHeader::createHeader($phone, $address, $subdistrictname, $districtname, $cityname, $provincename, $postalcode, $kdCabang, $invoiceID, $addressID, $nopo);

                        $tharga = 0;
                        $tdisc = 0;
                        $total = 0;
                        $csv = "Kode Cabang|No Anggota|No Pemesanan|No PO|Tgl Pemesanan|Kode Alamat|Kode PLU|Satuan|Harga (Rp)|Jml Pesanan|Bebas Biaya Pengiriman|Nama Penerima|Email|No Hp|Nama WP|NPWP|Alamat WP|Jarak\n"; //CSV HEADER
                        foreach ($cAssoc as $cIdx => $cRow) {
                            if($cRow['price'] == null){
                                $harga = $this->cekHargaMBT($cAssoc, $cRow['PLU'], $cRow['qty']);
                                $diskon = $this->cekHargaDiskon($cRow['PLU'], $harga, $cRow['qty']);
                            }else{
                                $harga = $cRow['price'] * $cRow['qty'];
                                $diskon = 0;
                            }
                            $tharga = $tharga + ($harga);
                            $tdisc = $tdisc + ($diskon);
                            $total = $tharga - $tdisc;
                            $stotal = $harga - $diskon;
                            $perPcs = $harga / $cRow['qty'];
                            $plu = $cRow['PLU'];
                            $qty = $cRow['qty'];
                            $picprod = $cRow['url_pic_prod'];

                            $perPcscsv = $stotal / $cRow['qty'];

//                            $flagKenaPromo = array_search((substr($cRow['PLU'], 0, 6) . "0"), array_column($arrayPromosi, 'KD_PLU')); //RETURN-AN AGUS VS PLU CART

                            TrDetail::insertDetail($HeaderID, $plu, $qty, $perPcs, $diskon, $stotal, $picprod);

                        }


                        if(\Auth::user()->flag_verif == 1) {
                            $array = json_decode($array[0]->details_promo);

                            foreach ($array as $index => $Row) {

                            }
                        }


                        TrHeader::updateHeader($HeaderID, $total, $tharga, $tdisc);


                        $countFreeOngkir = \DB::table('freeongkir_hdr')->select('id')
                            ->Join('freeongkir_dtl', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
                            ->Where('kodemember', $userid)
                            ->Where('kode_igr', $kdCabang)
//                            ->where('periode_start', '<=', Carbon::today())
//                            ->where('periode_end', '>=', Carbon::today())
                            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
                            ->Where('flag_all', 'N')
                            ->Count();

                        $FlagFreeOngkir = \DB::table('freeongkir_hdr')
                            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
//                            ->where('periode_start', '<=', Carbon::today())
//                            ->where('periode_end', '>=', Carbon::today())
                            ->where('flag_all', '=', 'Y')
                            ->where('cabang', $kdCabang)
                            ->pluck('nominal');

                        $FlagCabOngkir = \DB::table('freeongkir_hdr')
//                            ->where('periode_start', '<=', Carbon::today())
//                            ->where('periode_end', '>=', Carbon::today
                            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
                            ->where('cabang', $kdCabang)
                            ->Where('flag_all', 'Y')
                            ->count();


                        if ($kirim == 'COD') {
                            $ongkir = 'T';
                        } elseif ($kirim == 'ANTAR') {
//                                if(count($FlagFreeOngkir) > 0 && $total >= $FlagFreeOngkir){
//                                    $ongkir = 'Y';
//                                }else
                            if($countFreeOngkir > 0) {
                                $ongkir = 'Y';
                            }elseif($FlagCabOngkir > 0 && $total >= $FlagFreeOngkir){
                                $ongkir = 'Y';
                            }else{
                                $ongkir = 'N';
                            }

                        }

//                            dd($ongkir);

                        $trDtlAssoc = TrDetail::getTransactionDetail($invoiceID, $addressID);



                        foreach ($trDtlAssoc as $Idx => $dRow) {

                            $harga = $dRow['harga'];
                            $qty1 = $dRow['qty'];
                            $plu1 = $dRow['PLU'];
                            $perPcs1 = $harga;

                            if($typeuserid == 1) {
                                $headercsv = str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . "/cor/" . date("m/Y");
                            }elseif($typeuserid == 3){
                                $headercsv = str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . "/odr/" . date("m/Y");
                            }else{
                                $headercsv = str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . "/omm/" . date("m/Y");
                            }

                            $unit1 = Product::getUnit($plu);

                            $csv .= $kdCabang . "|"
                                . $kdmem . "/web/bln/tgl|"
                                . $headercsv . "|"
                                . $nopo . "|"
                                . date("d/m/Y") . "|"
                                . str_replace("|", null, $address) . ", " . str_replace("|", null, $subdistrictname) . ", " . str_replace("|", null, $districtname) . ", " . str_replace("|", null, $cityname) . ", " . str_replace("|", null, $provincename) . ", " . str_replace("|", null, $postalcode) . "|"
                                . $plu1 . "|"
                                . $unit1 . "|"
                                . $perPcs1 . "|"
                                . $qty1 . "|"
                                . $ongkir . "|"
                                . $name . "|"
                                . $email . "|"
                                . $phone . "|"
                                . $namanpwp . "|"
                                . $nomornpwp . "|"
                                . $alamatnpwp ."|"
                                . $distance .""
                                . "\n"; //Generate CSV Row
                        }


                        //                $min_order = User::find($userid)->minor;

                        //Create CSV OBI
                        if($typeuserid == 1){
                            $csvname = 'PB_' . $kdCabang . '_' . str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . '-cor-' . date("m-Y") . '.csv';
                        }elseif($typeuserid == 3){
                            $csvname = 'PB_' . $kdCabang . '_' . str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . '-odr-' . date("m-Y") . '.csv';
                        }else{
                            $csvname = 'PB_' . $kdCabang . '_' . str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . '-omm-' . date("m-Y") . '.csv';
                        }

                        $csv_handler = fopen("csv/" . $csvname, 'w');
                        fwrite($csv_handler, $csv);
                        fclose($csv_handler);

                        //Insert ke Tr Download
                        $csvDB = New TrDown;
                        $csvDB->kode_transaksi = $HeaderID;
                        $csvDB->status_download = 0;
                        $csvDB->kode_cabang = $kdCabang;
                        $csvDB->nama_file = $csvname;
                        $csvDB->save();

                        Cart::truncateUserCart($aRow['id']);
//                        TempPromo::DeleteTempPromo();

                        $trhAssoc = TrHeader::where('kode_transaksi', $HeaderID)->first();
                        $trdAssoc = TrDetail::getTransactionDetail($invoiceID, $addressID);

                        $mbrAssoc = User::find($trhAssoc->userid);
                        $emlAssoc = EmailRecv::where('kode_cabang', $kdCabang)->get();

                        if($typeuserid == 1){
                            $noPb = str_pad($HeaderID, 6, '0', STR_PAD_LEFT) . '/cor/' . date('m/Y');
                        }elseif($typeuserid == 3){
                            $noPb = str_pad($HeaderID, 6, '0', STR_PAD_LEFT) . '/odr/' . date('m/Y');
                        }else{
                            $noPb = str_pad($HeaderID, 6, '0', STR_PAD_LEFT) . '/omm/' . date('m/Y');
                        }


                        foreach($trdAssoc as $trow){
                            $trow->unit = Product::Where('prdcd', $trow['PLU'])->pluck('unit');
                            $trow->frac = Product::Where('prdcd', $trow['PLU'])->pluck('frac');
                        }

                        $emails = $mbrAssoc->email;

                        if(\Auth::user()->flag_verif == 1) {
                            \Mail::send('emails.mailer.mailer', ['trharray' => $trhAssoc, 'trdarray' => $trdAssoc, 'promktarray' => (object)$array, 'usrarray' => $mbrAssoc], function ($message) use ($emails) {
                                $message->to($emails)->subject('Konfirmasi Pemesanan Barang');
                            });
                        }else{
                            \Mail::send('emails.mailer.mailer', ['trharray' => $trhAssoc, 'trdarray' => $trdAssoc, 'usrarray' => $mbrAssoc], function ($message) use ($emails) {
                                $message->to($emails)->subject('Konfirmasi Pemesanan Barang');
                            });
                        }

                        $admEmails = array();
                        $admCount = 0;
                        foreach ($emlAssoc as $eAssoc) {
                            $admEmails[] = $eAssoc->email;
                            $admCount++;
                        }
                        if($admCount > 0){
                            if(\Auth::user()->flag_verif == 1) {
                                \Mail::send('emails.mailer.notification', ['kodeMM' => $mbrAssoc->nama . "(UserID : " . $mbrAssoc->id . ")", 'trharray' => $trhAssoc, 'trdarray' => $trdAssoc, 'promktarray' => $array, 'usrarray' => $mbrAssoc, 'typeid' => $typeuserid], function ($message) use ($admEmails) {
                                    $message->to($admEmails)->subject('Notifikasi Pemesanan Barang');
                                    $message->bcc('cs.klik@indogrosir.co.id', 'Cs Klik');
                                    $message->bcc('klikindogrosir1@indogrosir.co.id', 'Cs Klik1');
                                });
                            }else{
                                \Mail::send('emails.mailer.notification', ['kodeMM' => $mbrAssoc->nama . "(UserID : " . $mbrAssoc->id . ")", 'trharray' => $trhAssoc, 'trdarray' => $trdAssoc, 'usrarray' => $mbrAssoc, 'typeid' => $typeuserid], function ($message) use ($admEmails) {
                                    $message->to($admEmails)->subject('Notifikasi Pemesanan Barang');
                                    $message->bcc('cs.klik@indogrosir.co.id', 'Cs Klik');
                                    $message->bcc('klikindogrosir1@indogrosir.co.id', 'Cs Klik1');
                                });
                            }
                        }


                        $response = array();
                        try{
                            $response["kdCabang"] = $kdCabang;
                            $response["noAnggota"] = $kdmem . "/web/bln/tgl";
                            $response["noPB"] = $noPb;
                            $response["noPO"] = $nopo;
                            $response["Alamat"] = "". str_replace("|", null, $address) . ", " . str_replace("|", null, $subdistrictname) . ", " . str_replace("|", null, $districtname) . ", " . str_replace("|", null, $cityname) . ", " . str_replace("|", null, $provincename) . ", " . str_replace("|", null, $postalcode) . "";
                            $response["freeKirim"] = $ongkir;
                            $response["noHp"] = $phone;
                            $response["email"] = $email;
                            $response["namaPenerima"] = $name;
                            $response["namaWP"] = $namanpwp;
                            $response["noWP"] = $nomornpwp;
                            $response["alamatWP"] = $alamatnpwp;
                            $response["jarak"] = $distance;
                            $response["order"] = $trdAssoc->toJson();

                        }catch (Exception $ex){
                            $response["success"] = 0;
                            $response["message"] = "FAILED - " . $ex;
                        }

                        $ch = curl_init('http://172.31.2.118/aldoapi_sim/public/upload');
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'X-Authorization : 4b8bf8518b027f7adbf0e6c367ccb204b397566e',
//                           'Content-Type: application/x-www-form-urlencoded'
                        ));
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                        //execute post
                        $result = curl_exec($ch);

                        //close connection
                        curl_close($ch);


                    }
                }

                if(\Auth::user()->flag_verif == 1){
                    $arrayPromosi = $array;
                }
                foreach ($CartAddress as $cIdx => $aRow) {
                    $trdAssoc = TrDetail::getTransactionDetail($invoiceID, $aRow['id']);
                    if (count($trdAssoc) > 0) {
                        $cFormatRaw .= "<div class='col-md-12' style='box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);padding-left: 0px;padding-right: 0px;'><table width='100%' style='text-align: start; border-right-color:white;padding-bottom: 0px' class='table table-striped table-condensed table-responsive cart cart" . $aRow['id'] . "' data-id='" . $aRow['id'] . "'>";
                        $cFormatRaw .= "<tr style='background-color: #2980b9'>
                                        <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>No.</th>
                                        <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Gambar</th>
                                        <th width='25%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Deskripsi</th>
                                        <th width='20%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Jumlah</th>
                                        <th width='10%' class='font-15' style='text-align: center;color: #FFFFFF; vertical-align: middle;'>Harga</th>
                                         <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Diskon</th>
                                        <th width='15%' class='font-15' style='text-align: center;color: #FFFFFF; vertical-align: middle;'>Subtotal</th>

                                    </tr>";

//                        $cFormatRaw .= "<tr><th colspan='7' width='25%' class='font-15' style='text-align: left; color: black; vertical-align: middle;'>Alamat : " . $aRow['address'] . "</th></tr>";
                        $sindex = 0;
                        $totalSub = 0;
                        $totalDisc = 0;
                        $totalcashback = 0;
                        $totgab = 0;

                        foreach($trdAssoc as $cIdx => $tRow){
                            $totalSub = $totalSub + $tRow['subtotal'];
                            $totalDisc = $totalDisc + $tRow['disc'];
//                            $total = $totalSub - $totalDisc;
                            $tharga = $totalSub + $totalDisc;
                            $sindex++;
                            if(\Auth::user()->flag_verif == 1){
                                $flagKenaPromo = array_search((substr($tRow['PLU'], 0, 6) . "0"), array_column($arrayPromosi, 'KD_PLU')); //RETURN-AN AGUS VS PLU CART
                            }
                            $cFormatRaw .= "<tr>
                                            <td style='text-align: center; vertical-align: middle;'>" . $sindex ."</td>";

                            if ($tRow['url_pic_prod'] != null) {
                                $cFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . $tRow['url_pic_prod'] . "'/></td>";
                            } else {
                                $cFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . url('img/noimage.png') . "'/></td>";
                            }
                            $cFormatRaw .= "<td style='text-align: left'>" . $tRow['PLU'] . "-" . $tRow['long_description'] . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['qty'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['harga'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['disc'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['subtotal'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "</tr>";
                            if(\Auth::user()->flag_verif == 1){
                                if($flagKenaPromo !== FALSE){
                                    $cFormatRaw .= "<tr style='background-color: beige;'>
									<td colspan='3' style='vertical-align: middle;text-align:right'>Potongan CB " . $arrayPromosi[$flagKenaPromo]['KD_PROMOSI'] . " : </td>
									<td class='font-14' colspan='2' style='vertical-align: middle;text-align:center'>" . $arrayPromosi[$flagKenaPromo]['KELIPATAN'] . " x -" . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH']/$arrayPromosi[$flagKenaPromo]['KELIPATAN'], 0, ",", ".") . "</td>
									<td class='font-14' colspan='2' style='text-align: middle;vertical-align: middle;'>- Rp." . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH'], 0, ",", ".") . "</td>
							   </tr>";
                                    unset($arrayPromosi[$flagKenaPromo]); // remove item at index 0
                                    $arrayPromosi = array_values($arrayPromosi);
                                }
                            }
                        }

                        $cFormatRaw .= "</table></div>";
                    }

                }
                if(\Auth::user()->flag_verif == 1) {
                    foreach ($array as $index => $Row) {
                        //$cashback = $array[$key]['RUPIAH'];
                        if ($Row['TIPE_PROMOSI'] == "CASHBACK" && $Row['JENIS_PROMOSI'] == "0") {
                            $cashback = $Row['RUPIAH'];
                            $totalcashback = $totalcashback + ($cashback);

                        }

                        if ($Row['TIPE_PROMOSI'] == "CASHBACK" && $Row['JENIS_PROMOSI'] === "1") {
                            $cashbackgabungan = $Row['RUPIAH'];
                            $totgab = $totgab + ($cashbackgabungan);
                        }
                    }
                }



                $detailFormatRaw .= "<div class='col-md-4' style='border-width:0px;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; padding-bottom: 15px;float: right'>";
                $detailFormatRaw .= "<div class='row' style='margin-left: 0px;margin-right: 0px;padding-left: 20px;padding-top: 20px;'>";
                $detailFormatRaw .= "<div style='text-align: left;font-weight: bold;text-align: left;font-size: medium !important;'>Detail Order</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

                $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Belanja <span style='padding-right: 10px;float: right'>Rp. " . number_format($tharga, 0, ",", ".") . "</span></div>";

                $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Diskon <span style='padding-right: 10px;float: right'>Rp. " . number_format($totalDisc, 0, ",", ".") . "</span></div>";

                $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Cashback <span style='padding-right: 10px;float: right'>Rp. " . number_format($totalcashback, 0, ",", ".") . "</span></div>";

                $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Cashback Gabungan <span style='padding-right: 10px;float: right'>Rp. " . number_format($totgab, 0, ",", ".") . "</span></div>";

                if ($kirim == 'COD') {
                    $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
                } elseif ($kirim == 'ANTAR') {
                    if(count($FlagFreeOngkir) > 0 && $total >= $FlagFreeOngkir){
                        $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
                    }elseif($countFreeOngkir > 0){
                        $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
                    }else{
                        $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>Pesanan ini dikenakan ongkos kirim</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

                    }

                }
                //$detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

                $detailFormatRaw .= "<div style='text-align: left; font-weight: bold' id='total'>Total Pembayaran<span style='padding-right: 10px;float: right'>Rp. " . number_format($totalSub - $totalcashback - $totgab, 0, ",", ".") . "</span></div>";

                $firstGift = TRUE;
                if(\Auth::user()->flag_verif == 1) {
                    foreach ($array as $index => $Row) {

                        if ($Row['TIPE_PROMOSI'] == "GIFT" && $Row['JENIS_PROMOSI'] == "PD" && $Row['FLAG_KIOSK'] != "Y") {
                            if ($firstGift === TRUE) {
                                $detailFormatRaw .= "
						   <div class='font-14' style='text-align: left; margin-top:10px;'>Anda memperoleh : &nbsp; </div>";
                                $firstGift = FALSE;
                            }

                            $detailFormatRaw .= "
                               <div class='font-12' style='text-align: left'><b>" . $Row['QTY'] . " buah &nbsp;" . $Row['KET_HADIAH'] . "</b></div>";

                        } elseif ($Row['TIPE_PROMOSI'] == "GIFT" && $Row['JENIS_PROMOSI'] == "PR" && $Row['FLAG_KIOSK'] != "Y") {
                            if ($firstGift === TRUE) {
                                $detailFormatRaw .= "<div class='font-14' style='text-align: left; margin-top:10px;'>Anda memperoleh : &nbsp; </div>";
                                $firstGift = FALSE;
                            }

                            $detailFormatRaw .= "
                               <div class='font-12' style='text-align: left'><b>" . $Row['QTY'] . " POIN dari PROMOSI &nbsp;(" . $Row['NM_PROMOSI'] . ")</b></div>

                           ";
                        }
                    }
                }
                $detailFormatRaw .= "</div>";
                $detailFormatRaw .= "</div>";

                \DB::commit();
                return view('product.viewcheckout')->with('sucadd', 'TES1')->with('detailcheckout', $cFormatRaw)->with('ListAddress', $CartAddressDefault)->with('detailpayment', $detailFormatRaw);
            } catch (Exception $ex) {
                \DB::rollBack();
                return view('product.viewcheckout')->with('erroradd', 'TES1');
            }
        }
    }

    public function checkOut($nopo, $kirim)
    {

        if($nopo == 'blank'){
            $nomor =  "NO-PO-" . str_pad(Invoice::getInvoice(), 6, '0', STR_PAD_LEFT) . "";
        }else{
            $nomor= $nopo;
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        $userid = \Auth::User()->id;

        if($typeuserid == 1) {
            $kodemember = \DB::table('customers')->distinct()
                ->Join('members', 'customers.id', '=', 'members.customer_id')
                ->Pluck('kode_member');
        }else{
            $kodemember = \Auth::user()->kodemember;
        }

        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        $CartAddress = Address::Distinct();
        if(\Auth::user()->flag_verif == 1) {
            $CartAddress = $CartAddress->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
                ->join('branches','addresses.branch_id', '=', 'branches.id')
                ->join('provinces','addresses.province_id', '=', 'provinces.id')
                ->join('cities', 'addresses.city_id','=','cities.id')
                ->join('members', 'addresses.member_id', '=', 'members.id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
                ->Where('member_id',$userid)
                ->Where('flag_default', 1)
                ->Get();
        }else{
            $CartAddress = $CartAddress->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'sub_districts.sub_district_name')
                ->join('branches','addresses.branch_id', '=', 'branches.id')
                ->join('provinces','addresses.province_id', '=', 'provinces.id')
                ->join('cities', 'addresses.city_id','=','cities.id')
                ->join('members', 'addresses.member_id', '=', 'members.id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
                ->Where('member_id',$userid)
                ->Get();
        }

        $cartAssoc = Cart::getCartContent();

        $data = "$kodecabang@$kodemember|";
        $cFormatRaw = "";

        if($kodemember != "" && \Auth::user()->flag_verif == 1){
            foreach($cartAssoc as $index => $row){
                if($index > 0) {
                    $data .= "#";
                }
                else{
                    $cFormatRaw .= "<tr class='warning'>
						   <td colspan='7' class='font-14' style='text-align: center'><b>Tidak ada item di Keranjang Anda</b></td>
						   </tr>";
                }

                $prdInfo = Product::getInfoData($row['PLU']);
                $diskon = $prdInfo->DISC;
                if(!$diskon) $diskon = 0;
                $perPcs = $prdInfo->HRG;
                $frac = $prdInfo->frac;
                $perFrac = $perPcs * $frac;
                $plu = $row['PLU'];
                $qty = $row['qty'];
                $unit = $prdInfo->unit;
            }

        }

        $CartAddressDefault = Address::getAddressCheckout();

        $count = 0;
        $cFormatRaw = "";
        $detailFormatRaw = "";

        if (Count($CartAddress) > 0) {

            \DB::beginTransaction();
            try {

                $InvoiceAssoc = Invoice::createInvoice($userid);
//                $invoiceID = Invoice::getInvoice();
                $invoiceID = TrHeader::SelectRaw('MAX(kode_transaksi)')->pluck('MAX(kode_transaksi)');
                $invoiceID = $invoiceID +1;
//
//                if(\Auth::user()->flag_verif == 1) {
//
//                    $array = \DB::table('temp_promo')
//                        ->select('details_promo')
//                        ->where('userid', \Auth::User()->id)
//                        ->get();
////
//                    $arrayPromosi = json_decode($array);
//                }

                if(\Auth::user()->flag_verif == 1) {
                    $arrayPromosi = TempPromo::where('userid', \Auth::User()->id)->pluck('details_promo')->toArray();

                    if($arrayPromosi != null){
                        $array = json_decode($arrayPromosi[0], true);
                    }
                }

                foreach ($CartAddress as $cIdx => $aRow) {
                    $cAssoc = Cart::getCartContentKat($aRow['id']);

                    if (count($cAssoc) > 0) {
                        $userid = \Auth::User()->id;
                        $kdCabang = Branch::getCartBranches($aRow['id']);
                        $member = User::getNameMember();

                        $addressid = \DB::table('members')
                            ->Join('addresses', 'members.id', '=', 'addresses.member_id')
                            ->Where('members.id', $userid)
                            ->Where('flag_default', 1)
                            ->pluck('addresses.id');


                        foreach ($member as $uIdx => $uRow) {
                            $kdmem = $uRow['kode_member'];
                            $name = $uRow['nama'];
                            $email = $uRow['email'];
                            $namanpwp = $uRow['npwp_name'];
                            $nomornpwp = $uRow['npwp_number'];
                            $alamatnpwp = $uRow['npwp_address'];
                        }
                        $address = $aRow->address;
                        $addressID = $aRow->id;
                        $subdistrictname = $aRow->sub_district_name;
                        $districtname = $aRow->district_name;
                        $cityname = $aRow->city_name;
                        $provincename = $aRow->province_name;
                        $phone = $aRow->phone_number;
                        $postalcode = $aRow->postal_code;
                        $distance = $aRow->distance;

                        $nopo = Cart::getCartContentKat($aRow['id'])->pluck('no_po')->first();

                        if($nopo == "" || $nopo == null){
                            $nopo = $nomor;
                        }

//
//                      dd($FlagFreeOngkir);

//                        $typeongkir = $Request->get('kirim');


                        $HeaderID = TrHeader::createHeader($phone, $address, $subdistrictname, $districtname, $cityname, $provincename, $postalcode, $kdCabang, $invoiceID, $addressID, $nopo);

                        $tharga = 0;
                        $tdisc = 0;
                        $total = 0;
                        $csv = "Kode Cabang|No Anggota|No Pemesanan|No PO|Tgl Pemesanan|Kode Alamat|Kode PLU|Satuan|Harga (Rp)|Jml Pesanan|Bebas Biaya Pengiriman|Nama Penerima|Email|No Hp|Nama WP|NPWP|Alamat WP|Jarak\n"; //CSV HEADER
                        foreach ($cAssoc as $cIdx => $cRow) {
                            if($cRow['price'] == null){
                                $harga = $this->cekHargaMBT($cAssoc, $cRow['PLU'], $cRow['qty']);
                                $diskon = $this->cekHargaDiskon($cRow['PLU'], $harga, $cRow['qty']);
                            }else{
                                $harga = $cRow['price'] * $cRow['qty'];
                                $diskon = 0;
                            }
                            $tharga = $tharga + ($harga);
                            $tdisc = $tdisc + ($diskon);
                            $total = $tharga - $tdisc;
                            $stotal = $harga - $diskon;
                            $perPcs = $harga / $cRow['qty'];
                            $plu = $cRow['PLU'];
                            $qty = $cRow['qty'];
                            $picprod = $cRow['url_pic_prod'];

                            $perPcscsv = $stotal / $cRow['qty'];

//                            $flagKenaPromo = array_search((substr($cRow['PLU'], 0, 6) . "0"), array_column($arrayPromosi, 'KD_PLU')); //RETURN-AN AGUS VS PLU CART

                            TrDetail::insertDetail($HeaderID, $plu, $qty, $perPcs, $diskon, $stotal, $picprod);

                        }



                        if(\Auth::user()->flag_verif == 1) {
                            foreach ($arrayPromosi as $index => $Row) {
                            }
                        }

                        TrHeader::updateHeader($HeaderID, $total, $tharga, $tdisc);


                        $countFreeOngkir = \DB::table('freeongkir_hdr')->select('id')
                            ->Join('freeongkir_dtl', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
                            ->Where('kodemember', \Auth::User()->id)
                            ->Where('kode_igr', $kdCabang)
                            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
                            ->Where('flag_all', 'N')
                            ->Count();

                        $FlagFreeOngkir = \DB::table('freeongkir_hdr')
                            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
                            ->where('flag_all', '=', 'Y')
                            ->where('cabang', $kdCabang)
                            ->pluck('nominal');

                        $FlagCabOngkir = \DB::table('freeongkir_hdr')
                            ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                            ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
                            ->where('cabang', $kdCabang)
                            ->Where('flag_all', 'Y')
                            ->count();


                        if ($kirim == 'COD') {
                            $ongkir = 'T';
                        } elseif ($kirim == 'ANTAR') {
//                                if(count($FlagFreeOngkir) > 0 && $total >= $FlagFreeOngkir){
//                                    $ongkir = 'Y';
//                                }else
                            if($countFreeOngkir > 0) {
                                $ongkir = 'Y';
                            }elseif($FlagCabOngkir > 0 && $total >= $FlagFreeOngkir){
                                $ongkir = 'Y';
                            }else{
                                $ongkir = 'N';
                            }

                        }

//                            dd($ongkir);

                        $trDtlAssoc = TrDetail::getTransactionDetail($invoiceID, $addressID);



                        foreach ($trDtlAssoc as $Idx => $dRow) {

                            $harga = $dRow['harga'];
                            $qty1 = $dRow['qty'];
                            $plu1 = $dRow['PLU'];
                            $perPcs1 = $harga;

                            if($typeuserid == 1) {
                                $headercsv = str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . "/cor/" . date("m/Y");
                            }elseif($typeuserid == 3){
                                $headercsv = str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . "/odr/" . date("m/Y");
                            }else{
                                $headercsv = str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . "/omm/" . date("m/Y");
                            }

                            $unit1 = Product::getUnit($plu);

                            $csv .= $kdCabang . "|"
                                . $kdmem . "/web/bln/tgl|"
                                . $headercsv . "|"
                                . $nopo . "|"
                                . date("d/m/Y") . "|"
                                . str_replace("|", null, $address) . ", " . str_replace("|", null, $subdistrictname) . ", " . str_replace("|", null, $districtname) . ", " . str_replace("|", null, $cityname) . ", " . str_replace("|", null, $provincename) . ", " . str_replace("|", null, $postalcode) . "|"
                                . $plu1 . "|"
                                . $unit1 . "|"
                                . $perPcs1 . "|"
                                . $qty1 . "|"
                                . $ongkir . "|"
                                . $name . "|"
                                . $email . "|"
                                . $phone . "|"
                                . $namanpwp . "|"
                                . $nomornpwp . "|"
                                . $alamatnpwp ."|"
                                . $distance .""
                                . "\n"; //Generate CSV Row
                        }


                        //                $min_order = User::find($userid)->minor;

                        //Create CSV OBI
                        if($typeuserid == 1){
                            $csvname = 'PB_' . $kdCabang . '_' . str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . '-cor-' . date("m-Y") . '.csv';
                        }elseif($typeuserid == 3){
                            $csvname = 'PB_' . $kdCabang . '_' . str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . '-odr-' . date("m-Y") . '.csv';
                        }else{
                            $csvname = 'PB_' . $kdCabang . '_' . str_pad($HeaderID, 6, "0", STR_PAD_LEFT) . '-omm-' . date("m-Y") . '.csv';
                        }

                        $csv_handler = fopen("../resources/assets/csv/" . $csvname, 'w');
                        fwrite($csv_handler, $csv);
                        fclose($csv_handler);

                        //Insert ke Tr Download
                        $csvDB = New TrDown;
                        $csvDB->kode_transaksi = $HeaderID;
                        $csvDB->status_download = 0;
                        $csvDB->kode_cabang = $kdCabang;
                        $csvDB->nama_file = $csvname;
                        $csvDB->save();

                        Cart::truncateUserCart($aRow['id']);


                        $trhAssoc = TrHeader::where('kode_transaksi', $HeaderID)->first();
                        $trdAssoc = TrDetail::getTransactionDetail($invoiceID, $addressID);

                        $mbrAssoc = User::find($trhAssoc->userid);
                        $emlAssoc = EmailRecv::where('kode_cabang', $kdCabang)->get();

                        if($typeuserid == 1){
                            $noPb = str_pad($HeaderID, 6, '0', STR_PAD_LEFT) . '/cor/' . date('m/Y');
                        }elseif($typeuserid == 3){
                            $noPb = str_pad($HeaderID, 6, '0', STR_PAD_LEFT) . '/odr/' . date('m/Y');
                        }else{
                            $noPb = str_pad($HeaderID, 6, '0', STR_PAD_LEFT) . '/omm/' . date('m/Y');
                        }


                        foreach($trdAssoc as $trow){
                            $trow->unit = Product::Where('prdcd', $trow['PLU'])->pluck('unit');
                            $trow->frac = Product::Where('prdcd', $trow['PLU'])->pluck('frac');
                        }

                        $emails = $mbrAssoc->email;


//                        $arrayPromosiemail = json_encode($array, true);

                        if(\Auth::user()->flag_verif == 1) {
                            \Mail::send('emails.mailer.mailer', ['trharray' => $trhAssoc, 'trdarray' => $trdAssoc, 'promktarray' => $arrayPromosi, 'usrarray' => $mbrAssoc], function ($message) use ($emails) {
                                $message->to($emails)->subject('Konfirmasi Pemesanan Barang');
                            });
                        }else{
                            \Mail::send('emails.mailer.mailer', ['trharray' => $trhAssoc, 'trdarray' => $trdAssoc, 'usrarray' => $mbrAssoc], function ($message) use ($emails) {
                                $message->to($emails)->subject('Konfirmasi Pemesanan Barang');
                            });
                        }

                        $admEmails = array();
                        $admCount = 0;
                        foreach ($emlAssoc as $eAssoc) {
                            $admEmails[] = $eAssoc->email;
                            $admCount++;
                        }
                        if($admCount > 0){
                            if(\Auth::user()->flag_verif == 1) {
                                \Mail::send('emails.mailer.notification', ['kodeMM' => $mbrAssoc->nama . "(UserID : " . $mbrAssoc->id . ")", 'trharray' => $trhAssoc, 'trdarray' => $trdAssoc, 'promktarray' => $arrayPromosi, 'usrarray' => $mbrAssoc, 'typeid' => $typeuserid], function ($message) use ($admEmails) {
                                    $message->to($admEmails)->subject('Notifikasi Pemesanan Barang');
                                    $message->bcc('cs.klik@indogrosir.co.id', 'Cs Klik');
                                    $message->bcc('klikindogrosir1@indogrosir.co.id', 'Cs Klik1');
                                });
                            }else{
                                \Mail::send('emails.mailer.notification', ['kodeMM' => $mbrAssoc->nama . "(UserID : " . $mbrAssoc->id . ")", 'trharray' => $trhAssoc, 'trdarray' => $trdAssoc, 'usrarray' => $mbrAssoc, 'typeid' => $typeuserid], function ($message) use ($admEmails) {
                                    $message->to($admEmails)->subject('Notifikasi Pemesanan Barang');
                                    $message->bcc('cs.klik@indogrosir.co.id', 'Cs Klik');
                                    $message->bcc('klikindogrosir1@indogrosir.co.id', 'Cs Klik1');
                                });
                            }
                        }


                        $response = array();
                        try{
                            $response["kdCabang"] = $kdCabang;
                            $response["noAnggota"] = $kdmem . "/web/bln/tgl";
                            $response["noPB"] = $noPb;
                            $response["noPO"] = $nopo;
                            $response["Alamat"] = "". str_replace("|", null, $address) . ", " . str_replace("|", null, $subdistrictname) . ", " . str_replace("|", null, $districtname) . ", " . str_replace("|", null, $cityname) . ", " . str_replace("|", null, $provincename) . ", " . str_replace("|", null, $postalcode) . "";
                            $response["freeKirim"] = $ongkir;
                            $response["noHp"] = $phone;
                            $response["email"] = $email;
                            $response["namaPenerima"] = $name;
                            $response["namaWP"] = $namanpwp;
                            $response["noWP"] = $nomornpwp;
                            $response["alamatWP"] = $alamatnpwp;
                            $response["jarak"] = $distance;
                            $response["order"] = $trdAssoc->toJson();

                        }catch (Exception $ex){
                            $response["success"] = 0;
                            $response["message"] = "FAILED - " . $ex;
                        }

//                        $ch = curl_init('http://172.31.2.118/aldoapi/public/upload');
                        $ch = curl_init('http://172.31.2.118/aldoapi_sim/public/upload');
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'X-Authorization : 4b8bf8518b027f7adbf0e6c367ccb204b397566e',
//                           'Content-Type: application/x-www-form-urlencoded'
                        ));
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                        //execute post
                        $result = curl_exec($ch);

                        //close connection
                        curl_close($ch);


                    }
                }

                if(\Auth::user()->flag_verif == 1){
                    $arrayPromosi = $array;
                }
                

                foreach ($CartAddress as $cIdx => $aRow) {
                    $trdAssoc = TrDetail::getTransactionDetail($invoiceID, $aRow['id']);

                    if (count($trdAssoc) > 0) {
                        $cFormatRaw .= "<div class='col-md-12' style='box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);padding-left: 0px;padding-right: 0px;'><table width='100%' style='text-align: start; border-right-color:white;padding-bottom: 0px' class='table table-striped table-condensed table-responsive cart cart" . $aRow['id'] . "' data-id='" . $aRow['id'] . "'>";
                        $cFormatRaw .= "<tr style='background-color: #2980b9'>
                                        <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>No.</th>
                                        <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Gambar</th>
                                        <th width='25%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Deskripsi</th>
                                        <th width='20%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Jumlah</th>
                                        <th width='10%' class='font-15' style='text-align: center;color: #FFFFFF; vertical-align: middle;'>Harga</th>
                                         <th width='10%' class='font-15' style='text-align: center; color: #FFFFFF; vertical-align: middle;'>Diskon</th>
                                        <th width='15%' class='font-15' style='text-align: center;color: #FFFFFF; vertical-align: middle;'>Subtotal</th>

                                    </tr>";

//                        $cFormatRaw .= "<tr><th colspan='7' width='25%' class='font-15' style='text-align: left; color: black; vertical-align: middle;'>Alamat : " . $aRow['address'] . "</th></tr>";
                        $sindex = 0;
                        $totalSub = 0;
                        $totalDisc = 0;
                        $totalcashback = 0;
                        $totgab = 0;

                        foreach($trdAssoc as $cIdx => $tRow){
                            $totalSub = $totalSub + $tRow['subtotal'];
                            $totalDisc = $totalDisc + $tRow['disc'];
//                            $total = $totalSub - $totalDisc;
                            $tharga = $totalSub + $totalDisc;
                            $sindex++;
                            if(\Auth::user()->flag_verif == 1){
                                $flagKenaPromo = array_search((substr($tRow['PLU'], 0, 6) . "0"), array_column($arrayPromosi, 'KD_PLU')); //RETURN-AN AGUS VS PLU CART
                            }
                            $cFormatRaw .= "<tr>
                                            <td style='text-align: center; vertical-align: middle;'>" . $sindex ."</td>";

                            if ($tRow['url_pic_prod'] != null) {
                                $cFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . $tRow['url_pic_prod'] . "'/></td>";
                            } else {
                                $cFormatRaw .= "<td style='vertical-align: middle;'><img  height='100' width='100' src='" . url('../resources/assets/img/noimage.png') . "'/></td>";
                            }
                            $cFormatRaw .= "<td style='text-align: left'>" . $tRow['PLU'] . "-" . $tRow['long_description'] . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['qty'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['harga'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['disc'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "<td style='text-align: center'>" . number_format($tRow['subtotal'], 0, ',', '.') . "</td>";
                            $cFormatRaw .= "</tr>";
                            if(\Auth::user()->flag_verif == 1){
                                if($flagKenaPromo !== FALSE){
                                    $cFormatRaw .= "<tr style='background-color: beige;'>
									<td colspan='3' style='vertical-align: middle;text-align:right'>Potongan CB " . $arrayPromosi[$flagKenaPromo]['KD_PROMOSI'] . " : </td>
									<td class='font-14' colspan='2' style='vertical-align: middle;text-align:center'>" . $arrayPromosi[$flagKenaPromo]['KELIPATAN'] . " x -" . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH']/$arrayPromosi[$flagKenaPromo]['KELIPATAN'], 0, ",", ".") . "</td>
									<td class='font-14' colspan='2' style='text-align: middle;vertical-align: middle;'>- Rp." . number_format($arrayPromosi[$flagKenaPromo]['RUPIAH'], 0, ",", ".") . "</td>
							   </tr>";
                                    unset($arrayPromosi[$flagKenaPromo]); // remove item at index 0
                                    $arrayPromosi = array_values($arrayPromosi);
                                }
                            }
                        }

                        $cFormatRaw .= "</table></div>";
                    }

                }
                if(\Auth::user()->flag_verif == 1) {
                    foreach ($array as $index => $Row) {
                        //$cashback = $array[$key]['RUPIAH'];
                        if ($Row['TIPE_PROMOSI'] == "CASHBACK" && $Row['JENIS_PROMOSI'] == "0") {
                            $cashback = $Row['RUPIAH'];
                            $totalcashback = $totalcashback + ($cashback);

                        }

                        if ($Row['TIPE_PROMOSI'] == "CASHBACK" && $Row['JENIS_PROMOSI'] === "1") {
                            $cashbackgabungan = $Row['RUPIAH'];
                            $totgab = $totgab + ($cashbackgabungan);
                        }
                    }
                }



                $detailFormatRaw .= "<div class='col-md-4' style='border-width:0px;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; padding-bottom: 15px;float: right'>";
                $detailFormatRaw .= "<div class='row' style='margin-left: 0px;margin-right: 0px;padding-left: 20px;padding-top: 20px;'>";
                $detailFormatRaw .= "<div style='text-align: left;font-weight: bold;text-align: left;font-size: medium !important;'>Detail Order</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

                $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Belanja <span style='padding-right: 10px;float: right'>Rp. " . number_format($tharga, 0, ",", ".") . "</span></div>";

                $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Diskon <span style='padding-right: 10px;float: right'>Rp. " . number_format($totalDisc, 0, ",", ".") . "</span></div>";

                $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Cashback <span style='padding-right: 10px;float: right'>Rp. " . number_format($totalcashback, 0, ",", ".") . "</span></div>";

                $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Total Cashback Gabungan <span style='padding-right: 10px;float: right'>Rp. " . number_format($totgab, 0, ",", ".") . "</span></div>";

                if ($kirim == 'COD') {
                    $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
                } elseif ($kirim == 'ANTAR') {
                    if($FlagFreeOngkir > 0 && $total >= $FlagFreeOngkir){
                        $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
                    }elseif($countFreeOngkir > 0){
                        $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
                    }else{
                        $detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>Pesanan ini dikenakan ongkos kirim</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

                    }

                }
                //$detailFormatRaw .= "<div style='text-align: left; padding-bottom: 10px;'>Biaya Pengiriman <span style='padding-right: 10px;float: right'>GRATIS</span></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";

                $detailFormatRaw .= "<div style='text-align: left; font-weight: bold' id='total'>Total Pembayaran<span style='padding-right: 10px;float: right'>Rp. " . number_format($totalSub - $totalcashback - $totgab, 0, ",", ".") . "</span></div>";

                $firstGift = TRUE;
                if(\Auth::user()->flag_verif == 1) {
                    foreach ($array as $index => $Row) {

                        if ($Row['TIPE_PROMOSI'] == "GIFT" && $Row['JENIS_HADIAH'] == "PD" && $Row['FLAG_KIOSK'] != "Y") {
                            if ($firstGift === TRUE) {
                                $detailFormatRaw .= "
						   <div class='font-14' style='text-align: left; margin-top:10px;'>Anda memperoleh : &nbsp; </div>";
                                $firstGift = FALSE;
                            }

                            $detailFormatRaw .= "
                               <div class='font-12' style='text-align: left'><b>" . $Row['QTY'] . " buah &nbsp;" . $Row['KET_HADIAH'] . "</b></div>";

                        } elseif ($Row['TIPE_PROMOSI'] == "GIFT" && $Row['JENIS_HADIAH'] == "PR" && $Row['FLAG_KIOSK'] != "Y" && $typeuserid != 3) {
                            if ($firstGift === TRUE) {
                                $detailFormatRaw .= "<div class='font-14' style='text-align: left; margin-top:10px;'>Anda memperoleh : &nbsp; </div>";
                                $firstGift = FALSE;
                            }

                            $detailFormatRaw .= "
                               <div class='font-12' style='text-align: left'><b>" . $Row['QTY'] . " POIN dari PROMOSI &nbsp;(" . $Row['NM_PROMOSI'] . ")</b></div>

                           ";
                        }
                    }
                }
                $detailFormatRaw .= "</div>";
                $detailFormatRaw .= "</div>";

                \DB::commit();
                return view('product.viewcheckout')->with('sucadd', 'TES1')->with('detailcheckout', $cFormatRaw)->with('ListAddress', $CartAddressDefault)->with('detailpayment', $detailFormatRaw);
            } catch (Exception $ex) {
                \DB::rollBack();
                return view('product.viewcheckout')->with('erroradd', 'TES1');
            }
        }
    }

}