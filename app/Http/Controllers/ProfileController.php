<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\BranchDistrict;
use App\Models\City;
use App\Models\District;
use App\Models\ProductView;
use App\Models\Province;
use App\Models\SubDistrict;
use Carbon\Carbon;
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
use App\Models\Promotion;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

    public function index()
    {
        $profilAssoc = User::getProfileUser();

        $provFormat="";
        $citFormat="";
        $disFormat="";
        $Province = Province::getAllProvince();
        $Cities = City::getCityByProv("%");
        $District = District::getDistrictByCity("%");

        foreach($Province as $index=> $prow) {

            $provFormat .= "<option style='font-size: 12px;' value='". $prow->id ."'>" . $prow->province_name . "</option>";
        }
        foreach($Cities as $index => $crow) {
            $citFormat .= "<option style='font-size: 12px;' value='" . $crow->id . "'>" . $crow->city_name . "</option>";
        }
        foreach($District as $index => $drow) {
            $disFormat .= "<option style='font-size: 12px;' value='" . $drow->id . "'>" . $drow->district_name . "</option>";
        }


        return view('user.editprofile')->with('divdeptkat', $this->getMenuDropdown())->with('sidebar', $this->getSideBar())->with('profilArray',$profilAssoc)->with('provOpt', $provFormat)->with('citOpt', $citFormat)->with('disOpt', $disFormat)->with('divdeptkatmobile', $this->getMenuDropdownMobile());
    }

    public function UpdateProfile(Request $Request){

        $userid = \Auth::User()->id;
        $editname = $Request->get('nama');
        $editNohp = $Request->get('NoHp');
        $npwpname = $Request->get('namanpwp');
        $npwpnumber = $Request->get('nomornpwp');
        $npwpaddress = $Request->get('alamatnpwp');
        $profilAssoc = User::getProfileUser();

        foreach($profilAssoc as $index => $crow) {
        }

        $oldname = $crow['nama'];
        $oldnohp = $crow['phone_number'];
        $oldnamanpwp = $crow['npwp_name'];
        $oldnomornpwp = $crow['npwp_number'];
        $oldalamatnpwp = $crow['npwp_address'];


        if($editname == $oldname && $editNohp == $oldnohp && $npwpname == $oldnamanpwp && $npwpnumber == $oldnomornpwp && $npwpaddress == $oldalamatnpwp){
            return redirect('profile')->with('err', 'Anda tidak melakukan perubahan data');
        }else{
            \DB::table('members')
                ->where('id', $userid)
                ->update(['nama' => $editname]);

            \DB::table('addresses')
                ->where('member_id', $userid)
                ->update(['phone_number' => $editNohp]);

            if($npwpname == null || $npwpnumber == null || $npwpaddress == null){
                return redirect('profile')->with('errnpwp', 'Isian Data NPWP Anda belum lengkap, Mohon periksa kembali !');
            }else{
                \DB::table('members')
                    ->where('id', $userid)
                    ->update(['npwp_name' => $npwpname]);

                \DB::table('members')
                    ->where('id', $userid)
                    ->update(['npwp_number' => $npwpnumber]);

                \DB::table('members')
                    ->where('id', $userid)
                    ->update(['npwp_address' => $npwpaddress]);

            }

            return redirect('profile')->with('suc', 'Anda berhasil melakukan perubahan data profile Anda');
        }

    }

    public function getCity(Request $Request){
        $prov = $Request -> get('prov');
        $Cities = City::getCityByProv($prov);
        $cityFormat="<option value='0'>--Pilih Kota--</option>";

        foreach($Cities as $index => $crow) {
            $cityFormat .= "<option style='font-size: 12px;' value='" . $crow->id . "'>" . $crow->city_name . "</option>";
        }
        return $cityFormat;
    }

    public function getDistrict(Request $Request){
        $city = $Request -> get('city');
        $District = District::getDistrictByCity($city);
        $disFormat="<option value='0'>--Pilih Kecamatan--</option>";

        foreach($District as $index => $Drow) {
            $disFormat .= "<option style='font-size: 12px;' value='" . $Drow->id . "'>" . $Drow->district_name . "</option>";
        }
        return $disFormat;
    }

    public function getSubDistrict(Request $Request){
        $district = $Request -> get('district');
        $SubDistrictBranch = SubDistrict::getSubDistrictByDistrict($district);
        $SubDistrictFormat="<option value='0'>--Pilih Kelurahan--</option>";

        foreach($SubDistrictBranch as $index => $prow) {
            $SubDistrictFormat .= "<option style='font-size: 12px;' value='" . $prow->id . "'>" . $prow->sub_district_name . "</option>";
        }
        return $SubDistrictFormat;
    }
	
	 public function getLocation()
    {
        return view('user.location')->with('divdeptkat', $this->getMenuDropdown())->with('sideprofile', $this->getSideProfile())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;
    }

    public function getPolicy()
    {
        return view('user.policy')->with('divdeptkat', $this->getMenuDropdown())->with('sideprofile', $this->getSideProfile())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;
    }

    public function getTerm()
    {
        return view('user.term')->with('divdeptkat', $this->getMenuDropdown())->with('sideprofile', $this->getSideProfile())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;
    }

    public function getFAQ()
    {
        return view('user.faq')->with('divdeptkat', $this->getMenuDropdown())->with('sideprofile', $this->getSideProfile())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;
    }

    public function getContact()
    {
        return view('user.contact')->with('divdeptkat', $this->getMenuDropdown())->with('sideprofile', $this->getSideProfile())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;
    }

    public function getInfo()
    {
        return view('user.info')->with('divdeptkat', $this->getMenuDropdown())->with('sideprofile', $this->getSideProfile())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;
    }

    public function getRegister()
    {
        return view('user.reg')->with('divdeptkat', $this->getMenuDropdown())->with('sideprofile', $this->getSideProfile())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;
    }

    public function getBuy()
    {
        return view('user.buy')->with('divdeptkat', $this->getMenuDropdown())->with('sideprofile', $this->getSideProfile())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;
    }

    public function getListPromo() {

//        $viewpromo = Promotion::getListPromotion();

        return view('product.listpromo');
    }

    public function getPromoNotif($id) {

        $viewpromo = Promotion::getViewPromo($id);

        $tipe = \DB::table('promotions')
            ->leftJoin('promotion_links', 'promotions.id', '=', 'promotion_links.promotion_id')
            ->Where('flag_active', 1)
            ->Where('promotions.id', $id)
            ->Pluck('link_type');

        if($tipe != 4 && $tipe != 5){
            $linktype = Promotion::getLinkPromo($id, $tipe);
        }else{
            $linktype = Promotion::getLinkKeteranganPromo($id);
        }
        

        return view('product.pushpromo')->with('viewpromotion', $viewpromo)->with('linkhdr', $linktype)->with('tipe', $tipe);
    }

}
