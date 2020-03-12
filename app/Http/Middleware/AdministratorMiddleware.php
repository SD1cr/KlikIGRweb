<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdministratorMiddleware{
  public function handle($request, Closure $next){
    $response = $next($request);

    if(Auth::user('users_admin')){
      return $response;
    }
    else{
      return redirect('admin');
    }
  }
}

