<?php
$rd = \App\Cm::where('position','cooperation')->first();
?>
@extends('main')
@section('content')		
<section class="hot">
	<div class="ttl-bar">
		<h2>產醫合作</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="">行銷專區</a> &gt; 
		<a href="">合作平台</a> &gt; 
		<a href="/marketing/cooperation">產醫合作</a>
	</div>
	<div class="content clearfix">
		@if($rd)
		{!!$rd->cont!!}
		@endif
	</div>
</section>
@endsection
@section('javascript')
@endsection