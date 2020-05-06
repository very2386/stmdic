<?php
$resume = \App\Cm::where('position', 'resume')->where('id',$id)->first();
if(!$resume){
	$resume = \App\Cm::new_obj();
	$rdata = \App\Cm::new_resume_obj();
}else{
	$rdata = json_decode($resume->cont);
}
if(!$resume->pic) $resume->pic = '/img/member_default.png';
$n=0;
?>
@extends('main')
@section('content')
<section class="resume-preview">
	<div class="ttl-bar">
		<h2>個人履歷表</h2>
	</div>
	<div class="breadcrumb">
		<a href="resume/{{$id}}">{{$rdata->name}} 履歷表</a>
	</div>
	<div class="content grid-intro form">
		<div class="resume">
			<h3 class="ttl-underline">
				<span class="name"><span class="ct">{{$rdata->name}}</span><span class="en">{{$rdata->ename}}</span></span>
				<span class="gender">{{$rdata->gender == 'M' ? '男性':'女性'}}</span>
				<span class="status">{{$rdata->occupy_status ? $rdata->occupy_status : ''}}</span>
			</h3>
			<div class="basic">
				<ul>
					<li>生日：{{$rdata->birth}}</li>
					<li>E-mail：{{$rdata->email}}</li>
					<li>聯絡電話：{{$rdata->tel}}</li>
					<li>聯絡地址：{{$rdata->address}}</li>
					@if($rdata->facebook_id)
					<li>https://www.facebook.com/{{$rdata->facebook_id}}</li>
					@endif
					@if($rdata->google_id)
					<li>https://plus.google.com/{{$rdata->google_id}}</li>
					@endif
				</ul>
				<div class="avatar"><img src="{{\App\Cm::get_pic($resume->id)}}" alt="{{$rdata->name}}的大頭照"></div>
			</div>
			
			<div class="edu">
				<h4>學能經歷</h4>
				<ul>
				@if(\App\Funcs::chk_ary($rdata->schools))
					@foreach($rdata->schools as $school)
						<li>{{$school->name}} {{$school->department}}</li>
					@endforeach
				@endif
				@if(\App\Funcs::chk_ary($rdata->languages))
					<li>語言：
					@foreach($rdata->languages as $language)
						{{$language}}&nbsp;
					@endforeach
					</li>
				@endif
				@if(\App\Funcs::chk_ary($rdata->certs))
					<li>證照：
					@foreach($rdata->certs as $cert)
						{{$cert}}&nbsp;
					@endforeach
					</li>
				@endif
				</ul>
			</div>
			@if(\App\Funcs::chk_ary($rdata->jobs))
			<div class="exp">
				<h4>工作經歷</h4>
				<ul>
					@foreach($rdata->jobs as $job)
					<li>{{$job->name}} {{$job->position}}({{$job->start}}~{{$job->end}})</li>
					@endforeach
				</ul>
			</div>
			@endif
			<div class="self">
				<h4>自傳</h4>
				<ul>
					<li>
						{{$rdata->self_intro}}
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection