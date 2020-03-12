<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
URL::forceSchema('https');  
   
   Route::get('login', 'LoginController@index');
Route::get('register', 'LoginController@registerMember');
Route::get('changemember', 'LoginController@getMember');
Route::post('createmember', 'LoginController@createMember');
Route::post('newlogin', 'LoginController@getLogin');
Route::get('getlogindialog', 'LoginController@getFormLogin');
Route::post('loginajax', 'LoginController@getLoginAjax');
Route::post('loginmobile', 'LoginController@getLoginMobile');    
Route::get('reloadlogin', 'LoginController@reloadLogin');

//Route::get('/', 'ProductController@getProduct');
Route::get('list/{divisi}/{department}/{kategori}', 'ProductController@getListProduct');
Route::get('list/{divisi}/{department}', 'ProductController@getListProduct');
Route::get('list/{divisi}', 'ProductController@getListProduct');
Route::get('product', 'ProductController@getSection');
Route::get('list', 'ProductController@getListProduct');
//Route::get('product', 'ProductController@getProduct');
Route::get('listcontract', 'ProductController@getListProductContract');

Route::get('reloadcart', 'ProductController@reloadCart');

//Aktivasi
Route::get('activate/{code}','LoginController@activateAccount');
Route::get('resendaktivasi', 'LoginController@ResendEmail');
Route::get('activation', 'LoginController@getActivation'); 
Route::get('registrationview', 'LoginController@getRegView');

Route::get('verif', 'LoginController@getVerifikasiMember');
Route::post('postverif', 'LoginController@getVerifKodemember');
Route::post('cekotp', 'LoginController@cekVerifOTP');
Route::post('ResendOTP', 'LoginController@ResendOtp');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('product');
});
Route::group(['middleware' => 'auth'], function() {
    Route::get('history', 'HistoryController@getHistoryAll');
    Route::get('precheckout', 'ProductController@getcheckOut');
    Route::get('viewcheckout', 'ProductController@getViewCheckout');
    Route::get('detailcheckout', 'ProductController@getDetailCheckout');
    Route::get('checkout/{nopo}/{kirim}', 'ProductController@checkOut')->where('nopo', '[A-Za-z0-9_/-]+');   
});
//    Route::group(['middleware' => 'biru'], function () {
//        Route::group(['middleware' => 'corporate'], function () {
//Default Route


//Checkout


            Route::get('getproductdialog', 'ProductController@getProductInfo');
            Route::get('getcartdialog', 'ProductController@getCartInfo');
            Route::get('getaddressdialog', 'LoginController@getFormAddress');
            Route::post('updateflagaddress', 'LoginController@updateAddress');

//cart

            Route::post('addcart', 'ProductController@addToCart');
            Route::get('updatecart', 'ProductController@updateCart');
            Route::get('deletecart', 'ProductController@deleteCart'); 
            Route::delete('deleteallcart', 'ProductController@deleteCartAll');

//Route For History Page (User)

//Route::get('list12', 'HistoryController@getListInfo');
            Route::get('reorder', 'HistoryController@reOrder');
            Route::get('gethistorydialog', 'HistoryController@getHistoryInfo');

//Route get Address
            Route::get('changecity', 'ProfileController@getCity');
            Route::get('changedistrict', 'ProfileController@getDistrict');
            Route::get('changeBranch', 'ProfileController@getSubDistrict');

//detail product
            Route::get('detail/{PLU}', 'ProductController@getDetailProduct2');

//user profile
            Route::get('profile', 'ProfileController@index');
            Route::get('uploadorder', 'BukuAlamatController@getUploadOrder');
            Route::post('addcartcsv', 'BukuAlamatController@AddPluCsv');
            Route::post('updateprofile', 'ProfileController@UpdateProfile');

//        });
//    });
//});
Route::get('/', 'ProductController@getSection');      

//detail buku alamat
Route::get('bukualamat', 'BukuAlamatController@index');
Route::get('get_alamat', 'BukuAlamatController@get_alamat');
Route::get('alamat_default/{id}', 'BukuAlamatController@alamat_default');
Route::get('get_kota', 'BukuAlamatController@get_kota');
Route::get('get_district', 'BukuAlamatController@get_district');
Route::get('get_sub_district', 'BukuAlamatController@get_sub_district');
Route::post('tambah_alamat', 'BukuAlamatController@tambah_alamat');
Route::get('edit_alamat/{id}', 'BukuAlamatController@edit_alamat');
Route::get('delete_alamat/{id}', 'BukuAlamatController@delete_alamat');
Route::get('changeaddress', 'BukuAlamatController@getChangeAddress');
Route::get('updateflag/{id}', 'BukuAlamatController@UpdateFlagAddress');


//Route For Dashboard Page (Admin)
//Route::get('dashboard', 'AdminController@getDashboard');
Route::post('forced', 'AdminController@forceDown');   
Route::post('updatestkirim', 'AdminController@updateStatusKirim');
Route::get('downloadcsvr', 'AdminController@getCSVZipRange');
Route::post('reloaddashboard', 'AdminController@getReloadDashboard');
//Route::get('reloaddashboard', 'AdminController@getReloadDashboard');
Route::post('downloadcsv', 'AdminController@getCSV');
Route::get('changemember', 'AdminController@getMemberKlik');

Route::get('get_member', 'AdminController@get_member');



//Route For Dashboard Page (Admin)
Route::group(['middleware' => 'admin'], function(){
    Route::get('dashboard', 'AdminController@getDashboard');
    Route::get('dashboard/{cab}', 'AdminController@getDashboard');
});

Route::get('admin/dashboard/datatable', 'AdminController@getViewAdminDashboard');

//////////////////////////////////
/////////   ADMIN    ////////////
////////////////////////////////

//Route For Admin Management
Route::get('admin/members/datatable', 'AdminController@getMemberManagement');
Route::get('member', 'AdminController@getMember'); 

Route::get('admin', 'AdministratorController@index');
Route::post('login_admin', 'AdministratorController@login');
Route::get('logout_admin', 'AdministratorController@logout');

//Admin Email
//Route For Email Management Page (Admin)
Route::get('emails', 'AdminController@getEmailList');
Route::get('createmail', 'AdminController@getEmailCreatePage');
Route::get('deletemail', 'AdminController@deleteMail');
Route::post('addmail', 'AdminController@createMail');
Route::get('admin/emails/datatable', 'AdminController@getViewAdminEmail'); 


//Route For Admin Management
Route::get('adminlist', 'AdminController@getAdminList');
Route::get('registeradmin', 'AdminController@registerAdmin');
Route::get('deleteadmin', 'AdminController@deleteAdmin');
Route::post('addadmin', 'AdminController@createAdmin');


//Route For Push Notif
Route::get('notification', 'AdminController@getNotif');

Route::post('notification', 'AdminController@send');

Route::get('notif', 'AdminController@createNotification');

Route::post('createnotif', 'AdminController@postNotification');

Route::get('createpromo', 'AdminController@getCreatePromo');



//Route For Profil

Route::get('location', 'ProfileController@getLocation');
Route::get('policy', 'ProfileController@getPolicy');
Route::get('term', 'ProfileController@getTerm');
Route::get('faq', 'ProfileController@getFAQ');
Route::get('contact', 'ProfileController@getContact');
Route::get('info', 'ProfileController@getInfo');
Route::get('reg', 'ProfileController@getRegister');
Route::get('buy', 'ProfileController@getBuy');

//Route For Realisasi
Route::get('realisasi', 'AdminController@getRealisasi');
Route::any('reportpb', 'AdminController@getTransactionRealisasi');

//Register Member Web MM
Route::get('registermember', 'AdminController@registerMemberMerah');
Route::get('getKodedialog', 'AdminController@getKodeMember');
Route::post('createmembermerah', 'AdminController@createMemberMerah');

// edit alamat
Route::post('simpan_alamat', 'AdminController@simpan_alamat');
Route::post('get_alamat_admin', 'AdminController@get_alamat_admin');
Route::get('get_provinsi_admin', 'AdminController@get_provinsi');
Route::post('get_kota_admin', 'AdminController@get_kota');
Route::post('get_kecamatan_admin', 'AdminController@get_kecamatan');
Route::post('get_kelurahan_admin', 'AdminController@get_kelurahan');
Route::post('get_kodepos_admin', 'AdminController@get_kodepos');

//monitoring
Route::get('admin/monitoring/datatable', 'AdminController@getMonitoringJob');
Route::get('monitoring', 'AdminController@getListMonitoring');

Route::get('getbranddialog', 'ProductController@getBrandSection');

//Master Ongkir
Route::get('masterongkir', 'AdminController@getMasterOngkir');

Route::get('getbranddialog', 'ProductController@getBrandSection');
Route::get('masterkendaraan', 'AdminController@getMasterKendaraan');
Route::get('viewongkir', 'AdminController@getViewListOngkir');
Route::get('masterongkir', 'AdminController@getMasterOngkir');

Route::post('createkendaraan', 'AdminController@postMasterKendaraan');
Route::post('createongkir', 'AdminController@postOngkir');

Route::get('admin/ongkir/datatable', 'AdminController@getViewOngkir');
Route::post('ongkirAjax', 'AdminController@getOngkirAjax');
Route::post('EditOngkir', 'AdminController@EditOngkir');

//Free Ongkir
Route::get('masterfreeongkir', 'AdminController@getMasterFreeOngkir');
Route::post('postfreeongkir', 'AdminController@postFreeOngkir');
Route::get('viewfreeongkir', 'AdminController@getViewListFreeOngkir');
Route::get('admin/freeongkir/datatable', 'AdminController@getViewFreeOngkir');

Route::get('memberongkirdialog', 'AdminController@getFreeOngkirAjax');
Route::get('cabangongkirdialog', 'AdminController@getCabangOngkirAjax'); 


//Get Koordinat Kode Pos
Route::get('postalcode', 'AdminController@getKoordinatKodePos');
Route::post('getpostalcode', 'AdminController@PostKoordinatKodePos');
Route::get('getviewaddress/datatable', 'AdminController@getViewDistance');
Route::post('getdistanceajax', 'AdminController@getEditDistanceAjax');

Route::post('getviewmarker', 'AdminController@getMarkerDistanceAjax');
Route::post('getdataajax', 'AdminController@getData');
Route::post('EditJarakOngkir', 'AdminController@EditJarakOngkir');

Route::post('deleteongkir', 'AdminController@DeleteOngkirAjax');


//konfimassi

Route::get('confirmation', 'LoginController@getKonfirmasiView');

//promo

Route::get('promonotif/{id}', 'ProfileController@getPromoNotif');
Route::get('listpromo', 'ProfileController@getListPromo');
  

