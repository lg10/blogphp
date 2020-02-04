<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        {{--css--}}
        @include('admin.public.styles')
        {{--js--}}
        @include('admin.public.scripts')
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>菜单类别
                        </label>
                        <div class="layui-input-inline">
                            <select name="cate_pid">
                                <option name="cate_pid" value="0" selected="">==一级菜单==</option>
                                @foreach($cate as $v)
                                    @if($v->cate_pid == 0)
                                        <option name="cate_pid" value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>菜单名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="username" name="cate_name" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>

                  </div>

                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          <span class="x-red">*</span>菜单简介
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="L_email" name="cate_title" required="" lay-verify="text"
                          autocomplete="off" class="layui-input">
                      </div>

                  </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            <span class="x-red">*</span>是否上线</label>
                        <div class="layui-input-block">
                                <input type="checkbox" checked="" name="status" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                        </div>
                    </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          增加
                      </button>
                  </div>
              </form>
                @include('admin.public.form')
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //监听开关设置默认值
                form.on('switch(switchTest)', function(data){
                    $("input[name='status']").val(this.checked ?1:0);
                });

                //监听提交
                form.on('submit(add)', function(data){

                    //发异步，把数据提交给php
                    $.ajax({
                        type:'POST',
                        url:'/admin/category',
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:data.field,
                        success:function(data){
                            // 弹层提示添加成功，并刷新父页面
                            //  console.log(data);
                            if(data.status == 0){
                                layer.alert(data.message,{icon:6},function(){
                                    parent.location.reload(true);
                                });
                            }else{
                                layer.alert(data.message,{icon:5});
                            }
                        },
                        error:function(){
                            //错误信息
                        }

                    });





                    // layer.alert("增加成功", {icon: 6},function () {
                    //     // 获得frame索引
                    //     var index = parent.layer.getFrameIndex(window.name);
                    //     //关闭当前frame
                    //     parent.layer.close(index);
                    // });
                    return false;
                });

            });</script>
        <script>var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();</script>
    </body>

</html>
