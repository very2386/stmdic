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
$vcat = 9 ; 
$bodyclass="page-index";
$bodyid="page-index";
$link_type = \App\Cm::get_link_type();
$link = [] ; 
foreach($link_type as $type){
    $link[$type] = \App\Cm::where('position','link')->where('type',$type)->where('mstatus','Y')->limit(10)->get();
}
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
<section class="hot">
    <div class="ttl-bar">
        <h2><a href="/news">聚落新知</a></h2>
        <ul class="tab">
            @foreach($news_type as $ns)
                @if($ns!='')
                    <li ><a href="/news/{{$ns}}">{{$ns}}</a></li>
                @endif
            @endforeach
        </ul>
        @include('searchbar')
    </div>
    <div class="content two-side clearfix">
        <div class="cat10 active hot-articles">
            <ul class="grid3 spacing20 wrap">
                @foreach($news_type as $k => $type)
                    @if($k!=2)
                        <?php 
                        $wh = ['position'=>'news','mstatus'=>'Y'] ; 
                        $fdata = \App\Cm::where($wh)->where('type','like','%'.$type.'%')->where('pic','!=','')->orderBy('psort','DESC')->orderBy('created_at','DESC')->first() ; 
                        $news_data = \App\Cm::where($wh)->where('type','like','%'.$type.'%')->where('id','!=',$fdata->id)->orderBy('created_at','DESC')->take(4)->get();
                        ?>
                        <li>
                            <h3><a href="/news/{{$type}}">{{$type}}</a></h3>
                            <div class="img" style="position: relative;">
                                <a href="/news/{{$fdata->id}}">
                                    <img src="{{$fdata->pic}}">
                                    <div class="new_title">{{$fdata->name}}</div>
                                </a>
                            </div>
                            <div class="text">
                                <ul class="list">
                                    @foreach($news_data as $data)
                                    <li><a href="/news/{{$data->id}}">{{$data->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        <li></li>
                    @endif
                @endforeach
            </ul>
            <a class="btn-more" href="/news">More....</a>
        </div>
        
        <!-- 聚落交流、企業徵才 -->
        <div class="hot-today side-right">
            <div class="img">
                <a href="/post_cat"><img src="img/posts.jpg"></a>
                <a href="/job"><img src="img/comp_job.jpg"></a>
            </div>
        </div>
    </div>
</section>

<!-- 育成專區 -->
<section class="bred">
    <div class="ttl-bar">
        <h2><a href="/video">育成專區</a></h2>
        <?php
        $vtype = \App\Cm::where('position','videotype')->where('mstatus','Y')->where('name','!=','行銷專區')->get() ;
        $cat = 0 ; 
        ?>
        <ul class="tab">
            @foreach($vtype as $vt)
            <li data-target="cat{{$vt->name}}">
                <a>{{$vt->name}}</a>
                <?php
                $second = \App\Cm::where('position','videotype_2nd')->where('type',$vt->name)->where('mstatus','Y')->get();
                ?>
                <ul class="submenu">
                    @foreach($second as $st)
                    <li data-target="cat{{$st->name}}">
                        <a>{{$st->name}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="content grid-intro">
        <div class="cat99 active">
            <div class="slider">
                <div class="swiper-container">
                    <?php
                    $video = \App\Cm::where('position','video')->where('type','!=','行銷專區')->orderBY('psort','DESC')->limit(6)->get();
                    ?>
                    <ul class="swiper-wrapper grid4 no-shrink">
                        @foreach($video as $rv)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/video/{{$rv->id}}"><img src="{{\App\Cm::get_pic($rv->id)}}" alt=""></a>
                            </div>
                            <div class="text">
                                <h3><a href="/video/{{$rv->id}}">{{$rv->name}}</a></h3>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
            </div>
            <a class="btn-more" href="/video" style="bottom: -40px;right: 40px;">More....</a>
        </div>
        @foreach($vtype as $vt)
        <div class="cat{{$vt->name}}">
            <div class="slider">
                <div class="swiper-container">
                    <?php
                    $video = \App\Cm::where('position','video')->where('type','like','%'.$vt->name.'%')->limit(6)->get();
                    ?>
                    <ul class="swiper-wrapper grid4 no-shrink">
                        @foreach($video as $rv)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/video/{{$rv->id}}"><img src="{{\App\Cm::get_pic($rv->id)}}" alt=""></a>
                            </div>
                            <div class="text">
                                <h3><a href="/video/{{$rv->id}}">{{$rv->name}}</a></h3>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
                <a class="btn-more" href="/video/{{$vt->name}}">More....</a>
            </div>
        </div>
        @endforeach
        <?php
        $all_type = \App\Cm::where('position','videotype_2nd')->where('mstatus','Y')->get(); 
        ?>
        @foreach($all_type as $st)
        <div class="cat{{$st->name}}">
            <div class="slider">
                <div class="swiper-container">
                    <?php
                    $video = \App\Cm::where('position','video')->where('type','like','%'.$st->name.'%')->limit(6)->get();
                    ?>
                    <ul class="swiper-wrapper grid4 no-shrink">
                        @foreach($video as $rv)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/video/{{$rv->id}}"><img src="{{\App\Cm::get_pic($rv->id)}}" alt=""></a>
                            </div>
                            <div class="text">
                                <h3><a href="/video/{{$rv->id}}">{{$rv->name}}</a></h3>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
                <a class="btn-more" href="/video/{{$st->name}}">More....</a>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- 近期活動 -->
<section class="exhibit">
    <div class="ttl-bar">
        <h2><a href="/event">近期活動</a></h2>
        <ul class="tab">
            @foreach($event_type as $key => $n)
            <li data-target="cat{{$key}}"><a>{{$n}}</a></li>
            @endforeach
        </ul>
        <ul class="btns">
            <li><a class="btn" href="/calendar" style="border: 2px solid;"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;行事曆</a></li>
        </ul>
    </div>
    <div class="content grid-intro">
        <div class="cat6 active">
            <div class="slider">
                <div class="swiper-container">
                    <ul class="swiper-wrapper grid4 no-shrink">
                        <?php
                        \App\Cm::where('event_edate','<',date('Y-m-d :H:i:s',strtotime('-3 month')))->update(['mstatus'=>'N']) ;
                        $w = ['position'=>'event','mstatus'=>'Y'];
                        // $events[] = \App\Cm::where('position','event')->where('mstatus','Y')->where('psort','999')->orderby('event_sdate','ASC')->limit(4)->get();
                        $events[] = \App\Cm::where($w)->where('signup_edate','>=',date('Y-m-d H:i:s',strtotime('-3 day')))->where('signup_sdate','<=',date('Y-m-d H:i:s',strtotime('+3 day')))->orderBy('psort','DESC')->orderby('event_sdate','ASC')->limit(6)->get();
                        ?>
                        @foreach($events as $event)
                            @foreach($event as $e)
                            <li class="swiper-slide">
                                <div class="img">
                                    <a href="/event/{{$e->id}}"><img src="{{\App\Cm::get_pic($e->id)}}" alt=""></a>
                                </div>
                                <div class="text">
                                    <h3><a href="/event/{{$e->id}}">[{{$e->name}}]</a></h3>
                                    <ul class="date">
                                        <li class="evt-time">
                                            <h4>活動時間</h4>
                                            <p>
                                                <span>{{substr($e->event_sdate,0,10)}}</span>
                                                @if($e->event_edate && $e->event_edate != $e->event_sdate )
                                                <span>至 {{substr($e->event_edate,0,10)}}</span>
                                                @endif
                                            </p>
                                        </li>
                                        <li class="reg-time">
                                            <h4>報名時間</h4>
                                            <p>
                                                <span>{{substr($e->signup_sdate,0,10)}}</span>
                                                @if($e->signup_edate && $e->signup_edate != $e->signup_sdate)
                                                <span>至 {{substr($e->signup_edate,0,10)}}</span>
                                                @endif
                                            </p>
                                        </li>
                                    </ul>
                                    <div class="link">
                                        <a href="/event/{{$e->id}}">活動詳情</a>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
            </div>
            <a href="/event" class="btn-more">More....</a>
        </div>
        @foreach($event_type as $key => $n)
        <?php
        $event = \App\Cm::where('position','event')->where('type',$n)->where('mstatus','Y')->where('end_status','N')->where('signup_edate','>=',date('Y-m-d H:i:s',strtotime('-3 day')))->where('signup_sdate','<=',date('Y-m-d H:i:s',strtotime('+3 day')))->orderby('event_sdate','ASC')->limit(10)->get();
        ?>
        <div class="cat{{$key}}">
            @if($event->count()!=0)
            <div class="slider">
                <div class="swiper-container">
                    <ul class="swiper-wrapper grid4 no-shrink">
                        @foreach($event as $e)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/event/{{$e->id}}"><img src="{{\App\Cm::get_pic($e->id)}}" alt=""></a>
                            </div>
                            <div class="text">
                                <h3><a href="/event/{{$e->id}}">[{{$e->name}}]</a></h3>
                                <ul class="date">
                                    <li class="evt-time">
                                        <h4>活動時間</h4>
                                        <p>
                                            <span>{{substr($e->event_sdate,0,10)}}</span>
                                            @if($e->event_edate && $e->event_edate != $e->event_sdate )
                                            <span>至 {{substr($e->event_edate,0,10)}}</span>
                                            @endif
                                        </p>
                                    </li>
                                    <li class="reg-time">
                                        <h4>報名時間</h4>
                                        <p>
                                            <span>{{substr($e->signup_sdate,0,10)}}</span>
                                            @if($e->signup_edate && $e->signup_edate != $e->signup_sdate)
                                            <span>至 {{substr($e->signup_edate,0,10)}}</span>
                                             @endif
                                        </p>
                                    </li>
                                </ul>
                                <div class="link">
                                    <a href="/event/{{$e->id}}">活動詳情</a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
            </div>
            <a href="/event/{{$n}}" class="btn-more">More....</a>
            @endif
        </div>
        @endforeach
    </div>
</section>

<!-- 聚落廠商 -->
<section class="manufacturers">
    <div class="ttl-bar">
        <h2><a href="/company">聚落廠商</a></h2>
        <ul class="tab">
            <?php
            $comptype_big = \App\Cm::get_company_big_type();
            ?>
            @foreach($comptype_big as $cb_type)
            <li data-target="cat{{$cb_type}}">
                <a href="javascript:;">{{$cb_type}}</a>
                <ul class="submenu">
                    <?php
                    $comptype_2nd = \App\Cm::get_company_second_type($cb_type); 
                    ?>
                    @foreach($comptype_2nd as $st)
                    <li data-target="cat{{$st}}">
                        <a>{{$st}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
        <form id="searchform" action="/company" method="get">
            <div class="searchbar">
                <input type="search" name="q" placeholder="廠商搜尋">
                <div class="custom-select" target="#search-type">
                    <h5 class="ttl">全部</h5>
                    <ul class="opt">
                        <li>全部</li>
                        <li>廠商名稱</li>
                        <li>內文內容</li>
                        <li>核心技術</li>
                        <li>產品名稱</li>
                    </ul>
                    <input type="hidden" name="c" id="search-type" value="全部">
                </div>
                <button type="submit" class="btn-search">Search</button>
            </div>
        </form>
    </div>
    <div class="content grid-intro">
        <div class="cat99 active">
            <div class="slider">
                <div class="swiper-container">
                    <ul class="swiper-wrapper grid4 no-shrink">
                        <?php
                        $company = \App\Cm::where('position','company')->where('mstatus','Y')->where('pic','!=','NULL')->inRandomOrder()->limit(10)->get();
                        ?>
                        @foreach($company as $c)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/company/{{$c->id}}"><img src="{{\App\Cm::get_pic($c->id)}}" alt="{{$c->name}}"></a>
                            </div>
                            <div class="text">
                                <h3 class="comp_name">
                                    <a href="/company/{{$c->id}}" data-compname="{{$c->name}}">[ {{$c->name}} ]</a>
                                </h3>
                                <p>{{$c->brief}}</p>
                                <div class="link">
                                    <a class="cooperation" data-compid="{{$c->id}}">合作</a>
                                    <a class="ask" data-compid="{{$c->id}}">詢問</a>
                                    <a href="/company_hire_list/{{$c->id}}">徵才</a>
                                </div>
                          </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
            </div>
            <a href="/company" class="btn-more">More....</a>
        </div>
        @foreach($comptype_big as $ct)
        <div class="cat{{$ct}}">
            <div class="slider">
                <div class="swiper-container">
                    <ul class="swiper-wrapper grid4 no-shrink">
                        <?php
                        $query = \App\Cm::where('position','company')->where('mstatus','Y')->where('pic','!=','NULL');
                        $stype = \App\Cm::get_company_second_type($ct);
                        $t = 0 ;  
                        foreach($stype as $rs){
                            if($t==0) $query->where('type', 'like', '%'.$rs.'%') ;
                            else if($rs=='體外診斷') $query->where('type', 'like', '%'.$rs.'%')->where('position','company') ;
                            else $query->orWhere('type', 'like', '%'.$rs.'%') ;
                            ++$t;
                        } 
                        $company = $query->inRandomOrder()->limit(10)->get();
                        ?>
                        @foreach($company as $c)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/company/{{$c->id}}"><img src="{{\App\Cm::get_pic($c->id)}}" alt="{{$c->name}}"></a>
                            </div>
                            <div class="text">
                                <h3 class="comp_name">
                                    <a href="/company/{{$c->id}}" data-compname="{{$c->name}}">[ {{$c->name}} ]</a>
                                </h3>
                                <p>{{$c->brief}}</p>
                                <div class="link">
                                    <a class="cooperation" data-compid="{{$c->id}}">合作</a>
                                    <a class="ask" data-compid="{{$c->id}}">詢問</a>
                                    <a href="/company_hire_list/{{$c->id}}">徵才</a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
            </div>
            <a href="/company/{{$ct}}" class="btn-more">More....</a>
        </div>
        @endforeach
        @foreach($company_type as $ct)
        <div class="cat{{$ct}}">
            <div class="slider">
                <div class="swiper-container">
                    <ul class="swiper-wrapper grid4 no-shrink">
                        <?php
                        $company = \App\Cm::where('position','company')->where('type',$ct)->where('mstatus','Y')->where('pic','!=','NULL')->inRandomOrder()->limit(10)->get();
                        ?>
                        @foreach($company as $c)
                        <li class="swiper-slide">
                            <div class="img">
                                <a href="/company/{{$c->id}}"><img src="{{\App\Cm::get_pic($c->id)}}" alt="{{$c->name}}"></a>
                            </div>
                            <div class="text">
                                <h3 class="comp_name">
                                    <a href="/company/{{$c->id}}" data-compname="{{$c->name}}">[ {{$c->name}} ]</a>
                                </h3>
                                <p>{{$c->brief}}</p>
                                <div class="link">
                                    <a class="cooperation" data-compid="{{$c->id}}">合作</a>
                                    <a class="ask" data-compid="{{$c->id}}">詢問</a>
                                    <a href="/company_hire_list/{{$c->id}}">徵才</a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next black"></div>
                <div class="swiper-button-prev black"></div>
            </div>
            <a href="/company/{{$ct}}" class="btn-more">More....</a>
        </div>
        @endforeach
    </div>
</section>

<!-- 領域專家 -->
<section class="yellow-pages">
    <div class="ttl-bar">
        <h2><a href="/expert">領域專家</a></h2>
        <ul class="tab">
            <?php
            $etype = \App\Cm::get_expert_first();
            $cat = 0 ; 
            $t=0;
            ?> 
            <li data-target="cat產學專家">
                <a href="javascript:;">產學專家</a>
                <ul class="submenu">
                    @foreach($etype as $et)
                    <li data-target="cat{{$cat++}}">
                        <a>{{$et}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @foreach($expert_type as $k => $type)
            @if( $k!='expert' && $k!='p_expert' )
            <li data-target="cat{{$cat++}}">
                <a>{{$type}}</a>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
    <div class="content two-side clearfix">
        @foreach($expert_type as $type)
        <div class="cat{{$t++}} side-left">
            <ul class="grid4 wrap">
                <?php
                $experts = \App\Cm::where('position','expert')->where('type',$type)->where('mstatus','Y')->inRandomOrder()->limit(4)->get();
                ?>
                @foreach($experts as $e)
                <li>
                    <div class="img">
                        <?php
                        $pic_src = \App\Cm::get_pic($e->id);
                        $src = $pic_src=='/images/no_image.gif'?'/img/memberimg.jpg':$pic_src;
                        ?>
                        <a href="/expert/{{$e->id}}"><img src="{{$src}}" alt=""></a>
                    </div>
                    <div class="text">
                        <h3><a href="/expert/{{$e->id}}">{{$e->name}}</a></h3>
                        @if($e->type!='服務業者')
                        @if($e->cont)
                        <?php
                        $conts = json_decode($e->cont) ;
                        ?>
                        @if(isset($conts->unit))
                        @foreach($conts->unit as $unit)
                        <p>{{$unit}}</p>
                        @endforeach
                        @endif
                        @if(isset($conts->job_title))
                        @foreach($conts->job_title as $job_title)
                        <p>{{$job_title}}</p>
                        @endforeach
                        @endif
                        @endif
                        @else
                        <p>{{$e->brief}}</p>
                        @endif
                        <a href="/expert/{{$type}}" class="btn-more-box">More</a>
                    </div>
                </li>
                @endforeach
            </ul>
            <a href="/expert/{{$type}}" class="btn-more">More....</a>
        </div>
        @endforeach
        <div class="cat產學專家 side-left">
            <ul class="grid4 wrap">
                <?php
                $experts = \App\Cm::where('position','expert')->whereIn('type',['學界專家','產業專家'])->where('mstatus','Y')->inRandomOrder()->limit(4)->get();
                ?>
                @foreach($experts as $e)
                <li>
                    <div class="img">
                        <?php
                        $pic_src = \App\Cm::get_pic($e->id);
                        $src = $pic_src=='/images/no_image.gif'?'/img/memberimg.jpg':$pic_src;
                        ?>
                        <a href="/expert/{{$e->id}}"><img src="{{$src}}" alt=""></a>
                    </div>
                    <div class="text">
                        <h3><a href="/expert/{{$e->id}}">{{$e->name}}</a></h3>
                        @if($e->type!='服務業者')
                        @if($e->cont)
                        <?php
                        $conts = json_decode($e->cont) ;
                        ?>
                        @if(isset($conts->unit))
                        @foreach($conts->unit as $unit)
                        <p>{{$unit}}</p>
                        @endforeach
                        @endif
                        @if(isset($conts->job_title))
                        @foreach($conts->job_title as $job_title)
                        <p>{{$job_title}}</p>
                        @endforeach
                        @endif
                        @endif
                        @else
                        <p>{{$e->brief}}</p>
                        @endif
                        <a href="/expert/{{$type}}" class="btn-more-box">More</a>
                    </div>
                </li>
                @endforeach
            </ul>
            <a href="/expert/產學專家" class="btn-more">More....</a>
        </div>

        <div class="cat6 active side-left">
            <ul class="grid4 wrap">
                <?php
                $experts = \App\Cm::where('position','expert')->where('mstatus','Y')->inRandomOrder()->limit(4)->get();
                ?>
                @foreach($experts as $e)
                <li>
                    <div class="img">
                        <?php
                        $pic_src = \App\Cm::get_pic($e->id);
                        $src = $pic_src=='/images/no_image.gif'?'/img/memberimg.jpg':$pic_src;
                        ?>
                        <a href="/expert/{{$e->id}}"><img src="{{$src}}" alt=""></a>
                    </div>
                    <div class="text">
                        <h3><a href="/expert/{{$e->id}}">{{$e->name}}</a></h3>
                        @if($e->type!='服務業者')
                        @if($e->cont)
                        <?php
                        $conts = json_decode($e->cont) ;
                        ?>
                        @if(isset($conts->unit))
                        @foreach($conts->unit as $unit)
                        <p>{{$unit}}</p>
                        @endforeach
                        @endif
                        @if(isset($conts->job_title))
                        @foreach($conts->job_title as $job_title)
                        <p>{{$job_title}}</p>
                        @endforeach
                        @endif
                        @endif
                        @else
                        <p>{{$e->brief}}</p>
                        @endif
                        <a href="/expert/{{$type}}" class="btn-more-box">More</a>
                    </div>
                </li>
                @endforeach
            </ul>
            <a href="/expert" class="btn-more">More....</a>
        </div>
        <div class="side-right">
            <h3>尋找最有價值的專家</h3>
            <form id="searchform" action="/expert" method="get">
                <div class="searchbar">
                    <input type="search" name="q" placeholder="聚落專家搜尋">
                    <div class="custom-select" target="#search-t">
                        <h5 class="ttl">全部</h5>
                        <ul class="opt">
                            <li>全部</li>
                            <li>標題</li>
                            <li>內文</li>
                        </ul>
                    </div>
                    <input type="hidden" name="t" id="search-t" value="全部">
                    <button class="btn-search">Search</button>
                </div>
                <div class="search-cat">
                    <h4>篩選類別搜尋</h4>
                    <div class="custom-select" target="#search-et">
                        <h5 class="ttl">全部</h5>
                        <ul class="opt">
                            <li>全部</li>
                            <li>產業專家</li>
                            <li>學界專家</li>
                            <li>醫療人員</li>
                            <li>服務業者</li>
                            <li>創業投資人</li>
                            <li>其他</li>
                        </ul>
                    </div>
                    <input type="hidden" name="c" id="search-et" value="全部">
                </div>
            </form>
        </div>
    </div>
</section>
<section class="links">
    <h2>外站連結</h2>
    <ul class="grid3">
        @foreach($link_type as $type)
        <li>
            <h3>{{$type}}</h3>
            <ul class="grid2">
                @foreach($link[$type] as $rd)
                <li><a href="{{$rd->link}}" target="_blank">{{$rd->name}}</a></li>
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
    <a class="btn-more" href="/link">More....</a>
</section>
@endsection
@section('javascript')
@include('popup')
    @endsection