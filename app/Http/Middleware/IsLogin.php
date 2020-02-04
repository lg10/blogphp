<?php

namespace App\Http\Middleware;

use Closure;

class IsLogin
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
//       $res = session()->get('user');
//       dd($res);

        if(session()->get('user')){
            return $next($request);
        }else{
            return redirect('admin/login')->with('errors','未登录');
        }

    }
}
