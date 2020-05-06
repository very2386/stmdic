<?php
$choose_type = \App\Cm::get_event_type();
\App\Cm::where('id',$id)->increment('hits');
$event = \App\Cm::where('id',$id)->first() ; 
$cont = json_decode($event->cont) ;
$brief = json_decode($event->brief) ;
?>
@extends('main')
@section('content')
<style>
	.map img{width: auto;}
	pre { 
		white-space: pre-wrap; 
		white-space: -moz-pre-wrap; 
		white-space: -pre-wrap; 
		white-space: -o-pre-wrap; 
		word-wrap: break-word; 
	} 
	.popup_background{
		position: absolute;
	    top: 100px;
	    left: 44%;
	    width: 800px;
	    margin-left: -300px;
	    background-color: #fff;
	    color: #333;
	}
</style>
<section class="activity">
	<div class="ttl-bar">
		<h2>近期活動</h2>
		<ul class="tab">
			@foreach($choose_type as $t)
			<li class="{{$t==$event->type?'active':''}}"><a href="/event/{{$t}}">{{$t}}</a></li>
			@endforeach
		</ul>
		@include('searchevent')
		<ul class="btns">
			<li><a class="btn" href="/calendar"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;行事曆</a></li>
		</ul>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/event">近期活動</a> &gt; <a href="/event/{{$id}}">{{$event->name}}</a>
	</div>
	<div class="content grid-intro">
		<div class="frame">
			<div class="video-frame" style="background-color:#000000;width:100%">
				<img src="{{\App\Cm::get_pic($event->id)}}">
			</div>
		</div>
		<div class="block bg-gray pd15">
			<ul>
				<li class="flex v-center">
					<h3 class="ttl">活動名稱</h3>
					<p>{{$event->name}}</p>
				</li>
				<li class="flex v-center">
					<?php
						$e_sdate = mb_substr(strip_tags($event->event_sdate),0,10) ;
						$e_edate = mb_substr(strip_tags($event->event_edate),0,10) ;
					?>

	                @if($e_sdate)
					<h3 class="ttl">活動日期</h3>
					<p>{{$e_sdate}}{{$e_sdate!=$e_edate?' ~ '.$e_edate:''}}</p>
					@endif
				</li>
				<li class="flex v-center">
					<?php
						$s_sdate = mb_substr(strip_tags($event->signup_sdate),0,10) ;
						$s_edate = mb_substr(strip_tags($event->signup_edate),0,10) ;
	                ?>
					@if($s_sdate)
					<h3 class="ttl">報名日期</h3>
					<p>{{$s_sdate}}{{$s_sdate!=$s_edate?' ~ '.$s_edate:''}}</p>
					@endif
				</li>
			</ul>
		</div>
		<h3 class="ttl-underline colored">活動內容</h3>
		<div class="block block2 bg-gray pd15">
			<ul>
				@if(isset($brief->event_cont))
				<li class="flex v-center">
					<h3 class="ttl">活動內容</h3>
					<p><pre>{{$brief->event_cont}}</pre></p>
				</li>
				@endif
				@if(isset($brief->event_fee))
				<li class="flex v-center">
					<h3 class="ttl">收費標準</h3>
					<p>{{$brief->event_fee}}
						@if($brief->event_fee!='免費')元/人@endif
					</p>
				</li>
				@endif
				@if(isset($brief->event_organizer))
				<li class="flex v-center">
					<h3 class="ttl">主辦單位</h3>
					<p>{{$brief->event_organizer}}</p>
				</li>
				@endif
				@if(isset($brief->event_co_organizer))
				<li class="flex v-center">
					<h3 class="ttl">協辦單位</h3>
					<p>{{$brief->event_co_organizer}}</p>
				</li>
				@endif
				@if(isset($brief->event_sponsors))
				<li class="flex v-center">
					<h3 class="ttl">贊助單位</h3>
					<p>{{$brief->event_sponsors}}</p>
				</li>
				@endif
			</ul>
		</div>
		@if($cont)
		<h3 class="ttl-underline colored">活動流程</h3>
		<div class="tbl-st2">
			<table>
				<tr>
					<th>時間</th>
					<th>議程</th>
					<th>貴賓 / 主持人</th>
				</tr>
				@foreach($cont as $rs)
				<tr>
					<td>{{$rs->time}}</td>
					<td><pre>{!!$rs->agenda!!}</pre></td>
					<td>{{$rs->vip}}</td>
				</tr>
				@endforeach
			</table>
		</div>
		@endif
		@if(isset($brief->event_vip))
		<div class="mb20">
			<h3 class="ttl-underline colored">主持人</h3>
			<h4>{{$brief->event_vip}}</h4>
		</div>
		@endif
		@if($event->link)
		<div class="mb20">
			<h3 class="ttl-underline colored">報名表</h3>
			<a href="{{$event->link}}" target="_blank">{{$event->link}}</a>
		</div>
		@endif
		@if(isset($brief->event_contact_tel))
		<div class="mb20">
			<h3 class="ttl-underline colored">聯絡方式</h3>
			<p>{{$brief->event_contact_tel}} &nbsp;{{$brief->event_contact}}</p>
		</div> 
		@endif
		@if($event->spic)
		<div class="mb20 map">
			<h3 class="ttl-underline colored">交通地圖</h3>
			<img src="{{\App\Cm::get_spic($event->id)}}">
		</div>
		@endif
		<?php
		$files = \App\OtherFiles::where('cm_id',$id)->get();
		?>
		@if(count($files)>0)
		<div class="mb20 map">
			<h3 class="ttl-underline colored">活動圖片</h3>
			<div class="slider">
				<div class="swiper-container">
					<ul class="swiper-wrapper grid4 no-shrink">
						@foreach($files as $rs)
						<li class="swiper-slide">
							<div class="img">
								<a href="{{$rs->fname}}" rel="lightbox[Demo]"><img class="show_pic" src="{{$rs->fname}}" alt="" ></a>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
				<div class="swiper-button-next black"></div>
				<div class="swiper-button-prev black"></div>
			</div>
		</div>
		@endif
	</div>
</section>
@endsection
@section('javascript')
<script type="text/javascript">
$(function(){
	$('.custom-select .opt li').click(function(){
		var sortby = $(this).data('sort');
		location.href=$('#current_url').val() +'?sort=' +sortby ;
	});

	lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })

	//活動圖片跳出
	$('.show_pic').click(function() {
		var img_src = $(this).attr("src") ;
		$('#event_pic').attr("src",img_src) ;
      	$('.popup-Cooperation').fadeIn();
    }) 
	//活動圖片淡出
    $('.masklayer').click(function(){
      	$(this).parent().fadeOut();
    })
})
</script>
@endsection