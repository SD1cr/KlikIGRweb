<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function getSideBar(){
        $typeuserid = \Auth::User()->email;
        $sideHtml ="";
// <img src='https://imagerouter.tokopedia.com/img/300/default_v3-usrnophoto2.png' class='img-responsive' alt=''>
        $sideHtml .= "
        <div class='col-md-3'>
                <div class='profile-sidebar'>
                    <!-- SIDEBAR USERPIC -->
                    <div class='profile-userpic'>
                        <img src='../resources/assets/icon/avatar.png' class='img-responsive' alt=''>

                    </div>
                    <div class='profile-usertitle'>
                        <div class='profile-usertitle-name'>
                               $typeuserid
                        </div>
                    </div>";
        $sideHtml .= "
                    <div class='profile-usermenu'>
                        <ul class='nav'>";
        if(\Illuminate\Support\Facades\Request::is('profile')){
            $sideHtml .= "<li class='active'>
                            <a href='profile'><i style='color:black' class='fa fa-user'></i>&nbsp; Profil User</a>
                          </li>";
        }else{
            $sideHtml .= "<li>
                            <a href='profile'><i style='color:black' class='fa fa-user'></i>&nbsp; Profil User</a>
                          </li>";
        }

        if(\Illuminate\Support\Facades\Request::is('bukualamat')){
            $sideHtml .= "<li class='active'>
                                <a href='bukualamat'><i style='color:black' class='fa fa-file'></i>&nbsp; Buku Alamat</a>
                          </li>";
        }else{
            $sideHtml .= "<li>
                                <a href='bukualamat'><i style='color:black' class='fa fa-file'></i>&nbsp; Buku Alamat</a>
                          </li>";
        }

        if(\Illuminate\Support\Facades\Request::is('history')){
            $sideHtml .= "<li class='active'>
                                <a href='history'><i style='color:black' class='fa fa-history'></i>&nbsp; History Pesanan</a>
                            </li>";
        }else{
            $sideHtml .= "<li>
                                <a href='history'><i style='color:black' class='fa fa-history'></i>&nbsp; History Pesanan</a>
                           </li>";
        }

        if (\Auth::User()->type_id == 1){
            if(\Illuminate\Support\Facades\Request::is('uploadorder')){
                $sideHtml .= "<li class='active'>
                                <a href='uploadorder'><i style='color:black' class='fa fa-list'></i>&nbsp; Upload Order</a>
                            </li>";
            }else{
                $sideHtml .= "<li>
                                <a href='uploadorder'><i style='color:black' class='fa fa-list'></i>&nbsp; Upload Order</a>
                           </li>";
            }
        }

        $sideHtml .= "</ul>
                    </div>
                </div>
            </div>";

        return $sideHtml;
    }
	
	public function getSideProfile(){
        $sideProfile ="";
// <img src='https://imagerouter.tokopedia.com/img/300/default_v3-usrnophoto2.png' class='img-responsive' alt=''>
        $sideProfile .= "
        <div class='col-md-3' style='box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);'>";

        $sideProfile .= "
                    <div class='row'>
                        <ul class='nav'>";
        if(\Illuminate\Support\Facades\Request::is('info')){
            $sideProfile .= "<li class='bs-callout bs-callout-info active' style=\"margin-top: 0px;margin-bottom: 0px;padding-left: 0px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;\">
                            <a href='info'><i style='color:black' class='fa fa-user'></i>&nbsp; Tentang Kami</a>
                          </li>";
        }else{
            $sideProfile .= "<li>
                            <a href='info'><i style='color:black' class='fa fa-user'></i>&nbsp; Tentang Kami</a>
                          </li>";
        }

        if(\Illuminate\Support\Facades\Request::is('location')){
            $sideProfile .= "<li class='bs-callout bs-callout-primary active' style=\"margin-top: 0px;margin-bottom: 0px;padding-left: 0px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;\">
                            <a href='location'><i style='color:black' class='fa fa-map-marker'></i>&nbsp; Lokasi</a>
                          </li>";
        }else{
            $sideProfile .= "<li>
                            <a href='location'><i style='color:black' class='fa fa-map-marker'></i>&nbsp; Lokasi</a>
                          </li>";
        }

        if(\Illuminate\Support\Facades\Request::is('reg')){
            $sideProfile .= "<li class='bs-callout bs-callout-warning active' style=\"margin-top: 0px;margin-bottom: 0px;padding-left: 0px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;\">
                            <a href='reg'><i style='color:black' class='fa fa-file-o'></i>&nbsp; Cara Pendaftaran</a>
                          </li>";
        }else{
            $sideProfile .= "<li>
                            <a href='reg'><i style='color:black' class='fa fa-file-o'></i>&nbsp; Cara Pendaftaran</a>
                          </li>";
        }

        if(\Illuminate\Support\Facades\Request::is('buy')){
            $sideProfile .= "<li class='bs-callout bs-callout-primary active' style=\"margin-top: 0px;margin-bottom: 0px;padding-left: 0px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;\">
                            <a href='buy'><i style='color:black' class='fa fa-shopping-cart'></i>&nbsp; Cara Belanja</a>
                          </li>";
        }else{
            $sideProfile .= "<li>
                            <a href='buy'><i style='color:black' class='fa fa-shopping-cart'></i>&nbsp; Cara Belanja</a>
                          </li>";
        }

        if(\Illuminate\Support\Facades\Request::is('term')){
            $sideProfile .= "<li class='bs-callout bs-callout-success active' style=\"margin-top: 0px;margin-bottom: 0px;padding-left: 0px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;\">
                                <a href='term'><i style='color:black' class='fa fa-pencil-square-o'></i>&nbsp; Syarat & Ketentuan</a>
                            </li>";
        }else{
            $sideProfile .= "<li>
                                <a href='term'><i style='color:black' class='fa fa-pencil-square-o'></i>&nbsp; Syarat & Ketentuan</a>
                           </li>";
        }

        if(\Illuminate\Support\Facades\Request::is('policy')){
            $sideProfile .= "<li class='bs-callout bs-callout-warning active' style=\"margin-top: 0px;margin-bottom: 0px;padding-left: 0px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;\">
                                <a href='policy'><i style='color:black' class='fa fa-history'></i>&nbsp; Kebijakan</a>
                            </li>";
        }else{
            $sideProfile .= "<li>
                                <a href='policy'><i style='color:black' class='fa fa-history'></i>&nbsp; Kebijakan</a>
                           </li>";
        }

        if(\Illuminate\Support\Facades\Request::is('faq')){
            $sideProfile .= "<li class='bs-callout bs-callout-danger active' style=\"margin-top: 0px;margin-bottom: 0px;padding-left: 0px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;\">
                                <a href='faq'><i style='color:black' class='fa fa-file'></i>&nbsp; FAQ</a>
                          </li>";
        }else{
            $sideProfile .= "<li>
                                <a href='faq'><i style='color:black' class='fa fa-file'></i>&nbsp; FAQ</a>
                          </li>";
        }



        $sideProfile .= "</ul>
                    </div> 
            </div>";

        return $sideProfile;
    }  


}
