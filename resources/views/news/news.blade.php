<!DOCTYPE html>
<html lang="zn">

<head>
   @include('public.heard')
    <title>智慧酒店解决方案一站式服务商_肯天智能</title>
    <meta name="description" content="肯天智能专注智慧酒店20年，自主研发并融合国内外先进技术，拥有独立知识产权国内领先的智慧酒店系统全套解决方案，迄今已合作海内外酒店企业上万家。">
    <meta name="keywords" content="智慧酒店,智慧酒店方案,智慧酒店解决方案,肯天智能">

    @include('public.style')
    @include('public.sscript')
</head>

<body>
<!--    qq链接消息-->
@include('public.qq')

<!--qq链接消息结束-->


    <!-- top star -->
    @include('public.top')
    <!-- top end -->

    <!-- 文章详情 star-->
    <div class="article" id="article">
        <img src="/html/images/news-details/bg.png" />
        <div class="article-content" id="article-content">
            <p class="article-content-tittle">{{$art->art_title}}</p>
            <div class="article-content-text" id="article-content-text">

                {!!$art->art_content!!}

            </div>
            <div class="article-content-footer" style="position: absolute;bottom: 70px;left: 250px;cursor: pointer;">
                <a href="./2.html">
                    <p>上一篇：探讨无人酒店的利与弊</p>
                </a>
                <a href="./2.html">
                    <p>下一篇：探讨无人酒店的利与弊</p>
                </a>
            </div>

        </div>
    </div>
    <!-- 文章详情 end-->

    <!--footer star-->
    @include('public.footer')
    <!--footer end-->
</body>


{{--底js--}}
@include('public.fscript')

</html>