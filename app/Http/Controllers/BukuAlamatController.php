<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\BranchDistrict;
use App\Models\MemberOrderFile;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use App\Models\TransactionHeader as TrHeader;
use App\Models\TransactionDetail as TrDetail;
use App\Models\User as User;
use App\Models\Cart as Cart;
use App\Models\Product as Product;
use App\Models\Invoice;
use App\Models\Address;
use App\Models\Branch;
use App\Models\Province;
use App\Models\Category as Kat;
use App\Models\Category;
use App\Models\Department;
use App\Models\Divisi as Div;
use App\Models\Department as Dep;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\MySqlConnection;
use Maatwebsite\Excel\Facades\Excel;

class BukuAlamatController extends Controller
{
  public function index(){

    $addID = Address::getAddressID();

//      $trhAssoc = TrHeader::getListTransactionHeaders($addID);

//    $trhAssoc = TrHeader::getListTransactionHeaders($add);

    $html_prov = '';
    $html_city = '';
    $html_district = '';
    $html_sub_district = '';

    // dropdown Province (tambah alamat)
    // $province = DB::Select("select * from provinces order by province_name");
    $province = \DB::table('provinces')
                ->orderby('province_name')
                ->get();
    foreach ($province as $key => $row) {
      $html_prov .= "<option style='font-size:12px;' value='".$row->id."'>".$row->province_name."</option>";
    }

    // dropdown Kota/Kab. (tambah alamat)
    // $city = DB::Select("select * from cities order by city_name");
    $city = \DB::table('cities')
            ->orderby('city_name')
            ->get();
    foreach ($city as $key => $row) {
      $html_city .= "<option style='font-size:12px;' value='".$row->id."'>".$row->city_name."</option>";
    }

    // dropdown Kecamatan. (tambah alamat)
    // $district = DB::Select("select * from districts order by district_name");
    $district = \DB::table('districts')
                ->orderby('district_name')
                ->get();
    foreach ($district as $key => $row) {
      $html_district .= "<option style='font-size:12px;' value='".$row->id."'>".$row->district_name."</option>";
    }

    // dropdown Kelurahan. (tambah alamat)
    // $sub_district = DB::Select("select * from sub_districts order by sub_district_name");
    $sub_district = \DB::table('sub_districts')
                    ->orderby('sub_district_name')
                    ->get();
    foreach ($sub_district as $key => $row) {
      $html_sub_district .= "<option style='font-size:12px;' value='".$row->id."'>".$row->sub_district_name."</option>";
    } 

    return view('product.bukuAlamat')->with('divdeptkat', $this->getMenuDropdown())->with('sidebar', $this->getSideBar())->with('province', $html_prov)->with('city', $html_city)->with('district', $html_district)->with('sub_district', $html_sub_district)->with('divdeptkatmobile', $this->getMenuDropdownMobile());
	
    // return view('product.bukuAlamat')->with('divdeptkat', $this->getMenuDropdown())->with('sidebar', $this->getSideBar())->with('province', $html_prov);
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

  public function get_alamat(){
    $userid = \Auth::User()->id;
    $data = \DB::table('addresses')
                  ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama', 'sub_districts.sub_district_name')
                  ->join('provinces','addresses.province_id', '=', 'provinces.id')
                  ->join('cities', 'addresses.city_id','=','cities.id')
                  ->join('members', 'addresses.member_id', '=', 'members.id')
                  ->join('districts', 'addresses.district_id', '=', 'districts.id')
                  ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
                  ->WhereNull('addresses.deleted_at')     
                  ->where('members.id', $userid)
              ->get();
    // dd($userid);

    // $data = DB::Select("Select ad.*, p.province_name, c.city_name, d.district_name, m.email, m.nama, sd.sub_district_name from addresses ad, provinces p, cities c, members m, districts d, sub_districts sd
    //                 where ad.province_id = p.id
    //                 and ad.city_id = c.id
    //                 and ad.district_id = d.id
    //                 and ad.member_id = m.id
    //                 and ad.sub_district_id = sd.id
    //                 and m.id = $userid");
    return $data;
  }

  public function edit_alamat($id){
    $userid = \Auth::User()->id;

    $data = \DB::table('addresses')
                  ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.nama', 'sub_districts.sub_district_name')
                  ->join('provinces','addresses.province_id', '=', 'provinces.id')
                  ->join('cities', 'addresses.city_id','=','cities.id')
                  ->join('members', 'addresses.member_id', '=', 'members.id')
                  ->join('districts', 'addresses.district_id', '=', 'districts.id')
                  ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
                  ->where('members.id', $userid)
                  ->where('addresses.id', $id)
              ->get();

    // $data = DB::Select("Select ad.*, p.province_name, ad.province_id, ad.city_id, ad.district_id, ad.sub_district_id, c.city_name, d.district_name, m.email, m.nama, sd.sub_district_name from addresses ad, provinces p, cities c, members m, districts d, sub_districts sd
    //                 where ad.province_id = p.id
    //                 and ad.city_id = c.id
    //                 and ad.district_id = d.id
    //                 and ad.member_id = m.id
    //                 and ad.sub_district_id = sd.id
    //                 and m.id = $userid
    //                 and ad.id = $id");
    return $data;
  }

  public function alamat_default($id){
    $userid = \Auth::User()->id;
    $type_id = \Auth::User()->type_id;

    // $update_all = DB::Select("Update addresses set flag_default = 0 where member_id = $userid");
    // $update_default = DB::Select("Update addresses set flag_default = 1 where id = $id");

    if($type_id == "1"){
      $update_all = \DB::table('addresses')
          ->where('member_id', $userid)
          ->update(['flag_default' => 0]);

      $update_default = \DB::table('addresses')
          ->where('id', $id)
          ->update(['flag_default' => 1]);
    }else{
      $update_all = \DB::table('addresses')
          ->where('member_id', $userid)
          ->update(['flag_default' => 0]);

      $update_default = \DB::table('addresses')
          ->where('id', $id)
          ->update(['flag_default' => 1]);

      $update_keranjang = \DB::table('carts')
          ->where('userid', $userid)
          ->update(['address_id' => $id]);
    }
  }

  public function get_kota(Request $request){
    $html_kota = '<option value=0>-- Pilih Kota/Kab. --</option>';
    $id_prov = $request->get('id_prov');
    // $data_kota = DB::Select("Select * from cities where province_id = $id_prov");
    $data_kota = \DB::table('cities')
                  ->where('province_id', $id_prov)
                  ->get();
    foreach ($data_kota as $key => $row) {
      $html_kota .= "<option style='font-size:12px;' value='".$row->id."'>".$row->city_name."</option>";
    }
    return $html_kota;
  }

  public function get_district(Request $request){
    $html_district = '<option value=0>-- Pilih Kecamatan --</option>';
    $id_kota = $request->get('id_kota');
    // $data_district = DB::Select("Select * from districts where city_id = $id_kota");
    $data_district = \DB::table('districts')
                      ->where('city_id', $id_kota)
                      ->get();
    foreach ($data_district as $key => $row) {
      $html_district .= "<option style='font-size:12px;' value='".$row->id."'>".$row->district_name."</option>";
    }
    return $html_district;
  }

  public function get_sub_district(Request $request){
    $html_sub_district = '<option value=0>-- Pilih Kelurahan --</option>';
    $id_sub_district = $request->get('id_district');
    // $data_sub_district = DB::Select("Select * from sub_districts where district_id = $id_sub_district");
    $data_sub_district = \DB::table('sub_districts')
                          ->where('district_id', $id_sub_district)
                          ->get();
    foreach ($data_sub_district as $key => $row) {
      $html_sub_district .= "<option style='font-size:12px;' value='".$row->id."'>".$row->sub_district_name."</option>";
    }
    return $html_sub_district;
  }

  public function registerMember(){
    $userFormat = "";
    $htmlFormat = "";
    $cabangAssoc = Branch::getAllBranches();
    foreach ($cabangAssoc as $index => $row) {
      $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
    return view('auth.register')->with('cabangOpt', $htmlFormat);
  }

  public function tambah_alamat1(Request $request){
    $id = $request->get('txt_id_alamat');

    $idbranch = $request->get('txt_sub_district');

    $cab = BranchDistrict::Distinct()->Where('sub_district_id', $idbranch)->pluck('branch_id');

    if($cab != null){
      if($id == null){
        $add = new Address;
        $add->address = $request->get('txt_alamat_penagihan');
        $add->label = $request->get('txt_label');
        $add->province_id = $request->get('txt_province');
        $add->city_id = $request->get('txt_kota');
        $add->district_id = $request->get('txt_district');
        $add->sub_district_id = $request->get('txt_sub_district');

        $sub_dist = $request->get('txt_sub_district');
        // $branch = DB::Select("Select branch_id from branch_sub_districts where sub_district_id = $sub_dist");
        $branch = \DB::table('branch_sub_districts')
            ->select('branch_id')
            ->where('sub_district_id', $sub_dist)
            ->get();

        foreach ($branch as $key => $row) {
          $add->branch_id = $row->branch_id;
        }

        $sub_district_id = $request->get('txt_sub_district');
        // $postal_code = DB::Select("Select postal_code from sub_districts where id = $sub_district_id");
        $postal_code = \DB::table('sub_districts')
            ->select('postal_code')
            ->where('id', $sub_district_id)
            ->get();

        foreach ($postal_code as $key => $row) {
          $add->postal_code = $row->postal_code;
        }

        $add->member_id = \Auth::User()->id;
        $add->phone_number = $request->get('txt_notelp');
        $add->save();
        return redirect('bukualamat')->with('new', 'TES');
      }else{
        $edit = Address::find($id);
        $edit->address = $request->get('txt_alamat_penagihan');
        $edit->label = $request->get('txt_label');
        $edit->province_id = $request->get('txt_province');
        $edit->city_id = $request->get('txt_kota');
        $edit->district_id = $request->get('txt_district');
        $edit->sub_district_id = $request->get('txt_sub_district');

        $sub_dist = $request->get('txt_sub_district');
        // $branch = DB::Select("Select branch_id from branch_sub_districts where sub_district_id = $sub_dist");
        $branch = \DB::table('branch_sub_districts')
            ->select('branch_id')
            ->where('sub_district_id', $sub_dist)
            ->get();

        foreach ($branch as $key => $row) {
          $edit->branch_id = $row->branch_id;
        }

        $sub_district_id = $request->get('txt_sub_district');
        // $postal_code = DB::Select("Select postal_code from sub_districts where id = $sub_district_id");
        $postal_code = \DB::table('sub_districts')
            ->select('postal_code')
            ->where('id', $sub_district_id)
            ->get();

        foreach ($postal_code as $key => $row) {
          $edit->postal_code = $row->postal_code;
        }

        $edit->member_id = \Auth::User()->id;
        $edit->phone_number = $request->get('txt_notelp');
        $edit->save();
        return redirect('bukualamat')->with('new', 'TES');
        // $flight = App\Flight::find(1);
        // $flight->name = 'New Flight Name';
        // $flight->save();
      }
    }else{
      return redirect('bukualamat')->with('err', 'TES');
    }
  }

  public function tambah_alamat(Request $request){
    $id = $request->get('txt_id_alamat');

    $idbranch = $request->get('txt_sub_district');

    $cab = BranchDistrict::Distinct()->Where('sub_district_id', $idbranch)->pluck('branch_id');

    if($cab != null){
      if($id == null){
        $add = new Address;
        $add->address = $request->get('txt_alamat_penagihan');
        $add->label = $request->get('txt_label');
        $add->province_id = $request->get('txt_province');
        $add->city_id = $request->get('txt_kota');
        $add->district_id = $request->get('txt_district');
        $add->sub_district_id = $request->get('txt_sub_district');

        $sub_dist = $request->get('txt_sub_district');
        // $branch = DB::Select("Select branch_id from branch_sub_districts where sub_district_id = $sub_dist");
        $branch = \DB::table('branch_sub_districts')
            ->select('branch_id')
            ->where('sub_district_id', $sub_dist)
            ->get();

        foreach ($branch as $key => $row) {
          $add->branch_id = $row->branch_id;
        }

        $sub_district_id = $request->get('txt_sub_district');
        // $postal_code = DB::Select("Select postal_code from sub_districts where id = $sub_district_id");
        $postal_code = \DB::table('sub_districts')
            ->select('postal_code')
            ->where('id', $sub_district_id)
            ->get();

        foreach ($postal_code as $key => $row) {
          $add->postal_code = $row->postal_code;
        }

        $origin = Branch::select('latitude', 'longitude')->where('id', $cab)->get();

        foreach($origin as $index=> $prow) {
          $latitude1 = $prow->latitude;
          $longitude1 = $prow->longitude;
        }

        $destination = \DB::table('provinces')
            ->selectraw('CONCAT_WS(\',\', sub_district_name, district_name,city_name,province_name,sub_districts.postal_code) AS tujuan')
            ->join('cities', 'provinces.id','=','cities.province_id')
            ->join('districts', 'cities.id', '=', 'districts.city_id')
            ->join('sub_districts', 'districts.id', '=', 'sub_districts.district_id')
            ->where('provinces.id','LIKE', $request->get('txt_province'))
            ->where('cities.id','LIKE',$request->get('txt_kota'))
            ->where('districts.id','LIKE',$request->get('txt_district'))
            ->where('sub_districts.id','LIKE',$request->get('txt_sub_district'))
//            ->Where('addresses.id',$id)
            ->Pluck('tujuan');

        $tujuantanpaspasi = str_replace(' ', '', $destination);

        $aContext = array(
            'http' => array(
                'proxy' => 'tcp://192.168.10.202:6124',
                'request_fulluri' => true,
            ),
        );

        $cxContext = stream_context_create($aContext);

        $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". $latitude1 .",". $longitude1 ."&destination=". $tujuantanpaspasi ."&key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY", False, $cxContext);

        $data = json_decode($dataJson,true);

        try{
          $nilaiJarak = $data['routes'][0]['legs'][0]['distance']['text'];
          $lat = $data['routes'][0]['legs'][0]['end_location']['lat'];
          $longi = $data['routes'][0]['legs'][0]['end_location']['lng'];
        }catch(\Exception $ex){
          $nilaiJarak = "0";
          $lat = "0";
          $longi = "0";
        }

        $add->member_id = \Auth::User()->id;
        $add->phone_number = $request->get('txt_notelp');
        $add->latitude = $lat;
        $add->longitude = $longi;
        $add->distance = $nilaiJarak;
        $add->save();
        return redirect('bukualamat')->with('new', 'TES');
      }else{
        $edit = Address::find($id);
        $edit->address = $request->get('txt_alamat_penagihan');
        $edit->label = $request->get('txt_label');
        $edit->province_id = $request->get('txt_province');
        $edit->city_id = $request->get('txt_kota');
        $edit->district_id = $request->get('txt_district');
        $edit->sub_district_id = $request->get('txt_sub_district');

        $sub_dist = $request->get('txt_sub_district');
        // $branch = DB::Select("Select branch_id from branch_sub_districts where sub_district_id = $sub_dist");
        $branch = \DB::table('branch_sub_districts')
            ->select('branch_id')
            ->where('sub_district_id', $sub_dist)
            ->get();

        foreach ($branch as $key => $row) {
          $edit->branch_id = $row->branch_id;
        }

        $sub_district_id = $request->get('txt_sub_district');
        // $postal_code = DB::Select("Select postal_code from sub_districts where id = $sub_district_id");
        $postal_code = \DB::table('sub_districts')
            ->select('postal_code')
            ->where('id', $sub_district_id)
            ->get();

        foreach ($postal_code as $key => $row) {
          $edit->postal_code = $row->postal_code;
        }

        $origin = Branch::select('latitude', 'longitude')->where('id', $cab)->get();

        foreach($origin as $index=> $prow) {
          $latitude1 = $prow->latitude;
          $longitude1 = $prow->longitude;
        }

        $destination = \DB::table('provinces')
            ->selectraw('CONCAT_WS(\',\', sub_district_name, district_name,city_name,province_name,sub_districts.postal_code) AS tujuan')
            ->join('cities', 'provinces.id','=','cities.province_id')
            ->join('districts', 'cities.id', '=', 'districts.city_id')
            ->join('sub_districts', 'districts.id', '=', 'sub_districts.district_id')
            ->where('provinces.id','LIKE', $request->get('txt_province'))
            ->where('cities.id','LIKE',$request->get('txt_kota'))
            ->where('districts.id','LIKE',$request->get('txt_district'))
            ->where('sub_districts.id','LIKE',$request->get('txt_sub_district'))
//            ->Where('addresses.id',$id)
            ->Pluck('tujuan');


        $tujuantanpaspasi = str_replace(' ', '', $destination);

        $aContext = array(
            'http' => array(
                'proxy' => 'tcp://192.168.10.202:6124',
                'request_fulluri' => true,
            ),
        );

        $cxContext = stream_context_create($aContext);

        $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". $latitude1 .",". $longitude1 ."&destination=". $tujuantanpaspasi ."&key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY", False, $cxContext);

        $data = json_decode($dataJson,true);


        try{
          $nilaiJarak = $data['routes'][0]['legs'][0]['distance']['text'];
          $lat = $data['routes'][0]['legs'][0]['end_location']['lat'];
          $longi = $data['routes'][0]['legs'][0]['end_location']['lng'];
        }catch(\Exception $ex){
          $nilaiJarak = "0";
          $lat = "0";
          $longi = "0";
        }
       

        $edit->member_id = \Auth::User()->id;
        $edit->phone_number = $request->get('txt_notelp');
        $edit->latitude = $lat;
        $edit->longitude = $longi;
        $edit->distance = $nilaiJarak;
        $edit->save();
        return redirect('bukualamat')->with('new', 'TES');
        // $flight = App\Flight::find(1);
        // $flight->name = 'New Flight Name';
        // $flight->save();
      }
    }else{
      return redirect('bukualamat')->with('err', 'TES');
    }
  }

  public function delete_alamat($id){
    // $data = DB::delete("Delete from addresses where id = $id");
    $data = \DB::table('addresses')
            ->where('id', $id)
            ->delete();
  }

  public function getChangeAddress(){
    $cFormatRaw = "";
    $AddressAssoc = Address::getOptAddress();
    $AddressDefaultAssoc = Address::getAddressCheckout();

    $cFormatRaw .= "<div class='row' style='margin-left: 0px;margin-right: 0px;padding-left: 20px;'>";
    foreach ($AddressDefaultAssoc as $cIdx => $row) {
      $cFormatRaw .= "<div style='text-align: left;padding-top: 5px;font-size: medium !important;'>Alamat Pengiriman Saat ini :</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
//          $cFormatRaw .= "<div style='font-weight: bold;text-align: left;font-size: medium !important;'>Alamat Pengiriman </div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
      $cFormatRaw .= "<div style='font-weight: bold; text-align: left;'>" . $row['email'] . "</div>";
      $cFormatRaw .= "<div style='text-align: left;padding-top: 10px;'>" . $row['address'] . ",<br> Kel." . $row['sub_district_name'] . ", Kec. " . $row['district_name'] . ",  Kota " . $row['city_name'] . ", Prov. " . $row['province_name'] . "</div>";
      $cFormatRaw .= " <div style='text-align: left;'>" . $row['postal_code'] . "</div>";
      $cFormatRaw .= "  <div style='text-align: left; padding-bottom: 10px;'>" . $row['phone_number'] . "</div>";
      $cFormatRaw .= "<div style='font-weight: bold; text-align: left;'><a id=\"changeaddressdialog\" disabled='true' class='btn btn-default flat'>Akan Dikirim kesini</a></div><hr style='margin-top: 5px;margin-bottom: 5px;padding-top: 10px;'/>";
    }
    $cFormatRaw .= "</div>";

    $cFormatRaw .= "<div class='row' style='margin-left: 0px;margin-right: 0px;padding-left: 20px;'>";
    foreach ($AddressAssoc as $cIdx => $row) {
          $cFormatRaw .= "<div style='text-align: left;padding-top: 5px;font-size: medium !important;'>Alamat " . $row['label'] . "</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
//          $cFormatRaw .= "<div style='font-weight: bold;text-align: left;font-size: medium !important;'>Alamat Pengiriman </div><hr style='margin-top: 5px;margin-bottom: 5px;'/>";
          $cFormatRaw .= "<div style='font-weight: bold; text-align: left;'>" . $row['email'] . "</div>";
          $cFormatRaw .= "<div style='text-align: left;padding-top: 10px;'>" . $row['address'] . ",<br> Kel." . $row['sub_district_name'] . ", Kec. " . $row['district_name'] . ",  Kota " . $row['city_name'] . ", Prov. " . $row['province_name'] . "</div>";
          $cFormatRaw .= " <div style='text-align: left;'>" . $row['postal_code'] . "</div>";
          $cFormatRaw .= "  <div style='text-align: left; padding-bottom: 10px;'>" . $row['phone_number'] . "</div>";
            $cFormatRaw .= "<div style='font-weight: bold; text-align: left;'><a onclick='UpdateFlagAddress(\"" . $row['id'] . "\")' class='btn btn-primary flat'>Pilih Default</a></div><hr style='margin-top: 5px;margin-bottom: 5px;padding-top: 10px;'/>";
    }
    $cFormatRaw .= "</div>";


    return $cFormatRaw;
  }

  public function UpdateFlagAddress(Request $Request, $id){
    if ($Request->ajax()) {
      $userid = \Auth::User()->id;

      $update_all = \DB::table('addresses')
          ->where('member_id', $userid)
          ->update(['flag_default' => 0]);

      $update_default = \DB::table('addresses')
          ->where('id', $id)
          ->update(['flag_default' => 1]);

      $update_keranjang = \DB::table('carts')
          ->where('userid', $userid)
          ->update(['address_id' => $id]);

      if($update_keranjang == true){
        return 1;
      }else{
        return 'Gagal Mengupdate Data';
      }
    }
  }

  public function getUploadOrder(Request $Request){
    return view('user.uploadorder')->with('divdeptkat', $this->getMenuDropdown())->with('sidebar', $this->getSideBar())->with('divdeptkatmobile', $this->getMenuDropdownMobile());
  }

  public function validateQty($QTY, $PLU){
    if ($QTY == 0) {
      return 'Zero';
    }
    $validSt = 'OK';
    $minBeli = Product::getMinBeli($PLU);
    if ($QTY < $minBeli) {
      $validSt = "QTY Minimal " . $minBeli;
    }
    return $validSt;
//    $validSt = 'OK';
//    $minBeli = Product::getMinBeli($PLU);
//    if($QTY % $minBeli != 0){
//      $validSt = "QTY Harus Kelipatan " . $minBeli;
//    }
//    return $validSt;
  }


  public function AddPluCsv(Request $request)
  {
    $fileOrder = \Input::file('import_file');

    $validator = \Validator::make(
        array(
            'fileOrder' => $fileOrder,
        ),
        array(
            'fileOrder' => 'required|max:2000',
        ),
        array(
            'required' => 'Silakan masukkan file form order excel anda',
            'max' => 'Maksimal file yang diupload adalah 2 MB',
        )
    );

    if ($fileOrder == null ){
      $request->session()->flash('success_message', 'Tidak ada file yang diupload');
    }
    if ($fileOrder->getClientOriginalExtension() != 'xls' && $fileOrder->getClientOriginalExtension() != 'xlsx' && $fileOrder->getClientOriginalExtension() != 'csv'){
      $request->session()->flash('success_message', 'Silakan masukkan file dengan type xls atau xlsx atau csv');
    }

    if ($validator->fails()){
      $request->session()->flash('success_message', $validator->messages()->first());
    }

    $memberId = \Auth::User()->id;

    if(\Auth::guest()){
      $branchId = '18';
    }else{
      $branchId = Branch::getBranches();
    }


    if($checkUploaded = MemberOrderFile::where('member_id', $memberId)->whereRaw('DATE(created_at) = "'.date('Y-m-d').'"')->get()){
      $counter = $checkUploaded->count() + 1;
      $counter = sprintf("%02d", $counter);
      $fileName = 'ATK'.$counter.$branchId.$memberId.date('dmy').'.xlxs';
    }else{
      $fileName = 'ATK'.'01'.$branchId.$memberId.date('dmy').'.xlxs';
    }
    $modelOrderFile = new MemberOrderFile;
    $modelOrderFile->member_id = $memberId;
    $modelOrderFile->branch_id = $branchId;
    $modelOrderFile->new_name = $fileName;
    $modelOrderFile->old_name = $fileOrder->getClientOriginalName();
    $modelOrderFile->save();

    $pathFile = public_path('contents/csv/order/'.$fileName);

    if ($fileOrder->isValid())
      $fileOrder->move(public_path('contents/csv/order/'), $fileName);
    else {
      if(\File::exists($pathFile))
        unlink($pathFile);
      $request->session()->flash('success_message', 'File tidak valid');
    }


    $dataTitle = Excel::load($pathFile)->calculate()->toArray();
    $po = Excel::load($pathFile)->calculate()->toArray();
    $products = Excel::load($pathFile)->calculate()->toArray();
    $products = array_splice($products, 2);

    //No PO
    $po_no = $po[0][1];

    if($po_no == null){
      return redirect('uploadorder')->with('err', 'File tidak Valid');
    }

    if(\Auth::User()->type_id == 2){

      $countcart = Cart::getcountcartall();


      $countproduct = Excel::selectSheetsByIndex(0)->load($pathFile, function($reader) {
        $reader->ignoreEmpty();
      })->get()->toArray();

      $countproduct = array_filter($countproduct);

      if(count($countcart) + count($countproduct) > 102){
        return redirect('uploadorder')->with('err', 'PO Yang Anda upload melebihi batas maksimal jumlah item di keranjang ,maks. 100 item');
      }

    }

    $orderCheck = TransactionHeader::Distinct()->Select('no_po')->where('no_po', $po_no)->count();


    $orderCheckCart = Cart::Distinct()->Select('no_po')->where('no_po', $po_no)->count();


    if($orderCheck > 0 || $orderCheckCart > 0)
    {
      return redirect('uploadorder')->with('err', 'NO PO Kembar, Silahkan coba mengupload ulang dengan nomor PO yang Berbeda');

    }

        $tempErrorFiles = array();
        if ($products != null) {
        \DB::beginTransaction();
          try{
          foreach ($products as $row) {
            if ($row[1]) {
              $PLU = str_replace('#', '', $row[1]);
              $PLU = str_pad($PLU, 7, "0", STR_PAD_LEFT);
              $QTY = $row[3];
              $unit = Product::getunit($PLU);

              if($unit != null){
                $QTYErr = $this->validateQty($QTY, $PLU);
                if ($QTYErr == 'OK') {
                  Cart::addCartItem($PLU, $QTY, $unit, $po_no);
                }
              }else{
                array_push($tempErrorFiles, $PLU);
              }
            }
          }


          if (count($tempErrorFiles) > 0) {
            $message = '<br/>PLU :<br/>';
            foreach ($tempErrorFiles as $file)
              $message = $message . ' ' . $file . '<br/>';
            $message = $message . ' gagal di-Upload! Format atau Nama Plu Tidak Sesuai';
            $request->session()->flash('error_message', $message);
          } else {
            $request->session()->flash('success_message', 'Data berhasil di-Upload!');
          }

          \DB::commit();
            return redirect('uploadorder')->with('opencart', true);

//            ->with('divdeptkat', $this->getMenuDropdown())->with('sidebar', $this->getSideBar())->with('divdeptkatmobile', $this->getMenuDropdownMobile());;

          }catch(Exception $ex){
            \DB::rollBack();
            return redirect('user.uploadorder')->with('err', 'Gagal mengupload file');
          }

        }
//        return view('user.uploadorder')->with('err', "File excel tidak valid")->with('divdeptkat', $this->getMenuDropdown())->with('sidebar', $this->getSideBar())->with('divdeptkatmobile', $this->getMenuDropdownMobile());
  }

}

