<?php
$wh = ['position'=>'event', 'mstatus'=>'Y'];
$type = isset($id) ? $id : '全部活動' ;
if($type != '全部活動') $wh['type']=$type;
if(request('q')) $wh[] = ['name', 'like', '%'.trim(request('q')).'%'];
$rs = \App\Cm::where($wh)->paginate(env('NEWS_PERPAGE'));
if(!$rs){
	session()->flash('sysmsg', '找不到活動資料');
	echo '<script>location.href="/"</script>';
	exit;
}
$choose_type = \App\Cm::get_event_type();
$bodyid = "page-statistics";
$data = [];
foreach($rs as $rd){
	$data[] = ['title'=>$rd->name, 'start'=>$rd->sdate];
}
$jdata = json_encode($data,JSON_UNESCAPED_UNICODE);
?>
@extends('main')
@section('content')
<section class="statistics">
	<div class="ttl-bar">
		<h2>日統計</h2>
		<ul class="tab">
			@foreach($choose_type as $t)
			<li class="{{$t==$type?'active':''}}"><a href="/event/{{$t}}">{{$t}}</a></li>
			@endforeach
		</ul>
		@include('searchevent')
		<ul class="btns">
			<li><a class="btn" href="/calendar"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;行事曆</a></li>
		</ul>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/event">展覽活動</a> &gt; <a class='name' href="/calendar">行事曆</a>
	</div>
	<div class="content grid-intro">
		<h3 class="ttl-basic mb20 bold">日統計</h3>
		<select class="year-select" name="" id="">
			<option value="2018">2018</option>
			<option value="2017">2017</option>
		</select>
		<p class="lts-l mb10 sts-year">2017年
			<a class="sts-day-left" href="javascript:;">&lt;</a>
			<span class="month">3</span>月
			<a class="sts-day-right" href="javascript:;">&gt;</a>
		</p>
		<div class="swiper-container month-swiper mb2e" data-mode="fade" data-pause="false" data-speed="3000" data-autoplay="false" data-left="sts-day-left" data-right="sts-day-right">
		    <ul class="swiper-wrapper">
		    	<li class="swiper-slide">
		    		<table>
		    			<tr>
		    				<th><span class="a">項目</span><span class="b">日統計</span></th>
		    				<th>1/1</th>
		    				<th>1/2</th>
		    				<th>1/3</th>
		    				<th>1/4</th>
		    				<th>1/5</th>
		    				<th>1/6</th>
		    				<th>1/7</th>
		    				<th>1/8</th>
		    				<th>1/9</th>
		    				<th>1/10</th>
		    				<th>1/11</th>
		    				<th>1/12</th>
		    				<th>1/13</th>
		    				<th>1/14</th>
		    				<th>1/16</th>
		    				<th>1/17</th>
		    				<th>1/18</th>
		    				<th>1/19</th>
		    				<th>1/20</th>
		    				<th>1/21</th>
		    				<th>1/22</th>
		    				<th>1/23</th>
		    				<th>1/24</th>
		    				<th>1/25</th>
		    				<th>1/26</th>
		    				<th>1/27</th>
		    				<th>1/28</th>
		    				<th>1/29</th>
		    				<th>1/30</th>
		    				<th>1/31</th>
		    			</tr>
		    			<tr>
		    				<th>廠商頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>資料</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才次數</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    		</table>
		    	</li>
		    	<li class="swiper-slide">
		    		<table>
		    			<tr>
		    				<th><span class="a">項目</span><span class="b">日統計</span></th>
		    				<th>1/1</th>
		    				<th>1/2</th>
		    				<th>1/3</th>
		    				<th>1/4</th>
		    				<th>1/5</th>
		    				<th>1/6</th>
		    				<th>1/7</th>
		    				<th>1/8</th>
		    				<th>1/9</th>
		    				<th>1/10</th>
		    				<th>1/11</th>
		    				<th>1/12</th>
		    				<th>1/13</th>
		    				<th>1/14</th>
		    				<th>1/16</th>
		    				<th>1/17</th>
		    				<th>1/18</th>
		    				<th>1/19</th>
		    				<th>1/20</th>
		    				<th>1/21</th>
		    				<th>1/22</th>
		    				<th>1/23</th>
		    				<th>1/24</th>
		    				<th>1/25</th>
		    				<th>1/26</th>
		    				<th>1/27</th>
		    				<th>1/28</th>
		    				<th>1/29</th>
		    				<th>1/30</th>
		    				<th>1/31</th>
		    			</tr>
		    			<tr>
		    				<th>廠商頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>資料</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才次數</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    		</table>
		    	</li>
		    	<li class="swiper-slide">
		    		<table>
		    			<tr>
		    				<th><span class="a">項目</span><span class="b">日統計</span></th>
		    				<th>1/1</th>
		    				<th>1/2</th>
		    				<th>1/3</th>
		    				<th>1/4</th>
		    				<th>1/5</th>
		    				<th>1/6</th>
		    				<th>1/7</th>
		    				<th>1/8</th>
		    				<th>1/9</th>
		    				<th>1/10</th>
		    				<th>1/11</th>
		    				<th>1/12</th>
		    				<th>1/13</th>
		    				<th>1/14</th>
		    				<th>1/16</th>
		    				<th>1/17</th>
		    				<th>1/18</th>
		    				<th>1/19</th>
		    				<th>1/20</th>
		    				<th>1/21</th>
		    				<th>1/22</th>
		    				<th>1/23</th>
		    				<th>1/24</th>
		    				<th>1/25</th>
		    				<th>1/26</th>
		    				<th>1/27</th>
		    				<th>1/28</th>
		    				<th>1/29</th>
		    				<th>1/30</th>
		    				<th>1/31</th>
		    			</tr>
		    			<tr>
		    				<th>廠商頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>資料</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才次數</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    		</table>
		    	</li>
		    </ul>
		    <div class="swiper-pagination"></div>
		</div>

		<h3 class="ttl-basic mb20 bold">月統計</h3>
		<p class="lts-l mb10 sts-month">
			<a class="sts-month-left" href="javascript:;">&lt;</a>
			<span class="year">2017</span>年
			<a class="sts-month-right" href="javascript:;">&gt;</a>
			
		</p>
		<div class="swiper-container year-swiper" data-mode="fade" data-pause="false" data-speed="3000" data-autoplay="false" data-left="sts-month-left" data-right="sts-month-right">
		    <ul class="swiper-wrapper">
		    	<li class="swiper-slide">
		    		<table>
		    			<tr>
		    				<th><span class="a">項目</span><span class="b">月統計</span></th>
		    				<th>1月</th>
		    				<th>2月</th>
		    				<th>3月</th>
		    				<th>4月</th>
		    				<th>5月</th>
		    				<th>6月</th>
		    				<th>7月</th>
		    				<th>8月</th>
		    				<th>9月</th>
		    				<th>10月</th>
		    				<th>11月</th>
		    				<th>12月</th>
		    			</tr>
		    			<tr>
		    				<th>廠商頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>資料</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才次數</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    		</table>
		    	</li>
		    	<li class="swiper-slide">
		    		<table>
		    			<tr>
		    				<th><span class="a">項目</span><span class="b">月統計</span></th>
		    				<th>1月</th>
		    				<th>2月</th>
		    				<th>3月</th>
		    				<th>4月</th>
		    				<th>5月</th>
		    				<th>6月</th>
		    				<th>7月</th>
		    				<th>8月</th>
		    				<th>9月</th>
		    				<th>10月</th>
		    				<th>11月</th>
		    				<th>12月</th>
		    			</tr>
		    			<tr>
		    				<th>廠商頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>資料</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才次數</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    		</table>
		    	</li>
		    	<li class="swiper-slide">
		    		<table>
		    			<tr>
		    				<th><span class="a">項目</span><span class="b">月統計</span></th>
		    				<th>1月</th>
		    				<th>2月</th>
		    				<th>3月</th>
		    				<th>4月</th>
		    				<th>5月</th>
		    				<th>6月</th>
		    				<th>7月</th>
		    				<th>8月</th>
		    				<th>9月</th>
		    				<th>10月</th>
		    				<th>11月</th>
		    				<th>12月</th>
		    			</tr>
		    			<tr>
		    				<th>廠商頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>資料</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才頁面</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<th>徵才次數</th>
		    				<td>22</td>
		    				<td>22</td>
		    				<td>22</td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    		</table>
		    	</li>
		    	
		    	
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
})
</script>
@endsection