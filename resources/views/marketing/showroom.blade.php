<?php
$wh = ['position'=>'event', 'mstatus'=>'Y'];
$wh['type'] = $type;
if(request('q')) $wh[] = ['name', 'like', '%'.trim(request('q')).'%'];
$query = \App\Cm::where($wh);	
if(request('status')){
	switch (request('status')) {
		case 'full':
			$query = $query->where('online_status','Y') ;
			break;
		case 'ongoing'://報名中
			$query = $query->where('signup_sdate','<',date('Y-m-d H:i:s'))->where('signup_edate','>',date('Y-m-d H:i:s')) ;
			break;
		case 'unavailable'://未開始
			$query = $query->where('signup_sdate','>',date('Y-m-d H:i:s')) ;
			break;
		case 'end'://已結束
			$query = $query->where('signup_edate','<',date('Y-m-d H:i:s')) ;
			break;
	}
}
if(request('sort')&&request('sort')=='hot') $query = $query->orderby('hits','desc');
else $query = $query->orderby('id','desc');
$rd = $query->paginate(20);
if(!$rd){
	session()->flash('sysmsg', '找不到活動資料');
	echo '<script>location.href="/"</script>';
	exit;
}
$bodyid = "page-market";
$sort_class = "sort";
$sort_array = ['new'=>'最新','hot'=>'熱門'];
$cur_sort = '請選擇';
if(request('sort') == 'new' || request('sort') == 'hot' ) $cur_sort = $sort_array[request('sort')];
?>
@extends('main')
@section('content')
<section class="exhibit bg-gray">
	<div class="ttl-bar">
		<h2>展示室活動</h2>
		<form id="searchform" action="/marketing/showroom/展示室活動" method="get">
			<div class="searchbar">
				<input type="text" name="q" value="{{request('q')}}" placeholder="活動搜尋">
				<button type="submit" class="btn-search">Search</button>
			</div>
		</form>
		<!-- <ul class="btns">
			<li><a class="btn" href="/calendar"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;行事曆</a></li>
		</ul> -->
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="">行銷專區</a> &gt; 
		<a href="">展示平台</a> &gt; 
		<a href="">醫材展示室</a> &gt; 
		<a href="/marketing/showroom/展示室活動">展示室活動</a>
		@include('sort')
	</div>
	<div class="content grid-intro">
		<ul class="icon-intro">
			<li class="ongoing">
				<span class="icon">
					<a href="/marketing/showroom/展示室活動?status=ongoing">
						<img src="/img/icon/act-ongoing.png" alt="">報名中
					</a>
				</span>
			</li>
			<li class="unavailable">
				<span class="icon">
					<a href="/marketing/showroom/展示室活動?status=unavailable">
						<img src="/img/icon/act-unavailable.png" alt="">尚未開放
					</a>
				</span>
			</li>
			<li class="full">
				<span class="icon">
					<a href="/marketing/showroom/展示室活動?status=full">
						<img src="/img/icon/act-full.png" alt="">已額滿
					</a>
				</span>
			</li>
			<li class="end">
				<span class="icon">
					<a href="/marketing/showroom/展示室活動?status=end">
						<img src="/img/icon/act-end.png" alt="">已結束
					</a>
				</span>
			</li>
		</ul>
		<ul class="grid4 wrap no-shrink">
			@foreach($rd as $k => $v)
				<?php
				$now = strtotime(date('Y-m-d H:i:s')) ; 
				$ftime = strtotime($v->signup_sdate) ;
				$etime = strtotime($v->signup_edate) ;
				?>
				<li>
					<div class="img">
						<a href="/marketing/showroom/展示室活動/{{$v->id}}"><img src="{{\App\Cm::get_pic($v->id)}}" alt=""></a>
					</div>
					<div class="text">
						<h3><a href="/marketing/showroom/展示室活動/{{$v->id}}">[ {{$v->name}} ]</a></h3>
		                <ul class="date">
			                <li class="evt-time">
			                    <h4>活動時間</h4>
			                    <p>
			                        <span>{{substr($v->event_sdate,0,10)}}</span>
			                        @if($v->event_edate && $v->event_edate != $v->event_sdate )
			                        <span>至 {{substr($v->event_edate,0,10)}}</span>
			                        @endif
			                    </p>
			                </li>
			                <li class="reg-time">
			                    <h4>報名時間</h4>
			                    <p>
			                      	<span>{{substr($v->signup_sdate,0,10)}}</span>
			                      	@if($v->signup_edate && $v->signup_edate != $v->signup_sdate)
			                      	<span>至 {{substr($v->signup_edate,0,10)}}</span>
			                      	@endif
			                    </p>
			                </li>
		                </ul>
						<div class="link">
							<a href="/marketing/showroom/展示室活動/{{$v->id}}">活動詳情</a>
						</div>
					</div>

					<div class="icon-intro">
						@if($v->online_status=='Y')
							<!-- 已額滿 -->
							<div class="icon"><a><img src="/img/icon/act-full.png" alt=""></a></div>
						@else
							@if($now < $ftime) 
								<!-- 尚未開始 -->
								<div class="icon"><a href="/marketing/showroom/展示室活動/{{$v->id}}"><img src="/img/icon/act-unavailable.png" alt=""></a></div>
							@elseif($now>$ftime && $now<$etime)
								<!-- 報名中 -->
								<div class="icon"><a href="http://{{$v->link}}" target="_blank"><img src="/img/icon/act-ongoing.png" alt=""></a></div>
							@else
								<!-- 已結束 -->
								<div class="icon"><a><img src="/img/icon/act-end.png" alt=""></a></div>
							@endif
						@endif
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
		location.href = $('#current_url').val() +'?sort=' +sortby ;
	});
})
</script>
@endsection