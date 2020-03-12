<?php

namespace App\Http\Middleware;

use Closure;

class BiruMiddleware
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
            if ($user['type_id'] != '1' && $user['type_id'] != '2') {
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
