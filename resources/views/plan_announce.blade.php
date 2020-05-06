<?php
$plants = \App\Cm::where('position','plan')->where('mstatus','Y')->orderBy('created_at','DESC')->paginate(10);
?>
@extends('main')
@section('content')	
<section class="plan">
	<div class="ttl-bar">
		<h2>計畫公告</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/about/plan_announce">計畫公告</a>
	</div>
	<div class="content">
		<table class="flag" width="100%">
			<tr>
				<th>計畫公告</th>
				<th>點閱率</th>
				<th>發佈日期</th>
			</tr>
			@foreach($plants as $rd)
			<tr>
				<td><a href="/about/plan_announce/{{$rd->id}}">{{$rd->name}}</a></td>
				<td>{{$rd->hits}}</td>
				<td>{{substr($rd->created_at,0,10)}}</td>
			</tr>
			@endforeach
		</table>
	</div>
	<div class="pager">
		{{$plants->links()}}
	</div>
</section>
@endsection
@section('javascript')
@endsection