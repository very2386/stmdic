<?php
$rd = \App\Cm::where('id',$id)->first();
if(isset($_GET['type'])){
	$bodyid = "page-market";
} 
?>
@extends('main')
@section('content')		
<section class="hot">
	<div class="ttl-bar">
		<h2>{{$type=='foreign'?'國外媒體':'國內媒體'}}</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="javascript:;">{{!isset($_GET['type'])?'最新消息':'行銷專區'}}</a> &gt; 
		<a href="javascript:;">媒體曝光</a> &gt; 
		<a href="/information/{{$type}}">{{$type=='foreign'?'國外媒體':'國內媒體'}}</a> &gt; 
		<a href="">{{$rd->name}}</a> 
	</div>
	<div class="content clearfix" style="line-height: 33px;">
		@if($rd)
		{!!$rd->cont!!}
		@endif
	</div>
</section>
@endsection
@section('javascript')
@endsection