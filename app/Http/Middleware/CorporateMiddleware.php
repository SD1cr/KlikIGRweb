<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CorporateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Auth::guest()) {
            $user = $request->user();
            if ($user['type_id'] != '2' && $user['type_id'] != '3') {
                return $next($request);
            }else{
                return redirect('product');
            }
        }else{
            //redirect ke home
            return redirect('product');   
        }
    }
}
