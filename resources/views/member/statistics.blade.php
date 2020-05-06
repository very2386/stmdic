<?php
$bodyid = "page-statistics";
$page = "statistics";
if($id&&$id!=date('Y')){
	$year = $id ; 
	$month = 12 ; 
}else{
	$year = date('Y') ;
	$month = date('m') ; 
}
$comp = \App\Cm::where('position','company')->where('up_sn',session('mid'))->first();	
?>
@extends('main')
@section('content')
<section class="statistics">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a class="name" href="/member/statistics">訪客分析</a>
	</div>
	<div class="content grid-intro">
		<h3 class="ttl-basic mb20 bold">日統計</h3>
		<select class="year-select" name="" id="">
		@for($i=2017;$i<=date('Y');++$i)
			<option value="{{$i}}" {{$id==$i?'selected':''}}>{{$i}}</option>
		@endfor
		</select>
		<p class="lts-l mb10 sts-year">{{$year}}年
			<a class="sts-day-left" href="javascript:;">&lt;</a>
			<span class="month">{{$month}}</span>月
			<a class="sts-day-right" href="javascript:;">&gt;</a>
		</p>
		<div class="swiper-container month-swiper mb2e" data-mode="fade" data-pause="false" data-speed="3000" data-autoplay="false" data-left="sts-day-left" data-right="sts-day-right">
		    <ul class="swiper-wrapper">
    		@for($i=1;$i<=$month;++$i)
				<?php
				$month_days  = cal_days_in_month(CAL_GREGORIAN, $i , $year );
				?>
		    	<li class="swiper-slide">
		    		<table>
		    			<tr>
		    				<th><span class="a">項目</span><span class="b">日統計</span></th>
		    				@for($y=1;$y<=$month_days;++$y)
		    				<th>{{$i}}/{{$y}}</th>
		    				@endfor
		    			</tr>
		    			<tr>
		    				<th>廠商頁面</th>
		    				@for($y=1;$y<=$month_days;++$y)
		    				<?php
		    				$data = \App\Statistics::where('position','company')->where('compid',$comp->id)->wheredate('updated_at',date('Y-'.$i.'-'.$y))->first();
		    				?>
		    				<td>{{$data?$data->hits:''}}</td>
		    				@endfor
		    			</tr>
		    			<tr>
		    				<th>產品頁面</th>
		    				@for($y=1;$y<=$month_days;++$y)
		    				<?php
		    				$data = \App\Statistics::where('position','product')->where('compid',$comp->id)->wheredate('updated_at',date('Y-'.$i.'-'.$y))->first();
		    				?>
		    				<td>{{$data?$data->hits:''}}</td>
		    				@endfor
		    			</tr>
		    			<tr>
		    				<th>徵才頁面</th>
		    				@for($y=1;$y<=$month_days;++$y)
		    				<?php
		    				$data = \App\Statistics::where('position','job')->where('compid',$comp->id)->wheredate('updated_at',date('Y-'.$i.'-'.$y))->first();
		    				?>
		    				<td>{{$data?$data->hits:''}}</td>
		    				@endfor
		    			</tr>
		    			<tr>
		    				<th>徵才人數</th>
		    				@for($y=1;$y<=$month_days;++$y)
		    				<?php
		    				$data = \App\Statistics::where('position','get_job')->where('compid',$comp->id)->wheredate('updated_at',date('Y-'.$i.'-'.$y))->first();
		    				?>
		    				<td>{{$data?$data->hits:''}}</td>
		    				@endfor
		    			</tr>
		    		</table>
		    	</li>
		    	@endfor
		    </ul>
		    <div class="swiper-pagination"></div>
		</div>

		<h3 class="ttl-basic mb20 bold">月統計</h3>
		<p class="lts-l mb10 sts-month">
			<a class="sts-month-left" href="javascript:;">&lt;</a>
			<span class="year">{{$year}}</span>年
			<a class="sts-month-right" href="javascript:;">&gt;</a>		
		</p>
		<div class="swiper-container year-swiper" data-mode="fade" data-pause="false" data-speed="3000" data-autoplay="false" data-left="sts-month-left" data-right="sts-month-right">
		    <ul class="swiper-wrapper">
		    	@for($i=2017;$i<=date('Y');++$i)
		    	<li class="swiper-slide">
		    		<table>
		    			<tr>
		    				<th><span class="a">項目</span><span class="b">月統計</span></th>
		    				@for($y=1;$y<=12;++$y)
		    				<th>{{$y}}月</th>
		    				@endfor
		    			</tr>
		    			<tr>
		    				<th>廠商頁面</th>
		    				@for($y=1;$y<=12;++$y)
		    				<?php
		    				$data = \App\Statistics::where('position','company')->where('compid',$comp->id)->whereYear('updated_at',$i)->whereMonth('updated_at',$y)->get();
		    				$cont = 0 ; 
		    				foreach ($data as $rs) {
		    					$cont += $rs->hits ; 
		    				}
		    				?>
		    				<td>{{$cont!=0?$cont:''}}</td>
		    				@endfor
		    			</tr>
		    			<tr>
		    				<th>產品頁面</th>
		    				@for($y=1;$y<=12;++$y)
		    				<?php
		    				$data = \App\Statistics::where('position','product')->where('compid',$comp->id)->whereYear('updated_at',$i)->whereMonth('updated_at',$y)->get();
		    				$cont = 0 ; 
		    				foreach ($data as $rs) {
		    					$cont += $rs->hits ; 
		    				}
		    				?>
		    				<td>{{$cont!=0?$cont:''}}</td>
		    				@endfor
		    			</tr>
		    			<tr>
		    				<th>徵才頁面</th>
		    				@for($y=1;$y<=12;++$y)
		    				<?php
		    				$data = \App\Statistics::where('position','job')->where('compid',$comp->id)->whereYear('updated_at',$i)->whereMonth('updated_at',$y)->get();
		    				$cont = 0 ; 
		    				foreach ($data as $rs) {
		    					$cont += $rs->hits ; 
		    				}
		    				?>
		    				<td>{{$cont!=0?$cont:''}}</td>
		    				@endfor
		    			</tr>
		    			<tr>
		    				<th>徵才人數</th>
		    				@for($y=1;$y<=12;++$y)
		    				<?php
		    				$data = \App\Statistics::where('position','get_job')->where('compid',$comp->id)->whereYear('updated_at',$i)->whereMonth('updated_at',$y)->get();
		    				$cont = 0 ; 
		    				foreach ($data as $rs) {
		    					$cont += $rs->hits ; 
		    				}
		    				?>
		    				<td>{{$cont!=0?$cont:''}}</td>
		    				@endfor
		    			</tr>
		    		</table>
		    	</li>
		    	@endfor
		    	
		    </ul>
		    <div class="swiper-pagination"></div>
		</div>
	</div>
</section>
@endsection
@section('javascript')
<script>
$(function(){
	var mLen = $('.month-swiper .swiper-slide').length;
	var yLen = $('.year-swiper .swiper-slide').length;
	var $month = $('.sts-year .month');
	var $year = $('.sts-month .year');
	var mText = parseInt($month.text());
	var yText = parseInt($year.text());
	var mMax = mText;
	var yMin = yText - yLen + 1;
	var yMax = yText;
	console.log(mText)
	$('.sts-day-left').click(function(){
		if(mText > 1)
		mText--;
		$month.html(mText);
	})
	$('.sts-day-right').click(function(){
		if(mText < mMax)
		mText++;
		$month.html(mText);
	})
	$('.sts-month-left').click(function(){
		if(yText > yMin)
		yText--;
		$year.html(yText);
	})
	$('.sts-month-right').click(function(){
		console.log(yLen)
		if(yText < yMax)
		yText++;
		$year.html(yText);
	})
	$('.swiper-pagination-bullet:last-child').click();
	$('.year-select').on('change',function(){
		var year = $(this).val();
		load_page('/member/statistics/'+year)
	})
})
</script>
@endsection