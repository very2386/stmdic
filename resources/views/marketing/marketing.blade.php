<?php
//計算訪客人數
$hits = \App\Cm::where('position','people')->where('type',$type)->value('hits') ; 
if(!$hits) \App\Cm::where('position','people')->where('type',$type)->create(['position'=>'people','type'=>$type,'hits'=>1]) ;
else \App\Cm::where('position','people')->where('type',$type)->increment('hits'); 

$bodyid = "page-market";
$prods = \App\Cm::get_prods_type();
if(request('q')){
	$query = \App\Cm::where('position','compinfo')->where('type','上市產品') ;
	$q = '%'.trim(request('q')).'%';
	if(request('t') == '全部'){
		$query->where(function($qry) use($q) {
	          $qry->where('name', 'like', $q)
	            ->orWhere('cont', 'like', $q);
	    });
	}else{
		if(request('t') == '標題') $t = 'name';
		if(request('t') == '內文') $t = 'cont';
		$query->where($t, 'like', $q);
	}
	$products = $query->where('mstatus','Y')->inRandomOrder()->paginate(15);
	foreach ($products as $rd) {
		$compname[$rd->up_sn] = \App\Cm::where('id',$rd->up_sn)->value('name') ;
	}
}else{
	// $wh = ['position'=>'company','mstatus'=>'Y'] ;
	// $compid = [] ;
	// //先找出屬於該類別的廠商
	// $company = \App\Cm::where($wh)->where('type','like','%'.trim($type).'%')->get() ;
	// //再找出該類別廠商的上市產品
	// foreach($company as $rs){
	// 	$compid[$rs->name] = $rs->id ;
	// 	$compname[$rs->id] = $rs->name ;
	// } 
	// $products = \App\Cm::where('position','compinfo')->where('type','上市產品')->whereIn('up_sn',$compid)->where('mstatus','Y')->inRandomOrder()->paginate(15);
	$products = \App\Cm::where('position','compinfo')->where('type','上市產品')->where('tags','like','%'.$type.'%')->where('mstatus','Y')->orderBy('pic','DESC')->inRandomOrder()->paginate(15);
}
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
<section class="marketing">
	
	<div class="breadcrumb">
		<a href="/market">首頁</a> &gt; 
		<a href="javascript:;">聚落產品</a> &gt;
		<a href="/marketing/marketing/{{$type}}">{{$type}}</a>
		
	</div>

	<div class="ttl-bar">
		<ul class="flex submenu-pic">
			@foreach($prods as $k => $v)
				@if($k>=4&&$k<=5)
				<li class="i{{$k+1}} {{$v == $type ? 'active' : ''}}" data-target="cat{{$k+1}}"><div class="img"><img src="/img/icon/market/i5{{$v == $type ? '-c' : ''}}.png" alt=""></div><div class="text">{{$v}}</div><a href="/marketing/marketing/{{$v}}"></a></li>
				@elseif($k>=6&&$k<=7)
				<li class="i{{$k+1}} {{$v == $type ? 'active' : ''}}" data-target="cat{{$k+1}}"><div class="img"><img src="/img/icon/market/i6{{$v == $type ? '-c' : ''}}.png" alt=""></div><div class="text">{{$v}}</div><a href="/marketing/marketing/{{$v}}"></a></li>
				@elseif($k==8)
				<li class="i{{$k+1}} {{$v == $type ? 'active' : ''}}" data-target="cat{{$k+1}}"><div class="img"><img src="/img/icon/market/i7{{$v == $type ? '-c' : ''}}.png" alt=""></div><div class="text">{{$v}}</div><a href="/marketing/marketing/{{$v}}"></a></li>
				@else
				<li class="i{{$k+1}} {{$v == $type ? 'active' : ''}}" data-target="cat{{$k+1}}"><div class="img"><img src="/img/icon/market/i{{$k+1}}{{$v == $type ? '-c' : ''}}.png" alt=""></div><div class="text">{{$v}}</div><a href="/marketing/marketing/{{$v}}"></a></li>
				@endif
			@endforeach
		</ul>
		<form id="searchform" action="/marketing/marketing/{{$type}}" method="get">
    		<div class="searchbar">
				<input type="search" name="q" value="{{request('q')}}" placeholder="產品搜尋">
				<div class="custom-select" target="#search-type">
    				<h5 class="ttl">全部</h5>
    				<ul class="opt">
    					<li>全部</li>
    					<li>標題</li>
    					<li>內文</li>
    				</ul>
    			</div>
    			<input type="hidden" name="t" id="search-type" value="{{request('t')?request('t'):'全部'}}">
				<button type="submit" class="btn-search">Search</button>
			</div>
		</form>
	</div>
	<div class="content clearfix">

		<div class="side-left list-page active article">

			<section class="marketing-list">
				<ul class="title">
					@foreach($products as $rd)
					<li class="flex">
						<div class="img">
							<a href="/marketing/marketing/{{$type}}/{{$rd->id}}">
								<img src="{{\App\Cm::get_pic($rd->id)}}" alt="{{$rd->name}}">
							</a>
						</div>
						<div class="text">
							<div class="flex">
								<h3 class="ttl"><a href="/marketing/marketing/{{$type}}/{{$rd->id}}" >{{$rd->name}}</a></h3>
							</div>
							<div class="ct">
								<h4>{{\App\Cm::where('id',$rd->up_sn)->value('name')}}</h4>
								<p>{{$rd->brief}}</p>
							</div>
							<a href="/marketing/marketing/{{$type}}/{{$rd->id}}" class="btn-box xs">More</a>
						</div>
					</li>
					@endforeach
				</ul>
			</section>
		</div>
		<div class="pager">
			{{$products->links()}}
		</div>
	</div>
</section>
@endsection
@section('javascript')
@endsection