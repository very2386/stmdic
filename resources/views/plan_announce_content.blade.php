<?php
$rd = \App\Cm::where('id',$id)->first();
\App\Cm::where('id',$id)->increment('hits');
?>
@extends('main')
@section('content')		
<section class="hot">
	<div class="ttl-bar">
		<h2>計畫公告</h2>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; <a href="/about/plan_announce">計畫公告</a>
	</div>
	<div class="content clearfix">
		{!!$rd->cont!!}
	</div>
	<div class="mb20 map">
		<h3 class="ttl-underline colored">附件</h3>
		<?php
		$files = \App\OtherFiles::where('position','plan')->where('cm_id',$rd->id)->get(); 
		?>
		@if(count($files)>0)
			@foreach($files as $f)
			<div style="margin-bottom:10px;"><a href="/download/{{$f->id}}">{{$f->name}}</a></div> 
			@endforeach
		@endif
	</div>
</section>
@endsection
@section('javascript')
@endsection