<?php
$rd = \App\Cm::where('position','information')->where('type',$type)->where('mstatus','Y')->orderBy('id','DESC')->paginate(16);
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
		<a href="/information/{{$type}}">{{$type=='foreign'?'國外媒體':'國內媒體'}}</a>
	</div>
	<div class="content grid-intro">
		<div class="cat active">
			<ul class="grid4 wrap no-shrink">
				@foreach($rd as $c)
				<li class="swiper-slide">
					<div class="img">
						<a href="/information/{{$type}}/{{$c->id}}{{isset($_GET['type'])?'?type=marketing':''}}">
							<img src="{{\App\Cm::get_pic($c->id)}}" alt="">
						</a>
					</div>
					<div class="text">
						<h3 class="comp_name">
							<a href="/information/{{$type}}/{{$c->id}}{{isset($_GET['type'])?'?type=marketing':''}}">{{$c->name}}</a>
						</h3>
					</div>	
				</li>
				@endforeach
			</ul>
			<div class="pager">
				{{$rd->appends(['id' => request('id')])->links()}}
			</div>
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection