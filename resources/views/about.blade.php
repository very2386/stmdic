<?php
$bodyid = 'page-about';
$rd = \App\Cm::where('position','article')->where('type','about')->first();
?>
@extends('main')
@section('content')		
<section class="hot">
	<div class="ttl-bar">
		<h2>聚落介紹</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/about">聚落介紹</a>
	</div>
	<div class="content clearfix">
		{!!$rd->cont!!}
	</div>
</section>
@endsection
@section('javascript')
@endsection