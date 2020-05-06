<?php
$news = \App\Cm::where('id',$id)->first();
if(!$news){
	session()->flash('sysmsg', '找不到新聞資料');
	echo '<script>location.href="/news"</script>';
	exit;
}
// $news->type = $news->type != '' ? $news->type : '全部文章' ;
$update = explode(" ",$news->created_at) ;
$up_sn = $news->up_sn!=0 ? $news->up_sn : '' ;
\App\Cm::where('id',$id)->increment('hits');
$news_type = \App\Cm::get_news_type();
$company_id = \App\Cm::get_related($id,'company') ;
$rss_source =  \App\Cm::get_sourcename($news->id);
$show_style="";
if($rss_source == "元氣網"){
	$show_style= 'display:none';
}
$ntype = explode(',', $news->type) ;
$comp = \App\Cm::relation_company($news->type) ; 
$size = count($comp)>3  ? 3 : count($comp) ;
if(count($comp)>0) $rand_comp = array_rand($comp,$size);
?>
@section('header')
<meta property="og:url"           content="{{request()->url()}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$news->name}}" />
<meta property="og:description"   content="{{mb_substr(strip_tags($news->cont),0,100)}}" />
<meta property="og:image"         content="{{\App\Cm::get_news_pic($news->id)}}" />
@endsection
@extends('main')
@section('content')	
<section class="hot">
	<div class="ttl-bar">
		<h2>聚落新知</h2>
		<ul class="tab">
			<!-- <li class="{{$news->type=='全部新聞'||$news->type==''?'active':''}}"><a href="/news/全部新聞">全部新聞</a></li> -->
			@foreach($news_type as $ns)
				@if($ns!='')
					<li class="{{$news->type==$ns?'active':''}}"><a href="/news/{{$ns}}">{{$ns}}</a></li>
				@endif
			@endforeach
		</ul>
		@include('searchbar')
		<!-- <div class="searchbar">
			<input type="search" placeholder="文章搜尋">
			<button class="btn-search">Search</button>
		</div> -->
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/news">熱門文章</a> &gt; <a class="name" >{{$news->name}}</a>
	</div>
	<div class="content two-side news clearfix">
		<div class="side-left active article">
			<!-- <h3 class="ttl fw-b fz-l" style={{$show_style}} >{{$news->name}}</h3> -->
			<h3 class="ttl fw-b fz-l">{{$news->name}}</h3>
			<p class="source">
				<span class="date">{{$update[0]}}</span>
				<span class="time">{{$update[1]}}</span>
				<span class="media">{{$news->up_sn!=0?\App\Cm::get_sourcename($news->id):''}}</span>
			</p>
			<!-- <div class="img mb20" style={{$show_style}} ><img src="{{\App\Cm::get_news_pic($news->id)}}" alt="" ></div> -->
			<div class="text">
				<p>{!!$news->cont!!}</p>
			</div>
			<a class="btn" href="{{$news->link}}" target="_blank" style="margin-left:0px">閱讀全文</a>
			<div id="fb-root"></div>
			<div class="fb-like" data-href="{{request()->url()}}" data-layout="standard" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
			<div class="fb-comments" data-href="{{request()->url()}}" data-numposts="5" data-width="750"></div>
		</div>
		<div class="side-right right-st1">
			<ul>
				<li>
					<h3 class="ttl">相關廠商</h3>

					@if(!empty($rand_comp))
						@foreach($rand_comp as $com)
							<?php
							$company = \App\Cm::where('id',$comp[$com])->first() ; 
							?>
							@if($company)
								<div class="img"><img src="{{\App\Cm::get_pic($company->id)}}" alt=""></div>
								<div class="text">
									<h4><a href="/company/{{$company->id}}">{{$company->name}}</a></h4>
									<p class="comp-brief">{{$company->brief}}</p>	
								</div>
							@endif	
							<hr>	
						@endforeach
					@else
						<div class="block">
							<h4>
								無相關廠商
							</h4>
						</div>
					@endif

				</li>
				<!-- <li>
					<h3 class="ttl">相關期刊</h3>
					<div class="text">
						<h4>膽固醇不一定是「吃」來的破除膽固醇4迷思</h4>
						<p>本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但
							依據有關法律規章規定、應司法機關調查要求
							為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
						</p>
					</div>
				</li> -->
			</ul>
		</div>
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
$(function(){
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=110989952909732';
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
})
</script>
@endsection