<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permissions;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * 列表页
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        return 1111;
        $role = Role::get();
        return view('admin.role.list',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //获取所有权限
        $per = Permissions::get();

        return view('admin.role.add',compact('per'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接收数据
        $input = $request->all();

        //将数据存入变量
        $role_name = $input['role_name'];

        $res = Role::create(['role_name'=>$role_name]);

        //配置权限
        $role_id = Role::where('role_name', $role_name)->first()->id;
        $per_id = $request->input(['per_id']);

        if (!empty($per_id)){
            foreach ($per_id as $v){
                \DB::table('role_permission')->insert(['role_id'=>$role_id,'permission_id'=>$v]);
            }
        }

        //回传数据
        if ($res){
            $data = [
                'status'=>0,
                'message'=>'增加成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'增加失败'
            ];
        }
        return $data;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //修改对象
        $role = Role::find($id);
        //获取所有权限
        $per = Permissions::get();

        //获取对象对应所有权限
        $own_pers = $role->permission;
        //获取对应权限的id
        $own_per= [];
        foreach ($own_pers as $v){
            $own_per[] = $v->id;
        }
        return view('admin.role.edit',compact('role','per','own_per'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //获取需要处理的id，权限
        $role = Role::find($id);
        $input = $request->all();
        $name = $input['role_name'];
        $per_id = $request->input(['per_id']);

        //删除现有权限
        \DB::table('role_permission')->where('role_id',$input['uid'])->delete();

        if (!empty($per_id)){
            foreach ($per_id as $v){
                \DB::table('role_permission')->insert(['role_id'=>$input['uid'],'permission_id'=>$v]);
            }
            $role->role_name = $name;

            $res = $role->save();

            //回传数据
            if ($res){
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
                'message'=>'权限修改失败'
            ];
        }



        return $data;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $role = Role::find($id);
        $res = $role->delete();
        //删除现有权限
        \DB::table('role_permission')->where('role_id',$id)->delete();
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
