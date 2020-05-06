<?php
$bodyid = 'page-about';
$rd = \App\Cm::where('position','article')->where('type','plan_intro')->first();
?>
@extends('main')
@section('content')		
<section class="hot">
	<div class="ttl-bar">
		<h2>計畫介紹</h2>
		@include('searchbar')
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/about/plan_intro">計畫介紹</a>
	</div>
	<div class="content clearfix">
		{!!$rd->cont!!}
	</div>
</section>
@endsection
@section('javascript')
@endsection