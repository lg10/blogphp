<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
@include('admin.public.styles')
@include('admin.public.scripts')

</head>

<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>角色名
            </label>
            <div class="layui-input-inline">
                <input type="hidden" name="uid" value="{{ $role->id }}">
                <input type="text" id="L_email" value="{{ $role->role_name }}" name="role_name" required="" lay-verify="text"
                       autocomplete="off" class="layui-input">
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>权限</label>
            <div class="layui-input-block">
                @foreach($per as $v)
                    @if(in_array($v->id,$own_per))
                        <input type="checkbox" name="per_id[]" lay-skin="primary" value="{{$v->id}}" title="{{$v->per_name}}" checked="">
                    @else
                        <input type="checkbox" name="per_id[]" lay-skin="primary" value="{{$v->id}}" title="{{$v->per_name}}" >
                    @endif
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="edit" lay-submit="">
                修改
            </button>
        </div>
    </form>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;



        //监听提交
        form.on('submit(edit)', function(data){
            var uid = $("input[name='uid']").val();
            //发异步，把数据提交给php
            $.ajax({
                type:'PUT',
                url:'/admin/role/'+uid,
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:data.field,
                success:function(data){
                    // 弹层提示添加成功，并刷新父页面
                    // console.log(data);
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


    });
</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>