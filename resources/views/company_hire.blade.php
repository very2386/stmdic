<?php
$jobs = \App\Cm::where('id',$id)->first();
$comp = \App\Cm::where('id',$jobs->up_sn)->first();
$conts = json_decode($jobs->cont) ;
//點擊率
\App\Cm::where('id',$id)->increment('hits');
$hits = \App\Statistics::where('compid',$comp->id)->where('position','job')->whereDate('updated_at',date('Y-m-d'))->first();
if($hits){//表示今日已經點擊過
	\App\Statistics::where('id',$hits->id)->increment('hits');
}else{
	\App\Statistics::create(['compid'=>$comp->id,'position'=>'job','hits'=>1]);
}
?>
@extends('main')
@section('content')
<section class="hire">
	<div class="ttl-bar">
		<h2>廠商徵才專區</h2>
		<div class="searchbar">
			<input type="search" placeholder="職缺搜尋">
			<button class="btn-search">Search</button>
		</div>
	</div>
	<div class="breadcrumb">
		<a href="/company/{{$comp->id}}">[{{$comp->name}}] 廠商徵才專區</a> &gt; <a href="/company_hire/{{$jobs->id}}">{{$conts->job_title}}</a>
	</div>
	<div class="content two-side clearfix">
		<div class="side-left active article">
			<section class="title flex v-center">
				<div class="text">
					<p class="type">{{$conts->job_type=='job_part'?'兼職':'全職'}}</p>
					<h3 class="ttl">{{$conts->job_title}}</h3>
					<a class="btn-hire" onclick="get_job('{{$jobs->id}}')">我要應徵</a>
				</div>
				
			</section>
			<section>
				<h4 class="ttl-underline colored">工作內容</h4>
				<p>{{$conts->job_intro}}</p>
				
			</section>
			<section>
				<h4 class="ttl-underline colored">詳細職缺資訊</h4>
				<ul>
					<li>工作地點：{{$conts->job_location}}</li>
					<li>工作經驗：{{$conts->job_exp}}</li>
					<li>招聘日期：{{$conts->job_date}}</li>
					<li>到職日期：{{$conts->job_arrivedate}}</li>
					<li>關鍵字：{{$conts->job_keyword}}</li>
				</ul>
			</section>
			
			<section>
				<h4 class="ttl-underline colored">員工福利制度</h4>
				<ul>
					<li>{!!$conts->job_benefit!!}</li>
				</ul>
			</section>
			
			<section>
				<h4 class="ttl-underline colored">聯絡資訊</h4>
				<ul>
					<li>聯絡人姓名：{{$conts->job_contact}}</li>
					<li>聯絡電話：{{$conts->job_phone}}</li>
					<li>電子郵件：{{$conts->job_email}}</li>
					<li>徵才網址：{{$conts->job_url}}</li>
				</ul>
			</section>
			<section>
				<h4 class="ttl-underline colored">廠商簡介</h4>
				<p>{{$comp->brief}}</p>
				
			</section>
		</div>
		@include('job_info')
	</div>
</section>
@endsection
@section('javascript')
@endsection