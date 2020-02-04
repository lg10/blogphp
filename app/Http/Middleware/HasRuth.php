<?php

namespace App\Http\Middleware;

use Closure;

class HasRuth
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
        //获取当前路由地址
        $route = \Route::current()->getActionName();
//        dd($route,session()->get('permission'));
        $permission = session()->get('permission');
        //判断当前用户请求的路由是否在用户允许权限内
        if (in_array($route,$permission)){
            return $next($request);
        }
        return redirect('admin/noruth');
    }
}
