<?php
$jrs = \App\EventJoin::where('mid', session('mid'))->get();
$data = [];
foreach($jrs as $jrd){
	$ard = \App\Cm::where('id', $jrd->eventid)->first();
	$data[] = ['title'=>$ard->name, 'start'=>$ard->sdate];
}
$jdata = json_encode($data,JSON_UNESCAPED_UNICODE);
?>
@extends('main')
@section('content')
<section class="member">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a class="name" href="">活動行事曆</a>
	</div>
	<div class="content grid-intro form">
		<div class="">
			<div id="calendar"></div>
		</div>
	</div>
</section>
@endsection
@section('javascript')
<script>
$(function(){
	$('#calendar').fullCalendar({
		schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
		events : <?php echo $jdata;?>
	});
})
</script>
@endsection
