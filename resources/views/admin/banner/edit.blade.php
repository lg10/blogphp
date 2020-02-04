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
    <form class="layui-form"  id="art_form">

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label"><span class="x-red">*</span>Banner图</label>
            <div class="layui-input-block">
                <img src="{{$img->img_url}}" id="art_thumb_img" alt="" style="max-width: 350px; max-height:100px;">
            </div>
        </div>


        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">

            </label>
            <div class="layui-input-block layui-upload">
                <input type="hidden" id="img1" class="hidden" name="img_url" value="">
                <button type="button" class="layui-btn" id="test1">
                    <i class="layui-icon">&#xe67c;</i>修改图片
                </button>
                <input type="file" name="photo" id="photo_upload" style="display: none;" />
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>备注
            </label>
            <div class="layui-input-inline">
                <input type="hidden" name="uid" value="{{ $img->id }}">
                <input type="text" id="L_email" value="{{ $img->img_name }}" name="img_name" required="" lay-verify="text"
                       autocomplete="off" class="layui-input">
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
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
    });
</script>
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
                url:'/admin/banner/'+uid,
                dataType:'json',
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
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>