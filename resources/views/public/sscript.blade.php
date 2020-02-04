<script src="{{asset('./js/tj.js')}}"></script>
<!-- 轮播设置 js-->
<script src="{{asset('html/layui/lay/modules/jquery.js')}}"></script>
<script src="{{asset('html/layui/lay/modules/carousel.js')}}"></script>
<script src="{{asset('html/layui/layui.js')}}"></script>
<script>
    layui.use('carousel', function () {
        var s = screen.availHeight - 105;
        var b = screen.availWidth;
        if (b <= 500) {
            s = 800;
        }
        var carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#test1'
            , width: '100%' //设置容器宽度
            , arrow: 'none' //始终显示箭头
            , anim: 'fade' //切换动画方式
            , height: s
            , autoplay: 'true'
            , interval: '3000'
        });
    });
</script>