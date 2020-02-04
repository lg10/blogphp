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
                <form class="layui-form" action="{{ url('admin/article') }}" method="post">
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

                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">缩略图</label>
                        <div class="layui-input-block layui-upload">
                            <input type="hidden" id="img1" class="hidden" name="art_thumb" value="">
                            <button type="button" class="layui-btn" id="test1">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                            <input type="file" name="photo" id="photo_upload" style="display: none;" />
                        </div>
                    </div>


                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <img src="" alt="" id="art_thumb_img" style="max-width: 350px; max-height:100px;">
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
        <script>

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            });

        </script>
        <script>layui.use(['upload','form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer,
                upload = layui.upload;

                //创建监听函数
                // var xhrOnProgress=function(fun) {
                //     xhrOnProgress.onprogress = fun; //绑定监听
                //     //使用闭包实现监听绑
                //     return function() {
                //         //通过$.ajaxSettings.xhr();获得XMLHttpRequest对象
                //         var xhr = $.ajaxSettings.xhr();
                //         //判断监听函数是否为函数
                //         if (typeof xhrOnProgress.onprogress !== 'function')
                //             return xhr;
                //         //如果有监听函数并且xhr对象支持绑定时就把监听函数绑定上去
                //         if (xhrOnProgress.onprogress && xhr.upload) {
                //             xhr.upload.onprogress = xhrOnProgress.onprogress;
                //         }
                //         return xhr;
                //     }

                $('#test1').on('click',function () {
                    $('#photo_upload').trigger('click');
                    $('#photo_upload').on('change',function () {
                        var obj = this;

                        var formData = new FormData($('#art_form')[0]);
                        $.ajax({
                            url: '/admin/banner/upload',
                            type: 'post',
                            data: formData,
                            // 因为data值是FormData对象，不需要对数据做处理
                            processData: false,
                            contentType: false,
                            success: function(data){
                                if(data['ServerNo']=='200'){
                                    // 如果成功
                                    {{--$('#art_thumb_img').attr('src', '{{ env('ALIOSS_DOMAIN')  }}'+data['ResultData']);--}}
                                    {{--$('#art_thumb_img').attr('src', '{{ env('QINIU_DOMAIN')  }}'+data['ResultData']);--}}
                                    $('#art_thumb_img').attr('src', data['path']+"/"+data['ResultData']);
                                    $('input[name=art_thumb]').val(data['path']+"/"+data['ResultData']);
                                    $(obj).off('change');
                                }else{
                                    // 如果失败
                                    alert(data['ResultData']);
                                }
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                var number = XMLHttpRequest.status;
                                var info = "错误号"+number+"文件上传失败!";
                                // 将菊花换成原图
                                // $('#pic').attr('src', '/file.png');
                                alert(info);
                            },
                            async: true
                        });
                    });

                });

                //拖拽上传https://httpbin.org/post
                // upload.render({
                //     elem: '#banner'
                //     ,url: '/admin/banner/upload' //改成您自己的上传接口
                //     ,headers: {
                //
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //
                //     }
                //     // ,before: function(obj){
                //     //     layer.msg('图片上传中，请耐心等待...', {
                //     //         icon: 16,
                //     //         shade: 0.01,
                //     //         time: 0
                //     //     })
                //     // }
                //     ,done: function(res){
                //         // layer.close(layer.msg());
                //         // layer.msg('上传成功');
                //         // layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.files.file);
                //         console.log(res)
                //     }
                // });


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
