<?php
if(request('q')){
	$comp = \App\Cm::where('id',$id)->first();
	$jobs = \App\Cm::where('position','comp_resume')->where('up_sn',$id)->where('name','like','%'.trim(request('q')).'%')->paginate(10);
}else{
	$comp = \App\Cm::where('id',$id)->first();
	$jobs = \App\Cm::where('position','comp_resume')->where('up_sn',$id)->paginate(10);
}
if($jobs->count()==0){
	echo '<script>alert("此廠商尚未有徵才資訊");history.back();</script>';
	exit;
}
?>
@extends('main')
@section('content')
<section class="hire">
	<div class="ttl-bar">
		<h2>廠商徵才專區</h2>
		<form id="searchform" action="/company_hire_list/{{$id}}" method="get">
			<div class="searchbar">
				<input type="text" name="q" value="{{request('q')}}" placeholder="職缺搜尋">
				<button type="submit" class="btn-search">Search</button>
			</div>
		</form>
	</div>
	<div class="breadcrumb">
		<a href="/company_hire_list/{{$id}}">[{{$comp->name}}] 職缺</a>
	</div>
	<div class="content two-side clearfix">
		<div class="side-left list-page active article">
			<section class="hire-list">
				<ul class="title">
				@if($jobs)
					@foreach($jobs as $rd)	
					<?php
					$conts = json_decode($rd->cont);
					?>
					<li>
						<div class="text">
							<div class="flex">
								<h3 class="ttl">{{$conts->job_title}}</h3>
								<p class="type">{{$conts->job_type=='job_full'?'全職':'兼職'}}</p>
								<a class="btn-hire" onclick="get_job('{{$rd->id}}')">我要應徵</a>
							</div>
							<div class="ct">
								<h4>{{$comp->name}}</h4>
								<ul>
									<li>工作地點：{{$conts->job_location}}</li>
									<li>工作待遇：{{$conts->job_salary}}</li>
									<li>工作經驗：{{$conts->job_exp}}</li>
									<li>必要條件：{{$conts->job_necessary}}</li>
								</ul>
							</div>
							<a href="/company_hire/{{$rd->id}}" class="btn-box xs">More</a>
						</div>
					</li>
					@endforeach
				@endif
				</ul>
			</section>
		</div>
		@include('job_info')
		<div class="pager">
			{{$jobs->links()}}
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection