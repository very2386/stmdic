<?php
$query = \App\Cm::where('position','comp_resume')->where('mstatus','Y') ;
if(request('q')){
	$query = $query->where('name','like','%'.trim(request('q')).'%');
}
if(request('sort')&&request('sort')=='hot') $query = $query->orderby('hits','desc');
elseif(request('sort')&&request('sort')=='new') $query = $query->orderby('id','desc');
$jobs = $query->paginate(10);

$sort_class = "job_sort" ;
$sort_array = ['new'=>'最新','hot'=>'熱門'];
$cur_sort = '請選擇';
if(request('sort') == 'new' || request('sort') == 'hot' ) $cur_sort = $sort_array[request('sort')];
?>
@extends('main')
@section('content')
<style type="text/css">
.breadcrumb .job_sort{
	position: absolute;
    right: 10px;
    top: 3px;
}
.breadcrumb h4{
	width: 5em;
}
</style>
<section class="hire">
	<div class="ttl-bar">
		<h2>廠商徵才專區</h2>
		<form id="searchform" action="/job" method="get">
			<div class="searchbar">
				<input type="text" name="q" value="{{request('q')}}" placeholder="職缺搜尋">
				<button type="submit" class="btn-search">Search</button>
			</div>
		</form>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/job">職缺總覽</a> @include('sort')
	</div>
	<div class="content two-side clearfix" style="padding-bottom:0">
		<div class="side-left list-page active article">
			<section class="hire-list">
				<ul class="title">
				@if(count($jobs)>0)
					@foreach($jobs as $rd)	
					<?php
					$comp_info = \App\Cm::where('id',$rd->up_sn)->first();
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
								<h4>{{isset($comp_info->name)?$comp_info->name:''}}</h4>
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
				@else
					<h2>目前站無職缺</h2>
				@endif
				</ul>
			</section>
		</div>
		@include('job_info')
		
	</div>
	<div class="pager" style="margin-bottom: 20px">
		{{$jobs->links()}}
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