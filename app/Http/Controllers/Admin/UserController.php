<?php

namespace App\Http\Controllers\Admin;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * 获取用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::paginate(3);
//        $user = User::get();
//
        $arr = [];
        foreach ($user as $k=>$v){
            $v->user_pass = Crypt::decrypt($v->user_pass);
            $arr[]=$v;
        }
//        $user->user_pass = Crypt::decrypt($user->user_pass);
        return view('admin.user.list',compact('arr','user'));
    }

    /**
     * 返回用户添加页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //获取所有权限
        $role = Role::get();
        return view('admin.user.add',compact('role'));
    }

    /**
     * 执行添加操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1.接收数据
        $input = $request->all();
//        //2.表单验证
////        $validator = Validator::make('需要验证的表单数据','验证规则','错误提示信息')
//            $rule=[
//                'username'=>'required|between:4,18',
//                'password'=>'required|between:4,18|alpha_dash',
//            ];
//            $msg=[
//                'username.required'=>'用户名不能为空',
//                'username.between'=>'用户名长度必须在4-18位之间',
//                'password.required'=>'密码不能为空',
//                'password.between'=>'密码长度必须在4-18位之间',
//                'password.alpha_dash'=>'密码只能有字母、数字、破折号（-）以及下划线（_）',
//            ];
//
//            $validator = Validator::make($input,$rule,$msg);
//
//            if ($validator->fails()) {
//                return redirect('admin/user/add')
//                    ->withErrors($validator)
//                    ->withInput();
//            }
        //3.添加到数据库user表
            $username = $input['username'];
            $email = $input['email'];
            $pass = Crypt::encrypt($input['pass']);

            $res = User::create(['user_name'=>$username,'email'=>$email,'user_pass'=>$pass]);

            //角色配置
        $user_id = User::where('user_name', $username)->first()->user_id;
        $role_id = $request->input(['role_id']);

        if (!empty($role_id)){
            foreach ($role_id as $v){
                \DB::table('user_role')->insert(['user_id'=>$user_id,'role_id'=>$v]);
            }
        }
        //4.根据结果给客户端反馈一个json格式的数组
//    return $res;
        if ($res){
            $data = [
                'status'=>0,
                'message'=>'添加成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'添加失败'
            ];
        }

        return $data;
    }

    /**
     * 返回一条用户记录
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 返回一个修改页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        //修改对象
        $user = User::find($id);
        $user_pass =  Crypt::decrypt($user->user_pass);
        //获取所有权限
        $role = Role::get();

        //获取对象对应所有权限
        $own_roles = $user->role;
        //获取对应权限的id
        $own_role= [];
        foreach ($own_roles as $v){
            $own_role[] = $v->id;
        }

        return view('admin.user.edit',compact('user','user_pass','role','own_role'));
    }

    /**
     * 执行修改操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        1. 根据id获取要修改的记录
        $user = User::find($id);
//        2. 获取要修改成的用户名
        $username = $request->input('user_name');
        $email = $request->input('email');
        $userpass = Crypt::encrypt($request->input('user_pass'));
        $userid = $request->input('uid');
        $role_id = $request->input(['role_id']);

        //删除现有权限
        \DB::table('user_role')->where('user_id',$userid)->delete();

        if (!empty($role_id)){
            foreach ($role_id as $v){
                \DB::table('user_role')->insert(['user_id'=>$userid,'role_id'=>$v]);
            }
            $user->user_name = $username;
            $user->user_pass = $userpass;
            $user->email = $email;
            $res = $user->save();

            if($res){
                $data = [
                    'status'=>0,
                    'message'=>'修改成功'
                ];
            }else{
                $data = [
                    'status'=>1,
                    'message'=>'用户修改失败'
                ];
            }
        }else{
            $data = [
                'status'=>1,
                'message'=>'角色修改失败'
            ];
        }



        return $data;
    }

    /**
     * 执行删除操作
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $res = $user->delete();
        //删除现有权限
        \DB::table('user_role')->where('user_id',$id)->delete();
        if($res){
            $data = [
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }
}
