<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Branch;
use App\Models\BranchDistrict;
use App\Models\Cabang;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\SubDistrict;
use App\Models\User;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use App\Services\Registrar;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    public function registerMember(){
        $userFormat = "";
        $htmlFormat = "";

//        if(\Auth::role() == 'SYSTEM'){
        $cabangAssoc = Branch::getAllBranches();
        $provFormat="";
        $citFormat="";
        $disFormat="";
        $BranchFormat="";
        $SubDistrictFormat="";
        $Province = Province::getAllProvince();
        $Cities = City::getCityByProv("%");
        $District = District::getDistrictByCity("%");
        $BranchDistrict = BranchDistrict::getDistrictByBranch("%");
        $SubDistrict = SubDistrict::getSubDistrictByDistrict("%");


        foreach($Province as $index=> $prow) {

            $provFormat .= "<option style='font-size: 12px;' value='". $prow->id ."'>" . $prow->province_name . "</option>";
        }
        foreach($Cities as $index => $crow) {
            $citFormat .= "<option style='font-size: 12px;' value='" . $crow->id . "'>" . $crow->city_name . "</option>";
        }
        foreach($District as $index => $drow) {
            $disFormat .= "<option style='font-size: 12px;' value='" . $drow->id . "'>" . $drow->district_name . "</option>";
        }

//        foreach ($cabangAssoc as $index => $row) {
//            $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['id'] . "'>" . $row['name'] . "</option>";
//        }

        foreach ($SubDistrict as $index => $prow) {
            $SubDistrictFormat .= "<option style='font-size: 12px;' value='" . $prow->id . "'>" . $prow->sub_district_name . "</option>";
        }    

        return view('auth.register')->with('cabangOpt', $htmlFormat)->with('provOpt', $provFormat)->with('citOpt', $citFormat)->with('disOpt', $disFormat)->with('SubDistrictOpt', $SubDistrictFormat);
    }

    public function getMember(Request $Request){
        $Cab = $Request -> get('cab');
        $MemberAssoc = \DB::table('customers')->select('customers.id', 'customers.name', 'kode_member', 'customers.kode_igr')
            ->Join('branches', 'customers.kode_igr', '=', 'branches.kode_igr')->Where('branches.id', $Cab)->get();

        $memFormat="<option>--Pilih Member--</option>";

        foreach($MemberAssoc as $index => $row) {
            $memFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->kode_member . "--" . $row->name . "</option>";
        }
        return $memFormat;
    }


    public function getFormLogin(Request $Request){
            $loginFormat = "<form class=\"form-horizontal\" role=\"form\" method=\"POST\" action=\"" . url('/newlogin') . "\">
                        <input id='token' type=\"hidden\" name=\"_token\" value=\"" . csrf_token() . "\">
                            <div class=\"login-page\">
                                <input id='email' placeholder=\"username\" type=\"text\" name=\"email\">
                                <input id='password' placeholder=\"password\" type=\"password\" name=\"password\">
                                <div id='btnsubmit'><a class='btn btn-success flat' style='height: 100%; width: 270px;'>Login</a></div>
                                <script>$(function()
                                {
                                $('#btnsubmit').on('click',function()
                                {
                                $(this).val('Please wait ...')
                                .attr('disabled','disabled');
                                validLogin();
                                });
                                });
                                </script>
                                <p class=\"message\">Not registered? <a href=\"" . url('/register') . "\">Create an account</a></p>
                            </div>
						</form>";

            return $loginFormat;
    }

//    public function getLogin(Request $Request){
//        $email = $Request->get('email');
//        $pass = $Request->get('password');
//
//        $password = UserAdmin::Where('email', $email)->pluck('password');
//        $uid = UserAdmin::Where('email', $email)->pluck('id');
//
//        if(\Hash::check($pass, $password)){
//            \Auth::loginUsingId($uid);
//            return redirect('dashboard');
//        }else{
//            return redirect('login')->with('err', true);
//        }
//    }

    public function getLogin(Request $request) {
        $email = $request->get('email');
        // $pass = bcrypt($request->get('password'));
        $pass = $request->get('password');

        $password = UserAdmin::Where('email', $email)->pluck('password');
        $uid = UserAdmin::Where('email', $email)->pluck('id');
        $credentials = $request->only('email', 'password');


        if(\Auth::attempt('users_admin', ['email' => $email, 'password' => $pass])){
            if(\Auth::user('users_admin')->active == 1){
                return redirect('/dashboard');
            }
        }else{   
            return redirect('admin')->with('err', 'Terjadi kesalahan login, Periksa Email dan Password Anda'); 
        }
    }

    public function getLoginAjax(Request $Request){ 
        if ($Request->ajax()) {
            $email = $Request->get('email');
            $pass = $Request->get('password');

            $countstatus = User::where('email', $email)->where('status',1)->count();

            $password = User::Where('email', $email)->pluck('password');
            $uid = User::Where('email', $email)->pluck('id');

            if($countstatus > 0){
                if(\Hash::check($pass, $password)){
                    //LOGIN OK
                    //MAKE AUTH
                    \Auth::loginUsingId($uid);
                    $userid = \Auth::User()->id;
                    $countAddress = Address::where('member_id', $userid)->where('flag_default', 1)->count();

                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 2;
            }

        }
    }

    public function updateAddress(Request $Request){
        $addID = $Request->get('alamat');

        \DB::table('addresses')
            ->where('member_id', \Auth::User()->id)
            ->update(['flag_default' => 0]);

        if($addID != null && $addID != ''){
            $flagsts = Address::where('id', $addID)->first();
            $flagsts->flag_default = 1;
            $flagsts->save();

            return redirect('product');
        }else{
            return redirect('product')->with('alamat', true);;
        }
    }

    public function getFormAddress(Request $Request){

        $AddressFormat="<form class=\"form-horizontal\" role=\"form\" method=\"POST\" action=\"". url('updateflagaddress') ."\">
                        <input type=\"hidden\" name=\"_token\" value=\"". csrf_token() ."\">

							<div class=\"form-group\">
                                " . $this->CreateAddress() . "
								<div class=\"col-md-6 col-md-offset-2\">
									<button type=\"submit\" class=\"btn btn-primary igr-flat\">Pilih</button>
								</div>
							</div>
						</form>";
        return $AddressFormat;
    }


    public function CreateAddress(){
        $OptAddressFormat = "";
        $AddressAssoc = Address::getAddress();
        foreach($AddressAssoc as $row){
            $OptAddressFormat .= "<div style='text-align: left; margin-left: 100px'><input type='radio' name='alamat' value='" . $row->id . "'>&nbsp " .  $row['address']  . "</input></div><br>";
        }
        return $OptAddressFormat;
    }

//    public function reloadLogin(){
//        $countAddress = Address::where('member_id')->where('flag_default', 1)->count();
//        $cFormatRaw = "";
//
//        $cFormatRaw .= "<ul class=\"nav navbar-nav navbar-left\">
//                    <li class=\"dropdown\" style=\"flex-wrap: nowrap;\">
//                    <a href=\"#\" class=\"dropdown-toggle\" id=\"userMenu\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\" style=\"color: white; padding-top: 0px;padding-bottom: 0px;\"><img height=\"40px\" style=\"padding-right: 5px; margin-top: 5px;\" src=\"{{ url('../resources/assets/img/user.png') }}\"/>Halo !<span style='color:white' class=\"caret\"></span></a>
//                    <ul class=\"dropdown-menu\" role=\"menu\">
//                        <li><a href=\"{{ url('/chpass') }}\"><i class=\"fa fa-key\" style=\"font-size:larger\"></i> &nbsp; Ganti Kata Sandi</a></li>
//                        <li><a href=\"{{ url('/logout') }}\"><i class=\"fa fa-sign-out\" style=\"font-size:larger\"></i> &nbsp; Logout</a></li>
//                    </ul>
//                </li>
//                </ul>";
//        return $cFormatRaw;
//    }
    public function reloadLogin(){
        $countAddress = Address::where('member_id')->where('flag_default', 1)->count();
        $cFormatRaw = "";
        // Edited 14 June 2017,
        $cFormatRaw .= "
                    <ul class=\"nav navbar-nav navbar-left\">
                        <li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle\" id=\"userMenu\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\" style=\"color: white; padding-top: 0px;padding-bottom: 0px;\"><img height=\"40px\" style=\"padding-right: 5px; margin-top: 5px;\" src=\"". url('../resources/assets/img/user.png'). "\"/>Halo !<span style='color:white' class=\"caret\"></span></a>
                            <ul class=\"dropdown-menu\">
                                <li>
                                    <div class=\"navbar-login\">
                                        <div class=\"row\">
                                            <div class=\"col-lg-12\">
                                                <a class=\"text-center\">
                                                    Selamat Datang, User !
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class=\"divider navbar-login-session-bg\"></li>
                                <li><a href=\"" .url('/profile'). "\"><i style='color:deepskyblue' class=\"fa fa-user\"></i>&nbsp; Profil User</a></li>
                                <li class=\"divider\"></li>
                                <li><a href=\"#\"><i style='color:deepskyblue' class=\"fa fa-file\"></i>&nbsp; Buku Alamat</a></li>
                                <li class=\"divider\"></li>
                                <li><a href=\"" .url('/history'). "\"><i style='color:deepskyblue' class=\"fa fa-history\"></i>&nbsp; History Pesanan</a></li>
                                <li class=\"divider\"></li>
                                <li><a href=\"" .url('/logout'). "\"><i style='color:deepskyblue' class=\"fa fa-sign-out\"></i>&nbsp; Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                    ";
        return $cFormatRaw;
    }

    public function sendEmail($data, $newU)
    {
        \Mail::send('auth.activation', $data, function($message) use ($newU) {
            $message->from('noreply@klikindogrosir.com', 'Klik Indogrosir');
            $message->to($newU['email'], $newU['name'])->subject('Silakan melakukan verifikasi akun Anda !');
        });
    }

    public function activate($code, User $user)
    {
        if ($user->activateAccount($code)) {
            return 'Activated!';
        }
        return 'Fail';
    }

    public function activateAccount($code)
    {
        $user = User::where('activation_code', $code)->first();

        if($user){
            $user->status = 1;
            $user->activation_code = NULL;
            $user->save();

            \Auth::login($user);

            return redirect('product')->with('new', true);
        }
    }


    public function getActivation(){
        return view('auth.activation');
    }

    public function getRegView(){
        return view('auth.registrasiview');
    }

    public function ResendEmail(Request $Request){
        $resendemail = $Request->get('email');


        $cekemail = User::where('email', $resendemail)->whereNotNull('activation_code')->get();

        $cekcode = User::where('email', $resendemail)->pluck('activation_code');


        if(count($cekemail) > 0){

            foreach($cekemail as $index=> $prow) {
                $admEmails[] = $prow->email;
            }

            $data = [
                'nama' => $prow['nama'],
                'code' => $prow['activation_code']
            ];

            \Mail::send('auth.activation', $data, function($message) use ($admEmails) {
                $message->from('noreply@klikindogrosir.com', 'Klik Indogrosir');
                $message->to($admEmails)->subject('Silakan melakukan verifikasi akun Anda !');
            });

        }else{
            return view('auth.registrasiview')->with('err', 'Anda sudah melakukan aktivasi email');
        }

        return view('auth.registrasiview')->with('suc', 'Anda telah mengirimkan permintaan resend email');
    }


    public function getLoginMobile(Request $Request)
    {
        $email = $Request->get('email');
        $pass = $Request->get('password');

        $password = User::Where('email', $email)->pluck('password');
        $uid = User::Where('email', $email)->pluck('id');

        if (\Hash::check($pass, $password)) {
            //LOGIN OK
            //MAKE AUTH
            \Auth::loginUsingId($uid);
            $userid = \Auth::User()->id;
            $countAddress = Address::where('member_id', $userid)->where('flag_default', 1)->count();

            return redirect('/product');
        } else {
            return redirect('login')->with('err', 'Terjadi kesalahan login, Periksa Email dan Password Anda');
        }
    }   


    public function createMember(Request $Request){

        $idbranch = $Request->get('subdistrict');


        $cab = BranchDistrict::Distinct()->Where('sub_district_id', $idbranch)->pluck('branch_id');


        $origin = Branch::select('latitude', 'longitude')->where('id', $cab)->get();


        foreach($origin as $index=> $prow) {
            $latitude1 = $prow->latitude;
            $longitude1 = $prow->longitude;
        }


        $destination = \DB::table('provinces')
            ->selectraw('CONCAT_WS(\' \', sub_district_name, district_name,city_name,province_name,sub_districts.postal_code) AS tujuan')
            ->join('cities', 'provinces.id','=','cities.province_id')
            ->join('districts', 'cities.id', '=', 'districts.city_id')
            ->join('sub_districts', 'districts.id', '=', 'sub_districts.district_id')
            ->where('provinces.id','LIKE', $Request->get('province'))
            ->where('cities.id','LIKE', $Request->get('cities'))
            ->where('districts.id','LIKE', $Request->get('district'))
            ->where('sub_districts.id','LIKE', $Request->get('subdistrict'))
//            ->Where('addresses.id',$id)
            ->Pluck('tujuan');


//        $tujuan=$Request->get('Alamat').' '.$destination;

        $tujuantanpaspasi = str_replace(' ', '+', $destination);

        $aContext = array(
            'http' => array(
                'proxy' => 'tcp://192.168.10.44:6115', 
                'request_fulluri' => true,
            ),
        );

        $cxContext = stream_context_create($aContext);

        $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". $latitude1 .",". $longitude1 ."&destination=". $tujuantanpaspasi ."&key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY", False, $cxContext);

//        $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". $latitude1 .",". $longitude1 ."&destination=". $tujuantanpaspasi ."&key=AIzaSyDiANMULOSQkgNwrdF1Dz0i1KXYvB7JiIk");

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
          

        $reg = new Registrar();

        $validator = $reg->validateNewMember($Request->all());
        if ($validator->fails()){
            $this->throwValidationException($Request, $validator);
        }

        if($cab != null){
            $postalcode = SubDistrict::Distinct()->Where('id',$idbranch)->pluck('postal_code');

            $date = new \DateTime;

            \DB::beginTransaction();
            try{
                $igr_code = Branch::select('kode_igr')->where('id', $cab)->pluck('kode_igr');

                if($igr_code == '01'){
                    $con = 'simcpg';
                }elseif($igr_code == '03'){
                    $con = 'igrsby';
                }elseif($igr_code == '04'){
                    $con = 'igrbdg';
                }elseif($igr_code == '05'){
                    $con = 'igrtgr';
                }elseif($igr_code == '06'){
                    $con = 'igrygy';
                }elseif($igr_code == '15'){       
                    $con = 'igrkmy';
                }elseif($igr_code == '16'){
                    $con = 'igrbks';
                }elseif($igr_code == '17'){
                    $con = 'igrplg';
                }elseif($igr_code == '18'){
                    $con = 'igrkmy';
                }elseif($igr_code == '20'){
                    $con = 'igrpku';
                }elseif($igr_code == '21'){
                    $con = 'igrsmd';
                }elseif($igr_code == '22'){
                    $con = 'igrsmg';
                }elseif($igr_code == '25'){
                    $con = 'igrbgr';
                }elseif($igr_code == '26'){
                    $con = 'igrptk';
                }elseif($igr_code == '27'){
                    $con = 'igrbms';
                }elseif($igr_code == '28'){
                    $con = 'igrmdo';
                }elseif($igr_code == '31'){
                    $con = 'igrmks';
                }elseif($igr_code == '32'){
                    $con = 'igrjbi';
                }elseif($igr_code == '33'){
                    $con = 'igrkri';
                }elseif($igr_code == '35'){
                    $con = 'igrcpt';    
                }elseif($igr_code == '36') {
                    $con = 'igrkrw';
                }else{
                    return null;
                }             

                $kdmember = '280676';                

                $newU = new User;
                $newU->nama = $Request->get('Nama');
                $newU->email = $Request->get('Email');
                $newU->password = bcrypt($Request->get('Password'));
                $newU->type_id = 3;
                $newU->kodemember = $kdmember;
                $newU->customer_id = null;
                $newU->activation_code = str_random(60) . $Request->get('Email');
                $newU->created_at = $date;
                $newU->updated_at = $date;
                $newU->save();

                $newA = new Address;
                $newA->address = $Request->get('Alamat');
                $newA->branch_id = $cab;
                $newA->phone_number = $Request->get('NoHp');
                $newA->province_id = $Request->get('province');
                $newA->city_id = $Request->get('cities');
                $newA->district_id = $Request->get('district');
                $newA->sub_district_id = $idbranch;
                $newA->postal_code = $postalcode;
                $newA->member_id = $newU->id;
                $newA->created_at = $date;
                $newA->updated_at = $date;
                $newA->flag_default = 1;
                $newA->latitude = $lat;
                $newA->longitude = $longi;
                $newA->distance = $nilaiJarak;
                $newA->save();

                \DB::connection($con)->table('tbmaster_customerkliknew')->insert(
                    ['CKI_KODEIGR' => $igr_code, 'CKI_RECORDID' => null, 'CKI_KODEMEMBER_KI' => $newU->id,'CKI_KODEMEMBER_IGR' => $kdmember,
                        'CKI_TIPEMEMBER' => null,'CKI_NAMA' => $Request->get('nama'), 'CKI_TELEPON' => null,'CKI_HP' => $Request->get('NoHp'),
                        'CKI_EMAIL' => $newU->email,'CKI_NPWP' => null, 'CKI_NAMANPWP' => null,'CKI_ALAMATNPWP' => null,
                        'CKI_CREATE_DT' => $date,'CKI_CREATE_BY' => 'ADM', 'CKI_MODIFY_DT' => $date,'CKI_MODIFY_BY' => 'ADM'
                    ]);

                \DB::commit();

                $data = [
                    'nama' => $newU['nama'],
                    'code' => $newU['activation_code']
                ];

                $this->sendEmail($data, $newU);

//                \Auth::loginUsingId($newU->id);

                return redirect('registrationview');
            }

            catch(Exception $ex){
                \DB::rollBack();
                return redirect('register')->with('err', 'Gagal menyimpan data, silahkan coba lagi');
            }

        }else{
            return redirect('register')->with('err', 'Kota Anda diluar jangkauan Indogrosir');
        }

        }


}


