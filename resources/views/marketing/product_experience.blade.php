<?php
// if(!session('mid')){
// 	echo "<script>alert('數位影音專區只供會員使用，謝謝');location.href='/'</script>";
// 	exit;
// }
//計算訪客人數
$hits = \App\Cm::where('position','people')->where('type','product_experience')->value('hits') ; 
if(!$hits) \App\Cm::where('position','people')->where('type','product_experience')->create(['position'=>'people','type'=>'product_experience','hits'=>1]) ;
else \App\Cm::where('position','people')->where('type','product_experience')->increment('hits'); 

$wh = ['position'=>'compinfo','online_status'=>'Y'];
$query = \App\Cm::where($wh) ; 
$rd = $query->paginate(20);
if(count($rd)==0){
	session()->flash('sysmsg', '找不到影片資料');
	echo "<script>alert('找不到影片資料');history.back();</script>";
	exit;
}
$bodyid="page-market";
?>
@extends('main')
@section('content')
<section class="exhibit bg-gray">
	<div class="ttl-bar">
		<h2>產品體驗</h2>
	</div>
	<div class="breadcrumb">
		<a href="/market">首頁</a> &gt; 
		<a href="">展示平台</a> &gt;
		<a href="/marketing/product_experience">產品體驗</a>
	</div>
	<div class="content grid-intro">
		<ul class="grid4 wrap no-shrink">
			@foreach($rd as $rs)
			<li>
				<div class="img">
					<!-- <iframe width="100%" height="200" src="https://www.youtube.com/embed/{{$rs->link}}" frameborder="0" allowfullscreen></iframe> -->
					<a href="/marketing/product_experience/{{$rs->id}}"><img src="{{\App\Cm::get_pic($rs->id)}}"></a>
				</div>
				<div class="text">
					<h3><a href="/marketing/product_experience/{{$rs->id}}">{{$rs->name}}</a></h3>
					<div class="link">
						<a href="/marketing/product_experience/{{$rs->id}}">產品體驗</a>
					</div>
				</div>
			</li>
			@endforeach
		</ul>
		<div class="pager">
			{{$rd->appends(['id' => request('id') ])->links()}}
		</div>
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
		var tabLen = $('.submenu-slide .swiper-slide').length;
		if(tabLen<11){
			$('.slide-nav').hide();
		}
	})
</script>
@endsection