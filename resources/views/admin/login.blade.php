<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
{{--css--}}
    @include('admin.public.styles')
{{--js--}}
    @include('admin.public.scripts')
</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">管理登录</div>
        <div id="darkbannerwrap"></div>
      @include('admin.public.form')
        <hr class="hr5">
        <form method="post" class="layui-form" action="{{url('admin/dologin')}}">
            {{csrf_field()}}
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <div id="slider"></div>
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        // $(function  () {
        //     layui.use('form', function(){
        //       var form = layui.form;
        //       layer.msg('玩命卖萌中', function(){
        //         //关闭后的操作
        //         });
        //       监听提交
        //       form.on('submit(login)', function(data){
        //         // alert(888)
        //         layer.msg(JSON.stringify(data.field),function(){
        //             location.href='index.blade.php'
        //         });
        //         return false;
        //       });
        //     });
        // })
    </script>
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
    <script>
        //一般直接写在一个js文件中
        layui.config({
            base: 'dist/sliderVerify/'
        }).use(['sliderVerify', 'jquery', 'form'], function() {
            var sliderVerify = layui.sliderVerify,
                $ = layui.jquery,
                form = layui.form;
            var slider = sliderVerify.render({
                elem: '#slider',
                onOk: function(){//当验证通过回调
                    layer.msg("滑块验证通过");
                }
            })
            $('#reset').on('click',function(){
                slider.reset();
            })
            //监听提交
            form.on('submit(formDemo)', function(data) {
                if(slider.isOk()){
                    layer.msg(JSON.stringify(data.field));
                }else{
                    layer.msg("请先通过滑块验证");
                }
                return false;
            });

        })
    </script>
</body>
</html>