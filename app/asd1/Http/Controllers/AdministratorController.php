<?php
namespace App\Http\Controllers;

use App\Models\UserAdmin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
// use Illuminate\Contracts\Auth\Guard;

class AdministratorController extends Controller
{
  public function index(){
    return view('admin.administrator');
  }

  public function login(Request $request) {
    $email = $request->get('email');
    // $pass = bcrypt($request->get('password'));
    $pass = $request->get('password');

    $password = UserAdmin::Where('email', $email)->pluck('password');
    $uid = UserAdmin::Where('email', $email)->pluck('id');
    $credentials = $request->only('email', 'password');

    // \Auth::attempt('users_admin', ['email'=> $email, 'password' => $pass]);
    // if(\Hash::check($pass, $password)){
    if(\Auth::attempt('users_admin', ['email' => $email, 'password' => $pass])){
      // return 'true'. Auth::user('users_admin'); // cara cek isi dari auth
      if(Auth::user('users_admin')->active == 1){
          return redirect('/dashboard');
      } 
      // return redirect();      
    }else{
      return redirect('admin')->with('err', 'Gagal Login, Periksa Email dan Password !');      
    }
    // return Auth::User_admin();
 }

 public function logout(){
    Auth::logout('user_admin');
    \Session::flush();
    return redirect('admin');
  }
}

