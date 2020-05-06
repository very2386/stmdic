<?php
$bodyid="page-market";
$choose_type = \App\Cm::get_event_type();
$event = \App\Cm::where('id',$id)->first() ; 
$cont = json_decode($event->cont) ;
$brief = json_decode($event->brief) ;
?>
@extends('main')
@section('content')
<style>
	.map img{width: auto;}
</style>
<section class="activity">
	<div class="ttl-bar">
		<h2>展示室活動</h2>
		<form id="searchform" action="/marketing/showroom/展示室活動" method="get">
			<div class="searchbar">
				<input type="text" name="q" value="{{request('q')}}" placeholder="活動搜尋">
				<button type="submit" class="btn-search">Search</button>
			</div>
		</form>
<!-- 		<ul class="btns">
			<li><a class="btn" href="/calendar"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;行事曆</a></li>
		</ul> -->
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="">行銷專區</a> &gt; 
		<a href="">展示平台</a> &gt; 
		<a href="">醫材展示室</a> &gt; 
		<a href="/marketing/showroom/展示室活動">展示室活動</a> &gt;
		<a href="/marketing/showroom/展示室活動/{{$id}}">{{$event->name}}</a>
	</div>
	<div class="content grid-intro">
		<div class="block bg-gray pd15">
			<ul>
				<li class="flex v-center">
					<h3 class="ttl">活動名稱</h3>
					<p>{{$event->name}}</p>
				</li>
				<li class="flex v-center">
					<?php
						$sdate_first = mb_substr(strip_tags($event->sdate),0,10) ;
						$sdate_end = mb_substr(strip_tags($event->sdate),11,21) ;
	                ?>
	                @if($sdate_first && $sdate_end)
					<h3 class="ttl">活動日期</h3>
					<p>{{$sdate_first}}{{$sdate_end?' ~ '.$sdate_end:''}}</p>
					@endif
				</li>
			</ul>
		</div>
		<h3 class="ttl-underline colored">活動內容</h3>
		<div class="block block2 bg-gray pd15">
			<ul>
				<li class="flex v-center">
					<h3 class="ttl">活動內容</h3>
					<p>{{$brief->event_cont}}</p>
				</li>
				@if($brief->event_fee)
				<li class="flex v-center">
					<h3 class="ttl">收費標準</h3>
					<p>{{$brief->event_fee}}元/人</p>
				</li>
				@endif
				@if($brief->event_organizer)
				<li class="flex v-center">
					<h3 class="ttl">主辦單位</h3>
					<p>{{$brief->event_organizer}}</p>
				</li>
				@endif
				@if($brief->event_co_organizer)
				<li class="flex v-center">
					<h3 class="ttl">協辦單位</h3>
					<p>{{$brief->event_co_organizer}}</p>
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
					<td>{{$rs->agenda}}</td>
					<td>{{$rs->vip}}</td>
				</tr>
				@endforeach
			</table>
		</div>
		@endif
		@if($brief->event_vip)
		<div class="mb20">
			<h3 class="ttl-underline colored">主持人</h3>
			<h4>{{$brief->event_vip}}</h4>
		</div>
		@endif
		@if($event->link)
		<div class="mb20">
			<h3 class="ttl-underline colored">報名表</h3>
			<a href="http://{{$event->link}}">{{$event->link}}</a>
		</div>
		@endif
		@if($brief->event_contact_tel)
		<div class="mb20">
			<h3 class="ttl-underline colored">聯絡方式</h3>
			<p>{{$brief->event_contact_tel}} &nbsp;{{$brief->event_contact}}</p>
		</div> 
		@endif
		@if($event->spic)
		<div class="mb20 map">
			<h3 class="ttl-underline colored">交通地圖</h3>
			<img src="{{\App\Cm::get_spic($event->id)}}">
			<!-- <p>台北市南港區三段110號2F</p>
			<a class="open-window" target="_blank" href="https://www.google.com.tw/maps/place/115台北市南港區南港路三段110號/">在Google Map瀏覽</a> -->
		</div>
		@endif
	</div>
</section>
@endsection
@section('javascript')
@endsection