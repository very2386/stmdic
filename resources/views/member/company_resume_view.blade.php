<?php
$comp = \App\Cm::where('position','company')->where('up_sn',session('mid'))->first();
$comp_jobs = \App\Cm::where('position','comp_resume')->where('up_sn',$comp->id)->get();
?>
@extends('main')
@section('content')
<section class="member">
	@include('member.menu')
	<div class="breadcrumb">
		<a href="/member/company">會員專區</a> &gt; <a class="name" href="/member/company_resume_view">徵才資訊</a>
	</div>
	<div class="content form">
		<div class="cat1 active">
			<div class="top">
				<h3>徵才資訊({{$comp_jobs->count()}})</h3>
			</div>
			<div class="job-tbl">
				<a class="right" href="/member/company_hire_edit">+新增徵才資訊</a>
				@if($comp_jobs)
				<table>
					<tr>
						<th width="20%">職稱</th>
						<th width="20%">新增職缺日期</th>
						<th width="20%">瀏覽人次</th>
						<th width="20%">履歷投遞人數</th>
						<th width="10%">編輯</th>
						<th width="10%">&nbsp;</th>
					</tr>
					@foreach($comp_jobs as $rd)
					<?php
						$conts = json_decode($rd->cont) ; 
					?>
					<tr id="item_row{{$rd->id}}">
						<td><a href="/member/company_resume_list/{{$rd->id}}">{{$conts->job_title}}</a></td>
						<td>{{mb_substr($rd->created_at,0,10)}}</td>
						<td>{{$rd->hits}}</td>
						<td><a href="/member/company_resume_list/{{$rd->id}}">{{$rd->reveals}}</a></td>
						<td><a href="/member/company_hire_edit/{{$rd->id}}"><img style="margin:0 auto;" src="/img/icon/edit.png" alt=""></a></td>
						<td><a style="cursor: pointer;" onclick="del_item('cms','{{$rd->id}}')"><img src="/img/icon/delete_x.png" alt=""></a></td>
					</tr>
					@endforeach
				</table>
				@endif
			</div>
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection