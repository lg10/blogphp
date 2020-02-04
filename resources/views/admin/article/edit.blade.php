<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.public.styles')
    @include('admin.public.scripts')
</head>

<body>
    <div class="x-body">
        <form class="layui-form" id="art_form"
{{--              action="{{url('admin/banner')}}" method="post"--}}
        >
{{--            {{ csrf_field() }}--}}


            <div class="layui-form-item" style="margin-top: 20px;">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>文章标题
{{--                    {{ csrf_field() }}--}}
                </label>
                <div class="layui-input-block">
                    <input type="hidden" name="uid" value="{{ $art->art_id }}">
                    <input style="width: 40%;" type="text" id="username" value="{{$art->art_title}}" name="art_title" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>作者
                    {{--                    {{ csrf_field() }}--}}
                </label>
                <div class="layui-input-block">
                    <input style="width: 20%;"  type="text" id="username"  value="{{$art->art_editor}}" name="art_editor" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    <span class="x-red">*</span>缩略图
                </label>
                <div class="layui-input-block layui-upload">
                    <input type="hidden" id="img1" class="hidden" name="art_thumb" value="{{$art->art_thumb}}">
                    <button type="button" class="layui-btn" id="test1">
                        <i class="layui-icon">&#xe67c;</i>重新上传
                    </button>
                    <input type="file" name="photo" id="photo_upload" style="display: none;" />
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img src="{{$art->art_thumb}}" alt="" id="art_thumb_img" style="max-width: 350px; max-height:100px;">
                </div>
            </div>

{{--            <div class="layui-form-item layui-form-text">--}}
{{--                <label class="layui-form-label"><span class="x-red">*</span>描述</label>--}}
{{--                <div class="layui-input-block">--}}
{{--                    <textarea style="width: 40%;" name="desc" value="{{$art->art_description}}" name="art_description" class="layui-textarea"></textarea>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="layui-form-item" style="margin-top: 20px;">
                <label for="username" class="layui-form-label">
                    网站描述（description）
                </label>
                <div class="layui-input-block">
                    <input style="width: 40%;" type="text" id="username" value="{{$art->web_description}}" name="web_description" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 20px;">
                <label for="username" class="layui-form-label">
                    网站关键字（keywords）
                </label>
                <div class="layui-input-block">
                    <input style="width: 40%;" type="text" id="username" value="{{$art->web_keywords}}" name="web_keywords" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>


            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"><span class="x-red">*</span>内容</label>
                <div class="layui-input-block">
{{--                    <input type="hidden" name="art_description" id="artd"/>--}}
                    <!-- 加载编辑器的容器 -->
                    <script id="container"  type="text/plain" name="art_content" style="width:80%;height:300px;">
                    {!! $art->art_content !!}
                    </script>
                    <!-- 配置文件 -->
                    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>

                    <!-- 编辑器源码文件 -->
                    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
                    <!-- 实例化编辑器 -->
                    <script type="text/javascript">
                        var ue = UE.getEditor('container');

                    </script>

                    <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

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
</body>
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
    });
</script>
    <script>
        layui.use(['form','layer','upload','element'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
          var upload = layui.upload;
            var element = layui.element;


            // //监听开关设置默认值
            // form.on('switch(switchTest)', function(data){
            //     $("input[name='status']").val(this.checked ?1:0);
            // });



            //监听提交
            form.on('submit(edit)', function(data) {
                var uid = $("input[name='uid']").val();
                // console.log(html,txt);
                // 发异步，把数据提交给php
                $.ajax({
                    type: 'PUT',
                    url: '/admin/art/'+uid,
                    dataType: 'json',
                    data:data.field,
                    success: function (data) {
                        // 弹层提示添加成功，并刷新父页面
                        //  console.log(data);
                        if (data.status == 0) {
                            layer.alert(data.message, {icon: 6}, function () {
                                parent.location.reload(true);
{{--                                window.location.href='{{url('admin/art')}}';--}}
                            });
                        } else {
                            layer.alert(data.message, {icon: 5});
                        }
                    },
                    error: function () {
                        //错误信息
                    }

                });

                return false;
            });



            //上传图片
            $('#test1').on('click',function () {
                $('#photo_upload').trigger('click');
                $('#photo_upload').on('change',function () {
                    var obj = this;

                    var formData = new FormData($('#art_form')[0]);
                    $.ajax({
                        url: '/admin/art/upload',
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
                                $('#art_thumb_img').attr('src', '/uploads/news/'+data['path']+data['ResultData']);
                                $('input[name=art_thumb]').val('/uploads/news/'+data['path']+data['ResultData']);
                                $(obj).off('change');
                            }else{
                                // 如果失败
                                alert(data['ResultData']);
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            var number = XMLHttpRequest.status;
                            var info = "错误号"+number+"文件上传失败!";
                            alert(info);
                        },
                        async: true
                    });
                });

            });
          
        });
    </script>

</html>