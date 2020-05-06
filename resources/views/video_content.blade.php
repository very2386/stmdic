<?php
\App\Cm::where('id',$id)->increment('hits');
$rd = \App\Cm::where('id',$id)->first();	
if(!$rd){
	session()->flash('sysmsg', '找不到影片資料');
	echo '<script>location.href="/"</script>';
	exit;
}
$video_type = explode('-',$rd->type) ; 
if(!session('mid')&&$video_type[0]=='數位教材'){
	echo "<script>alert('數位教材只供會員使用，謝謝');location.href='/'</script>";
	exit;
}
if($rd->type=='行銷專區'){
	$bodyid = "page-market";
	$bodyclass= "page-market";
}else $bodyid = "page-event";
?>
@extends('main')
@section('content')
<section class="video bg-gray mb20">
	<div class="ttl-bar">
		<h2>{{$rd->type=='行銷專區'?'數位影音':'育成專區'}}</h2>
		<?php
		$vtype = \App\Cm::where('position','videotype')->where('mstatus','Y')->get() ;
		$cat = 0 ; 
		?>
		@if($rd->type!='行銷專區')
		<ul class="tab">
		  	@foreach($vtype as $vt)
		  	<li class="{{$vt->name==$video_type[0]?'active':''}}">
		    	<a href="/video/{{$vt->name}}">{{$vt->name}}</a>
			    <?php
			    $second = \App\Cm::where('position','videotype_2nd')->where('type',$vt->name)->where('mstatus','Y')->get();
			    ?>
			    <ul class="submenu">
			      	@foreach($second as $st)
			      	<li data-target="cat{{$st->name}}" class="{{isset($video_type[1])? $video_type[1]==$st->name?'active':'' : ''}}">
			        	<a href="/video/{{$st->name}}">{{$st->name}}</a>
			      	</li>
			     	@endforeach
			    </ul>
			</li>
			@endforeach
		</ul>
		@endif
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		@if($rd->type=='行銷專區')
		<a href="javascript:;">行銷專區</a> &gt; 
		<a href="javascript:;">數位影音</a> &gt; 
		<a href="/video/{{$id}}">{{$rd->name}}</a>  
		@else
		<a href="javascript:;">育成專區</a> &gt; 
		<a href="/video/{{$video_type[0]}}">{{$video_type[0]}}</a>  &gt; 
		<a href="/video/{{$id}}">{{$rd->name}}</a>  
		@endif
	</div>
	<div class="content video grid-intro">
		<div class="frame">
			<h3 class="mb10">{{$rd->name}}</h3>
			<div class="video-frame" style="background-color:#000000;width:100%">
				@if($rd->link_type=='YouTube')
				<iframe width="100%" height="480" src="https://www.youtube.com/embed/{{$rd->link}}" frameborder="0" allowfullscreen></iframe>
				@else
				<img src="{{\App\Cm::get_pic($rd->id)}}">
				@endif
			</div>
		</div>
	</div>
</section>
<div class="video-info">
	<ul>
		<li class="flex">
			<h4>影片連結</h4>
			<p>
				@if($rd->link_type=='YouTube')
				<a href="https://www.youtube.com/watch?v={{$rd->link}}" target="_blank">https://www.youtube.com/watch?v={{$rd->link}}</a>
				@else
				<a href="{{$rd->link}}" target="_blank">{{$rd->link}}</a>
				@endif
			</p>
		</li>
		@if($rd->obj)
		<li class="flex">
			<h4>課程講師</h4>
			<p>{{$rd->obj}}</p>
		</li>
		@endif
		@if($rd->brief)
		<li class="flex">
			<h4>課程簡介</h4>
			<p>{{$rd->brief}}</p>
		</li>
		@endif
		@if($rd->type)
		<li class="flex">
			<h4>課程類別</h4>
			<p>{{$rd->type}}</p>
		</li>
		@endif
		@if($rd->cont)
		<li class="flex">
			<h4>課程大綱</h4>
			<div class="text default-html">
				<p>{!!$rd->cont!!}</p>
			</div>
		</li>
		@endif
		@if($rd->jdate)
		<li class="flex">
			<h4>日期</h4>
			<p>{{$rd->jdate}}</p>
		</li>
		@endif
		@if($rd->specs)
		<li class="flex">
			<h4>片長</h4>
			<p>{{$rd->specs}}</p>
		</li>
		@endif
		<?php
		$files = \App\OtherFiles::where('position','video')->where('cm_id',$rd->id)->get(); 
		?>
		@if(count($files)>0)
		<li class="flex">
			<h4>課程教材</h4>

				@foreach($files as $k => $f)
				<div style="margin-bottom:10px;">
					{{++$k}}.<a href="/download/{{$f->id}}">{{$f->name}}</a>&nbsp;&nbsp;&nbsp;
				</div>
				@endforeach

		</li>
		@endif
	</ul>
</div>
@endsection
@section('javascript')
@endsection