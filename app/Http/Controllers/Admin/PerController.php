<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerController extends Controller
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
        $permission = Permissions::where([])->orderBy('id','asc')->get();

        return view('admin.per.list',compact('permission'));
//        return view('admin.per.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.per.add');
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
        $per_name = $input['per_name'];
        $per_url = $input['per_url'];

        $res = Permissions::create(['per_name'=>$per_name,'per_url'=>$per_url]);

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
        //
        $per = Permissions::find($id);
        return view('admin.per.edit',compact('per'));
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
        //
        $per = Permissions::find($id);
        $input = $request->all();
        $name = $input['per_name'];
        $url = $input['per_url'];

        $per->per_name = $name;
        $per->per_url = $url;

        $res = $per->save();

        //回传数据
        if ($res){
            $data = [
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'修改失败'
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
        $per = Permissions::find($id);
        $res = $per->delete();
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
