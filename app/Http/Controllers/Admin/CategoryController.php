<?php

namespace App\Http\Controllers\Admin;


use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{

    /**
     * 修改排序
     */
    public function changeorder(Request $request)
    {
        //获取前台数据
        $input = $request->except('_token');

        //获取当前id的记录
        $cate = Category::find($input['cate_id']);

        //更新数据库中排序值
        $res = $cate->update(['cate_order'=>$input['cate_order']]);

        //返回json数组
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //引入模型中自建类
       $cate = (new Category())->itree();
        return view('admin.category.list',compact('cate'));
//        return $cate;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cate = (new Category())->itree();
        return view('admin.category.add',compact('cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->except('_token');

        //更新数据库中值
        if(!$input['status']){
            $res = Category::create(['cate_name'=>$input['cate_name'],'cate_title'=>$input['cate_title'],'cate_pid'=>$input['cate_pid'],'status'=>$input['status']]);
        }else{
            $res = Category::create(['cate_name'=>$input['cate_name'],'cate_title'=>$input['cate_title'],'cate_pid'=>$input['cate_pid']]);
        }


        //返回json数组
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

//        return $input;
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
        $cate = Category::find($id);
        return view('admin.category.edit',compact('cate'));
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
        $input = $request->except('_token');
        $cate = Category::find($input['uid']);
        //更新数据库中值
        if(!$input['status']){
            $res = $cate->update(['cate_name'=>$input['cate_name'],'cate_title'=>$input['cate_title'],'status'=>$input['status']]);
        }else{
            $res = $cate->update(['cate_name'=>$input['cate_name'],'cate_title'=>$input['cate_title']]);
        }


        //返回json数组
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
        $cate = Category::find($id);
        $res = $cate->delete();
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
