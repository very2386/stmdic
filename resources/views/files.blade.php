<?php
if(request('type')) $bodyid = "page-market";
if($ftype){
	if($type) $data = \App\Cm::where('position','files')->where('brief',$type)->where('mstatus','Y')->orderBy('created_at','DESC')->paginate(10);
	else $data = \App\Cm::where('position','files')->where('type',$ftype)->where('mstatus','Y')->orderBy('created_at','DESC')->paginate(10);
} 
elseif(!request('type')) $data = \App\Cm::where('position','files')->where('type','!=','文宣下載專區')->where('mstatus','Y')->orderBy('created_at','DESC')->paginate(10);
else $data = \App\Cm::where('position','files')->where('type','文宣下載專區')->where('mstatus','Y')->orderBy('created_at','DESC')->paginate(10);
$file_class = \App\Cm::get_file_class();
?>
@extends('main')
@section('content')	
<section class="plan">
	<div class="ttl-bar">
		<h2>{{request('type')?'文宣下載':'文件下載'}}</h2>
		<ul class="tab">
			@if(!request('type'))
				@foreach($file_class as $fc)
	            <li class="{{$ftype==$fc?'active':''}}">
	                <a href="/files/{{$fc}}">{{$fc}}</a>
	            </li>
	            @endforeach
	        @endif
    	</ul>
	</div>
	<div class="breadcrumb">
		<a href="/">首頁</a> &gt; 
		<a href="/files{{request('type')?'?type=marketing':''}}">{{request('type')?'文宣下載':'文件下載'}}</a>
		@if($ftype)
			&gt;
			<a href="/files/{{$type}}">{{$ftype}}</a>
		@endif
		@if($type)
			&gt;
			<a href="/files/{{$type}}/{{$type}}">{{$type}}</a>
		@endif
	</div>
	<div class="content files">
		<div class="tab-wrap">
			@if($ftype=='計畫各階段文件下載')
			<ul class="tabs mb20">
				<li class="{{$type=='計畫申請階段'?'active':''}}"><a href="/files/計畫各階段文件下載/計畫申請階段">計畫申請階段</a></li>
				<li class="{{$type=='計畫執行階段'?'active':''}}"><a href="/files/計畫各階段文件下載/計畫執行階段">計畫執行階段</a></li>
				<li class="{{$type=='計畫經費核銷'?'active':''}}"><a href="/files/計畫各階段文件下載/計畫經費核銷">計畫經費核銷</a></li>
			</ul>
			@endif
			@if(count($data)>0)
			<ul class="tab-content">
				<li class="active">
					<table class="flag" width="100%">
						<tr>
							<th width="15%">格式</th>
							<th width="70%">文件名稱</th>
							<th width="15%">說明</th>
						</tr>
						@foreach($data as $rs)
						<?php 
							$files = \App\OtherFiles::where('cm_id',$rs->id)->where('position','files')->get();
						?>
						<tr>
							<td>@if($files->count()>0)
									@foreach($files as $k => $f)
										<a href="/download/{{$f->id}}">{{strtoupper($f->filetype)}}</a> {{count($files)-1==$k?'':'|'}} 
									@endforeach
								@elseif($rs->link)
									<a href="{{$rs->link}}" target="_blank">連結</a>
								@endif
							</td>
							<td>{{$rs->name}}</td>
							<td>{{$rs->cont}}</td>
						</tr>
						@endforeach
					</table>
				</li>
			</ul>
			@else
			<p class="t-center">目前尚無此分類文件</p>
			@endif
		</div>
	</div>
	<div class="pager">
		{{$data->links()}}
	</div>
</section>
@endsection
@section('javascript')
@endsection