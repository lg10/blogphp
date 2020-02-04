<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //后台登录页面路由
    Route::get('login','LoginController@login');
    //处理后台登录的路由
    Route::post('dologin','LoginController@doLogin');
    //加密算法
    Route::get('jiami','LoginController@jiami');
    //没有权限提示页面的路由
    Route::get('noruth','LoginController@noruth');
    //后台退出登录的路由
    Route::get('logout','LoginController@logout');
    //后台首页的路由
    Route::get('index','LoginController@index');

    //后台幻灯片模块相关路由（增删改查）
    Route::resource('banner','BannerController');

});


Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function(){

    //后台首页的路由
    Route::get('index','LoginController@index');


});


Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['hasRuth','isLogin']],function(){


//后台欢迎页面的路由
    Route::get('welcome','LoginController@welcome');

    //后台用户模块相关路由（增删改查）
    Route::resource('user','UserController');

    //后台权限模块相关路由（增删改查）
    Route::resource('per','PerController');

    //后台角色模块相关路由（增删改查）
    Route::resource('role','RoleController');

    //后台菜单模块相关路由（增删改查）
    Route::resource('category','CategoryController');
    //修改排序的路由
    Route::post('category/changeorder','CategoryController@changeorder');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){


    //后台幻灯片模块相关路由（增删改查）
    Route::resource('banner','BannerController');
    //后台幻灯片状态切换
    Route::post('banner/changestatus','BannerController@changestatus');
    //后台幻灯片上传
    Route::post('banner/upload','BannerController@upload');
    //后台幻灯片排序
    Route::post('banner/changeorder','BannerController@changeorder');

    //后台新闻文章模块相关路由（增删改查）
    Route::resource('art','ArtController');
    //后台新闻文章状态切换
    Route::post('art/changestatus','ArtController@changestatus');
    //后台新闻缩略图上传
    Route::post('art/upload','ArtController@upload');
    //后台新闻文章排序
    Route::post('art/changeorder','ArtController@changeorder');
});
