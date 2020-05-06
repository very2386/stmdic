<?php
$bodyid = "page-market";
\App\Cm::where('id',$id)->increment('hits');
$rd = \App\Cm::where('id',$id)->first();
$comp_data = \App\Cm::where('id',$rd->up_sn)->first() ; 
$comp_name = $comp_data->name ; 
$comp_tel = $comp_data->tel ; 
$comp_email = $comp_data->email ; 
if(!$rd){
	session()->flash('sysmsg', '找不到產品資料');
	echo '<script>location.href="/"</script>';
	exit;
}
//點擊率
$hits = \App\Statistics::where('compid',$rd->up_sn)->where('position','product')->whereDate('updated_at',date('Y-m-d'))->first();
if($hits){//表示今日已經點擊過
	\App\Statistics::where('id',$hits->id)->increment('hits');
}else{
	\App\Statistics::create(['compid'=>$rd->up_sn,'position'=>'product','hits'=>1]);
}
?>
@extends('main')
@section('content')
<section class="video bg-gray mb20">
	<div class="ttl-bar">
		<h2>聚落產品 - {{$rd->name}}</h2>
	</div>
	<div class="breadcrumb">
		<a href="/market">首頁</a> &gt; 
		<a href="javascript:;">聚落產品</a> &gt; 
		@if(isset($type))<a href="/marketing/marketing/{{$type}}">{{$type}}</a> &gt; 
		<a href="/marketing/marketing/{{$type}}/{{$rd->id}}">{{$rd->name}}</a>
		@else
		<a href="/marketing/marketing/prod/{{$rd->id}}">{{$rd->name}}</a>
		@endif
	</div>
	<div class="content video grid-intro">
		<div class="frame">
			<div class="" style="width:100%">
				@if($rd->link)
				<iframe width="100%" height="480" src="https://www.youtube.com/embed/{{$rd->link}}" frameborder="0" allowfullscreen></iframe>
				@else
				<img src="{{\App\Cm::get_pic($rd->id)}}">
				@endif
			</div>
		</div>
	</div>
</section>
<div class="marketing-info mb20">
	<div class="flex market-content">
		<div class="text">
			<h4 class="fz-l">{{$rd->name}}</h4>
			<p>{!! $rd->cont !!}</p>
		</div>
	</div>
	<div class="comp">
		@if($comp_name)<p>{{$comp_name}}</p>@endif
		@if($comp_tel)<p>服務電話: {{$comp_tel}}</p>@endif
		@if($comp_email)<p>E-mail: {{$comp_email}}</p>@endif
	</div>
</div>
@endsection
@section('javascript')
@endsection