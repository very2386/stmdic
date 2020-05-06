<?php
$bodyid = "page-market";

//計算訪客人數
$hits = \App\Cm::where('position','people')->where('type','space')->value('hits') ; 
if(!$hits) \App\Cm::where('position','people')->where('type','space')->create(['position'=>'people','type'=>'space','hits'=>1]) ;
else \App\Cm::where('position','people')->where('type','space')->increment('hits'); 

$rd = \App\Cm::where('position','space')->first();
\App\Cm::where('position','space')->increment('hits'); 
$imgs = \App\OtherFiles::where('position','space')->get();
?>
@extends('main')
@section('content')		
<section class="hot">
	<div class="ttl-bar">
		<h2>空間介紹</h2>
	</div>
	<div class="breadcrumb">
		<a href="/market">首頁</a> &gt; 
		<a href="">展示平台</a> &gt; 
		<a href="/marketing/space">醫材展示室</a>
		<!-- <a href="/marketing/cooperation">空間介紹</a> -->
	</div>
	<div class="content clearfix" style="line-height: 33px;">
		@foreach($imgs as $img)
			<img class="mb10" src="{{$img->fname}}" alt="">
		@endforeach
		<h3 class="ttl fz-m bold mb10 mt10">{{$rd->name}}</h3>
		@if($rd)
		{!!$rd->cont!!}
		@endif
	</div>
</section>
@endsection
@section('javascript')
@endsection