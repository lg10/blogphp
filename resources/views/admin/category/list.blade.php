<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        {{--css--}}
        @include('admin.public.styles')
        {{--js--}}
        @include('admin.public.scripts')
    </head>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a>
              <cite>导航元素</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">
                            <button class="layui-btn" onclick="xadmin.open('添加目录','{{url('admin/category/create')}}',600,400)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th style="width: 5%;">排序(0-99)</th>
                                    <th style="width: 15%;">菜单名</th>
                                    <th style="width: 40%;">菜单简介</th>
                                      <th style="width: 10%;">状态</th>
                                      <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody class="x-cate">
                                @foreach($cate as $v)
                                    @if($v->cate_pid == 0)
                                  <tr cate-id='{{$v->cate_id}}' fid='0' >
                                    <td>
                                        <div class="layui-input-block" style="position: relative; margin-left: 0;width: 20px;">
                                            <input onchange="changeOrder(this,{{$v->cate_id}})" type="text" name="title"  placeholder="{{$v->cate_order}}" class="layui-input" style="padding-left: 4px;">
                                        </div>
                                    </td>
                                    <td><i class="layui-icon x-show" status='true'>&#xe623;</i>{{$v->cate_name}}</td>
                                    <td>{{$v->cate_title}}</td>
                                      @if($v->status == 1)
                                      <td class="td-status">
                                      <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></td>
                                      @else
                                          <td class="td-status">
                                          <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span></td>
                                      @endif
                                    <td class="td-manage">
                                        <a title="编辑"  onclick="xadmin.open('编辑','{{ url('admin/category/'.$v->cate_id.'/edit') }}',600,400)" href="javascript:;">
                                            <i class="layui-icon">&#xe642;</i>
                                        </a>
                                      <a title="删除" onclick="member_del(this,{{ $v->cate_id }})" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                      </a>
                                    </td>
                                  </tr>
                                  @else
                                        <tr cate-id='{{$v->cate_id}}' fid='{{$v->cate_pid}}' >
                                            <td>
                                                    <div class="layui-input-block" style="position: relative; margin-left: 60px;width:20px;">
                                                        <input onchange="changeOrder(this,{{$v->cate_id}})" type="text" name="title"  placeholder="{{$v->cate_order}}" class="layui-input" style="padding-left: 4px;">
                                                    </div>
                                            </td>
                                            <td>{{$v->cate_name}}</td>
                                            <td>{{$v->cate_title}}</td>
                                            @if($v->status == 1)
                                                <td class="td-status">
                                                    <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></td>
                                            @else
                                                <td class="td-status">
                                                    <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span></td>
                                            @endif
                                            <td class="td-manage">
                                                <a title="编辑"  onclick="xadmin.open('编辑','{{ url('admin/category/'.$v->cate_id.'/edit') }}',600,400)" href="javascript:;">
                                                    <i class="layui-icon">&#xe642;</i>
                                                </a>
                                                <a title="删除" onclick="member_del(this,{{ $v->cate_id }})" href="javascript:;">
                                                    <i class="layui-icon">&#xe640;</i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function(data){

          if(data.elem.checked){
            $('tbody input').prop('checked',true);
          }else{
            $('tbody input').prop('checked',false);
          }
          form.render('checkbox');
        }); 
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });


      });
      
      //修改排序id
      function changeOrder(obj,id) {
        //获取修改后文本框的值
          var cate_order = $(obj).val();
          $.post('/admin/category/changeorder',{'_token':"{{csrf_token()}}","cate_id":id,"cate_oder":cate_order},function (data) {
              if(data.status == 0){
                  layer.msg(data.message,{icon:1,time:1000});
                  location.reload();
              }else{
                  layer.msg(data.message,{icon:2,time:1000});
              }
          });
      }

      // 分类展开收起的分类的逻辑
      //
      $(function(){
          $("tbody.x-cate tr[fid!='0']").hide();
          // 栏目多级显示效果
          $('.x-show').click(function () {
              if($(this).attr('status')=='true'){
                  $(this).html('&#xe625;');
                  $(this).attr('status','false');
                  cateId = $(this).parents('tr').attr('cate-id');
                  $("tbody tr[fid="+cateId+"]").show();
              }else{
                  cateIds = [];
                  $(this).html('&#xe623;');
                  $(this).attr('status','true');
                  cateId = $(this).parents('tr').attr('cate-id');
                  getCateId(cateId);
                  for (var i in cateIds) {
                      $("tbody tr[cate-id="+cateIds[i]+"]").hide().find('.x-show').html('&#xe623;').attr('status','true');
                  }
              }
          })
      })

      var cateIds = [];
      function getCateId(cateId) {
          $("tbody tr[fid="+cateId+"]").each(function(index, el) {
              id = $(el).attr('cate-id');
              cateIds.push(id);
              getCateId(id);
          });
      }

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              $.post('/admin/category/'+id,{"_method":"delete","_token":"{{csrf_token()}}"},function(data){
                  // console.log(data);
                  if(data.status == 0){
                      $(obj).parents("tr").remove();
                      layer.msg(data.message,{icon:1,time:1000});
                  }else{
                      layer.msg(data.message,{icon:2,time:1000});
                  }
              })
              //发异步删除数
          });
      }
    </script>
</html>