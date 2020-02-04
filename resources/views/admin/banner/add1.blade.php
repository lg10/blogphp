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


            <div class="layui-form-item">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>图片名
{{--                    {{ csrf_field() }}--}}
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="username" name="img_name" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
                <label for="username" class="layui-form-label" style="position: relative; font-size: 5px;padding: 12px 0 0 0;width: 150px; margin-left: -38px;">
                    如：2020年1月1日头部图-1
                </label>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    <span class="x-red">*</span>Banner图
                </label>
                <div class="layui-input-block layui-upload">
                    <input type="hidden" id="img1" class="hidden" name="img_url" value="">
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
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" lay-skin="switch" lay-filter="switchTest" lay-text="上线|下线">
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

            //监听开关设置默认值
            form.on('switch(switchTest)', function(data){
                $("input[name='status']").val(this.checked ?1:0);
            });



            //监听提交
            form.on('submit(add)', function(data) {

                //发异步，把数据提交给php
                $.ajax({
                    type: 'POST',
                    url: '/admin/banner',
                    dataType: 'json',
                    data: data.field,
                    success: function (data) {
                        // 弹层提示添加成功，并刷新父页面
                        //  console.log(data);
                        if (data.status == 0) {
                            layer.alert(data.message, {icon: 6}, function () {
                                parent.location.reload(true);
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
                                $('#art_thumb_img').attr('src', '/uploads/banner/'+data['path']+data['ResultData']);
                                $('input[name=img_url]').val('/uploads/banner/'+data['path']+data['ResultData']);
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