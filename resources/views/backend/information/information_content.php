<?php
$rd = \App\Cm::where('id',$id)->first();
?>
@extends('main')
@section('content')		
<section class="hot">
	<div class="ttl-bar">
		<h2>{{$type=='foreign'?'國外媒體':'國內媒體'}}</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="javascript:;">最新消息</a> &gt; 
		<a href="javascript:;">媒體曝光</a> &gt; 
		<a href="/information/{{$type}}">{{$type=='foreign'?'國外媒體':'國內媒體'}}</a>
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