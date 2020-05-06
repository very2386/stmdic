<?php
\App\Prospects::where('id',$id)->increment('hits');
$rd = \App\Prospects::where('id',$id)->first();
$imgs = \App\OtherFiles::where('cm_id',$rd->id)->orderBy('fname','ASC')->get();
$bodyid = "page-market";
// $bodyclass = "page-market";
?>
@extends('main')
@section('content')

<section class="hot">
	<div class="ttl-bar">
		<h2>{{$rd->position=='prospect'?'目前展會':'未來展會'}}</h2>
	</div>
	<div class="breadcrumb">
		<a href="/market">首頁</a> &gt; 
		<a href="javascript:;">展會相關</a> &gt;
		<a href="/marketing/prospect/{{$rd->position}}">{{$rd->position=='prospect'?'目前展會':'未來展會'}}</a> &gt; 
		<a href="/marketing/prospect/prospect/{{$rd->id}}">{{$rd->name}}</a> 
	</div>
	<div class="grid2 prospect content clearfix">
		<div class="intro market-content">
			<h3 class="fz-l bold mb10">{{$rd->name}}</h3>
			<p>{!!$rd->cont!!}</p>
		</div>
		@if(count($imgs)>0)
		<div class="imgs">
			<div class="large-view">
				<?php
		    	$one_img = \App\OtherFiles::where('cm_id',$rd->id)->orderBy('fname','ASC')->first();
		    	?>
				<img src="{{$one_img->fname}}" alt="{{$one_img->name}}">
			</div>
			<div id="prospect-swiper" class="swiper-container prospect-swiper" data-col="3" data-space="10">
			    <div class="swiper-wrapper">
			    	@foreach($imgs as $img)
			        <div class="swiper-slide"><img src="{{$img->fname}}" alt="{{$img->name}}"></div>
			        @endforeach
			    </div>
			    <!-- Add Pagination -->
			    <div class="next">
			    	<div class="swiper-button-next"></div>
			    </div>
			    <div class="prev">
			    	<div class="swiper-button-prev"></div>
			    </div>
			</div>
		</div>
		@endif
	</div>
</section>
@endsection
@section('javascript')
<script>
	$(function(){
		$('.prospect-swiper .swiper-slide').each(function(){
			var $this = $(this);
			var index = $this.index();
			var $img = $this.find('img').prop('outerHTML');
			var $parent = $this.parents('.prospect-swiper');
			$parent.find('.swiper-pagination-bullet').eq(index).html($img)
		});
		$('.prospect-swiper img').on('load',function(){
			$('.prospect-swiper .swiper-slide').each(function(){
				var $this = $(this);
				var index = $this.index();
				var $img = $this.find('img').prop('outerHTML');
				var $parent = $this.parents('.prospect-swiper');
				$parent.find('.swiper-pagination-bullet').eq(index).html($img)
			});
		})
		$('.swiper-slide').click(function(){
			$('.large-view img').attr('src', $(this).find('img').attr('src'))
		})
	})
</script>
@endsection