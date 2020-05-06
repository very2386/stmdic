<?php
\App\Cm::where('position','people')->where('type','index')->increment('hits');
//首頁大圖小於今天日期則將其狀態設成N
\App\Cm::where('position','home')->where('type','slider')->whereDate('edate','<',date('Y-m-d'))->update(['mstatus'=>'N']);
$home_pic = \App\Cm::where('position','home')->where('type','slider')->where('mstatus','Y')->orderBy('psort','desc')->get();
$expert = \App\Cm::where('position','expert')->where('mstatus','Y')->orderBy('updated_at','desc')->limit(6)->get();
$company_type = \App\Cm::get_company_type();
$news_type = \App\Cm::get_news_type();
$expert_type = \App\Cm::get_expert_type();
$event_type = \App\Cm::get_event_type();
$video_type = \App\Cm::where('position','video')->where('type','type')->get();
$link = [] ; 
for( $i = 0 ; $i < 3 ; $i++ ){
    $link[$i] = \App\Cm::where('position','link')->limit(10)->get();
}
$vcat = 9 ; 
$bodyclass="page-index";
$bodyid="page-index";
?>
@extends('main')
@section('content')
<!-- TOP BANNER -->
<section class="top two-side clearfix">
    <div class="side-left">
        <div class="swiper-container" data-mode="fade" data-pause="false" data-speed="3000" data-autoplay="3000">
            <ul class="swiper-wrapper">
                @foreach($home_pic as $h)
                <li class="swiper-slide img"><a href="{{$h->link}}" target="_blank"><img src="{{\App\Cm::get_pic($h->id)}}" alt="{{$h->brief}}"></a></li>
                @endforeach
            </ul>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="side-right right-st1">
        <?php
        $posts = \App\Cm::where('position','posts')->where('mstatus','Y')->orderBy('psort','DESC')->orderBy('hits','DESC')->limit(11)->get();
        $new_post = \App\Cm::whereIn('position',['posts','news'])->where('mstatus','Y')->orderBy('created_at','DESC')->limit(11)->get();
        ?>
        <div class="tab-wrap">
            <ul class="tabs grid2">
                <li class="active">熱門討論</li>
                <li>最新文章</li>
            </ul>
            <ul class="tab-content">
                <li class="active">
                    <ul class="text">
                        @foreach($posts as $post)
                        <li>
                          <span class="name">
                            <a href="/post/{{$post->id}}">{{$post->name}}</a>
                        </span>
                    </li>
                    @endforeach
                </ul>
            </li>
            <li>
                <ul class="text">
                    @foreach($new_post as $np)
                    <li>
                        <span class="name">
                            <a href="/{{$np->position=='news'?'news':'post'}}/{{$np->id}}">{{$np->name}}</a>
                        </span>
                    </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
</div>
</section>

<!-- 聚落新知 -->


<!-- 育成專區 -->


<!-- 近期活動 -->


<!-- 聚落廠商 -->


<!-- 領域專家 -->

<section class="links">
    <h2>外站連結</h2>
    <ul class="grid3">
        <li>
            <h3>國內</h3>
            <ul class="grid2">
                @foreach($link[0] as $rd)
                <li><a href="">{{$rd->name}}</a></li>
                @endforeach
            </ul>
        </li>
        <li>
            <h3>國外</h3>
            <ul class="grid2">
                @foreach($link[1] as $rd)
                <li><a href="">{{$rd->name}}</a></li>
                @endforeach
            </ul>
        </li>
        <li>
            <h3>資源</h3>
            <ul class="grid2">
                @foreach($link[2] as $rd)
                <li><a href="">{{$rd->name}}</a></li>
                @endforeach
            </ul>
        </li>
    </ul>
    <a class="btn-more" href="/link">More....</a>
</section>
@endsection
@section('javascript')
@include('popup')
    @endsection