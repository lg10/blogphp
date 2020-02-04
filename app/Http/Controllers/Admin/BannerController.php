<?php

namespace App\Http\Controllers\Admin;

use App\Model\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{


    /**
     * 修改排序
     */
    public function changeorder(Request $request)
    {
        //获取前台数据
        $input = $request->except('_token');

        //获取当前id的记录
        $cate = Banner::find($input['id']);

        //更新数据库中排序值
        $res = $cate->update(['img_order'=>$input['img_order']]);

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
     * 图片上传
     * @param Request $request
     * @param $time
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $file = $request->file('photo');
//        $filetime = Carbon::today()->toDateString();
        $time = Carbon::now();
        $fyear = $time->year;
        $fmonth = $time->month;
        $fday = $time->day;
        $filetime = "$fyear".'/'."$fmonth".'/'."$fday".'/';
        if(!$file->isValid()){
            return response()->json(['ServerNo'=>'400','ResultData'=>'无效的上传文件']);
        }
        //获取原文件的扩展名
        $ext = $file->getClientOriginalExtension();    //文件拓展名
        //新文件名
        $newfile = md5(time().rand(1000,9999)).'.'.$ext;

        //文件上传的指定路径
        $path = public_path('uploads/banner/'.$filetime);

        $newpath = $path.$newfile;

        //将文件从临时目录移动到本地指定目录
        if(! $file->move($path,$newfile)){
            return response()->json(['ServerNo'=>'400','ResultData'=>'保存文件失败']);
        }

        return response()->json(['ServerNo'=>'200','ResultData'=>$newfile,'path'=>$filetime]);
    }

    /**
     * 状态切换操作
     */
    public function changestatus(Request $request)
    {
        $input = $request->except('_token');
        $img = Banner::find($input['id']);
        $res = $img->update(['status'=>$input['status']]);
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
        //检索数据库
        $img = (new Banner())->itree();
        return view('admin.banner.list1',compact('img'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.banner.add1');
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
        if ($input['img_url']) {
            if (!$input['status']) {
                $res = Banner::create(['img_name' => $input['img_name'], 'img_url' => $input['img_url'], 'status' => $input['status']]);
            } else {
                $res = Banner::create(['img_name' => $input['img_name'], 'img_url' => $input['img_url']]);
            }

            //返回json数组
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
        }else{
            $data = [
                'status'=>1,
                'message'=>'请上传图片'
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
        $img = Banner::find($id);
        return view('admin.banner.edit',compact('img'));
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
        $cate = Banner::find($input['uid']);
        //更新数据库中值
        if($input['img_url']){
            $res = $cate->update(['img_name'=>$input['img_name'],'img_url'=>$input['img_url']]);
        }else{
            $res = $cate->update(['img_name'=>$input['img_name']]);
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
        $img = Banner::find($id);
        $res = $img->delete();
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
