<?php
$bodyid = "page-event";
$data = [] ; 
$wh = ['position'=>'booking','mstatus'=>'Y'] ;
for($y=date('Y');$y<=date('Y')+1;++$y){
	for($m=1;$m<=12;++$m){
		$stamps = mktime(0,0,0,$m,1,$y);
    	$dayCount = date("t", $stamps)+1;
		for($d=1;$d<$dayCount;++$d){
			$date = $y.'-'.str_pad($m,2,"0",STR_PAD_LEFT).'-'.str_pad($d,2,"0",STR_PAD_LEFT) ; 
			if(strtotime(date('Y-m-d'))<=strtotime($date)){//代表今日（含）以後的日期
				$am = \App\Cm::where($wh)->where('obj','上午')->whereDate('edate',$date)->first();
				$pm = \App\Cm::where($wh)->where('obj','下午')->whereDate('edate',$date)->first();
				if($am){
					if($am->up_sn!=0&&$am->up_sn==session('mid')) $data[] = ['title'=>'上午：您已預約'.$am->type,'start'=>$date,'color'=>'#00adb9','url'=>'/marketing/booking_form?id='.$am->id.'&date='.$date];
					else $data[] = ['title'=>'上午：已被預約','start'=>$date,'color'=>'#00adb9'];
				}else{
					if(strtotime(date('Y-m-d'))==strtotime($date)){
						if(strtotime(date('H:i:s'))<strtotime("12:00:00")){
							$data[] = ['title'=>'上午：可預約', 'start'=>$date, 'url'=>'/marketing/booking_form?date='.$date.'&day=am'];
						}
					}else{
						$data[] = ['title'=>'上午：可預約', 'start'=>$date, 'url'=>'/marketing/booking_form?date='.$date.'&day=am'];
					}
					
				}
				if($pm){
					if($pm->up_sn!=0&&$pm->up_sn==session('mid')) $data[] = ['title'=>'下午：您已預約'.$pm->type,'start'=>$date,'color'=>'#00adb9','url'=>'/marketing/booking_form?id='.$pm->id.'&date='.$date];
					else $data[] = ['title'=>'下午：已被預約','start'=>$date,'color'=>'#00adb9'];
				}else{
					$data[] = ['title'=>'下午：可預約', 'start'=>$date, 'url'=>'/marketing/booking_form?date='.$date.'&day=pm'];
				}
			}
		}
	} 
}

$data[] = ['title'=>'上午：不可預約',    //顯示標題
		   'start'=>'2010-01-01',//時間
		   'color'=>'#00adb9'    //已預約顏色
			];

$jdata = json_encode($data,JSON_UNESCAPED_UNICODE);
?>
@extends('main')
@section('content')
<section class="exhibit bg-gray">
	<div class="ttl-bar">
		<h2>預約使用</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="javascript:;">行銷專區</a> &gt;
		<a href="javascript:;">展示平台</a> &gt;
		<a href="javascript:;">醫材展示室</a> &gt;
		<a href="/marketing/booking">預約使用</a>
	</div>
	<div class="content grid-intro">
		<div id="calendar"></div>
	</div>
</section>
@endsection
@section('javascript')
<script>
$(function(){
	$('#calendar').fullCalendar({
		schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
		events : <?php echo $jdata;?>,
	});
})
</script>
@endsection