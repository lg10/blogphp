<!-- 轮播浮动div js-->
<script src="{{asset('html/wowjs/js/wow.js')}}"></script>
<script>
    new WOW().init();
</script>

<!-- 下滑浮动div js-->
<script src="{{asset('html/js/scrollReveal.js')}}"></script>
<script>
    if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))) {
        (function () {
            window.scrollReveal = new scrollReveal({ reset: true });
        })();
    };
    window.scrollReveal = new scrollReveal();
</script>

<!-- 产品轮播设置 js-->
<script>
    layui.use('carousel', function () {
        var carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#product'
            , width: '100%' //设置容器宽度
            , arrow: 'none' //始终显示箭头
            , anim: 'fade' //切换动画方式
            , height: '800'
            , autoplay: 'true'
            , interval: '3000'
            , arrow: 'always'
        });
    });
</script>

<!--文章页高度 js-->
<script>
    var hei1 = document.getElementById("article-content-text").offsetHeight;
    document.getElementById("article-content").style.height = hei1 + 400 + "px";
    var hei = hei1 + 500;
    document.getElementById("article").style.height = hei + 300 + "px";
</script>