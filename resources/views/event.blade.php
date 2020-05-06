<?php
\App\Cm::where('signup_edate','<',date('Y-m-d H:i:s'))->update(['end_status'=>'Y']); //先判斷是否已結束，已end_status記錄活動是否結束
$wh = ['position'=>'event', 'mstatus'=>'Y'];
$type = isset($id) ? $id : '' ;
if($type != '') $wh['type'] = $type;
if(request('q')) $wh[] = ['name', 'like', '%'.trim(request('q')).'%'];
$query = \App\Cm::where($wh);	
if(request('status')){ //當有點取狀態時
	switch (request('status')) {
		case 'full':
			$query = $query->where('online_status','Y') ;
			break;
		case 'ongoing'://報名中
			$query = $query->where('signup_edate','>=',date('Y-m-d H:i:s'))->where('signup_sdate','<=',date('Y-m-d H:i:s'));
			break;
		case 'unavailable'://未開始
			$query = $query->where('signup_sdate','>',date('Y-m-d H:i:s')) ;
			break;
		case 'end'://已結束
			$query = $query->where('signup_edate','<',date('Y-m-d H:i:s'));
			break;
	}
}
//有選擇排序的時候
if(request('sort')&&request('sort')=='hot') $query->orderby('hits','desc');
elseif(request('sort')&&request('sort')=='new') $query->orderby('id','desc');
$rd = $query->orderBy('end_status','ASC')->orderby('signup_sdate','ASC')->paginate(20);
if(!$rd){
	session()->flash('sysmsg', '找不到活動資料');
	echo '<script>location.href="/"</script>';
	exit;
}

$choose_type = \App\Cm::get_event_type();
$bodyid = "page-event";
$sort_class = "sort";
$sort_array = ['new'=>'最新','hot'=>'熱門'];
$cur_sort = '請選擇';
if(request('sort') == 'new' || request('sort') == 'hot' ) $cur_sort = $sort_array[request('sort')];
?>
@extends('main')
@section('content')
<section class="exhibit bg-gray">
	<div class="ttl-bar">
		<h2>近期活動</h2>
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
		<a href="/">首頁</a> &gt; 
		<a href="/event">近期活動</a>  
		{{$type?'&gt;':''}}<a class='name' href="/event/{{$type}}">{{$type}}</a>
		@include('sort')
	</div>
	<div class="content grid-intro">
		<ul class="icon-intro">
			<li class="ongoing">
				<span class="icon">
					<a href="/event?status=ongoing">
						<img src="/img/icon/act-ongoing.png" alt="">報名中
					</a>
				</span>
			</li>
			<li class="unavailable">
				<span class="icon">
					<a href="/event?status=unavailable">
						<img src="/img/icon/act-unavailable.png" alt="">尚未開放
					</a>
				</span>
			</li>
			<li class="full">
				<span class="icon">
					<a href="/event?status=full">
						<img src="/img/icon/act-full.png" alt="">已額滿
					</a>
				</span>
			</li>
			<li class="end">
				<span class="icon">
					<a href="/event?status=end">
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
						<a href="/event/{{$v->id}}"><img src="{{\App\Cm::get_pic($v->id)}}" alt=""></a>
					</div>
					<div class="text">
						<h3><a href="/event/{{$v->id}}">[ {{$v->name}} ]</a></h3>
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
							<a href="/event/{{$v->id}}">活動詳情</a>
						</div>
					</div>
					<div class="icon-intro">
						@if($v->online_status=='Y')
							<!-- 已額滿 -->
							<div class="icon"><a><img src="/img/icon/act-full.png" alt=""></a></div>
						@else
							@if($now < $ftime) 
								<!-- 尚未開始 -->
								<div class="icon"><a href="/event/{{$v->id}}"><img src="/img/icon/act-unavailable.png" alt=""></a></div>
							@elseif($now>=$ftime && $now<=$etime)
								<!-- 報名中 -->
								<div class="icon"><a href="/event/{{$v->id}}"><img src="/img/icon/act-ongoing.png" alt=""></a></div>
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
		location.href=$('#current_url').val() +'?sort=' +sortby ;
	});
})
</script>
@endsection