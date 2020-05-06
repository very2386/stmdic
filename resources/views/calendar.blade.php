<?php
$wh = ['position'=>'event', 'mstatus'=>'Y'];
$type = isset($id) ? $id : '全部活動' ;
if($type != '全部活動') $wh['type']=$type;
if(request('q')) $wh[] = ['name', 'like', '%'.trim(request('q')).'%'];
$rs = \App\Cm::where($wh)->orderBy('event_sdate','ASC')->get();
if(!$rs){
	session()->flash('sysmsg', '找不到活動資料');
	echo '<script>location.href="/"</script>';
	exit;
}
$choose_type = \App\Cm::get_event_type();
$bodyid = "page-event";
$data = [];
foreach($rs as $rd){
	$start = substr($rd->event_sdate,0,10) ; 
	$end = substr($rd->event_edate,0,10) ; 
	if( trim($start) == trim($end) || $rd->event_edate == '' ) $data[] = ['title'=>$rd->name, 'start'=> $start ,'url'=>'/event/'.$rd->id];
	else{
		$date1 = strtotime($start);
    	$date2 = strtotime($end);
    	$days = ceil(abs($date1 - $date2)/86400)+1;
    	$end_day = date('Y-m-d',strtotime("$start +".$days." day"));
		// for( $i = 0 ; $i <= $days ; $i++){
		// 	$day = date('Y-m-d',strtotime("$start +".$i." day"));
		// 	$data[] = ['title'=>$rd->name, 'start'=>$day,'backgroundColor'=>'#00a65a'] ;
		// }
		$title = $rd->name . ' ' . $start . '~' . $end  ;
		$data[] = ['title'=>$title, 'start'=>$start,'end'=>$end_day,'backgroundColor'=>'#00a65a','url'=>'/event/'.$rd->id] ;	
	} 
}
$jdata = json_encode($data,JSON_UNESCAPED_UNICODE);
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
		<a href="/">首頁</a> &gt; <a href="/event">展覽活動</a> &gt; <a class='name' href="/calendar">行事曆</a>
	</div>
	<div class="content grid-intro">
		<!-- <ul class="icon-intro">
			<li class="ongoing"><span class="icon"><img src="/img/icon/act-ongoing.png" alt=""></span>報名中</li>
			<li class="unavailable"><span class="icon"><img src="/img/icon/act-unavailable.png" alt=""></span>尚未開放</li>
			<li class="full"><span class="icon"><img src="/img/icon/act-full.png" alt=""></span>已額滿</li>
			<li class="end"><span class="icon"><img src="/img/icon/act-end.png" alt=""></span>已結束</li>
		</ul> -->
		<div id="calendar"></div>
	</div>
</section>
@endsection
@section('javascript')
<script>
$(function(){
	$('#calendar').fullCalendar({
		schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
		events : <?php echo $jdata; ?>
	});
})
</script>
@endsection