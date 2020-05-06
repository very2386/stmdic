<?php
$resume = \App\Cm::where('position', 'resume')->where('up_sn', session('mid'))->first();
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
	@include('member.menu')
	<!-- <div class="ttl-bar">
		<h2>履歷表預覽</h2>
	</div> -->
	<div class="breadcrumb">
		<a href="/member/index">會員專區</a> &gt; <a href="">履歷表預覽</a>
	</div>
	<div class="content grid-intro form">
		<div class="resume">
			<div class="btns">
				<!-- <a href="javascript:;" class="btn-print"><span class="icon"><img src="/img/icon/print.png" alt=""></span>列印</a> -->
				<a href="/member/resume_edit" class="btn-edit"><span class="icon"><img src="/img/icon/edit.png" alt=""></span>修改履歷表</a>
			</div>
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
					@if(isset($rdata->facebook_id))
						@if($rdata->facebook_id)
						<li>https://www.facebook.com/{{$rdata->facebook_id}}</li>
						@endif
					@endif
					@if(isset($rdata->google_id))
						@if($rdata->google_id)
						<li>https://plus.google.com/{{$rdata->google_id}}</li>
						@endif
					@endif
				</ul>
				<div class="avatar"><img src="{{\App\Cm::get_pic($resume->id)}}" alt="{{$rdata->name}}的大頭照"></div>
			</div>
			
			<div class="edu">
				<h4>學能經歷</h4>
				<ul>
				@if(isset($rdata->schools))
					@if(\App\Funcs::chk_ary($rdata->schools))
						@foreach($rdata->schools as $school)
							<li>{{$school->name}} {{$school->department}}</li>
						@endforeach
					@endif
				@endif
				@if(isset($rdata->languages))
					@if(\App\Funcs::chk_ary($rdata->languages))
						<li>語言：
						@foreach($rdata->languages as $language)
							{{$language}}&nbsp;
						@endforeach
						</li>
					@endif
				@endif
				@if(isset($rdata->certs))
					@if(\App\Funcs::chk_ary($rdata->certs))
						<li>證照：
						@foreach($rdata->certs as $cert)
							{{$cert}}&nbsp;
						@endforeach
						</li>
					@endif
				@endif
				</ul>
			</div>
			@if(isset($rdata->certs))
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