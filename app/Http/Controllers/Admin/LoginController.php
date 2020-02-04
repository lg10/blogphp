<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //后台登录页地址
    public  function  login(){
        return view('admin.login');
    }


    //处理用户登录方法
    public function doLogin(Request $request)
    {
//        1.接受表单提交的数据
            $input = $request->except('_token');
//        2.进行表单验证
//        $validator = Validator::make('需要验证的表单数据','验证规则','错误提示信息')
            $rule=[
                'username'=>'required|between:4,18',
                'password'=>'required|between:4,18|alpha_dash',
                ];
            $msg=[
              'username.required'=>'用户名不能为空',
              'username.between'=>'用户名长度必须在4-18位之间',
              'password.required'=>'密码不能为空',
              'password.between'=>'密码长度必须在4-18位之间',
              'password.alpha_dash'=>'密码只能有字母、数字、破折号（-）以及下划线（_）',
            ];
            $validator = Validator::make($input,$rule,$msg);

            if ($validator->fails()) {
                return redirect('admin/login')
                    ->withErrors($validator)
                    ->withInput();
            }

//            3.验证是否有此用户（用户名，密码）
            $user = User::where('user_name',$input['username'])->first();
            if (!$user){
                return redirect('admin/login')->with('errors','没有找到用户名');
            }

            if ($input['password'] != Crypt::decrypt($user->user_pass)){
                return redirect('admin/login')->with('errors','密码错误');
           }
            //获取当前用户拥有的角色
        $roles = $user->role;
            //存放当前用户的角色名
        $arr = [];
        foreach ($roles as $v) {
            $pers = $v->permission;
            foreach ($pers as $per){
                $arr[] = $per->per_url;
            }
        }
        //去掉重复权限
        $arr = array_unique($arr);

//        4. 保存用户信息和权限到session中
            session()->put('user',$user);
        session()->put('username',$user->user_name);
            session()->put('permission',$arr);


            return redirect('admin/index');
    }


    //后台首页地址
    public function index(){
        return view('admin.index');
    }

    //后台欢迎页
    public function welcome(){
        return view('admin.welcome');
    }

    //无权访问
    public function noruth(){
        return view('admin.noruth');
    }

    //退出登录
    public function logout(){
//        情况session中的用户信息
        session()->flush();
        return redirect('admin/login');
    }

    //加密测试
    public function jiami(){
//        eyJpdiI6IkFcL0FjTXJvTFJ4QkRMZGxyT0krdm9RPT0iLCJ2YWx1ZSI6IndnOGRPa3FOMG9VUzViWEx6VDEyNkE9PSIsIm1hYyI6Ijc1ZDAzNjBiYzhkYWNjNDhiYzI2Njk4MTI3ZWIxM2YxZmYzNjU1ZWZlNDdiZTg1MzEwMTJjNjIyMGU2MmZiNDUifQ==
        $str = '123456';
        $crypt_str = Crypt::encrypt($str);
        return $crypt_str;
    }
}
