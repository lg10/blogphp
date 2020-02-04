<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtController extends Controller
{

    /**
     * 修改排序
     */
    public function changeorder(Request $request)
    {
        //获取前台数据
        $input = $request->except('_token');

        //获取当前id的记录
        $cate = Article::find($input['id']);

        //更新数据库中排序值
        $res = $cate->update(['art_order'=>$input['art_order']]);

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
        $path = public_path('uploads/news/'.$filetime);

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
        $img = Article::find($input['id']);
        $res = $img->update(['art_status'=>$input['status']]);
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
        //
        $art = (new Article())->itree();
        return view('admin.article.list',compact('art'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.article.add1');
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
        if ($input['art_thumb']) {

                $res = Article::create(['art_title' => $input['art_title'], 'art_editor' => $input['art_editor'],
                    'art_thumb' => $input['art_thumb'],
                    'web_description' => $input['web_description'],'web_keywords' => $input['web_keywords'],
                    'art_content' => $input['art_content'],'art_status' => $input['status']]);

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
        $art = Article::find($id);
        // 获取 “上一篇” 的 ID
//        $previousPostID = Article::where('id', '<', $id)->max('id');
//
//        // 同理，获取 “下一篇” 的 ID
//        $nextPostId = Article::where('id', '>', $id)->min('id');
        return view('news.news',compact('art'));
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
        $art = Article::find($id);
        return view('admin.article.edit',compact('art'));
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
        $art = Article::find($input['uid']);
        $res = $art->update(['art_title' => $input['art_title'], 'art_editor' => $input['art_editor'],
            'art_thumb' => $input['art_thumb'], 'web_description' => $input['web_description'],
            'web_keywords' => $input['web_keywords'], 'art_content' => $input['art_content']]);

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
        $img = Article::find($id);
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
