<?php
//if(!session('mid')){
// 	echo "<script>alert('數位影音專區只供會員使用，謝謝');location.href='/'</script>";
// 	exit;
// }
\App\Cm::where('id',$id)->increment('hits');
$rd = \App\Cm::where('id',$id)->first();	
if(!$rd){
	session()->flash('sysmsg', '找不到影片資料');
	echo '<script>location.href="/"</script>';
	exit;
}
$bodyid = "page-market";
?>
@extends('main')
@section('content')
<section class="video bg-gray mb20">
	<div class="ttl-bar">
		<h2>產品體驗</h2>
	</div>
	<div class="breadcrumb">
		<a href="/market">首頁</a> &gt; 
		<a href="">展示平台</a> &gt;
		<a href="/marketing/product_experience">產品體驗</a> &gt;
		<a href="/marketing/product_experience/{{$rd->id}}">{{$rd->name}}</a>
	</div>
	<div class="content video grid-intro">
		<div class="frame">
			<h3 class="mb10">{{$rd->name}}</h3>
			<div class="video-frame" style="background-color:#000000;width:100%">
				<iframe width="100%" height="480" src="https://www.youtube.com/embed/{{$rd->link}}" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>
<div class="video-info">
	<ul>
		<li class="flex">
			<h4>影片連結</h4>
			<p>
				<a href="https://www.youtube.com/watch?v={{$rd->link}}" target="_blank">https://www.youtube.com/watch?v={{$rd->link}}</a>
			</p>
		</li>
	</ul>
</div>
@endsection
@section('javascript')
@endsection